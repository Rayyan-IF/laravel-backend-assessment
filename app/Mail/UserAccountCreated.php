<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserAccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) 
    {
        
    }

    public function build()
    {
        return $this->subject('Welcome to Our Platform')
                    ->view('emails.user-account-created')
                    ->with([
                        'userName' => $this->user->name,
                        'userEmail' => $this->user->email,
                    ]);
    }
}
