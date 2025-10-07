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
        $branchparts = WhInventoryBranch::where('branch_id', auth()->user()->branch_id)->where('status', 'active')
            ->when($request->get('brandno'), function ($sql) use ($request) {
                $sql->whereHas('part', function ($sql) use ($request) {
                    $sql->where('brandno', $request->get('brandno'));
                });
            })->when($request->get('categoryid'), function ($sql) use ($request) {
                $sql->whereHas('part', function ($sql) use ($request) {
                    $sql->where('categorygroupid', $request->get('categoryid'));
                });
            })->when($request->get('carid'), function ($sql) use ($request) {
                $sql->whereHas('part', function ($sql) use ($request) {
                    $sql->whereHas('linkedcars', function ($sql) use ($request) {
                        $sql->where('carid', $request->get('carid'));
                    });
                });
            })->when($request->get('searchval'), function ($sql) use ($request) {
                $searchVal = str_replace(['-', ' ', '.', '--'], '', strtolower(trim($request->get('searchval'))));
                $sql->whereHas('part', function ($sql) use ($searchVal) {
                    $sql->where('fixedarticleno', 'LIKE', $searchVal . '%');
                })->orWhereHas('part', function ($sql) use ($request) {
                    $sql->whereHas('category', function ($sql) use ($request) {
                        $sql->where('categoryname', 'LIKE', $request->get('searchval') . '%')->orWhere('name', 'LIKE', $request->get('searchval') . '%');
                    });
                })->orWhereHas('part', function ($sql) use ($searchVal) {
                    $sql->whereHas('oemnumbers', function ($sql) use ($searchVal) {
                        $sql->where('oemfixed', 'LIKE', $searchVal . '%');
                    });
                });
            })->with(['part' => function ($sql) {
                $sql->select('articleid', 'articleno', 'categorygroupid', 'brandname', 'genericarticleid');
                $sql->with(['category' => function ($sql) {
                    $sql->select('categorygroupid', 'categoryname', 'name');
                }])->with(['isfilterattributes' => function ($sql) {
                    $sql->select('attrid', 'attrvalueid', 'articleid')->with(['attrname' => function ($sql) {
                        $sql->select('attrid', 'attrname', 'name');
                    }])->with(['attrvalue' => function ($sql) { 
                        $sql->select('attrvalueid', 'attrvalue', 'name', 'articleid', 'attrunit');
                    }]);
                }])->with(['notframes' => function ($sql) {
                    $sql->select('articleid', 'imgurl100');
                }]);
            }])->with(['inventory' => function ($sql) {
                $sql->select('id', 'point');
            }])->select('id', 'wh_inventory_id', 'articleid', 'branch_id', 'quantity', 'storeprice', 'wholesaleprice', 'issale', 'percentsale', 'storepricesale', 'sale_startdate', 'sale_enddate')
            ->paginate(20);
        $resourceData = BranchPartResource::collection($branchparts);
        return $this->sendResponsePagination($branchparts, $resourceData, '');
    }
}
