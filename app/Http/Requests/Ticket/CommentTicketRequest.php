<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class CommentTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'comment' => ['required', 'string', 'max:5000'],
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
            'comment.required' => 'Komentar wajib diisi.',
            'attachments.*.max' => 'Ukuran lampiran maksimal '.config('ticket.max_attachment_size').' KB.',
            'attachments.*.mimes' => 'Format lampiran tidak diizinkan.',
        ];
    }
}
