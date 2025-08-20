<?php

namespace App\Http\Controllers\Warehouse\Part;

use App\Http\Controllers\Controller;
use App\Http\Resources\Warehouse\Part\BranchPartResource;
use App\Models\Warehouse\Part\WhInventoryBranch;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
        $branchparts = WhInventoryBranch::where('branch_id', auth()->user()->branch_id)->where('status', 'active')->where(function($sql) use ($request) {
            if($request->get('vin')) {

            }

            if($request->get('partbrand')) {
                $sql->whereHas('part', function ($sql) use ($request) {
                    $sql->where('brandno', $request->get('partbrand')); 
                });
            }

            if($request->get('categoryid')) {
                $sql->whereHas('part', function ($sql) use ($request) {
                    $sql->where('categorygroupid', $request->get('categoryid'));
                });
            }

            if($request->get('carengine')) {
                $sql->whereHas('part', function ($sql) use ($request) {
                    $sql->whereHas('linkedcars', function ($sql) use ($request) {
                        $sql->where('carid', $request->get('carengine'));
                    });
                });
            }
        })->with(['part' => function ($sql) {
            $sql->select('articleid', 'articleno', 'categorygroupid', 'brandname', 'genericarticleid');
            $sql->with(['category' => function ($sql) {
                $sql->select('categorygroupid', 'categoryname', 'name');
            }]);
        }])->with(['inventory' => function ($sql) {
            $sql->select('id');
        }])->select('id', 'wh_inventory_id', 'articleid', 'branch_id', 'quantity', 'storeprice', 'wholesaleprice', 'issale', 'percentsale', 'storepricesale', 'sale_startdate', 'sale_enddate')
        ->paginate(20);
        $resourceData = BranchPartResource::collection($branchparts);
        return $this->sendResponsePagination($branchparts, $resourceData, '');
    }
}
