<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->integer('movie_id');
    $table->string('seat');
    $table->integer('total_price');
    $table->string('payment_method');
    $table->string('status');
    $table->timestamps();
});
    }
};
