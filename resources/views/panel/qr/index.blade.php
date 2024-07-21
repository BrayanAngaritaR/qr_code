@extends('panel.app')
@section('content')
<p>Lista de códigos QR</p>

<a href="{{ route('panel.qr.create') }}" class="btn btn btn-dark mb-4">Agregar QR</a>


<div class="table-responsive">
   <table class="table">
      <thead>
         <tr>
            <th>#</th>
            <th scope="col" class="text-center">QR</th>
            <th scope="col">Tipo</th>
            <th scope="col" class="text-center">Acciones</th>
            <th>Eliminar</th>
         </tr>
      </thead>
      <tbody>
         @forelse($qr_codes as $code)
         <tr class="align-middle">
            <th scope="row">{{ $code->id }}</th>
            <td>
               <div class="mt-3 text-center mx-auto">
                  <div class="image_wrapper">
                     <img src="{{ asset('storage/' . $code->path) }}" width="100" alt="">
                     @if($code->logo === 'main_logo') 
                     <div class="overlay logo_list">
                        <img class="rounded" src="{{ asset($qr_settings->main_logo) }}" width="25" alt="">
                     </div>
                     @endif 
                     @if($code->logo === 'alternative_logo') 
                     <div class="overlay logo_list">
                        <img class="rounded" src="{{ asset($qr_settings->alternative_logo) }}" width="25" alt="">
                     </div>
                     @endif
                  </div>
               </div>
            </td>
            <td>{{ $code->type }}</td>
            <td>
               <div class="d-flex justify-content-center align-items-center">
                  <a class="mx-2 btn btn-outline-dark" target="_blank" href="{{ route('user.qr.show', $code) }}">Ver</a>
                  <a class="mx-2 btn btn-outline-dark" href="{{ route('panel.qr.edit', $code) }}">Editar</a>
                  <a class="btn btn-outline-dark" href="{{ route('panel.qr.show', $code) }}" target="_blank">
                     Descargar
                  </a>
               </div>
            </td>
            <td>
               <form action="{{ route('panel.qr.destroy', $code) }}" method="POST" class="mx-2">
                  @method('DELETE')
                  @csrf
                  <button class="btn btn-danger mt-3">
                     Eliminar
                  </button>
               </form>
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