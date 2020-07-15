@extends('layout.master')

@push('plugin-styles')
<style>
  label {
    font-weight: bold;
  }
</style>
@endpush

@section('content')
<form method="POST" action="{{ url('admin/project/update/'.$project->id) }}" onsubmit="return confirm('Are you sure you want to save this changes on this project?');">
{{ csrf_field() }}
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-header">
          <h3 class="float-left">{{ $project->project_name }}</h3>
          <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
              <label id="status1" 
                @if($project->status)
                    class="btn btn-secondary"
                @else
                    class="btn btn-danger"
                @endif
              >
                <input type="radio" name="status" autocomplete="off" value=false> On-going
              </label>
              <label id="status1" 
                @if($project->status)
                    class="btn btn-success"
                @else
                    class="btn btn-secondary"
                @endif
              >
                <input type="radio" name="status" autocomplete="off" value=true> Completed
              </label>
          </div>
      </div>
      <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-12">
                    <label>Project Name</label>
                    <textarea value="{{ $project->project_name }}" name="project_name" type="text" class="form-control fillables" placeholder="ex. Electrification of ..." required>{{ $project->project_name }}</textarea>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Project Location</label>
                    <input value="{{ $project->location }}" name="location" type="text" class="form-control fillables" placeholder="ex. INCAT, Laoag City, Ilocos Norte" required>
                </div>
                <div class="col-md-6">
                    <label>Project Type</label>
                    <input value="{{ $project->project_type }}" name="project_type" type="text" class="form-control fillables" placeholder="ex. Civil, Electrical, etc." required>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Start Date</label>
                    <input value="{{ Carbon\Carbon::parse($project->start_date)->toDateString() }}" name="start_date" type="date" class="form-control fillables" required>
                </div>
                <div class="col-md-6">
                    <label>End Date</label>
                    <input value="@if($project->enddate){{ Carbon\Carbon::parse()->toDateString() }}@endif" name="end_date" type="date" class="form-control fillables">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Contract By</label>
                    <input value="{{ $project->contract_by }}" name="contract_by" type="text" placeholder="ex. City Government of ..." class="form-control fillables" required>
                </div>
                <div class="col-md-6">
                    <label>Project Cost</label>
                    <input value="{{ $project->amount }}" name="amount" type="number" step=0.01 min=0 class="form-control fillables" placeholder="xxx.xx" required>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    Add Employees to Project<br>
                    <select style="width: 100%" class="fillables">
                        <option selected disabled>Select an employee</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->employee_id }}">{{ $emp->last_name }}, {{ $emp->first_name }} {{ $emp->middle_name[0] ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered" id="toaddemp" style="width: 100%">
                        @foreach($project->employees as $projemp)
                            <tr id="{{ $projemp->employee_id }}">
                                <td><input type="text" name="emp[]" value="{{ $projemp->employee_id }}" hidden>{{ $projemp->employee_id }}</td>
                                <td>{{ $projemp->last_name }}, {{ $projemp->first_name }} {{ $projemp->middle_name[0] ?? '' }}</td>
                                <td><button class="btn btn-sm btn-danger fillables" type="button" onclick="removeEmp('{{ $projemp->employee_id }}')">Remove</button></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
      </div>
      <div class="card-footer">
        <button style="display: none" id="btnsave" class="btn btn-rounded btn-success" type="submit">Save</button>
        <button id="btnedit" class="btn btn-rounded btn-primary" onclick="edit()" type="button">Edit</button>
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
    
    $('.fillables').prop('disabled',true);
    $('select.fillables').select2();
    
        $('select').on('change', function(e) {
            var txt = $('select option:selected').text();
            $('#toaddemp').append(
                '<tr id="'+$(this).val()+'"><td><input type="text" name="emp[]" value="'+$(this).val()+'" hidden>'+$(this).val()+'</td><td>'+txt+'</td><td><button class="btn btn-sm btn-danger" type="button" onclick=removeEmp("'+$(this).val()+'")>Remove</button></td></tr>');
        });

        $('input[type=radio][name=status]').change(function() {
            
            if($(this).val()=='true') {
                $('#status1').attr('class','btn btn-secondary')
                $('#status2').attr('class','btn btn-success')
            } else {
                $('#status1').attr('class','btn btn-danger')
                $('#status2').attr('class','btn btn-secondary')
            }
                
        });
  });

  function edit() {
    $('.fillables').prop('disabled',false);
    $('#btnedit').hide();
    $('#btnsave').show();
  }

    function removeEmp(id) {
        $('#'+id).remove();
    }

</script>
@endpush