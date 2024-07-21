<?php

namespace App\Http\Controllers\Panel;

use App\Models\User\Qr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\QrSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth');
   }

   public function index()
   {
      $qr_codes = Qr::where('user_id', Auth::id())->latest()->get();
      return view('panel.qr.index', compact('qr_codes'));
   }

   public function show(Qr $qr)
   {
      return view('panel.qr.show', compact('qr'));
   }

   public function create()
   {
      $qr_settings = QrSetting::first();

      $color = $qr_settings->color;
      $backgroundColor = $qr_settings->background;

      return view('panel.qr.create', compact([
         'color',
         'backgroundColor',
         'qr_settings'
      ]));
   }

   function hexToRgb($hex, $alpha = false)
   {
      $hex      = str_replace('#', '', $hex);
      $length   = strlen($hex);
      $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
      $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
      $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
      if ($alpha) {
         $rgb['a'] = $alpha;
      }
      return $rgb;
   }

   public function store(Request $request)
   {
      //Definir valores por defecto
      $logo = false;
      $backgroundColor = $this->hexToRgb($request->backgroundColor);
      $qrColor = $this->hexToRgb($request->qrColor);

      if($request->qrForm){
         $qrForm = $request->qrForm;
      } else {
         $qrForm = 'square';
      }

      //Crear las reglas de validación
      $rules = [
         'content' => 'required'
      ];

      //Validar que sí se esté pasando información
      $customMessages = [
         'required' => 'Este campo es requerido.'
      ];

      $this->validate($request, $rules, $customMessages);

      //Obtener el último QR creado
      $id = Qr::latest()->first();

      if ($id) {
         $id = $id->id + 1;
      } else {
         $id = 1;
      }

      //Asignar una URL y un código de manera aleatoria
      $str = Str::random(4);
      $code = $id . $str;
      $slug = env('APP_URL') . $code;

      //Asignar el nombre a la imagen (QR)
      $imageName = 'img-' . $code . '.svg';

      //Verificar si agregar el logo o no
      if ($request->addLogo) {
         $logo = true;
      }

      //Verificar si el usuario quiere cambiar la configuración
      if ($request->saveSetting) {
         //Actualizar la configuración en la base de datos
      }

      //Especificar/Obtener el tipo de QR a generar 
      switch ($request->qrType) {
         case ('phone'):
            if ($logo) {
               $image = QrCode::margin(2)->format('png')->size(500)->style($qrForm)->color($qrColor['r'], $qrColor['g'], $qrColor['b'])->backgroundColor($backgroundColor['r'], $backgroundColor['g'], $backgroundColor['b'])->merge('https://ciberpaz.gov.co/855/channels-755_logo_micrositio.png', .3, true)->errorCorrection('H')->phoneNumber($request->content);
            } else {
               $image = QrCode::margin(2)->format('svg')->size(500)->style($qrForm)->color($qrColor['r'], $qrColor['g'], $qrColor['b'])->backgroundColor($backgroundColor['r'], $backgroundColor['g'], $backgroundColor['b'])->errorCorrection('H')->phoneNumber($request->content);
            }
            break;
         case ('sms'):

            if ($logo) {
               $image = QrCode::margin(2)->format('png')->size(500)->style($qrForm)->color($qrColor['r'], $qrColor['g'], $qrColor['b'])->backgroundColor($backgroundColor['r'], $backgroundColor['g'], $backgroundColor['b'])->merge('https://ciberpaz.gov.co/855/channels-755_logo_micrositio.png', .3, true)->errorCorrection('H')->SMS($request->content);
            } else {
               $image = QrCode::margin(2)->format('svg')->size(500)->style($qrForm)->color($qrColor['r'], $qrColor['g'], $qrColor['b'])->backgroundColor($backgroundColor['r'], $backgroundColor['g'], $backgroundColor['b'])->errorCorrection('H')->SMS($request->content);
            }
            break;
         case ('email'):
            //Crear las reglas de validación
            $rules = [
               'content' => 'required|email',
               'subject' => 'required|min:4|max:50',
               'message' => 'required|min:5|max:300'
            ];

            //Validar que sí se esté pasando información
            $customMessages = [
               'required' => 'Este campo es requerido.',
               'email' => 'Este campo debe ser un correo electrónico válido',
               'subject.min' => 'Este campo requiere mínimo :min caracteres',
               'subject.max' => 'Este campo requiere máximo :max caracteres',
               'message.min' => 'Este campo requiere mínimo :min caracteres',
               'message.max' => 'Este campo requiere máximo :max caracteres'
            ];

            $this->validate($request, $rules, $customMessages);

            //email, subject, message
            if ($logo) {
               $image = QrCode::margin(2)->format('png')->size(500)->style($qrForm)->color($qrColor['r'], $qrColor['g'], $qrColor['b'])->backgroundColor($backgroundColor['r'], $backgroundColor['g'], $backgroundColor['b'])->merge('https://ciberpaz.gov.co/855/channels-755_logo_micrositio.png', .3, true)->errorCorrection('H')->email($request->content, $request->subject, $request->message);
            } else {
               $image = QrCode::margin(2)->format('svg')->size(500)->style($qrForm)->color($qrColor['r'], $qrColor['g'], $qrColor['b'])->backgroundColor($backgroundColor['r'], $backgroundColor['g'], $backgroundColor['b'])->errorCorrection('H')->email($request->content, $request->subject, $request->message);
            }

            break;
         default:
            $image = QrCode::margin(2)->format('svg')->size(500)->style($qrForm)->color($qrColor['r'], $qrColor['g'], $qrColor['b'])->backgroundColor($backgroundColor['r'], $backgroundColor['g'], $backgroundColor['b'])->errorCorrection('H')->generate($slug);

            // if ($logo) {
            //    $image = QrCode::margin(2)->format('png')->size(500)->style($qrForm)->color($qrColor['r'], $qrColor['g'], $qrColor['b'])->backgroundColor($backgroundColor['r'], $backgroundColor['g'], $backgroundColor['b'])->merge('https://ciberpaz.gov.co/855/channels-755_logo_micrositio.png', .3, true)->generate($slug);
            // } else {
               
            // }
      }

      $content = $request->content;

      //Guardar la imagen
      $path = 'images/' . $imageName;
      Storage::disk('public')->put($path, $image);

      //Guardar el registro en la base de datos
      $qr_code = Qr::create([
         'code' => $code,
         'slug' => $slug,
         'path' => $path,
         'has_logo' => $logo,
         'redirect_to' => $content, //Website, Text,...
         'type' => $request->qrType,
         'user_id' => Auth::id(),
      ]);

      //Informar al usuario que se ha creado el QR
      Session::flash('info', ['success', 'Se ha creado el código QR']);
      return back();
   }

   public function edit(Qr $code)
   {
      if ($code->type === 'email') {
         Session::flash('info', ['error', 'No puedes editar códigos QR que contengan correos electrónicos']);
         return redirect()->route('panel.qr.index');
      }

      if ($code->user_id === Auth::id()) {
         return view('panel.qr.edit', compact('code'));
      }
      Session::flash('info', ['error', 'No puedes editar este código QR']);
      return redirect()->route('panel.qr.index');
   }

   public function update(Request $request, Qr $code)
   {
      $code->update([
         'redirect_to' => $request->content,
         'type' => $request->qrType,
      ]);

      //Informar al usuario que se ha actualizado el QR
      Session::flash('info', ['success', 'Se ha actualizado el código QR']);
      return back();
   }

   public function destroy(Qr $code)
   {
      if ($code->user_id === Auth::id()) {
         if (Storage::disk('public')->exists($code->path)) {
            //Eliminar el archivo físicamente
            Storage::disk('public')->delete($code->path);

            //Eliminar el registro en la base de datos
            $code->delete();

            //Informar al usuario que se ha eliminado el QR
            Session::flash('info', ['info', 'Se ha eliminado el código QR']);
            return back();
         } else {
            //Informar al usuario que no se ha encontrado el código el QR
            Session::flash('info', ['error', 'No se ha encontrado el código QR']);
            return back();
         }
      }

      //Informar al usuario que no puede eliminar el QR
      Session::flash('info', ['error', 'No puedes eliminar este código QR']);
      return redirect()->route('panel.qr.index');
   }
}
