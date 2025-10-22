<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) 
    {
        
    }

    public function build()
    {
        return $this->subject('New User Registration')
                    ->view('emails.new-user-notification')
                    ->with([
                        'userName' => $this->user->name,
                        'userRole' => $this->user->role,
                        'userEmail' => $this->user->email,
                        'registrationDate' => $this->user->created_at->format('d M Y H:i:s'),
                    ]);
    }
}
