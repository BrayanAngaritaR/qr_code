<div class="text-center">
   <h3>Vista previa del QR</h3>

   <div id="qrPreview" class="mt-3 text-center mx-auto" style="width: 300px; background-color: {{ $backgroundColor }}">
      <div class="image_wrapper">
         <div id="squaredQR">
            @include('panel.includes.qr._squared')
         </div>

         <div id="dotsQR" class="d-none">
            @include('panel.includes.qr._dot')
         </div>

         <div id="roundQR" class="d-none">
            @include('panel.includes.qr._round')
         </div>

         <div class="overlay overlay_1 d-none" id="displayMainLogo">
            <img src="{{ asset($qr_settings->main_logo) }}" class="rounded" width="50" alt="">
         </div>

         <div class="overlay overlay_1 d-none" id="displayAlternativeLogo">
            <img src="{{ asset($qr_settings->alternative_logo) }}" class="rounded" width="50" alt="">
         </div>
      </div>
   </div>

   <small>El resultado final puede variar</small>
</div>
