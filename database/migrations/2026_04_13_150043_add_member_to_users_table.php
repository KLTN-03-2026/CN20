<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('member_type')->default('normal');
        $table->integer('member_discount')->default(0);
    });
}
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
