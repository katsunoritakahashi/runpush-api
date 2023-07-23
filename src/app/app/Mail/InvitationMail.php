<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;
    protected $verifyRoute = 'verify';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($register, $user)
    {
        $this->token = $register->token;
        $this->type = $register->type;
        $this->familyId = Crypt::encrypt($user->family_id);
        $this->userName = $user->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'CAJICOに招待されました！';

        $baseUrl = config('app.url');
        $url = "{$baseUrl}/{$this->verifyRoute}?type={$this->type}&token={$this->token}&familyId={$this->familyId}&utm_source=deeplink";
        $from = config('mail.from.address');
        $fromName = config('mail.from.name');

        return $this
            ->from($from, $fromName)
            ->subject($subject)
            ->view('emails.invitation_mail')
            ->with('url', $url)
            ->with('userName', $this->userName);
    }
}
