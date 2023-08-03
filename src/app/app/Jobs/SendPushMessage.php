<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class SendPushMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userIds;
    private $title;
    private $body;
    private $imageUrl;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct
    (
        array $userIds,
        string $title,
        string $body,
        string $imageUrl
    )
    {
        $this->userIds = $userIds;
        $this->title = $title;
        $this->body = $body;
        $this->imageUrl = $imageUrl;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::whereIn('id', $this->userIds)->get();
        $tokens = array_values(array_filter($users->pluck('device_token')->toArray()));
        $serviceAccount = ServiceAccount::fromValue([
            'type' => 'service_account',
            'project_id' => config('services.firebase.service_key.project_id'),
            'private_key_id' => config('services.firebase.service_key.private_key_id'),
            'private_key' => config('services.firebase.service_key.private_key'),
            'client_email' => config('services.firebase.service_key.client_email'),
            'client_id' => config('services.firebase.service_key.client_id'),
            'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
            'token_uri' => 'https://oauth2.googleapis.com/token',
            'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
            'client_x509_cert_url' => config('services.firebase.service_key.client_x509_cert_url'),
        ]);

        $factory = (new Factory)
            ->withServiceAccount($serviceAccount);

        if (count($tokens) > 0) {
            $messaging = $factory->createMessaging();
            $notification = Notification::create($this->title, $this->body, $this->imageUrl);

            $message = CloudMessage::withTarget('token', $tokens[0])
                ->withNotification($notification)->withApnsConfig(
                    ApnsConfig::fromArray([
                        'payload' => [
                            'aps' => [
                                'mutable-content' => 1,
                            ],
                        ],
                    ])
                );

            if (count($tokens) === 1) {
                $messaging->send($message);
            } else {
                $chunks = array_chunk($tokens, 300);
                foreach ($chunks as $chunk) {
                    $messaging->sendMulticast($message, $chunk);
                }
            }
        }
    }
}

