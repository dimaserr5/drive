<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_attr', function (Blueprint $table) {

            $table->id();
            $table->string('type');
            $table->string('img');
        });

        DB::table('file_attr')->insert([
            'types' => "folder",
            'img' => "/storage/imgs/files_img/folder.png"
        ]);
        DB::table('file_attr')->insert([
            'types' => "png",
            'img' => "/storage/imgs/files_img/image.png"
        ]);
        DB::table('file_attr')->insert([
            'types' => "jpg",
            'img' => "/storage/imgs/files_img/image.png"
        ]);
        DB::table('file_attr')->insert([
            'types' => "jpeg",
            'img' => "/storage/imgs/files_img/image.png"
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_attr');
    }
};
