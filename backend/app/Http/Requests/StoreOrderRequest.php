<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest {
    public function authorize(): bool 
    { 
        return true; 
    }
    
    public function rules(): array 
    { 
        return [
            'member_id' => ['nullable', 'exists:members,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'payment_method' => ['required', 'string', 'max:255'],
            'order_status' => ['required', 'string'],
            'date_finished' => ['required', 'date'],
            'currency_code' => ['required', 'string', 'size:3'],
            'tax_total' => ['required', 'numeric'],
            'total' => ['required', 'numeric']
        ];
    }
}