<?php

namespace App\Http\Controllers\Ichi\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Profile\SetfmcRequest;
use App\Models\User;
use App\Models\User\IchiOnesellerDevice;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        
    }

    public function index()
    {

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
}
