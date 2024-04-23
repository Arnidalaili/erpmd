<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Notifications\PushNotification;
use App\Notifications\PushNotificationDemo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PushController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'endpoint' => 'required',
            'keys.auth' => 'required',
            'keys.p256dh' => 'required'
        ]);

        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $user = Auth::user();

        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true], 200);
    }

    public function pushdapatnotif()
    {

        $userIds = UserRole::whereIn('role_id', [1, 4])->pluck('user_id');

        foreach ($userIds as $userId) {
            $user = User::find($userId);

            Notification::send($user, new PushNotification());
        }


        return response()->json('Notification sent.', 201);
    }
}
