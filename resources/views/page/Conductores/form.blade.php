@csrf
<h2 class="text-center text-uppercase text-secondary mb-0">Datos Generales</h2>

<hr class="star-dark mb-5">

<div class="row d-flex justify-content-center">
  <div class="col-md-8">
    <div class="card border-primary mb-3" style="border-radius: 20px;padding: 10px">
      <div class="card-body p-4">
          <div class="form-floating mb-3">
            {{ Form::text(
                'nombre',
                isset($id) ? $conductor['Nombre'] : null,
                ['class' => 'form-control', 'id' => 'nombre', 'placeholder' => 'Nombre', 'autocomplete' => 'off', 'required']
            ) }}

            {{Form::label('nombre', 'Nombre')}}
          </div>
          <div class="form-floating mb-3">
            {{Form::text('apellidos', isset($id) ? $conductor['Apellidos'] : null,
            ['class' => 'form-control', 'id' => 'apellidos', 'placeholder' => 'Apellidos', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('apellidos', 'Apellidos')}}
          </div>
          <div class="form-floating mb-3">
              {{ Form::select('socio', $usuarios, isset($id) ? $conductor['IDSocio'] : null,
              ['class' => 'form-select', 'id' => 'socio', 'placeholder' => 'Seleccione uno', 'autocomplete' => 'off', 'required']) }}
              {{ Form::label('socio', 'Socio') }}
          </div>
            <div class="form-floating mb-3">
                {{ Form::select('conductor', $usuarios, isset($id) ? $conductor['IDConductor'] : null,
                ['class' => 'form-select', 'id' => 'conductor', 'placeholder' => 'Seleccione uno', 'autocomplete' => 'off', 'required']) }}
                {{ Form::label('conductor', 'Conductor') }}
            </div>
          <div class="form-floating mb-3">
            {{Form::text('telefono', isset($id) ? $conductor['Telefono'] : null,
            ['class' => 'form-control', 'id' => 'telefono', 'placeholder' => 'Teléfono', 'autocomplete' => 'off', 'required'])}}
            {{Form::label('telefono', 'Teléfono')}}
          </div>
      </div>
    </div>
  </div>
</div>
@push('script')

@endpush


&nbsp;
