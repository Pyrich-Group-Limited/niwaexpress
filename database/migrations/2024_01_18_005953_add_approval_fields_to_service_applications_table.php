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
            $table->integer('mse_are_documents_verified')->default(0);
            $table->text('mse_document_verification_comment')->nullable();

            $table->integer('finance_is_application_fee_verified')->default(0);
            $table->integer('finance_is_processing_fee_verified')->default(0);
            $table->integer('finance_is_inspection_fee_verified')->default(0);

            $table->integer('inspection_status')->default(0);
            $table->text('comments_on_inspection')->nullable();
            $table->string('inspection_report_document_path')->nullable();

            $table->integer('are_equipment_and_monitoring_fees_verified')->default(0);

            $table->integer('area_officer_approval')->default(0);
            $table->string('area_officer_signature_path')->nullable();

            $table->integer('hod_marine_approval')->default(0);
            $table->string('hod_marine_signature_path')->nullable();

            $table->string('permit_document_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_applications', function (Blueprint $table) {
            $table->dropColumn('mre_are_documents_verified')->default(0);
            $table->dropColumn('mre_document_verification_comment')->nullable();

            $table->dropColumn('finance_is_application_fee_verified')->default(0);
            $table->dropColumn('finance_is_processing_fee_verified')->default(0);
            $table->dropColumn('finance_is_inspection_fee_verified')->default(0);

            $table->dropColumn('inspection_status')->default(0);
            $table->dropColumn('comments_on_inspection')->nullable();
            $table->dropColumn('inspection_report_document_path')->nullable();

            $table->dropColumn('are_equipment_and_monitoring_fees_verified')->default(0);

            $table->dropColumn('area_officer_approval')->default(0);
            $table->dropColumn('area_officer_signature_path')->nullable();

            $table->dropColumn('hod_marine_approval')->default(0);
            $table->dropColumn('hod_marine_signature_path')->nullable();

            $table->dropColumn('permit_document_path')->nullable();
        });
    }
};
