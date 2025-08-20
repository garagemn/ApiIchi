<?php

namespace App\Http\Controllers\Ichi\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ichi\Order\OrderStoreRequest;
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

    }

    public function store(OrderStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $order = new IchiOrder();
            $order->phone = $request->get('phone');
            $order->type = $request->get('type');
            if($request->get('pickupbranch')) $order->branch_id = $request->get('pickupbranch');
            $order->oneseller_id = auth()->id();
            $order->save();
            $orderparts = $request->get('items');
            foreach($orderparts as $orderpart) {
                $hasInventoryBranch = WhInventoryBranch::where('branch_id', auth()->user()->branch_id)->findOrFail($orderpart['partid']);
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
            DB::commit();
            return $this->sendResponse('', 'Захиалга амжилттай үүсгэлээ.');
        } catch(\Exception $e) {
            \Log::info($e);
            DB::rollBack();
            return $this->sendError('Захиалга үүсгэхэд алдаа гарлаа', '', 500);
        }
    }


}
