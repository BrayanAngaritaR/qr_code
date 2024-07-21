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
		Schema::create('qr_settings', function (Blueprint $table) {
			$table->id();
			$table->string('qr_type')->default('square');
			$table->string('main_logo')->default('N/A');
			$table->string('alternative_logo')->default('N/A');
			$table->string('selected_logo')->default('main_logo');
			$table->string('background')->default('#FFEDE3');
			$table->string('color')->default('#3B8D2A');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('qr_settings');
	}
};
