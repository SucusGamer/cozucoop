@csrf
<h2 class="text-center text-uppercase text-secondary mb-0">Datos Generales</h2>

<hr class="star-dark mb-5">

<div class="row d-flex justify-content-center">
  <div class="col-md-8">
    <div class="card border-primary mb-3" style="border-radius: 20px;padding: 10px">
      <div class="card-body p-4">
          <div class="form-floating mb-3">
            {{ Form::text(
                'unidad',
                isset($id) ? $mototaxi['Unidad'] : null,
                ['class' => 'form-control', 'id' => 'unidad', 'placeholder' => 'Unidad', 'autocomplete' => 'off', 'required', 'readonly' => 'readonly']
            ) }}

            {{Form::label('unidad', 'Unidad')}}
          </div>
          <div class="form-floating mb-3">
              {{ Form::select('socio', $usuarios, isset($id) ? $mototaxi['IDSocio'] : null,
              ['class' => 'form-select', 'id' => 'socio', 'placeholder' => 'Seleccione uno', 'autocomplete' => 'off', 'required']) }}
              {{ Form::label('socio', 'Socio') }}
          </div>
            <div class="form-floating mb-3">
                {{ Form::select('conductor', $usuarios, isset($id) ? $mototaxi['IDConductor'] : null,
                ['class' => 'form-select', 'id' => 'conductor', 'placeholder' => 'Seleccione uno', 'autocomplete' => 'off', 'required']) }}
                {{ Form::label('conductor', 'Conductor') }}
            </div>
            {{-- ponemos un select para activo --}}
        <div class="form-floating mb-3">
            {{ Form::select('activo', [true => 'Si', false => 'No'], isset($id) ? $mototaxi['Activo'] : null,
            ['class' => 'form-select', 'id' => 'activo', 'placeholder' => 'Seleccione uno', 'autocomplete' => 'off', 'required']) }}
            {{ Form::label('activo', 'Activo') }}
        </div>

      </div>
    </div>
  </div>
</div>



&nbsp;
