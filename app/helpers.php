<?php

/**
 *
 * @param string $message
 * 
 * 
 * @return Illuminate\Http\JsonResponse
 *  */

function sendSuccessResponse(string $message)
{
    return response()->json([
        "status"=>200,
        "message"=>$message,
    ]);
}


/**
 * 
 * @return Illuminate\Http\JsonResponse
 * 
 *  */

function sendForbiddenResponse()
{
    return response(["message"=>"You don't have permission to access this resource"], 403);
}



/**
 * @param int $status 
 * @param string $message
 * @param array $data
 * 
 * @return Illuminate\Http\JsonResponse
 *  */

function sendJsonResponse(int $status, string $message, array $data): Illuminate\Http\JsonResponse
{
    // return "hello world";
    return response()->json([
        "status"=>$status,
        "message"=>$message,
        "data"=>$data
    ]);

}

