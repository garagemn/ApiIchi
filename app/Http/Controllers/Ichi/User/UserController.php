<?php

namespace App\Http\Controllers\Ichi\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Profile\SetfmcRequest;
use App\Http\Resources\Oneseller\ChildsResource;
use App\Http\Resources\Oneseller\ProfileResource;
use App\Http\Resources\Oneseller\WeekSaleAmountResource;
use App\Models\Order\IchiOrderDetail;
use App\Models\User;
use App\Models\User\IchiOnesellerDevice;
use App\Models\User\IchiOnesellerPoint;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        
    }

    public function index()
    {
        $oneseller = User::withSum('points', 'point')->with(['branch' => function ($sql) {
            $sql->select('id', 'name');
        }])->with(['organization' => function ($sql) {
            $sql->select('id', 'name');
        }])->with(['rank' => function ($sql) { $sql->select('id', 'name'); }])
        ->select('id', 'lastname', 'name', 'phone', 'organization_id', 'branch_id', 'parent_id', 'ichi_oneseller_rank_id')
        ->withCount(['children'])->findOrFail(auth()->id());
        return $this->sendResponse(ProfileResource::make($oneseller), '');
    }

    public function childs()
    {
        $descendants = DB::table('ichi_oneseller_closures as c')->join('ichi_onesellers as u', 'u.id', '=', 'c.descendant_id')
        ->where('c.ancestor_id', auth()->id())->whereBetween('c.depth', [1, auth()->user()->depth])
        ->select('u.id', 'u.name', 'u.lastname', 'u.phone', 'u.parent_id', 'c.depth')->get();
        foreach ($descendants as $descendant) {
            $descendant->points = $this->getpoint($descendant->id) ?? 0;
        }
        return $this->sendResponse(ChildsResource::collection($descendants), '');
    }

    public function userpoint()
    {

    }

    public function setfcm(SetfmcRequest $request)
    {
        $user = User::findOrFail(auth()->id());
        if($user->device) {
            if($user->device->fcm != $request->get('fcm')) {
                $user->device->fcm = $request->get('fcm');
                $user->device->save();
                return $this->sendResponse('', 'Fcm token амжилттай хадгалагдлаа.');    
            }
            return $this->sendResponse('', 'Fcm token амжилттай хадгалагдлаа.');
        } else {
            $userdevice = new IchiOnesellerDevice();
            $userdevice->fcm = $request->get('fcm');
            $userdevice->oneseller_id = $user->id;
            $userdevice->save();
            return $this->sendResponse('', 'Fcm token амжилттай хадгалагдлаа.');
        }
    }

    public function getpoint($id)
    {
        return IchiOnesellerPoint::where('oneseller_id', $id)->sum('point');
    }

    public function weeksale()
    {
        $totalamount = IchiOrderDetail::whereHas('order', function ($sql) {
            $sql->where('oneseller_id', auth()->id())->where('ispaid', 1);
        })->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('totalamount');
        return $this->sendResponse(['weeksaleamount' => $totalamount], '');
    }
}
