<?php

namespace App\Http\Requests\Ticket;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AssignTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isTicketLeader();
    }

    public function rules(): array
    {
        return [
            'assigned_to' => ['required', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'assigned_to.required' => 'Pilih teknisi yang ditugaskan.',
            'assigned_to.exists' => 'Teknisi tidak ditemukan.',
        ];
    }

    public function technician(): User
    {
        return User::findOrFail($this->assigned_to);
    }
}
