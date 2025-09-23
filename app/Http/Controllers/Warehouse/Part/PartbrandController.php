<?php

namespace App\Http\Controllers\Warehouse\Part;

use App\Http\Controllers\Controller;
use App\Http\Resources\Warehouse\Partbrand\PartbrandResouce;
use App\Models\Warehouse\Partbrand\WhPartbrand;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PartbrandController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
        $partbrands = WhPartbrand::where('status', 'active')->whereHas('parts', function ($sql) {
            $sql->whereHas('branchparts', function ($sql) {
                $sql->where('status', 'active')->where('branch_id', auth()->user()->branch_id);
            });
        })->select('datasupplierid', 'brandname')->with(['logo' => function ($sql) {
            $sql->select('datasupplierid', 'imageurl200');
        }])->get();

        return $this->sendResponse(PartbrandResouce::collection($partbrands), '');

    }


}
