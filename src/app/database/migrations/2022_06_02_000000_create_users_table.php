<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('family_id')->nullable()->index('fk_user_family1_idx')->comment('家族ID');
            $table->foreign('family_id', 'fk_user_family1')->references('id')->on('families')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->string('name')->comment('名前');
            $table->unsignedInteger('position_id')->nullable()->index('fk_user_position1_idx')->comment('立場ID');
            $table->foreign('position_id', 'fk_user_position1')->references('id')->on('positions')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable()->comment('メールアドレス確認日時');
            $table->string('password')->comment('パスワード');
            $table->string('icon_url', 200)->nullable()->comment('iconURL');
            $table->string('device_token', 200)->nullable()->comment('デバイストークン');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
