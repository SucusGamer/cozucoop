@csrf
<h2 class="text-center text-uppercase text-secondary mb-0">Datos Generales</h2>

<hr class="star-dark mb-5">

<div class="row d-flex justify-content-center">
  <div class="col-md-8">
    <div class="card border-primary mb-3" style="border-radius: 20px;padding: 10px">
      <div class="card-body p-4">
          <div class="form-floating mb-3">
            {{ Form::text(
                'usuario',
                isset($id) ? $usuario['Usuario'] : null,
                ['class' => 'form-control', 'id' => 'usuario', 'placeholder' => 'Usuario', 'autocomplete' => 'off', 'required']
            ) }}

            {{Form::label('usuario', 'Usuario')}}
          </div>
          <div class="form-floating mb-3">
            {{Form::text('correo', isset($id) ? $usuario['Correo'] : null,
            ['class' => 'form-control', 'id' => 'correo', 'placeholder' => 'Correo', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('correo', 'Correo')}}
          </div>
            <div class="form-floating mb-3">
                {{ Form::password('contrasena',['class' => 'form-control', 'id' => 'contrasena', 'placeholder' => 'Contraseña', 'autocomplete' => 'off', 'required', 'minlength' => '6']) }}
                {{Form::label('contrasena', 'Contraseña')}}
            </div>
      </div>
    </div>
  </div>
</div>
@push('script')
@endpush


&nbsp;
