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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
			$table->string('poster')->default('default.png');
			$table->string('title');
			$table->string('slug');
			$table->string('summary', 512)->nullable();
			$table->mediumText('content')->nullable();
			$table->tinyInteger('is_draft')->default(1);
			$table->timestamp('published_at')->nullable();
			$table->foreignId('author_id')->nullable()->constrained('users');
			$table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
