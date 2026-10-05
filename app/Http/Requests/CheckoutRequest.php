<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'customer_name'     => ['required', 'string', 'max:255'],
            'customer_phone'    => ['required', 'string', 'regex:/^(0[3|5|7|8|9])[0-9]{8}$/'],
            'customer_email'    => ['nullable', 'email', 'max:255'],
            'shipping_address'  => ['required', 'string', 'max:500'],
            'shipping_city'     => ['nullable', 'string', 'max:100'],
            'shipping_district' => ['nullable', 'string', 'max:100'],
            'shipping_ward'     => ['nullable', 'string', 'max:100'],
            'payment_method'    => ['required', 'string', 'in:cod,banking'],
            'note'              => ['nullable', 'string', 'max:1000'],
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
            'customer_name.required'     => 'Vui lòng nhập họ và tên người nhận hàng.',
            'customer_phone.required'    => 'Vui lòng nhập số điện thoại người nhận.',
            'customer_phone.regex'       => 'Số điện thoại không đúng định dạng (VD: 0901234567 gồm 10 chữ số).',
            'customer_email.email'       => 'Địa chỉ email không hợp lệ.',
            'shipping_address.required'  => 'Vui lòng nhập địa chỉ nhận hàng chi tiết.',
            'payment_method.required'    => 'Vui lòng chọn phương thức thanh toán.',
            'payment_method.in'          => 'Phương thức thanh toán phải là COD hoặc Chuyển khoản ngân hàng.',
        ];
    }
}
