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

         <div class="overlay overlay_1 d-none" id="addLogo">
            <img src="{{ asset('img/bg_qr.jpg') }}" class="rounded" width="50" alt="">
         </div>
      </div>
   </div>

   <small>El resultado final puede variar</small>
</div>

@push('styles')
<style>
   :root {
      --fillColor: #98a715;
   }

   .qr-border-left {
      border-left: 1px solid #cdcdcd;
   }

   .image_wrapper {
      position: relative;
   }

   .form-control-color{
      width: 6rem;
      height: 50px;
   }

   .overlay {
      position: absolute;
      display: flex;
      align-items: center;
      justify-content: center;
   }

   .overlay_1 {
      left: 0;
      bottom: 100px;
      width: 100%;
      padding: 1rem;
   }

   /* HIDE RADIO */
   [type=radio].qr-selector {
      position: absolute;
      opacity: 0;
      width: 0;
      height: 0;
   }

   /* IMAGE STYLES */
   [type=radio].qr-selector + svg {
      cursor: pointer;
      padding: 5px;
   }

   /* CHECKED STYLES */
   [type=radio].qr-selector:checked+svg {
      outline: 2px solid #26284f;

   }
</style>
@endpush
