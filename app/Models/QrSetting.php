<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrSetting extends Model
{
	use HasFactory;
	protected $fillable = ['qr_type', 'main_logo', 'alternative_logo', 'selected_logo', 'background', 'color'];
}
