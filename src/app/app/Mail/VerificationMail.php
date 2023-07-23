<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;
    protected $verifyRoute = 'verify';

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

        $baseUrl = config('app.url');
        $url = "{$baseUrl}/{$this->verifyRoute}?type={$this->type}&token={$this->token}&utm_source=deeplink";
        $from = config('mail.from.address');
        $fromName = config('mail.from.name');

        if ($this->type == 'reset') {
            return $this
                ->from($from, $fromName)
                ->subject($subject)
                ->view('emails.verification_reset_mail')
                ->with('url', $url);
        } else {
            return $this
                ->from($from, $fromName)
                ->subject($subject)
                ->view('emails.verification_mail')
                ->with('url', $url);
        }
    }
}
