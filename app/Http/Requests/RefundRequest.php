<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RefundRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comment' => 'nullable|string|max:1000',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'loan_id' => 'required|exists:loans,id',
            'interest' => 'required|numeric|min:0',
            'remain' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'loan_id.required' => 'Veuillez sélectionner un prêt.',
            'loan_id.exists' => 'Le prêt sélectionné est invalide.',
        ];
    }
}
