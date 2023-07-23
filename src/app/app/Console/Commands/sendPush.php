<?php

namespace App\Console\Commands;

use App\Jobs\SendPushMessage;
use App\Models\User;
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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sendUserIds = User::where('end_at', '>', now())->pluck('id')->toArray();
        $message = 'テスト';

        // push通知送信&お知らせ作成
        SendPushMessage::dispatch($sendUserIds, 'タイトル', $message);
    }
}
