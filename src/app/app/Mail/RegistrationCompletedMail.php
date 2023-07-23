<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'CAJICOの登録が完了しました！';
        $from = config('mail.from.address');
        $fromName = config('mail.from.name');

        return $this
            ->from($from, $fromName)
            ->subject($subject)
            ->view('emails.registration_completed_mail')
            ->with([
                'name' => $this->user->name,
            ]);
    }
}
