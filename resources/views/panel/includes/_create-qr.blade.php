<form class="mt-4" action="{{ route('panel.qr.store') }}" method="POST">
   @csrf

   <h4>Tipo de QR</h4>

   <div class="form-check form-check-inline">
      <input @checked(old('qrType')==='website') checked class="form-check-input" type="radio" name="qrType" id="websiteItem" value="website">
      <label class="form-check-label" for="websiteItem">Sitio web</label>
   </div>
   <div class="form-check form-check-inline">
      <input @checked(old('qrType')==='text' ) class="form-check-input" type="radio" name="qrType" id="textItem" value="text">
      <label class="form-check-label" for="textItem">Texto</label>
   </div>
   <div class="form-check form-check-inline">
      <input @checked(old('qrType')==='email' ) class="form-check-input" type="radio" name="qrType" id="emailItem" value="email">
      <label class="form-check-label" for="emailItem">Correo electrónico</label>
   </div>
   <div class="form-check form-check-inline">
      <input @checked(old('qrType')==='phone' ) class="form-check-input" type="radio" name="qrType" id="phoneItem" value="phone">
      <label class="form-check-label" for="phoneItem">Teléfono</label>
   </div>
   <div class="form-check form-check-inline">
      <input @checked(old('qrType')==='sms' ) class="form-check-input" type="radio" name="qrType" id="smsItem" value="sms">
      <label class="form-check-label" for="smsItem">SMS</label>
   </div>

   <div class="mb-3 mt-4">
      <label for="contentItem" id="labelContentItem" class="form-label">Contenido</label>
      <input type="text" name="content" value="{{ old('content') }}" class="form-control @error('content') is-invalid                    
             @enderror" id="contentItem" aria-describedby="emailHelp">
      <p class="text-danger">
         @error('content')
         {{ $message }}
         @enderror
      </p>
      <div id="emailHelp" class="form-text">Ingresa la URL o la información que deseas agregar</div>
   </div>

   <div id="emailContent" @if (old('qrType') !='email' ) class="d-none" @endif>
      <div class="mb-3 mt-4">
         <label for="subjectItem" class="form-label">Asunto</label>
         <input type="text" maxlength="50" value="{{ old('subject') }}" placeholder="Ej: Invitación al evento" name="subject" class="form-control @error('subject') is-invalid                    
                     @enderror" id="subjectItem" aria-describedby="emailHelp">
         <p class="text-danger">
            @error('subject')
            {{ $message }}
            @enderror
         </p>
      </div>

      <div class="mb-3 mt-4">
         <label for="messageItem">Mensaje</label>
         <textarea name="message" id="messageItem" placeholder="Hola, te invitar al evento que se hará por parte de Ciberpaz" rows="3" maxlength="300" class="form-control @error('message') is-invalid                    
                     @enderror">{{ old('message') }}</textarea>
         <p class="text-danger">
            @error('message')
            {{ $message }}
            @enderror
         </p>
      </div>
   </div>

   <div class="mt-5">
      <h4>Configuración</h4>

      <div class="form-check form-switch">
         <input class="form-check-input" type="checkbox" name="customizeQR" role="switch" id="customizeQROption">
         <label class="form-check-label" for="customizeQROption">Personalizar QR</label>
      </div>
   </div>

   <div id="configurationBlock" class="d-none mt-3">
      <div class="row border p-4 rounded m-1">

         <div class="col-sm-12">
            <label class="form-label">Estilo del QR</label>

            <div class="mb-4">
               <div class="form-check form-check-inline p-0">
                  <label class="form-check-label" for="squaredItem">
                     <input class="form-check-input qr-selector" checkeds type="radio" name="qrForm" id="squaredItem" @checked($qr_settings->qr_type === 'square') value="square">
                     {!! QrCode::size(100)->format('svg')->generate('-'); !!}
                  </label>
               </div>
               <div class="form-check form-check-inline">
                  <label class="form-check-label" for="dotItem">
                     <input class="form-check-input qr-selector" type="radio" name="qrForm" id="dotItem" @checked($qr_settings->qr_type === 'dot') value="dot">
                     {!! QrCode::size(100)->style('dot')->format('svg')->generate('https://ciberpaz.gov.co/'); !!}
                  </label>
               </div>
               <div class="form-check form-check-inline">
                  <label class="form-check-label" for="roundItem">
                     <input class="form-check-input qr-selector" type="radio" name="qrForm" id="roundItem" @checked($qr_settings->qr_type === 'round') value="round">
                     {!! QrCode::size(100)->style('round')->format('svg')->generate('https://ciberpaz.gov.co/'); !!}
                  </label>
               </div>
            </div>
         </div>

         <div class="col-sm-12">
            <div class="form-check form-switch">
               <input class="form-check-input" type="checkbox" name="addLogo" role="switch" id="addLogoSelector">
               <label class="form-check-label" for="addLogoSelector">Agregar logo</label>
            </div>
         </div>

         <div class="col-sm-12 mt-3 d-none" id="logoSelector">
            <label class="form-label">Estilo del logo</label>

            <div class="mb-4">
               <div class="form-check form-check-inline p-0">
                  <label class="form-check-label" for="mainLogo">
                     <input @checked($qr_settings->selected_logo === 'main_logo') class="form-check-input qr-selector" checkeds type="radio" name="qrSelectedImage" id="mainLogo" value="main_logo">
                     <img src="{{ asset($qr_settings->main_logo) }}" width="80" alt="">
                  </label>
               </div>
               <div class="form-check form-check-inline">
                  <label class="form-check-label" for="alternativeLogo">
                     <input @checked($qr_settings->selected_logo != 'main_logo') class="form-check-input qr-selector" type="radio" name="qrSelectedImage" id="alternativeLogo" value="alternative_logo">
                     <img src="{{ asset($qr_settings->alternative_logo) }}" width="80" alt="">
                  </label>
               </div>
               <div class="form-check form-check-inline">
                  <label class="form-check-label" for="none">
                     <input @checked($qr_settings->selected_logo === 'none') class="form-check-input qr-selector" type="radio" name="qrSelectedImage" id="none" value="none">
                     <img src="{{ asset('img/none.png') }}" width="80" alt="">
                  </label>
               </div>
            </div>
         </div>

         <div class="col-sm-12 mt-3">
            <label for="backgroundColor" class="form-label">Color del fondo</label>
            <input type="color" value="{{ $backgroundColor }}" name="backgroundColor" class="form-control form-control-color" id="backgroundColor" aria-describedby="backgroundColor">
         </div>

         <div class="col-sm-12 mt-3">
            <label for="qrColor" class="form-label">Color del QR</label>
            <input type="color" value="{{ $color }}" name="qrColor" class="form-control form-control-color" id="qrColor" aria-describedby="qrColor">
         </div>

         <div class="col-sm-12 mt-3">
            <div class="form-check form-switch">
               <input class="form-check-input" type="checkbox" name="saveSetting" role="switch" id="saveSettingSelector">
               <label class="form-check-label" for="saveSettingSelector">Guardar configuración</label>
            </div>
         </div>
      </div>
   </div>

   <div class="text-end">
      <button type="submit" class="btn btn-dark mt-5">Guardar</button>
   </div>
</form>
