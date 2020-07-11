<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Migrationファイル
        Schema::create('histories', function (Blueprint $table) {
            $table->increments('id');
        //外部キー(従テーブルに主テーブルのプライマリキー「id」を保存するカラム)
        //外部キーは単数形の名前にするのが慣習
            $table->integer('news_id');
            
            $table->string('edited_at');
            
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
        Schema::dropIfExists('histories');
    }
}
