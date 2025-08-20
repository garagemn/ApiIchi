<?php

namespace App\Traits;

trait ApiResponse {

    public function sendResponse($result, $message, $iv = null)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
            'iv' => $iv,
        ];
        return response()->json($response, 200);
    }

    public function sendResponsePagination($paginator, $result, $message, $iv = null)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'pagination' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'next_page_url' => $paginator->nextPageUrl(),
            ],
            'message' => $message,
            'iv' => $iv
        ];
        return $response;
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
            'statuscode' => $code,
            'iv' => null
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}