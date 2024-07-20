@extends('panel.app')
@section('content')
<div class="container-fluid">

   <div class="row h-100">
      <div class="col-sm-12 col-lg-8">
         @include('panel.includes._create-qr')
      </div>

      <div class="col-sm-12 col-lg-3 offset-lg-1 h-75 qr-border-left">
         <div class="text-center">
				<h3>Vista previa del QR</h3>
            <div id="qrPreview" class="mt-3 text-center mx-auto" style="width: 300px; background-color: {{ $backgroundColor }}">
               @include('panel.includes._qr-preview')
            </div>
         </div>
      </div>
   </div>
</div>
@stop

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.3.slim.min.js" integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>

<script type="text/javascript">
   //Cambiar los formularios con base en lo que seleccione el usuario
   $('input[type=radio][name=qrType]').on('change', function() {
      switch ($(this).val()) {
         case 'email':
            $("#emailContent").removeClass('d-none');
            $('#labelContentItem').text("Correo electrónico de destino");
            $('#emailHelp').text(
               "Ingresa el correo electrónico al que quieres que llegue el mensaje. Ej: hola@ciberpaz.gov.co"
            );
            break;
         case 'phone':
            $("#emailContent").addClass('d-none');
            $('#labelContentItem').text("Ingresa tu número de contacto");
            $('#emailHelp').text(
               "Ingresa tu número de contacto: Ej: 3218057515"
            );
            break;
         case 'sms':
            $("#emailContent").addClass('d-none');
            $('#labelContentItem').text("Ingresa el número celular de destino");
            $('#emailHelp').text(
               "Ingresa el número al cual quieres que llegue el SMS"
            );
            break;
         default:
            $("#emailContent").addClass('d-none');
            $('#labelContentItem').text("Contenido");
            $('#emailHelp').text(
               "Ingresa la URL o la información que deseas agregar"
            );
            break;
      }
   });

   //Mostrar el formulario de la configuración
   $('#customizeQROption').on('change', function() {
      if ($(this).is(':checked')) {
         $("#configurationBlock").removeClass('d-none');
      } else {
         $("#configurationBlock").addClass('d-none');
      }
   });

   //Definir la variable para cambiar el color del QR
   let qrFrame = document.querySelector(".qrFrame");
	qrFrame.setAttribute('fill', $('#qrColor').val());

   $('#backgroundColor').on('input', function() {
      document.getElementById('qrPreview').style.backgroundColor = $(this).val();
   });

   $('#qrColor').on('input', function() {
      qrFrame.setAttribute('fill', $(this).val());
   });

</script>
@endpush
