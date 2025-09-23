<?php

namespace App\Http\Controllers\Ichi\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ichi\Order\OrderStoreRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order\IchiOrder;
use App\Models\Order\IchiOrderDetail;
use App\Models\Warehouse\Part\WhInventoryBranch;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
        $orders = IchiOrder::where('oneseller_id', auth()->id())->where(function ($sql) use ($request) {

        })->with(['details' => function ($sql) {
            $sql->select('id', 'quantity', 'totalamount', 'ichi_order_id');
        }])
        // ->with(['details' => function ($sql) {
        //     $sql->select('id', 'wh_inventory_branch_id', 'quantity', 'price', 'totalamount', 'ichi_order_id');
        //     $sql->with(['branchpart' => function ($sql) {
        //         $sql->select('id', 'articleid')->with(['part' => function ($sql) {
        //             $sql->select('articleid', 'articleno', 'categorygroupid', 'brandname');
        //             $sql->with(['category' => function ($sql) {
        //                 $sql->select('categorygroupid', 'categoryname', 'name');
        //             }]);
        //         }]);
        //     }]);
        // }])
        ->select('id', 'phone', 'type', 'ispaid', 'ebarimt', 'regnumber', 'branch_id', 'created_at')->with(['branch' => function ($sql) {
            $sql->select('id', 'name');
        }])->latest('id')->paginate(20);
        $resourceData = OrderResource::collection($orders);
        return $this->sendResponsePagination($orders, $resourceData, '');
    }

    public function detail($id)
    {
        $order = IchiOrder::with(['details' => function ($sql) {
            $sql->select('id', 'wh_inventory_branch_id', 'quantity', 'price', 'totalamount', 'ichi_order_id');
            $sql->with(['branchpart' => function ($sql) {
                $sql->select('id', 'articleid')->with(['part' => function ($sql) {
                    $sql->select('articleid', 'articleno', 'categorygroupid', 'brandname');
                    $sql->with(['category' => function ($sql) {
                        $sql->select('categorygroupid', 'categoryname', 'name');
                    }]);
                }]);
            }]);
        }])->findOrFail($id);
        if($order->oneseller_id != auth()->id()) return $this->sendError('Захиалгын мэдээлэл олдсонгүй', '', 404);
        $resourceData = OrderResource::make($order);
        return $this->sendResponse($resourceData, '');
    }

    public function store(OrderStoreRequest $request)
    {
        // \Log::info($request->all());
        DB::beginTransaction();
        try {
            $order = new IchiOrder();
            $order->phone = $request->get('phone');
            $order->type = $request->get('type');
            if($request->get('type') === 'delivery') {
                $order->city_id = $request->get('city');
                $order->district_id = $request->get('district');
                $order->team_id = $request->get('team');
                $order->address = $request->get('address');
            } elseif($request->get('type') === 'pickup') {
                $order->branch_id = $request->get('pickupbranch');
            }
            if($request->get('ebarimt') === 'personal') {
                $order->ebarimt = $request->get('ebarimt');
            } elseif($request->get('ebarimt') === 'corporate') {
                $order->ebarimt = $request->get('ebarimt');
                $order->regnumber = $request->get('regnumber');
            }
            $order->oneseller_id = auth()->id();
            
            $order->save();
            $orderparts = $request->get('items');
            foreach($orderparts as $orderpart) {
                $hasInventoryBranch = WhInventoryBranch::where('branch_id', auth()->user()->branch_id)->where('id', $orderpart['partid'])->first();
                if($hasInventoryBranch) {
                    $orderDetail = new IchiOrderDetail();
                    $orderDetail->ichi_order_id = $order->id;
                    $orderDetail->wh_inventory_branch_id = $orderpart['partid'];
                    $orderDetail->quantity = $orderpart['quantity'];
                    if($hasInventoryBranch->issale && $hasInventoryBranch->sale_startdate <= date('Y-m-d') && $hasInventoryBranch->sale_enddate >= date('Y-m-d')) {
                        $orderDetail->price = $hasInventoryBranch->storepricesale;
                        $orderDetail->totalamount = $hasInventoryBranch->storepricesale * $orderpart['quantity'];
                    } else {
                        $orderDetail->price = $hasInventoryBranch->storeprice;
                        $orderDetail->totalamount = $hasInventoryBranch->storeprice * $orderpart['quantity'];
                    }
                    $orderDetail->save();
                }
            }
            DB::commit();
            return $this->sendResponse('', 'Захиалга амжилттай үүсгэлээ.');
        } catch(\Exception $e) {
            \Log::info($e);
            DB::rollBack();
            return $this->sendError('Захиалга үүсгэхэд алдаа гарлаа', '', 200);
        }
    }
}
