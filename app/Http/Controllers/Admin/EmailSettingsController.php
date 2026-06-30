<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class EmailSettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.email', [
            'mailFromAddress' => env('MAIL_FROM_ADDRESS', ''),
            'mailFromName' => env('MAIL_FROM_NAME', ''),
            'tokenLowRecipients' => env('TOKEN_LOW_EMAIL_RECIPIENTS', ''),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'nullable|string|max:100',
            'token_low_recipients' => 'required|string',
        ]);

        $recipients = array_map('trim', explode(',', $validated['token_low_recipients']));
        foreach ($recipients as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return back()->withErrors(['token_low_recipients' => "Email '$email' tidak valid."])->withInput();
            }
        }

        $this->saveToEnv([
            'MAIL_FROM_ADDRESS' => $validated['mail_from_address'],
            'MAIL_FROM_NAME' => $validated['mail_from_name'] ?? 'Johen Office System',
            'TOKEN_LOW_EMAIL_RECIPIENTS' => implode(',', $recipients),
        ]);

        Artisan::call('config:clear');

        return redirect()->route('admin.settings.email')->with('success', 'Pengaturan email berhasil disimpan.');
    }

    private function saveToEnv(array $replacements): void
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            return;
        }

        $content = file_get_contents($envPath);

        foreach ($replacements as $key => $value) {
            $escapedValue = (strpbrk($value, ' "#') !== false || str_contains($value, "'")) 
                ? '"' . str_replace(['\\', '"'], ['\\\\', '\\"'], $value) . '"' 
                : $value;
            $pattern = '/^' . preg_quote($key, '/') . '=.*/m';
            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, $key . '=' . $escapedValue, $content);
            } else {
                $content .= "\n" . $key . '=' . $escapedValue;
            }
        }

        file_put_contents($envPath, $content);
    }
}
