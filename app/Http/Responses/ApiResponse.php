<?php


namespace App\Http\Responses;


use Illuminate\Http\JsonResponse;

class ApiResponse extends JsonResponse
{
    public function __construct($data = null, ?array $error = null, $status = 200, $headers = [], $options = 0)
    {
        $success = true;
        parent::__construct(compact('success', 'data', 'error'), $status, $headers, $options);
    }
}
