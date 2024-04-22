<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\ReportAction;
use App\Enums\ReportStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reportables', function (Blueprint $table) {
            $table->id();
			$table->uuid('uuid')->unique()->nullable();
			$table->foreignId('reported_by')->constrained('users')->onDelete('cascade');
			$table->morphs('reportable');
			$table->enum('status', ReportStatus::values())->default(ReportStatus::PENDING_REVIEW());
			$table->enum('action_taken', ReportAction::values())->default(ReportAction::AWAITING());
			$table->text('action_description', 8192)->nullable();
			$table->text('reason', 8192);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportables');
    }
};
