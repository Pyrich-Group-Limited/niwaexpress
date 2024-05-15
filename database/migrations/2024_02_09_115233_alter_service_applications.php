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
        Schema::table('service_applications', function (Blueprint $table) {
            $table->decimal('latitude1', 15, 7)->nullable();
            $table->decimal('longitude1', 15, 7)->nullable();
            $table->decimal('latitude2', 15, 7)->nullable();
            $table->decimal('longitude2', 15, 7)->nullable();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
