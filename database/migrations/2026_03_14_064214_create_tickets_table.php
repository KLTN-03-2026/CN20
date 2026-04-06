<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('tickets', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('movie');
        $table->string('room');
        $table->string('seat');
        $table->string('showtime');
        $table->integer('price');
        $table->string('poster')->nullable();
        $table->timestamps();
    });
}
    


    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
