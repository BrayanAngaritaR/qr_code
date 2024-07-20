@extends('panel.app')
@section('content')
<p>Lista de códigos QR</p>

<div class="visible-print text-center">
   {!! QrCode::size(100)->format('svg')->merge('https://ciberpaz.gov.co/855/channels-755_logo_micrositio.png', .3, true)->color(255, 0, 0, 75)->backgroundColor(255, 255, 0, 25)->style('round')->eye('circle')->generate('https://bepro.digital'); !!}
   <p>Scan me to return to the original page.</p>

   {{-- <div style="background: red; background-url: {{ QrCode::size(100)->format('svg')->merge('https://ciberpaz.gov.co/855/channels-755_logo_micrositio.png', .3, true)->color(255, 0, 0, 75)->backgroundColor(255, 255, 0, 25)->style('round')->eye('circle')->generate('https://bepro.digital'); }}">

</div> --}}

{{-- <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->merge('https://www.seeklogo.net/wp-content/uploads/2016/09/facebook-icon-preview-1.png', .3, true)->size(200)->generate('http://www.simplesoftware.io')) !!} "> --}}

</div>

<a href="{{ route('panel.qr.create') }}" class="btn btn-primary mb-4">Agregar QR</a>

<div class="table-responsive">
   <table class="table">
      <thead>
         <tr>
            <th scope="col">#</th>
            <th scope="col">QR</th>
            <th scope="col">Tipo</th>
            <th scope="col" class="text-center">Acciones</th>
         </tr>
      </thead>
      <tbody>
         @forelse($qr_codes as $code)
         <tr class="align-middle">
            <th scope="row">{{ $code->id }}</th>
            <td>
               <img src="{{ asset('storage/' . $code->path) }}" width="100" alt="">
            </td>
            <td>{{ $code->type }}</td>
            <td>
               <div class="d-flex justify-content-center align-items-center">
                  <a class="mx-2" href="{{ route('user.qr.show', $code) }}">Ver</a>
                  <a class="mx-2" href="{{ route('panel.qr.edit', $code) }}">Editar</a>
                  <form action="{{ route('panel.qr.destroy', $code) }}" method="POST" class="mx-2">
                     @method('DELETE')
                     @csrf
                     <button class="btn btn-danger mt-3">
                        Eliminar
                     </button>
                  </form>
               </div>
            </td>
         </tr>
         @empty
         <tr>
            <th scope="row">
               No tienes códigos QR
            </th>
         </tr>
         @endforelse
      </tbody>
   </table>
</div>
@stop
