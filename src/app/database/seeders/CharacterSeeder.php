<?php

namespace Database\Seeders;

use App\Models\Character;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    private $characters = [
        1 => ['カエルとキツネのキメラ', 'https://runpush-prd.s3.ap-northeast-1.amazonaws.com/runtekun.png'],
        2 => ['校長先生', 'https://runpush-prd.s3.ap-northeast-1.amazonaws.com/hisaju.png'],
        3 => ['𓉔𓍢𓃭𓄿𓂋𓄿𓍯', 'https://runpush-prd.s3.ap-northeast-1.amazonaws.com/pharaoh.png'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->characters as $index => $character) {
            Character::updateOrCreate(
                ['id' => $index],
                ['id' => $index, 'name' => $character[0], 'image_url' => $character[1]]
            );
        }
    }
}
