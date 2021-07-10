<?php

namespace App\Http\Requests\Api;


/**
 * Class PlacesByRangeRequest
 * @package App\Http\Requests\Api
 */
class PlacesByRangeRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'target_id' => ['required', 'numeric', 'exists:places,id'],
            'range' => ['required', 'numeric', $this->regex_array['unsigned_integer'],],
        ];
    }
}
