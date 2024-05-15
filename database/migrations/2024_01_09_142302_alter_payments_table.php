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
        //
        Schema::table('payments', function (Blueprint $table) {
            $table->integer('service_id')->nullable();
            $table->integer('sub_service_id')->nullable();
            $table->string('letter_of_intent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('payments');
    }
};
