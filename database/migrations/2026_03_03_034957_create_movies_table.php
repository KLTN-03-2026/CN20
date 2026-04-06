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
        Schema::create('movies', function (Blueprint $table) {
           $table->id();
            $table->string('ten_phim');
            $table->string('slug')->unique();
            $table->date('ngay_chieu')->nullable();
            $table->integer('thoi_luong')->nullable();
            $table->integer('dien_vien')->nullable();
            $table->string('dao_dien')->nullable();
            $table->string('nha_san_xuat')->nullable();
            $table->string('the_loai')->nullable();
            $table->string('gioi_han_do_tuoi')->nullable();
            $table->string('hinh_anh')->nullable();
            $table->string('trailer')->nullable();
            $table->string('ngon_ngu')->nullable();
            $table->text('chi_tiet')->nullable();
            $table->string('tinh_trang')->nullable(); // dangchieu / sapchieu
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
