<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationAuthCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($register)
    {
        $this->token = $register->token;
        $this->type = $register->type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->type == 'reset' ? 'パスワード再設定' :'CAJICO（カジコ）へようこそ！';

        $authCode = $this->token;
        $from = config('mail.from.address');
        $fromName = config('mail.from.name');

        if ($this->type == 'reset') {
            return $this
                ->from($from, $fromName)
                ->subject($subject)
                ->view('emails.verification_reset_auth_code_mail')
                ->with('authCode', $authCode);
        } else {
            return $this
                ->from($from, $fromName)
                ->subject($subject)
                ->view('emails.verification_auth_code_mail')
                ->with('authCode', $authCode);
        }
    }
}
