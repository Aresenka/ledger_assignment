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
        if(!Schema::hasTable('balance')){
            Schema::create('balance', function (Blueprint $table) {
                $table->id();
                $table->foreignId('account_id')->constrained('account');
                $table->foreignId('currency_id')->constrained('currency');
                $table->unsignedBigInteger('amount')->default(0);
                $table->timestamps();
            });

            Schema::table('balance', function (Blueprint $table) {
                $table->unique(['account_id', 'currency_id']);
                $table->index(['account_id', 'currency_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('balance')){
            Schema::table('balance', function (Blueprint $table) {
                $table->dropIndex(['account_id', 'currency_id']);
                $table->dropUnique(['account_id', 'currency_id']);
            });

            Schema::dropIfExists('balance');
        }
    }
};
