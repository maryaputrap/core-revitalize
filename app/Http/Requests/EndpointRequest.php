<?php

namespace App\Http\Requests;

use App\Models\Cluster;
use App\Models\Container;
use App\Models\OptionReference\EndpointType;
use App\Enums\OptionReference\EndpointType as EndpointTypeEnums;
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
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->routeIs('fdt.*')) {
            $this->merge([
                'type_id' => EndpointType::query()->where('code', EndpointTypeEnums::FAT())->first()->hash,
            ]);
        } elseif ($this->routeIs('jb.*')) {
            $this->merge([
                'type_id' => EndpointType::query()->where('code', EndpointTypeEnums::JB())->first()->hash,
            ]);
        }
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
            'cluster_id' => ['nullable', 'sometimes', 'string', new ExistsByHash(Cluster::class)],
            'container_id' => ['nullable', 'sometimes', 'string', new ExistsByHash(Container::class)],
            'name' => ['required', 'string', 'max:255'],
            'port_total' => ['required', 'integer', 'min:0'],
            'latitude' => ['sometimes', 'nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['sometimes', 'nullable', 'numeric', 'between:-180,180'],
        ];
    }

    public function attributes(): array
    {
        return [
            'type_id' => 'Tipe Endpoint',
            'container_id' => 'Container',
            'name' => 'Nama',
            'port_total' => 'Jumlah Port',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        $this->replace([
            'latitude' => floatval($this->input('latitude')),
            'longitude' => floatval($this->input('longitude'))
        ]);
    }
}
