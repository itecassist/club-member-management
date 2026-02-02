<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest {
    public function authorize(): bool 
    { 
        return true; 
    }
    
    public function rules(): array 
    { 
        return [
            'title' => ['nullable', 'string', 'max:50'],
            'first_name' => ['string', 'max:50'],
            'last_name' => ['string', 'max:50'],
            'email' => ['email', 'max:255'],
            'mobile_phone' => ['string', 'max:30'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['in:female,male,other'],
            'member_number' => ['nullable', 'string', 'max:30'],
            'is_active' => ['boolean']
        ];
    }
}