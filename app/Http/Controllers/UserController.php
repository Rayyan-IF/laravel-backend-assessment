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
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string',
            'page' => 'nullable|integer|min:1',
            'sortBy' => 'nullable|string|in:name,email,created_at',
        ]);

        // Mocked currently logged-in user for can_edit logic
        $currentUser = [
            'id' => 1,
            'role' => 'admin',
        ];

        $query = User::where('active', true)->withCount('orders');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")->orWhere('email', 'ILIKE', "%{$search}%");
            });
        }

        $sortBy = $request->get('sortBy', 'created_at');
        $query->orderBy($sortBy, 'asc');

        $users = $query->paginate(10);

        // Transform data and add can_edit field
        $transformedUsers = $users->getCollection()->map(function ($user) use ($currentUser) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
                'email' => $user->email,
                'orders_count' => $user->orders_count,
                'can_edit' => $this->canEdit($currentUser, $user),
                'created_at' => $user->created_at->format('Y-m-d\TH:i:s\Z'),
            ];
        });

        return response()->json([
            'page' => $users->currentPage(),
            'users' => $transformedUsers,
        ]);
    }

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

    private function canEdit($currentUser, $targetUser)
    {
        if ($currentUser['role'] === 'admin') {
            return true;
        }

        if ($currentUser['role'] === 'manager') {
            return $targetUser->role === 'user';
        }

        if ($currentUser['role'] === 'user') {
            return $currentUser['id'] === $targetUser->id;
        }

        return false;
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
