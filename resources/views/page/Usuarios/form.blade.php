@csrf
<h2 class="text-center text-uppercase text-secondary mb-0">Datos Generales</h2>

<hr class="star-dark mb-5">

<div class="row d-flex justify-content-center">
  <div class="col-md-8">
      <div class="card {{ request()->is('usuarios/create') ? 'border-primary' : 'border-warning' }} mb-3" style="border-radius: 20px; padding: 10px">
      <div class="card-body p-4">
        <div class="form-floating mb-3">
          {{Form::text('nombre', isset($id) ? $usuario['Nombre'] : null,
            ['class' => 'form-control', 'id' => 'nombre', 'placeholder' => 'Nombre', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('nombre', 'Nombre')}}
          </div>
          <div class="form-floating mb-3">
            {{Form::text('apellidos', isset($id) ? $usuario['Apellidos'] : null,
            ['class' => 'form-control', 'id' => 'apellidos', 'placeholder' => 'Apellidos', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('apellidos', 'Apellidos')}}
          </div>
          <div class="form-floating mb-3">
            {{Form::text('telefono', isset($id) ? $usuario['Telefono'] : null,
            ['class' => 'form-control', 'id' => 'telefono', 'placeholder' => 'Telefono', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('telefono', 'Telefono')}}
            <div id="telefono-error-message" class="invalid-feedback"></div>
          </div>
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
            ['class' => 'form-control', 'id' => 'correo', 'placeholder' => 'Correo', 'autocomplete' => 'off', 'required', 'readonly'])}}
            {{Form::label('correo', 'Correo')}}
          </div>
          {{-- este campo solo se mostrará cuando se esté creando un usuario --}}
          @if (request()->is('usuarios/create'))
            <div class="form-floating mb-3">
                {{ Form::password('contrasena',['class' => 'form-control', 'id' => 'contrasena', 'placeholder' => 'Contraseña', 'autocomplete' => 'off', 'required', 'minlength' => '6']) }}
                {{Form::label('contrasena', 'Contraseña')}}
            </div>
          @endif
          <div class="form-floating mb-3">
            {{Form::select('tipo', ['Socio' => 'Socio', 'Conductor' => 'Conductor', 'Administrador' => 'Administrador'], isset($id) ? $usuario['Tipo'] : null,
            ['class' => 'form-control', 'id' => 'tipo', 'placeholder' => 'Tipo', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('tipo', 'Tipo')}}
          </div>
          <div class="form-floating mb-3">
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
<!-- Agrega esto antes de cerrar el body de tu HTML -->
<script>
  $(document).ready(function() {
      // Desactivar el botón de siguiente por defecto
      $('#campo-siguiente').prop('disabled', true);

      // Manejar cambios en los campos de número y usuario
      $('#telefono, #usuario').on('input', function() {
          actualizarCorreo();
      });

      // Validar el teléfono al presionar Enter
      $('#telefono').on('keypress', function(event) {
          if (event.keyCode === 13) {
              event.preventDefault();
              validarTelefono();
          }
      });

      // Validar el teléfono al salir del campo
      $('#telefono').on('blur', function() {
          validarTelefono();
      });

      // Función para validar el teléfono
      function validarTelefono() {
          var telefono = $('#telefono').val();
          var telefonoInput = $('#telefono');
          var siguienteCampo = $('#campo-siguiente');

          if (telefono.length !== 10) {
              telefonoInput.addClass('is-invalid');
              telefonoInput.focus();

              // Desactivar el siguiente campo
              siguienteCampo.prop('disabled', true);

              // Agregar el mensaje de error
              $('#telefono-error-message').text('El número tiene que ser de 10 dígitos');
          } else {
              telefonoInput.removeClass('is-invalid');

              // Limpiar el mensaje de error
              $('#telefono-error-message').text('');

              // Activar el siguiente campo
              siguienteCampo.prop('disabled', false);

              // Actualizar el correo solo si el usuario y el número son válidos
              actualizarCorreo();
          }
      }

      function actualizarCorreo() {
          var numero = $('#telefono').val(); // Valor predeterminado vacío si el campo está vacío
          var usuario = $('#usuario').val() || ''; // Valor predeterminado vacío si el campo está vacío
          var correoInput = $('#correo');

          // Quitar espacios del usuario
          var usuarioSinEspacios = usuario.replace(/\s/g, '');

          // Generar automáticamente el correo si el número y el usuario son válidos
          if (numero.length === 10 && usuarioSinEspacios !== '') {
              var correoDefault = '@cozucoop.com';
              var correo = numero + usuarioSinEspacios + correoDefault;

              // Actualizar el valor del campo de correo
              correoInput.val(correo);
          } else {
              // Si el número o el usuario no son válidos, establecer el campo de correo como vacío
              correoInput.val('');
          }
      }


      //eso fue con jquery nada mas, ahora lo haremos con el validate que trae jquery
        jQuery('#basicForm').validate({
          rules: {
              nombre: {
                  required: true,
                  minlength: 3
              },
              apellidos: {
                  required: true,
                  minlength: 3
              },
              telefono: {
                  required: true,
                  minlength: 10,
                  maxlength: 10
              },
              usuario: {
                  required: true,
                  minlength: 3
              },
              correo: {
                  required: true,
                  email: true
              },
              contrasena: {
                  required: true,
                  minlength: 6
              },
              tipo: {
                  required: true
              },
              estatus: {
                  required: true
              }
          },
          messages: {
              nombre: {
                  required: 'Por favor ingresa tu nombre',
                  minlength: 'El nombre debe tener al menos 3 caracteres'
              },
              apellidos: {
                  required: 'Por favor ingresa tus apellidos',
                  minlength: 'Los apellidos deben tener al menos 3 caracteres'
              },
              telefono: {
                  required: 'Por favor ingresa tu número de teléfono',
                  minlength: 'El número debe tener 10 dígitos',
                  maxlength: 'El número debe tener 10 dígitos'
              },
              usuario: {
                  required: 'Por favor ingresa tu usuario',
                  minlength: 'El usuario debe tener al menos 3 caracteres'
              },
              correo: {
                  required: 'Por favor ingresa tu correo',
                  email: 'Por favor ingresa un correo válido'
              },
              contrasena: {
                  required: 'Por favor ingresa tu contraseña',
                  minlength: 'La contraseña debe tener al menos 6 caracteres'
              },
              tipo: {
                  required: 'Por favor selecciona un tipo de usuario'
              },
              estatus: {
                  required: 'Por favor selecciona un estatus'
              }
          },
          errorElement: 'div',
          errorPlacement: function(error, element) {
              error.addClass('invalid-feedback');
              element.closest('.form-floating').append(error);
          },
          highlight: function(element, errorClass, validClass) {
              $(element).addClass('is-invalid');
          },
          unhighlight: function(element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
          },
      });

    jQuery(".enviar").click(function() {
        //solo mostrar el loader si los campos están validados
        if (jQuery("#basicForm").valid()) {
            jQuery("#loader").show();
        }
    });
  });


</script>

@endpush


&nbsp;
