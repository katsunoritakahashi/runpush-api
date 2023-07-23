<?php

namespace App\Console\Commands;

use App\Jobs\SendPushMessage;
use App\Models\Character;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class sendPush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'push通知の送信';

    const START_TIME = 8;
    const END_TIME = 24;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $startTime = Carbon::today()->setHour(self::START_TIME);
        $endTime = Carbon::today()->setHour(self::END_TIME);

        if ($now->between($startTime, $endTime)) {
            // ランダムなキャラクターを選定し、、そのキャラクターを選んだユーザーにpush通知を送る
            $character = Character::inRandomOrder()->first();
            $sendUserIds = User::where('end_at', '>', $now)->where('character_id', $character->id)->pluck('id')->toArray();
            $message = $character->messages()->inRandomOrder()->first();

            SendPushMessage::dispatch($sendUserIds, $character->name, $message->message, $character->image_url);
        }
    }
}
