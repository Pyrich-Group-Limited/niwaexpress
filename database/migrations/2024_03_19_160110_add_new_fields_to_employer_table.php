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
        Schema::table('employers', function (Blueprint $table) {
            $table->string('user_type');
            $table->text('personal_address')->nullable();
            $table->string('contact_number')->nullable()->change();
            $table->string('company_name')->nullable()->change();
            $table->string('company_address')->nullable()->change();
            $table->string('company_email')->nullable()->change();
            $table->string('company_rcnumber')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->dropColumn('user_type');
            $table->dropColumn('personal_address');
            $table->string('contact_number')->change();
            $table->string('company_name')->change();
            $table->string('company_address')->change();
            $table->string('company_email')->change();
            $table->string('company_rcnumber')->change();
        });
    }
};
