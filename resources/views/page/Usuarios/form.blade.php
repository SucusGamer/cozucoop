@csrf
<h2 class="text-center text-uppercase text-secondary mb-0">Datos Generales</h2>

<hr class="star-dark mb-5">

<div class="row d-flex justify-content-center">
  <div class="col-md-8">
      <div class="card {{ request()->is('usuarios/create') ? 'border-primary' : 'border-warning' }} mb-3" style="border-radius: 20px; padding: 10px">
      <div class="card-body p-4 row">
        <div class="form-floating mb-3 col-6">
          {{Form::text('nombre', isset($id) ? $usuario['Nombre'] : null,
            ['class' => 'form-control', 'id' => 'nombre', 'placeholder' => 'Nombre', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('nombre', 'Nombre')}}
          </div>
          <div class="form-floating mb-3 col-6">
            {{Form::text('apellidos', isset($id) ? $usuario['Apellidos'] : null,
            ['class' => 'form-control', 'id' => 'apellidos', 'placeholder' => 'Apellidos', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('apellidos', 'Apellidos')}}
          </div>
          <div class="form-floating mb-3 col-3">
            {{Form::select('tipo', ['Socio' => 'Socio', 'Conductor' => 'Conductor', 'Administrador' => 'Administrador'], isset($id) ? $usuario['Tipo'] : null,
            ['class' => 'form-control', 'id' => 'tipo', 'placeholder' => 'Tipo', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('tipo', 'Tipo')}}
          </div>
          <div class="form-floating mb-3 col-4">
            {{Form::text('telefono', isset($id) ? $usuario['Telefono'] : null,
            ['class' => 'form-control', 'id' => 'telefono', 'placeholder' => 'Telefono', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('telefono', 'Telefono')}}
            <div id="telefono-error-message" class="invalid-feedback"></div>
          </div>
          <div class="form-floating mb-3 col-5">
            {{ Form::text(
                'usuario',
                isset($id) ? $usuario['Usuario'] : null,
                ['class' => 'form-control', 'id' => 'usuario', 'placeholder' => 'Usuario', 'autocomplete' => 'off', 'required']
            ) }}
            {{Form::label('usuario', 'Usuario')}}
          </div>
          <div class="form-floating  col">
            {{Form::text('correo', isset($id) ? $usuario['Correo'] : null,
            ['class' => 'form-control', 'id' => 'correo', 'placeholder' => 'Correo', 'autocomplete' => 'off', 'required', 'readonly'])}}
            {{Form::label('correo', 'Correo')}}
          </div>
          {{-- este campo solo se mostrará cuando se esté creando un usuario --}}
          @if (request()->is('usuarios/create'))
            <div class="form-floating  col">
                {{ Form::password('contrasena',['class' => 'form-control', 'id' => 'contrasena', 'placeholder' => 'Contraseña', 'autocomplete' => 'off', 'required', 'minlength' => '6']) }}
                {{Form::label('contrasena', 'Contraseña')}}
            </div>
          @endif
          <div class="form-floating col-2">
            {{Form::select('estatus', [1 => 'Activo', 0 => 'Inactivo'], isset($id) ? $usuario['Estatus'] : 1,
            ['class' => 'form-control', 'id' => 'estatus', 'placeholder' => 'Estatus', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('estatus', 'Estatus')}}
          </div>
      </div>
    </div>
  </div>
</div>
@push('script')
{{-- aqui van mis scripts --}}
<script src="{{ asset('js/procesos/usuarios.js') }}"></script>

@endpush
&nbsp;
