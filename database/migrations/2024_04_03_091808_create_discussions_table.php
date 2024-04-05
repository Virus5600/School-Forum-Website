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
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
			$table->foreignId('category_id')->default(1)->constrained('discussion_categories')->cascadeOnDelete();
			$table->string('slug', 128)->unique();
			$table->string('title', 100);
			$table->text('content', 8192);
			$table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();
			$table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussions');
    }
};
