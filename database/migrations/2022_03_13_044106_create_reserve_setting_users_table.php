<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReserveSettingUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserve_setting_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('ユーザーID');
            $table->unsignedBigInteger('reserve_setting_id')->comment('カレンダー予約ID');
            $table->timestamp('created_at')->nullable()->comment('登録日時');

            // 外部キー制約の追加
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('reserve_setting_id')->references('id')->on('reserve_settings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserve_setting_users');
    }
}