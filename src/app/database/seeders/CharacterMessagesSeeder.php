<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\CharacterMessage;
use Illuminate\Database\Seeder;

class CharacterMessagesSeeder extends Seeder
{
    private $messages = [
        [Character::RANTEKUN, 'カリキュラムの調子はどうかな？無理なく頑張ってくれよな！応援してるぞ！'],
        [Character::HISAJU, '仕事(twitter)ちゃんとしましょうー'],
        [Character::PHARAOH, '𓎡𓍯𓅓𓄿𓏏𓏏𓄿𓎡𓍯𓏏𓍯𓎼𓄿𓄿𓂋𓇌𓃀𓄿𓈖𓄿𓈖𓂧𓇌𓅓𓍯𓎡𓇋𓇋𓏏𓇌𓈖𓇌'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->messages as $index => $message) {
            CharacterMessage::updateOrCreate(
                ['id' => $index + 1],
                ['id' => $index + 1, 'character_id' => $message[0], 'message' => $message[1]]
            );
        }
    }
}
