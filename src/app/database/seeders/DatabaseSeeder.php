<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PositionSeeder::class,
            HouseWorkCategoryImageSeeder::class,
            HouseWorkCategorySeeder::class,
            RewardCategoryImageSeeder::class,
            RewardCategorySeeder::class,
            StampSeeder::class,
            OperatorSeeder::class,
            FamilySeeder::class,
            HouseWorkSeeder::class,
            RewardSeeder::class,
            PointHistorySeeder::class,
            InquirySeeder::class,
            NoticeSeeder::class,
            NoticeManuscriptSeeder::class,
            ScheduleSeeder::class,
        ]);
    }
}
