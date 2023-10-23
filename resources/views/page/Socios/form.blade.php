@csrf
<h2 class="text-center text-uppercase text-secondary mb-0">Datos Generales</h2>

<hr class="star-dark mb-5">

<div class="row d-flex justify-content-center">
  <div class="col-md-8">
    <div class="card shadow">
      <div class="card-body p-4">
          <div class="form-floating mb-3">
            {{Form::text('nombre', null, ['class' => 'form-control', 'id' => 'nombre', 'placeholder' => 'Nombre', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('nombre', 'Nombre')}}
          </div>
          <div class="form-floating mb-3">
            {{Form::text('apellidos', null, ['class' => 'form-control', 'id' => 'apellidos', 'placeholder' => 'Apellidos', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('apellidos', 'Apellidos')}}
          </div>
          <div class="form-floating mb-3">
            {{Form::text('usuario', null, ['class' => 'form-control', 'id' => 'usuario', 'placeholder' => 'Usuario', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('usuario', 'Usuario')}}
          </div>
          <div class="form-floating mb-3">
            {{Form::password('contrasena', ['class' => 'form-control', 'id' => 'contrasena', 'placeholder' => 'Contraseña', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('contrasena', 'Contraseña')}}
          </div>
          <div class="form-floating mb-3">
            {{Form::text('telefono', null, ['class' => 'form-control', 'id' => 'telefono', 'placeholder' => 'Teléfono', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('telefono', 'Teléfono')}}
          </div>
      </div>
    </div>
  </div>
</div>




&nbsp;