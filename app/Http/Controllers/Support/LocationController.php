<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Http\Resources\Authserver\LocationResource;
use App\Models\Authserver\Location;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        
    }

    public function index()
    {
        $cities = Location::parentLocation();
        return $this->sendResponse(LocationResource::collection($cities), '');
    }

    public function sublocation($id) 
    {
        $sublocations = Location::where('parent_id', $id)->where('status', 'active')->select('id', 'name', 'sort')->orderBy('sort', 'ASC')->get();
        return $this->sendResponse(LocationResource::collection($sublocations), '');
    }
}
