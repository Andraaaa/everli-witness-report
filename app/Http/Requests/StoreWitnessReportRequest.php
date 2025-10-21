<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWitnessReportRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'query' => ['required', 'string', 'min:2'],
            'phone' => ['required', 'string'],
        ];
    }

    public function queryString(): string
    {
        return (string) $this->input('query');
    }

    public function phoneString(): string
    {
        return (string) $this->input('phone', '');
    }

    public function clientIpResolved(): string
    {
        $xff = $this->header('X-Forwarded-For');
        if ($xff) {
            $ips = explode(',', $xff);

            return trim($ips[0]);
        }

        return $this->ip();
    }
}
