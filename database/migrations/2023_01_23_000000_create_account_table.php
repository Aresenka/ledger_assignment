<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('account')) {
            Schema::create('account', function (Blueprint $table) {
                $table->id();
                $table->string('uuid')->unique();
                $table->timestamps();
            });

            Schema::table('account', function (Blueprint $table) {
                $table->index('uuid');
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
        if (Schema::hasTable('account')) {
            Schema::table('account', function (Blueprint $table) {
                $table->dropIndex('uuid');
            });

            Schema::dropIfExists('account');
        }
    }
};
