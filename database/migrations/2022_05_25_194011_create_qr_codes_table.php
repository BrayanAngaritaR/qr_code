<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('qr_codes', function (Blueprint $table) {
			$table->id();
			$table->string('code')->unique();
			$table->string('slug')->unique();
			$table->string('path')->nullable();
			$table->text('redirect_to')->nullable();
			$table->string('type'); //URL, Contact, Text, Email...
			$table->string('logo')->default('none');
			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('qr_codes');
	}
};
