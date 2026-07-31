<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    /**
     * Catat aktivitas user (IP, browser, action, nilai lama & baru).
     */
    public function log(
        string $action,
        ?string $description = null,
        ?string $model = null,
        $modelId = null,
        $oldValue = null,
        $newValue = null,
        ?Request $request = null
    ): ActivityLog {
        $request = $request ?: request();

        return ActivityLog::create([
            'user_id' => Auth::id(),
            'ip' => $request?->ip(),
            'browser' => $this->browser($request),
            'action' => $action,
            'description' => $description,
            'model' => $model,
            'model_id' => $modelId,
            'old_value' => $this->encode($oldValue),
            'new_value' => $this->encode($newValue),
        ]);
    }

    protected function browser(?Request $request): ?string
    {
        $ua = $request?->userAgent();

        if (! $ua) {
            return null;
        }

        if (stripos($ua, 'Edg/') !== false) {
            return 'Edge';
        }

        if (stripos($ua, 'Chrome/') !== false) {
            return 'Chrome';
        }

        if (stripos($ua, 'Firefox/') !== false) {
            return 'Firefox';
        }

        if (stripos($ua, 'Safari/') !== false) {
            return 'Safari';
        }

        return 'Lainnya';
    }

    protected function encode($value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value) || is_object($value)) {
            return json_encode($value);
        }

        return (string) $value;
    }
}
