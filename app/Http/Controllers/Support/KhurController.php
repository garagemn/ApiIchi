<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Http\Requests\Khur\CarinfoRequest;
use App\Http\Resources\Warehouse\Car\KhurcarinfoResource;
use App\Models\Service\Khur\SpKhurcount;
use App\Models\Warehouse\Car\Carvin;
use App\Models\Warehouse\Car\VinKatashiki;
use App\Traits\ApiResponse;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class KhurController extends Controller
{
    use ApiResponse;

    protected $accesstoken;

    public function __construct()
    {
        $this->accesstoken = $this->connectKhur();
    }

    public function index(CarinfoRequest $request)
    {
        $carinfo = $this->carinfo($request->get('platenumber'));
        // \Log::info(array($carinfo));
        if(!$carinfo) return $this->sendError('Машины мэдээлэл олдсонгүй', '', 404);

        $car = new \stdClass();
        $car->platenumber = $carinfo->platenumber;
        $car->islandnumber = $carinfo->islandnumber;
        $car->buildyear = $carinfo->buildyear;
        $car->manufacture = $carinfo->manufacturer;
        $car->model = $carinfo->model;

        if($carinfo->manufacturer === 'TOYOTA' || $carinfo->manufacturer === 'LEXUS') {
            $hasKatashiki = VinKatashiki::where('vin', strtoupper($carinfo->islandnumber))->with(['katashikicar'])->first();
            if($hasKatashiki && $hasKatashiki->katashikicar) $car->carid = $hasKatashiki->katashikicar?->carid;
        } else {
            $hasCarvin = Carvin::where('vin', $carinfo->islandnumber)->select('carid')->first();
            if($hasCarvin) $car->carid = $hasCarvin->carid;
        }
        return $this->sendResponse(KhurcarinfoResource::make($car), '');
    }

    public function refreshdata(CarinfoRequest $request)
    {
        $carinfo = $this->carinforefresh($request->get('platenumber'));
        // \Log::info(array($carinfo));
        if(!$carinfo) return $this->sendError('Машины мэдээлэл олдсонгүй', '', 404);
        $this->khurcount($request->get('platenumber'));
        $car = new \stdClass();
        $car->platenumber = $carinfo->platenumber;
        $car->islandnumber = $carinfo->islandnumber;
        $car->buildyear = $carinfo->buildyear;
        $car->manufacture = $carinfo->manufacturer;
        $car->model = $carinfo->model;

        if($carinfo->manufacturer === 'TOYOTA' || $carinfo->manufacturer === 'LEXUS') {
            $hasKatashiki = VinKatashiki::where('vin', strtoupper($carinfo->islandnumber))->with(['katashikicar'])->first();
            if($hasKatashiki && $hasKatashiki->katashikicar) $car->carid = $hasKatashiki->katashikicar?->carid;
        } else {
            $hasCarvin = Carvin::where('vin', $carinfo->islandnumber)->select('carid')->first();
            if($hasCarvin) $car->carid = $hasCarvin->carid;
        }
        return $this->sendResponse(KhurcarinfoResource::make($car), '');
    }

    public function carinfo($platenumber)
    {
        if($this->accesstoken) {
            $url = config('services.khur_server') . '/carinfo';
            $client = new Client(['verify' => false]);
            $postdata = array(
                'platenumber' => $platenumber,
            );
            $clientRequest = $client->post($url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->accesstoken,
                ],
                'body' => json_encode($postdata),
            ]);
            $response = json_decode($clientRequest->getBody()->getContents());
            return $response;
        }
    }

    public function carinforefresh($platenumber)
    {
        if($this->accesstoken) {
            $url = config('services.khur_server') . '/getnewdata';
            $client = new Client(['verify' => false]);
            $postdata = array(
                'platenumber' => $platenumber,
                'channel' => 'service',
            );
            $clientRequest = $client->post($url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->accesstoken,
                ],
                'body' => json_encode($postdata),
            ]);
            $response = json_decode($clientRequest->getBody()->getContents());
            return $response;
        }
    }

    private function connectKhur()
    {
        $url = config('services.khur_server');
        $username = config('services.khur_username');
        $pwd = config('services.khur_pwd');
        if(!$url && !$username && !$pwd) return $this->sendError('Машины мэдээлэл тохироо хийгдээгүй байна', '', 404);
        $url = $url . '/login';
        try {
            $client = new Client(['verify' => false]);
            $fields = array(
                'email' => $username,
                'password' => $pwd
            );
            $clientRequest = $client->post($url, [
                'headers' => [ 'Content-Type' => 'application/json'],
                'body' => json_encode($fields),
            ]);
            $response = json_decode($clientRequest->getBody());
            return $response->token;
        } catch(\Exception $e) {
            \Log::info($e);
        }
    }

    public function khurcount($platenumber)
    {
        $user = auth()->user();
        $khurcount = new SpKhurcount();
        $khurcount->body = $platenumber;
        $khurcount->organization_id = $user->organization_id;
        $khurcount->user_id = $user->id;
        $khurcount->type = 'warehouse';
        $khurcount->save();
    }

}
