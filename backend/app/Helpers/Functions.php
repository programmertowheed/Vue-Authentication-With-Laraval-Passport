<?php

/**
 * @param $message
 * @param array $data
 * @return \Illuminate\Http\JsonResponse
 */
function sendResponse( $message, $data = []){
    $response = [
        'status'  => true,
        'message' => $message
    ];

    !empty($data) ? $response['data'] = $data : null ;

    return response()->json( $response );
}


/**
 * @param $message
 * @param array $messages
 * @param int $code
 * @return \Illuminate\Http\JsonResponse
 */
function sendError( $message, $messages = [], $code = 404 ){
    $response = [
        'status'  => false,
        'message' => $message
    ];

    !empty($messages) ? $response['errors'] = $messages : null ;

    return response()->json( $response, $code );
}
