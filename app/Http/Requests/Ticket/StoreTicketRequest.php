<?php

namespace App\Http\Requests\Ticket;

use App\Support\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'category_id' => ['nullable', 'exists:ticket_categories,id'],
            'description' => ['required', 'string', 'max:5000'],
            'location' => ['required', 'string', 'max:191'],
            'priority' => ['required', 'string', 'in:'.implode(',', Ticket::priorities())],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => [
                'file',
                'max:'.config('ticket.max_attachment_size'),
                'mimes:'.implode(',', config('ticket.allowed_extensions')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul masalah wajib diisi.',
            'description.required' => 'Deskripsi masalah wajib diisi.',
            'location.required' => 'Lokasi/ruangan wajib diisi.',
            'priority.required' => 'Prioritas wajib dipilih.',
            'attachments.*.max' => 'Ukuran lampiran maksimal '.config('ticket.max_attachment_size').' KB.',
            'attachments.*.mimes' => 'Format lampiran tidak diizinkan.',
        ];
    }
}
