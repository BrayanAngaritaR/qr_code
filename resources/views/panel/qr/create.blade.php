@extends('panel.app')
@section('content')
<div class="container-fluid">

   <div class="row h-100">
      <div class="col-sm-12 col-lg-8">
         @include('panel.includes._create-qr')
      </div>

      <div class="col-sm-12 col-lg-3 offset-lg-1 h-75 qr-border-left">
         @include('panel.includes._qr-preview')
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

	//Mostrar el logo
   $('#addLogoSelector').on('change', function() {
      setLogoToQR($('input[type=radio][name=qrSelectedImage]').val());
      if ($(this).is(':checked')) {
         $("#logoSelector").removeClass('d-none');
      } else {
         $("#logoSelector").addClass('d-none');
      }
   });

   $('input[type=radio][name=qrSelectedImage]').on('change', function() {
      setLogoToQR($(this).val());
   });

	//Cambiar los formularios con base en lo que seleccione el usuario
   $('input[type=radio][name=qrForm]').on('change', function() {
		changePreviewQR($(this).val());
   });

	function changePreviewQR(selector){
		switch (selector) {
         case 'round':
				$("#squaredQR").addClass('d-none');
				$("#roundQR").removeClass('d-none');
				$("#dotsQR").addClass('d-none');
            break;
         case 'dot':
				$("#squaredQR").addClass('d-none');
				$("#roundQR").addClass('d-none');
				$("#dotsQR").removeClass('d-none');
            break;
         default:
				$("#squaredQR").removeClass('d-none');
				$("#roundQR").addClass('d-none');
				$("#dotsQR").addClass('d-none');
            break;
      }
	}

   function setLogoToQR(logo){
      if(logo === 'main_logo'){
         $("#displayMainLogo").removeClass('d-none');
         $("#displayAlternativeLogo").addClass('d-none');
      } else if(logo === 'none') {
         $("#displayAlternativeLogo").addClass('d-none');
         $("#displayMainLogo").addClass('d-none');
      } else {
         $("#displayAlternativeLogo").removeClass('d-none');
         $("#displayMainLogo").addClass('d-none');
      }
   }
	
   //Definir la variable para cambiar el color del QR
   let qrFrame = document.querySelector(".qrFrame");
   let qrDotFrame = document.querySelector(".qrDotFrame");
   let qrRoundFrame = document.querySelector(".qrRoundFrame");

	qrFrame.setAttribute('fill', $('#qrColor').val());
	qrDotFrame.setAttribute('fill', $('#qrColor').val());

   $('#backgroundColor').on('input', function() {
      document.getElementById('qrPreview').style.backgroundColor = $(this).val();
   });

   $('#qrColor').on('input', function() {
      qrFrame.setAttribute('fill', $(this).val());
      qrDotFrame.setAttribute('fill', $(this).val());
      qrRoundFrame.setAttribute('fill', $(this).val());
   });

</script>
@endpush
