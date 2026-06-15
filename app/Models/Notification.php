<?php

namespace App\Models;

use App\Http\Controllers\PushController;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'type', 'title', 'message', 'url', 'is_read', 'read_at'];

    protected $casts = ['is_read' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Kirim notif ke satu user
    public static function send(int $userId, string $type, string $title, string $message, ?string $url = null): void
    {
        static::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'url' => $url,
            'is_read' => false,
        ]);

        // Kirim Web Push
        try {
            PushController::sendToUser($userId, $type, $title, $message, $url ?? '/');
        } catch (\Throwable $e) {
        }
    }

    // Kirim notif ke banyak user sekaligus
    public static function sendToMany(array $userIds, string $type, string $title, string $message, ?string $url = null): void
    {
        $now = now();
        $rows = array_map(fn ($id) => [
            'user_id' => $id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'url' => $url,
            'is_read' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ], $userIds);

        static::insert($rows);

        // Kirim Web Push ke semua
        try {
            PushController::sendToMany($userIds, $type, $title, $message, $url ?? '/');
        } catch (\Throwable $e) {
        }
    }
}
