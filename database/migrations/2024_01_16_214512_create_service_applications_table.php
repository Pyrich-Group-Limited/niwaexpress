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
        /* Schema::create('service_applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('service_id');
            $table->tinyInteger('application_form_payment_status')->default(0);
            $table->dateTime('date_of_inspection')->nullable();
            $table->string('service_type_id');
            $table->timestamps();
        }); */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_applications');
    }
};
