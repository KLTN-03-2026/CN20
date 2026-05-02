<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('movie_id');
        $table->string('user_name');
        $table->integer('rating');
        $table->text('comment');
        $table->timestamps();

        $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
    });
}
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
