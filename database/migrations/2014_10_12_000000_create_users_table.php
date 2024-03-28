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
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('username')->unique();
			$table->string('first_name');
			$table->string('middle_name')->nullable();
			$table->string('last_name');
			$table->string('suffix', 50)->nullable();
			$table->string('email')->unique();
			$table->enum('gender', ['male', 'female', 'others'])->default('others');
			$table->string('avatar')->default('default.png');
			$table->foreignId('user_type_id')->constrained('user_types')->cascadeOnDelete();
			$table->tinyInteger('login_attempts')->default(0);
			$table->tinyInteger('locked')->default(0);
			$table->ipAddress('locked_by')->nullable();
			$table->string('password');
			$table->dateTime('last_auth')->nullable();
			$table->rememberToken();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('users');
	}
};
