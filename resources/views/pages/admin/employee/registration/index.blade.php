@extends('layout.master')

@push('plugin-styles')
<style>
  label {
    font-weight: bold;
  }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
            <registration-component csrf="{{ csrf_token() }}" />
        </div>
      </div>
    </div>
</div>
@endsection