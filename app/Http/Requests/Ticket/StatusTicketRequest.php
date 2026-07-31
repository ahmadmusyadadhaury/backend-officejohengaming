<?php

namespace App\Http\Requests\Ticket;

use App\Support\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class StatusTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:'.implode(',', Ticket::statuses())],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status tujuan wajib diisi.',
            'status.in' => 'Status tidak valid.',
        ];
    }
}
