<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\{JsonResponse};
use App\Traits\RespondsWithHttpStatusTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class StatusChnageRequest extends FormRequest
{

    use RespondsWithHttpStatusTrait;

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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'invoice' => 'required|string',
            'amount' => 'required|min:0.1|max:99999999|regex:/^\d+(\.\d{1,2})?$/|gt:0',
        ];
    }

    public function failedValidation(Validator $validator): JsonResponse

    {
        throw new HttpResponseException($this::failure($validator->errors(), ['error' => __('Validation errors')]));
    }



    public function messages(): array

    {

        return [];
    }
}
