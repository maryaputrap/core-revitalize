<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'color' => 'required|string|max:255',
            'port_from_id' => 'required|exists:ports,id',
            'port_to_id' => 'required|exists:ports,id',
            'tube_id' => 'nullable|exists:tubes,id',
        ];
    }
}
