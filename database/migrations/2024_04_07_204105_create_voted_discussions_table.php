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
        Schema::create('voted_discussions', function (Blueprint $table) {
            $table->id();
			$table->enum('type', ['upvote', 'downvote']);
			$table->foreignId('discussion_id')->constrained('discussions')->cascadeOnDelete();
			$table->foreignId('voted_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voted_discussions');
    }
};
