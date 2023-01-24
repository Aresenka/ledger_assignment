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
        if(!Schema::hasTable('transaction')) {
            Schema::create('transaction', function (Blueprint $table) {
                $table->string('id')->unique();
                $table->string('idempotency_key')->unique();
                $table->string('status');
                $table->string('failure_reason')->nullable();
                $table->foreignId('from_account_id')->constrained('account');
                $table->foreignId('to_account_id')->constrained('account');
                $table->foreignId('currency_id')->constrained('currency');
                $table->bigInteger('amount');
                $table->timestamps();
            });

            Schema::table('transaction', function(Blueprint $table) {
                $table->primary('id');
                $table->index(['from_account_id', 'currency_id']);
                $table->index(['to_account_id', 'currency_id']);
                $table->index('status');
                $table->fullText('failure_reason');
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
        if(Schema::hasTable('transaction')) {
            Schema::table('transaction', function (Blueprint $table) {
                $table->dropFullText('failure_reason');
                $table->dropIndex('status');
                $table->dropIndex(['to_account_id', 'currency_id']);
                $table->dropIndex(['from_account_id', 'currency_id']);
                $table->dropPrimary('id');
            });

            Schema::dropIfExists('transaction');
        }
    }
};
