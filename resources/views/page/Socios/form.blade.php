@csrf
<h2 class="text-center text-uppercase text-secondary mb-0">Datos Generales</h2>

<hr class="star-dark mb-5">

<div class="row d-flex justify-content-center">
  <div class="col-md-8">
    <div class="card shadow">
      <div class="card-body p-4">
          <div class="form-floating mb-3">
            {{ Form::text(
                'nombre',
                isset($id) ? $socio['Nombre'] : null,
                ['class' => 'form-control', 'id' => 'nombre', 'placeholder' => 'Nombre', 'autocomplete' => 'off', 'required']
            ) }}

            {{Form::label('nombre', 'Nombre')}}
          </div>
          <div class="form-floating mb-3">
            {{Form::text('apellidos', isset($id) ? $socio['Apellidos'] : null,
            ['class' => 'form-control', 'id' => 'apellidos', 'placeholder' => 'Apellidos', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('apellidos', 'Apellidos')}}
          </div>
          <div class="form-floating mb-3">
              {{ Form::select('usuario', $usuarios, isset($id) ? $socio['IDSocio'] : null,
              ['class' => 'form-select', 'id' => 'usuario', 'placeholder' => 'Seleccione uno', 'autocomplete' => 'off', 'required']) }}
              {{ Form::label('usuario', 'Usuario') }}
              {{ Form::hidden('nombreUsuario', isset($id) ? $socio['Usuario'] : null, 
              ['id' => 'nombreUsuario']) }}
          </div>
          <div class="form-floating mb-3">
            {{Form::text('telefono', isset($id) ? $socio['Telefono'] : null,
            ['class' => 'form-control', 'id' => 'telefono', 'placeholder' => 'Teléfono', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('telefono', 'Teléfono')}}
          </div>
      </div>
    </div>
  </div>
</div>
@push('script')
<script>
   $(document).ready(function(){
      jQuery('#usuario').on('change', function(){
        var usuario = jQuery(this).val();
        var nombreUsuario = jQuery('#usuario option:selected').text();
        jQuery('#nombreUsuario').val(nombreUsuario);
        console.log(nombreUsuario);
      });
  });
</script>
@endpush


&nbsp;