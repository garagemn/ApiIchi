<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ichi\Order\EbarimtRequest;
use App\Traits\ApiResponse;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class EbarimtController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        
    }

    public function index(EbarimtRequest $request)
    {
        $url = config('services.ebarimt_server') . '/api/ebarimt/getname';
        $client = new Client(['verify' => false]);
        $clientRequest = $client->request('GET', $url, [
            'query' => [
                'regnumber' => $request->get('regnumber')
            ]
        ]);
        $response = json_decode($clientRequest->getBody()->getContents());
        if($response->status === 'success') {
            return $this->sendResponse(['corporatename' => $response->data], '');
        } else {
            return $this->sendError('Байгууллагын мэдээлэл олдсонгүй', '', 404);
        }
    }
}
