<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize()
    {
        // Optionally gate by policy
        return auth()->check();
    }

    public function rules()
    {
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:customers,email'],
            'phone' => ['nullable','string','max:30'],
            'password' => ['nullable','string','min:6','confirmed'],
            'address' => ['nullable','string','max:500'],
            'dob' => ['nullable','date'],
            'pin' => ['nullable','string','max:50'],
            'package_name' => ['nullable','string','max:255'],
            'package_price' => ['nullable','numeric','min:0'],
            'due' => ['nullable','numeric','min:0'],
            'package_start' => ['nullable','date'],
            'router_name' => ['nullable','string','max:255'],
            'router_password' => ['nullable','string','max:255'],
            'status' => ['required','in:active,inactive,suspended'],
        ];
    }
}
