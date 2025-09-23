<?php

namespace App\Http\Controllers\Warehouse\Car;

use App\Http\Controllers\Controller;
use App\Http\Resources\Warehouse\Car\CarengineResource;
use App\Models\Warehouse\Car\Carengine;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CarengineController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        
    }

    public function index($manuid, $modelid)
    {
        $carengines = Carengine::where('status', 1)->where('manuid', $manuid)->where('modelid', $modelid)
            ->select('carid', 'carname', 'manuid', 'modelid')
            ->with(['carinfo' => function ($sql) {
                $sql->select('carid', 'motortype', 'fueltype', 'cylinder', 'motorcode');
            }])->with(['carbrand' => function ($sql) {
                $sql->select('manuid', 'manuname');
            }])->with(['carmodel' => function ($sql) {
                $sql->select('modelid', 'modelname', 'yearstart', 'yearend');
            }])->orderBy('carname', 'ASC')->get();
        return $this->sendResponse(CarengineResource::collection($carengines), '');
    }
}
