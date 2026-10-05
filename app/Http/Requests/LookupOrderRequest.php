<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LookupOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_code'     => ['required', 'string', 'max:50'],
            'customer_phone' => ['required', 'string', 'max:20'],
        ];
    }

    /**
     * Thông báo lỗi tiếng Việt
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'order_code.required'     => 'Vui lòng nhập mã đơn hàng (VD: ORD-20261004-XXXX).',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại đặt hàng.',
        ];
    }
}
