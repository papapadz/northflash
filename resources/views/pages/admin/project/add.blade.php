@extends('layout.master')

@push('plugin-styles')
<style>
  label {
    font-weight: bold;
  }
</style>
@endpush

@section('content')
<form method="POST" action="{{ url('admin/projects/save') }}">
{{ csrf_field() }}
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-header"><h3>New Project Details</h3></div>
      <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-12">
                    <label>Project Name</label>
                    <textarea name="project_name" type="text" class="form-control" placeholder="ex. Electrification of ..." required></textarea>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Project Location</label>
                    <input name="location" type="text" class="form-control" placeholder="ex. INCAT, Laoag City, Ilocos Norte" required>
                </div>
                <div class="col-md-6">
                    <label>Project Type</label>
                    <input name="project_type" type="text" class="form-control" placeholder="ex. Civil, Electrical, etc." required>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Start Date</label>
                    <input name="start_date" type="date" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>End Date</label>
                    <input name="end_date" type="date" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Contract By</label>
                    <input name="contract_by" type="text" placeholder="ex. City Government of ..." class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Project Cost</label>
                    <input name="amount" type="number" step=0.01 min=0 class="form-control" placeholder="xxx.xx" required>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    Add Employees to Project<br>
                    <select style="width: 100%">
                        <option selected disabled>Select an employee</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->employee_id }}">{{ $emp->last_name }}, {{ $emp->first_name }} {{ $emp->middle_name[0] ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="table table-bordered" id="toaddemp" style="width: 100%">

                    </div>
                </div>
            </div>
      </div>
      <div class="card-footer">
        <button class="btn btn-rounded btn-success" type="submit" onsubmit="return confirm('Are you sure you want to save this project?')">Save</button>
        <a href="{{ url('admin/projects') }}" class="btn btn-rounded btn-warning">Back</a>
      </div>
    </div>
  </div>
</div>
</form>  
@endsection

@push('custom-scripts')
<script>
  $(document).ready(function(){
    $('#table').DataTable();
    $('select').select2();

        $('select').on('change', function(e) {
            var txt = $('select option:selected').text();
            $('#toaddemp').append(
                '<tr id="'+$(this).val()+'"><td><input type="text" name="emp[]" value="'+$(this).val()+'" hidden>'+$(this).val()+'</td><td>'+txt+'</td><td><button class="btn btn-sm btn-danger" type="button" onclick=removeEmp("'+$(this).val()+'")>Remove</button></td></tr>');
        });
  });

    function removeEmp(id) {
        $('#'+id).remove();
    }

</script>
@endpush