<?php

namespace App\Http\Controllers\Warehouse\Car;

use App\Http\Controllers\Controller;
use App\Http\Resources\Warehouse\Car\CarbrandResource;
use App\Models\Warehouse\Car\Carbrand;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CarbrandController extends Controller
{
    use ApiResponse;
    
    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
        $carbrands = Carbrand::activeCarbrands();
        $resourceData = CarbrandResource::collection($carbrands);
        return $this->sendResponse($resourceData, '');
    }
}
