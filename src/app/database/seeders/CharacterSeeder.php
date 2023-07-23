<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    private $positions = [
        '旦那',
        '妻',
        '息子',
        '娘',
        '祖父',
        '祖母',
        '叔父',
        '叔母',
        '彼氏',
        '彼女',
        '父',
        '母',
        'その他',
    ];
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->positions as $position) {
            Position::Create(
                ['name' => $position],
            );
        }
    }
}
