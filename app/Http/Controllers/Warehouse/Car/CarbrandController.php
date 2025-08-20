<?php

namespace App\Http\Controllers\Warehouse\Car;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Car\Carbrand;
use Illuminate\Http\Request;

class CarbrandController extends Controller
{
    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
        $carbrands = Carbrand::activeCarbrands();
    }
}
