<?php

namespace App\Console\Commands;

use App\Enums\Character;
use App\Jobs\SendPushMessage;
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

            // らんてくん
            $sendUserIds = User::where('end_at', '>', $now)->where('character_id', Character::RUNTEKUN)->pluck('id')->toArray();
            $title = 'カエルとキツネのキメラ';
            $message = 'カリキュラムの進捗はどうかな？応援してるゾ！';
            SendPushMessage::dispatch($sendUserIds, $title, $message, "https://runpush-prd.s3.ap-northeast-1.amazonaws.com/runtekun.png");

            // ひさじゅさん
            $sendUserIds = User::where('end_at', '>', $now)->where('character_id', Character::HISAJU)->pluck('id')->toArray();
            $title = '校長先生';
            $message = '仕事(twitter)ちゃんとしましょうー';
            SendPushMessage::dispatch($sendUserIds, $title, $message, "https://runpush-prd.s3.ap-northeast-1.amazonaws.com/hisaju.png");

            // らんてくん
            $sendUserIds = User::where('end_at', '>', $now)->where('character_id', Character::PHARAOH)->pluck('id')->toArray();
            $title = '𓉔𓍢𓃭𓄿𓂋𓄿𓍯';
            $message = '𓎡𓍯𓅓𓄿𓏏𓏏𓄿𓎡𓍯𓏏𓍯𓎼𓄿𓄿𓂋𓇌𓃀𓄿𓈖𓄿𓈖𓂧𓇌𓅓𓍯𓎡𓇋𓇋𓏏𓇌𓈖𓇌';
            SendPushMessage::dispatch($sendUserIds, $title, $message, "https://runpush-prd.s3.ap-northeast-1.amazonaws.com/pharaoh.png");
        }
    }
}
