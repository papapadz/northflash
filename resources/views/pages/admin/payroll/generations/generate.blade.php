@extends('layout.master')

@push('plugin-styles')
@endpush

@section('content')
<form method="POST" action="{{ url('admin/payrolls/generations/save') }}">
{{ csrf_field() }}
<input type="text" name="payroll_date" value="{{ $payroll_date }}" hidden>
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-rounded btn-success" type="submit">Save</button>
        <hr>
        <div class="table-responsive">
          <table id="table" class="table table-striped">
            <thead>
              <tr>
                <th> ID </th>
                <th> Name </th>
                <th> No. of Days </th>
                <th> Overtime (hrs) </th>
                <th> Undertime (min) </th>
              </tr>
            </thead>
            <tbody>
            @foreach($employees as $e)
            <tr class="py-1">
                <td><input type="text" name="emp[]" value="{{ $e->employee_id }}" hidden>{{ $e->employee_id }}</td>
                <td>{{ $e->last_name }}, {{ $e->first_name }} {{ $e->middle_name[0] ?? ''}}</td>
                <td><input type="number" name="reg[]" value=0 min=0></td>
                <td><input type="number" name="ot[]" value=0 min=0></td>
                <td><input type="number" name="ut[]" value=0 min=0></td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</form>

@endsection

@push('plugin-scripts')
@endpush

@push('custom-scripts')
<script>
  $('#table').DataTable();
  $('select').select2();

  $('.repeat').on('change',function() {
    if($(this).val()==1)
      $('#divFixedDate').hide();
    else
      $('#divFixedDate').show();
  });
</script>
@endpush