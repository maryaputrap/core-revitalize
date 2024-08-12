<?php

namespace App\Http\Requests;

use App\Models\Container;
use App\Models\OptionReference\EndpointType;
use App\Models\Port;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Veelasky\LaravelHashId\Rules\ExistsByHash;

class ConnectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'from_port_id' => ['required', 'string', new ExistsByHash(Port::class)],
            'to_port_id' => ['required', 'string', new ExistsByHash(Port::class)],
            'tube' => ['required', 'string', 'max:5'],
            'tube_color' => ['required', 'string', 'max:255'],
            'cable' => ['required', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'from_port_id' => 'Port Asal',
            'to_port_id' => 'Port Tujuan',
            'tube' => 'Tube',
            'tube_color' => 'Warna Tube',
            'cable' => 'Nama Kabel',
        ];
    }
}
