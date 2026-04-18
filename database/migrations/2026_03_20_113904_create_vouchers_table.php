<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

   public function up(){
    Schema::create('vouchers', function (Blueprint $table) {
        $table->id();
        $table->string('code');          // mã giảm giá
        $table->string('type');          // fixed
        $table->integer('value');        // giá trị
        $table->date('start');           // ngày bắt đầu
        $table->date('end');             // ngày kết thúc
        $table->timestamps();
    });
}

  
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
