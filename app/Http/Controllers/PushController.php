<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class PushController extends Controller
{
    // Simpan subscription dari browser
    public function subscribe(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|string',
            'p256dh'   => 'required|string',
            'auth'     => 'required|string',
        ]);

        DB::table('push_subscriptions')->updateOrInsert(
            ['user_id' => auth()->id(), 'endpoint' => substr($request->endpoint, 0, 500)],
            [
                'p256dh'     => $request->p256dh,
                'auth'       => $request->auth,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return response()->json(['success' => true]);
    }

    // Hapus subscription (saat logout)
    public function unsubscribe(Request $request)
    {
        DB::table('push_subscriptions')
            ->where('user_id', auth()->id())
            ->where('endpoint', substr($request->endpoint ?? '', 0, 500))
            ->delete();

        return response()->json(['success' => true]);
    }

    // Kirim push ke user tertentu (dipanggil dari Notification::send)
    public static function sendToUser(int $userId, string $title, string $body, string $url = '/'): void
    {
        $subs = DB::table('push_subscriptions')->where('user_id', $userId)->get();
        if ($subs->isEmpty()) return;

        $auth = [
            'VAPID' => [
                'subject'    => env('VAPID_SUBJECT', 'mailto:admin@example.com'),
                'publicKey'  => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ];

        $webPush = new WebPush($auth);

        foreach ($subs as $sub) {
            $subscription = Subscription::create([
                'endpoint'        => $sub->endpoint,
                'keys'            => [
                    'p256dh' => $sub->p256dh,
                    'auth'   => $sub->auth,
                ],
            ]);

            $payload = json_encode([
                'title' => $title,
                'body'  => $body,
                'url'   => $url,
                'icon'  => '/images/logo/logo_web.png',
            ]);

            $webPush->queueNotification($subscription, $payload);
        }

        foreach ($webPush->flush() as $report) {
            // Hapus subscription yang tidak valid
            if (!$report->isSuccess()) {
                DB::table('push_subscriptions')
                    ->where('endpoint', substr($report->getRequest()->getUri()->__toString(), 0, 500))
                    ->delete();
            }
        }
    }

    // Kirim push ke banyak user
    public static function sendToMany(array $userIds, string $title, string $body, string $url = '/'): void
    {
        foreach ($userIds as $userId) {
            static::sendToUser($userId, $title, $body, $url);
        }
    }

    public function vapidPublicKey()
    {
        return response()->json(['key' => env('VAPID_PUBLIC_KEY')]);
    }
}
