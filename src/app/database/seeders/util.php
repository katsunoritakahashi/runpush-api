<?php

namespace Illuminate\Database;

class Util
{
    public static function getRandomId($class) {
        $modelClassName = 'App\Models\\' . $class;
        $candidates = $modelClassName::all();
        return count($candidates)
            ? $candidates->random()->id
            : factory($modelClassName)->create()->id;
    }

    public static function getRandom($class) {
        $modelClassName = 'App\Models\\' . $class;
        $candidates = $modelClassName::all();
        return count($candidates)
            ? $candidates->random()
            : factory($modelClassName)->create();
    }

    public static function phoneNumber($faker) {
       return str_replace('-', '', $faker->phoneNumber);
    }
}
?>
