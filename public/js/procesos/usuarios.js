  $(document).ready(function() {
    // Desactivar el botón de siguiente por defecto
    $('#campo-siguiente').prop('disabled', true);

    // Manejar cambios en los campos de número, usuario y tipo
    $('#telefono, #usuario, #tipo').on('input change', function() {
        // Verificar el tipo de usuario y modificar el campo de correo según sea necesario
        var tipoUsuario = $('#tipo').val();
        if (tipoUsuario === 'Administrador') {
            // Si el tipo es Administrador, quitar el atributo 'readonly'
            $('#correo').prop('readonly', false);
        } else {
            // Si el tipo no es Administrador, agregar el atributo 'readonly'
            $('#correo').prop('readonly', true);
            // Actualizar el correo
            actualizarCorreo();
        }

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