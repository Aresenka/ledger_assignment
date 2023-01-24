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
        if(!Schema::hasTable('currency')) {
            Schema::create('currency', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('ticker')->unique();
                $table->integer('units_amount');
                $table->timestamps();
            });

            Schema::table('currency', function (Blueprint $table) {
                $table->index('ticker');
                $table->index('name');
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
        if(Schema::hasTable('currency')) {
            Schema::table('currency', function (Blueprint $table) {
                $table->dropIndex('name');
                $table->dropPrimary('ticker');
            });

            Schema::dropIfExists('currency');
        }
    }
};
