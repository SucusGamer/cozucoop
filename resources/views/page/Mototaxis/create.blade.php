@extends('layouts.layout')
@section('title', 'Crear Mototaxi')
@section('extra-js')

@endsection
@section('content')

<div class="container my-4">
  <div class="row">
    <div class="col-12">
        {{ Breadcrumbs::render() }}
    </div>
    <div class="col-md-12">
      <hr>
      {{-- {{ Breadcrumbs::render() }} --}}
      {{Form::open(['route' => 'mototaxis.store', 'method' => 'POST'])}}
        @include('page.mototaxis.form')
        <div class="text-center mb-3">
          <button type="submit" class="btn btn-primary">Crear Mototaxi</button>
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>

@push('script')
<script>

        $.get('/mototaxi/getUnidad', function(resp){
          console.log(resp);
            $.each(resp, function(i, item){
                $('#unidad').val(item);
            });
        });

</script>
@endpush
@endsection
