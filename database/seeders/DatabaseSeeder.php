<?php

namespace Database\Seeders;

use App\Models\QrSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		QrSetting::create([
			'main_logo' => 'img/bg_qr.jpg',
			'alternative_logo' => 'img/bg_qr_alternative.jpg',
			'background' => '4287f5'
		]);
	}
}
