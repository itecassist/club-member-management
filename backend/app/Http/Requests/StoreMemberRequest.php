<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest {
    public function authorize(): bool 
    { 
        return true; 
    }
    
    public function rules(): array 
    { 
        return [
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['nullable', 'string', 'max:50'],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'mobile_phone' => ['required', 'string', 'max:30'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['required', 'in:female,male,other'],
            'member_number' => ['nullable', 'string', 'max:30'],
            'joined_at' => ['required', 'date'],
            'is_active' => ['boolean']
        ];
    }
}