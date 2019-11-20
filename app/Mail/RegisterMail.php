<?php

namespace App\Mail;

use App\Constants\RegisterMailConstant;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User
     *
     * @var User
     */
    public $user;

    /**
     * URL for email verification
     *
     * @var string
     */
    public $uri;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $uuid)
    {
        $this->user = $user;
        $this->uri  = env('APP_URL') . RegisterMailConstant::VERIFICATION_URI . '/' . $uuid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('sender@example.com')->view('mails.register-mail');
    }
}
