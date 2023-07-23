<?php

namespace App\Jobs;

use App\Models\Notice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateNotice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $users;
    private $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct
    (
        $users,
        string $message,
    )
    {
        $this->users = $users;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->users as $user) {
            Notice::create([
                'user_id' => $user->id,
                'message' => $this->message
            ]);
        }
    }
}

