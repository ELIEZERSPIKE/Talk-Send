<?php

namespace App\Response;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiResponse
{
    
    public static function rollback(
        $e,
        $message = "Des problème est survenu. Prière de reprendre le processus"
    ) {
        DB::rollback();
        self::throw($e, $message);
    }
    
    public static function throw(
        $e,
        $message = "Des problème d'origine est survenu. Prière de reprendre le processus."
    ) {
        Log::info($e);
        throw new HttpResponseException(response()->json(["message" => $message], 500));
    }
    
    public static function sendResponse($requestState = true, $result, $message, $code = 200) {
        $response = [
            'success' => $requestState, 
            'data' => $result
        ];
        if (!empty($message)) {
            $response['message'] = $message;
        }
        return response()->json($response, $code);
    }
    
    
       
}
