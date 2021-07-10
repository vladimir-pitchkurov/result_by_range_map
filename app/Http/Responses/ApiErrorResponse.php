<?php


namespace App\Http\Responses;


use Illuminate\Http\JsonResponse;

class ApiErrorResponse extends JsonResponse
{
    public function __construct(string $message, $status = 400, $code = 4000, $data = null, $headers = [], $options = 0)
    {
        $success = false;
        $error = compact('message', 'code');
        parent::__construct(compact('success', 'data', 'error'), $status, $headers, $options);
    }
}
