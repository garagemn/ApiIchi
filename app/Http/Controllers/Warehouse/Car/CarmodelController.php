<?php

namespace App\Http\Controllers\Warehouse\Car;

use App\Http\Controllers\Controller;
use App\Http\Resources\Warehouse\Car\CarmodelResource;
use App\Models\Warehouse\Car\Carmodel;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CarmodelController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        
    }

    public function index($manuid)
    {
        $carmodels = Carmodel::getActiveModel($manuid);
        $resourceData = CarmodelResource::collection($carmodels);
        return $this->sendResponse($resourceData, '');
    }
}
