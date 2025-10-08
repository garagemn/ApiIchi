<?php

namespace App\Http\Controllers\Warehouse\Part;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warehouse\Part\Partlinked\CarbrandRequest;
use App\Http\Requests\Warehouse\Part\Partlinked\CarmodelRequest;
use App\Http\Resources\Warehouse\Part\Partlinked\LinkedCarbrandResource;
use App\Http\Resources\Warehouse\Part\Partlinked\LinkedCarengineResource;
use App\Http\Resources\Warehouse\Part\Partlinked\LinkedCarmodelResource;
use App\Models\Warehouse\Car\Carbrand;
use App\Models\Warehouse\Car\Carengine;
use App\Models\Warehouse\Car\Carmodel;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PartlinkedController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        
    }

    public function carbrand(CarbrandRequest $request)
    {
        $carbrands = Carbrand::whereHas('carengines', function ($sql) use ($request) {
            $sql->whereHas('linkedcars', function ($sql) use ($request) {
                $sql->where('articleid', $request->get('articleid'));
            }); 
        })->select('manuid', 'manuname')->orderBy('sort', 'DESC')->get();
        return $this->sendResponse(LinkedCarbrandResource::collection($carbrands), '');
    }

    public function carmodel(CarmodelRequest $request)
    {
        $carmodels = Carmodel::where('manuid', $request->get('manuid'))->whereNotNull('groupid')->whereHas('carengines', function ($sql) use ($request) {
            $sql->whereHas('linkedcars', function ($sql) use ($request) {
                $sql->where('articleid', $request->get('articleid'));
            });
        })->select('modelid', 'modelname', 'yearstart', 'yearend')->orderBy('modelname', 'ASC')->get();
        return $this->sendResponse(LinkedCarmodelResource::collection($carmodels), '');
    }

    public function carengine(Request $request)
    {
        $cars = Carengine::where(function ($sql) use ($request) {
            $sql->whereHas('linkedcars', function ($sql) use ($request) {
                $sql->where('articleid', $request->get('articleid'))->where('manuid', $request->get('manuid'))->where('modelid', $request->get('modelid'));
            });
        })->with(['carinfo' => function ($sql) { $sql->select('carid', 'motorcode', 'cylinder', 'ccmtech', 'fueltype');
        }])->with(['carbrand' => function ($sql) { $sql->select('manuid', 'manuname');
        }])->with(['carmodel' => function ($sql) { $sql->select('modelid', 'modelname');
        }])->select('carid', 'carname', 'manuid', 'modelid')->get();
        return $this->sendResponse(LinkedCarengineResource::collection($cars), '');
    }
}
