@extends('panel.app')
@section('content')
<div id="output"></div>
<div id="exportQR">
   <div class="image_wrapper">
      <img class="img-fluid" src="{{ asset('storage/' . $qr->path) }}" width="1920" alt="">
      
      @if($qr->logo === 'main_logo')
      <div class="overlay export_qr">
         <img class="rounded" src="{{ asset($qr_settings->main_logo) }}" width="300" alt="">
      </div>
      @endif
      @if($qr->logo === 'alternative_logo')
      <div class="overlay export_qr">
         <img class="rounded" src="{{ asset($qr_settings->alternative_logo) }}" width="300" alt="">
      </div>
      @endif
   </div>
</div>
@stop

@push('scripts')

<script src="http://html2canvas.hertzen.com/dist/html2canvas.js"></script>

<script>
   function onScreenShotClick() {
      const element = document.querySelector("#exportQR");

      html2canvas(element).then((canvas) => {
         var img = canvas.toDataURL("image/png");
         var link = document.createElement('a');
         link.href = img;
         link.download = 'qr.png';
         link.click();
      });
   }

   window.addEventListener('load', function() {
      onScreenShotClick();
   });

   setTimeout(() => {
      window.close();
   }, 3000);
</script>
@endpush
