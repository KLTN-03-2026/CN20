<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_cards', function (Blueprint $table) {
    $table->id();
    $table->string('code')->unique(); // mã thẻ
    $table->string('level')->default('Bạc'); // Bạc / Vàng / Kim Cương
    $table->integer('discount')->default(5); // %
    $table->decimal('total_spent', 12, 2)->default(0); // tổng chi tiêu

    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('member_cards');
    }
};
