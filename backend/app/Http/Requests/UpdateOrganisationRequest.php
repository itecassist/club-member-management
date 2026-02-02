<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganisationRequest extends FormRequest {
    public function authorize(): bool 
    { 
        return true; 
    }
    
    public function rules(): array 
    { 
        return [
            'name' => ['string', 'max:255'],
            'seo_name' => ['string', 'max:64'],
            'email' => ['email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'free_trail' => ['boolean'],
            'free_trail_end_date' => ['date'],
            'billing_policy' => ['in:debit_order,wallet,invoice'],
            'is_active' => ['boolean']
        ];
    }
}