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
		Schema::create('lost_founds', function (Blueprint $table) {
			$table->id();
			$table->enum("status", ["lost", "found"])->default("lost");
			$table->string("owner_name")->nullable();
			$table->string("founder_name")->default("Anonymous User");
			$table->string("item_found", 512);
			$table->string("item_image")->default("default.png");
			$table->string("item_description", 1000)->nullable();
			$table->string("place_found", 512);
			$table->date("date_found");
			$table->time("time_found");
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('lost_founds');
	}
};
