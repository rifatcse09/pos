<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\{JsonResponse};
use App\Traits\RespondsWithHttpStatusTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class OrderRequest extends FormRequest
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
            'customer_name' => 'required|string|max:50',
            'customer_email' => 'required|string|email|min:3|max:50',
            'customer_phone' => 'required|string|max:15|min:9',
            'customer_street' => 'required|string|min:2|max:200',
            'customer_city' => 'required|string|min:2|max:200',
            'customer_state' => 'required|string|min:2|max:200',
            'customer_zipcode' => 'required|string|min:3|max:8',
            'customer_country' => 'required|string|max:11',
            'product_name' => 'required|string||min:3|max:150',
            'product_description' => 'required|string|min:3|max:300',
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
