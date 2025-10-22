<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\UserAccountCreated;
use App\Mail\NewUserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'string', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $this->sendUserConfirmationEmail($user);
        $this->sendAdminNotificationEmail($user);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at->format('Y-m-d\TH:i:s\Z'),
        ], 201);
    }

    private function sendUserConfirmationEmail($user)
    {
        Mail::to($user->email)->send(new UserAccountCreated($user));
    }

    private function sendAdminNotificationEmail($user)
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
        Mail::to($adminEmail)->send(new NewUserNotification($user));
    }
}
