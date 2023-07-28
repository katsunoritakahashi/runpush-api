<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\CharacterMessage;
use Illuminate\Database\Seeder;

class CharacterMessagesSeeder extends Seeder
{
    private $messages = [
        [Character::RANTEKUN, 'カリキュラムの調子はどうかな？無理なく頑張ってくれよな！応援してるぞ！'],
        [Character::RANTEKUN, 'エンジニア転職を目指してる姿、とても素敵だぞ！着実に夢に近づいてるから無理せず頑張ってくれよな！'],
        [Character::RANTEKUN, 'カリキュラムで困ったことがあったら気軽に友達の「ロボカエルとキツネのキメラくん」に相談してみてくれよな！'],
        [Character::HISAJU, '仕事(twitter)ちゃんとしましょうー'],
        [Character::HISAJU, 'Vimちゃんと使えてますか？（圧）'],
        [Character::HISAJU, 'アモアスやりすぎると禁止にしますよー'],
        [Character::HISAJU, 'カリキュラムでわからないことあれば、是非「ロボカエルとキツネのキメラくん」に質問してみてくださいー'],
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
