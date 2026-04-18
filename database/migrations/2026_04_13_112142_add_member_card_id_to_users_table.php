<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->unsignedBigInteger('member_card_id')->nullable();

            $table->foreign('member_card_id')
                  ->references('id')
                  ->on('member_cards')
                  ->onDelete('set null');

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['member_card_id']);
            $table->dropColumn('member_card_id');

        });
    }
};
