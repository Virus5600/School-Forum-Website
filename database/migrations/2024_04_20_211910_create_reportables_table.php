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
        Schema::create('reportables', function (Blueprint $table) {
            $table->id();
			$table->foreignId('reported_by')->constrained('users')->onDelete('cascade');
			$table->morphs('reportable');
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
