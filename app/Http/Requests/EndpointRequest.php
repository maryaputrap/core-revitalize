<?php

namespace App\Http\Requests;

use App\Models\Container;
use App\Models\OptionReference\EndpointType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Veelasky\LaravelHashId\Rules\ExistsByHash;

class EndpointRequest extends FormRequest
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
            'type_id' => ['required', 'string', new ExistsByHash(EndpointType::class)],
            'container_id' => ['required', 'string', new ExistsByHash(Container::class)],
            'code' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'port_total' => ['required', 'integer', 'min:0'],
        ];
    }

    public function attributes(): array
    {
        return [
            'type_id' => 'Tipe Endpoint',
            'container_id' => 'Container',
            'code' => 'Kode',
            'name' => 'Nama',
            'port_total' => 'Jumlah Port',
        ];
    }
}
