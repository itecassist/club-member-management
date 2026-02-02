<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest {
    public function authorize(): bool 
    { 
        return true; 
    }
    
    public function rules(): array 
    { 
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'membership' => ['required', 'in:basic,other'],
            'membership_type' => ['required', 'in:individual,group'],
            'period' => ['in:daily,weekly,monthly,yearly,lifetime,no_period,installments'],
            'renewals' => ['in:fixed_end_date,individual_anniversary,not_renewable'],
            'published' => ['in:published,renewal_only,unpublished']
        ];
    }
}