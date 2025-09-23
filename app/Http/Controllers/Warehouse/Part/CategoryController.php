<?php

namespace App\Http\Controllers\Warehouse\Part;

use App\Http\Controllers\Controller;
use App\Http\Resources\Warehouse\Category\CategoryResource;
use App\Models\Warehouse\Part\WhSubcategory;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
        $categories = WhSubcategory::whereHas('parts', function ($sql) {
            $sql->whereHas('branchparts', function ($sql) {
                $sql->where('status', 'active')->where('branch_id', auth()->user()->branch_id);
            });
        })->select('categorygroupid', 'categoryname', 'name')->get();
        return $this->sendResponse(CategoryResource::collection($categories), '');
    }

}
