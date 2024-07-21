<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\QrSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SettingController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//Obtener el usuario autenticado
		$user = Auth::user();

		//Obtener las variables desde el archivo .env
		$logo               = env('APP_LOGO');
		$mail_mailer        = env('MAIL_MAILER');
		$mail_host          = env('MAIL_HOST');
		$mail_port          = env('MAIL_PORT');
		$mail_username      = env('MAIL_USERNAME');
		$mail_encryption    = env('MAIL_ENCRYPTION');
		$mail_from_address  = env('MAIL_FROM_ADDRESS');

		$aws_access_key_id  = env('AWS_ACCESS_KEY_ID');
		$aws_secret_access_key = env('AWS_SECRET_ACCESS_KEY');
		$aws_default_region  = env('AWS_DEFAULT_REGION');
		$aws_bucket  = env('AWS_BUCKET');

		return view('panel.settings.index', compact([
			'user',
			'logo',
			'mail_mailer',
			'mail_host',
			'mail_port',
			'mail_username',
			'mail_encryption',
			'mail_from_address',
			'aws_access_key_id',
			'aws_secret_access_key',
			'aws_default_region',
			'aws_bucket'
		]));
	}

	public function edit()
	{
		//Obtener el usuario autenticado
		$user = Auth::user();

		//Obtener la configuración para los QR
		$qr_settings = QrSetting::first();
		$main_logo = $qr_settings ? $qr_settings->main_logo : '';
		$alternative_logo = $qr_settings ? $qr_settings->alternative_logo : '';
		$background = $qr_settings ? $qr_settings->background : '#FFEDE3';
		$color = $qr_settings ? $qr_settings->color : '#3B8D2A';
		$selected_logo = $qr_settings ? $qr_settings->selected_logo : 'main_logo';

		//Obtener las variables desde el archivo .env
		$logo               = env('APP_LOGO');
		$mail_mailer        = env('MAIL_MAILER');
		$mail_host          = env('MAIL_HOST');
		$mail_port          = env('MAIL_PORT');
		$mail_username      = env('MAIL_USERNAME');
		$mail_encryption    = env('MAIL_ENCRYPTION');
		$mail_from_address  = env('MAIL_FROM_ADDRESS');
		$mail_password      = env('MAIL_PASSWORD');

		$aws_access_key_id  = env('AWS_ACCESS_KEY_ID');
		$aws_secret_access_key = env('AWS_SECRET_ACCESS_KEY');
		$aws_default_region  = env('AWS_DEFAULT_REGION');
		$aws_bucket  = env('AWS_BUCKET');

		return view('panel.settings.edit', compact([
			'user',
			'logo',
			'mail_mailer',
			'mail_host',
			'mail_port',
			'mail_username',
			'mail_password',
			'mail_encryption',
			'mail_from_address',
			'aws_access_key_id',
			'aws_secret_access_key',
			'aws_default_region',
			'aws_bucket',
			'main_logo',
			'alternative_logo',
			'background',
			'color',
			'selected_logo'
		]));
	}

	public function setEnvironmentValue($envKey, $envValue)
	{
		$path = base_path('.env');
		$file = file_get_contents($path);

		$oldValue = env($envKey);

		if (file_exists($path)) {
			file_put_contents($path, Str::replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $file));
		}
	}

	public function update(Request $request)
	{
		//Verificar si se agregó un nuevo logo
		if ($request->hasFile('logo')) {
			$file = $request->file('logo');
			$name = time() . "." . $file->getClientOriginalExtension();
			$path = 'img/' . $name;
			$file->storeAs(null, $path, 'public');
			$this->setEnvironmentValue('APP_LOGO', $path);
		}

		$qr_settings = QrSetting::first();

		//Verificar si se agregó un nuevo logo principal para los QR
		if ($request->hasFile('qr_main_logo')) {
			$file = $request->file('qr_main_logo');
			$name = time() . "." . $file->getClientOriginalExtension();
			$path = 'img/' . 'main_' . $name;
			$qr_settings->main_logo = $path;
			$file->storeAs(null, $path, 'public');
		}

		//Verificar si se agregó un nuevo logo alternativo para los QR
		if ($request->hasFile('qr_alternative_logo')) {
			$file = $request->file('qr_alternative_logo');
			$name = time() . "." . $file->getClientOriginalExtension();
			$path = 'img/' . 'alternative_' . $name;
			$file->storeAs(null, $path, 'public');

			$qr_settings->alternative_logo = $path;
		}

		$qr_settings->background = $request->background;
		$qr_settings->color = $request->color;
		$qr_settings->selected_logo = $request->selected_logo;
		$qr_settings->update();

		//Información de mensajería
		$this->setEnvironmentValue('MAIL_MAILER', $request->mail_mailer);
		$this->setEnvironmentValue('MAIL_HOST', $request->mail_host);
		$this->setEnvironmentValue('MAIL_PORT', $request->mail_port);
		$this->setEnvironmentValue('MAIL_USERNAME', $request->mail_username);
		$this->setEnvironmentValue('MAIL_ENCRYPTION', $request->mail_encryption);
		$this->setEnvironmentValue('MAIL_FROM_ADDRESS', $request->mail_from_address);
		$this->setEnvironmentValue('MAIL_PASSWORD', $request->mail_password);

		//Información de AWS
		$this->setEnvironmentValue('AWS_ACCESS_KEY_ID', $request->aws_access_key_id);
		$this->setEnvironmentValue('AWS_SECRET_ACCESS_KEY', $request->aws_secret_access_key);
		$this->setEnvironmentValue('AWS_DEFAULT_REGION', $request->aws_default_region);
		$this->setEnvironmentValue('AWS_BUCKET', $request->aws_bucket);

		return back();
	}
}
