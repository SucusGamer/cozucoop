@csrf
<h2 class="text-center text-uppercase text-secondary mb-0">Datos Generales</h2>

<hr class="star-dark mb-5">

<div class="row d-flex justify-content-center">
  <div class="col-md-8">
    <div class="card {{ request()->is('mototaxis/create') ? 'border-primary' : 'border-warning' }} mb-3" style="border-radius: 20px; padding: 10px">
      <div class="card-body p-4 row">
          <div class="form-floating mb-3 col-6">
            {{ Form::text(
                'unidad',
                isset($id) ? $mototaxi['Unidad'] : null,
                ['class' => 'form-control', 'id' => 'unidad', 'placeholder' => 'Unidad', 'autocomplete' => 'off', 'required', 'readonly' => 'readonly']
            ) }}

            {{Form::label('unidad', 'Unidad')}}
          </div>
          <div class="form-floating mb-3 col-6">
              {{ Form::select('socio', $socios, isset($id) ? $mototaxi['IDSocio'] : null,
              ['class' => 'form-select', 'id' => 'socio', 'placeholder' => 'Seleccione uno', 'autocomplete' => 'off', 'required']) }}
              {{ Form::label('socio', 'Socio') }}
          </div>
            <div class="form-floating col-6">
                {{ Form::select('conductor', $conductores, isset($id) ? $mototaxi['IDConductor'] : null,
                ['class' => 'form-select', 'id' => 'conductor', 'placeholder' => 'Seleccione uno', 'autocomplete' => 'off', 'required']) }}
                {{ Form::label('conductor', 'Conductor') }}
            </div>
        <div class="form-floating  col-6">
          {{Form::select('estatus', [1 => 'Activo', 0 => 'Inactivo'], isset($id) ? $mototaxi['Estatus'] : 1,
          ['class' => 'form-control', 'id' => 'estatus', 'placeholder' => 'Estatus', 'autocomplete' => 'off', 'required'])}}
          {{Form::label('estatus', 'Estatus')}}
        </div>

      </div>
    </div>
  </div>
</div>
@push('script')
{{-- aqui van mis scripts --}}
<script src="{{ asset('js/procesos/mototaxis.js') }}"></script>

@endpush
&nbsp;
