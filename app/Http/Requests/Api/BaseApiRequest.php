<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BaseApiRequest
 * @package App\Http\Requests\Api
 */
class BaseApiRequest extends FormRequest
{
    /**
     * @var array|string[]
     */
    protected array $regex_array = [
        'unsigned_integer' => 'regex:/^\d+$/',
        'integer' => 'regex:/^(-?)\d+$/',
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
