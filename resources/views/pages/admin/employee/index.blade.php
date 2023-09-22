@extends('layout.master')

@push('plugin-styles')
<style>
  label {
    font-weight: bold;
  }
</style>
@endpush

@section('content')
<employee-index-component employeeList='{{ $employees }}'></employee-index-component>
@endsection

@push('plugin-scripts')
@endpush