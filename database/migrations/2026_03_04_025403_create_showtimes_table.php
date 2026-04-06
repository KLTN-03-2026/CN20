<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('showtimes', function (Blueprint $table) {
        $table->id();

        $table->foreignId('movie_id')
              ->constrained()
              ->onDelete('cascade');

        $table->date('date');

        $table->time('start_time');

        $table->time('end_time');

        $table->string('room');

        $table->string('format'); // 2D, 3D, IMAX

        $table->integer('price'); // giá vé

        $table->string('status')->default('dangchieu');

        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('showtimes');
    }
};
