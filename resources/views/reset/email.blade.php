@extends('layouts.layout')


@section('content')

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Verifica tu dirección de correo electrónico</div>

          <div class="card-body">
            @if(Session::has('error'))
              <p class=" pb-3 alert {{ Session::get('alert-class', 'alert-danger') }} " style="text-transform: capitalize;">{{ Session::get('error') }}</p>
            @else
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            Antes de continuar, por favor verifica tu correo electrónico en busca de un enlace de verificación. Si no recibiste el correo electrónico,

            <a href="/" style="text-decoration:none;">{{ __('haz clic aquí para solicitar otro') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
