@extends('layout.master')

@push('plugin-styles')
<style>
  label {
    font-weight: bold;
  }
</style>
@endpush

@section('content')
<div class="row mb-3">
  <div class="col-12">
    <a href="{{ url('admin/payrolls') }}" class="btn btn-warning float-right"><i class="mdi mdi-arrow-left"></i>Go Back</a>
  </div>
</div>
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter"><i class="mdi mdi-file-document-box-plus"></i> Generate</button>
        <hr>
        <div class="table-responsive">
          <table id="table" class="table table-striped">
            <thead>
              <tr>
                <th> Period </th>
                <th> Project </th>
                <th> # of Employees </th>
                <th> Gross Pay </th>
                <th> Total Deductions </th>
                <th> Net Pay </th>
                <th></th>
              </tr> 
            </thead>
            <tbody>
            @foreach($payrollGenerations as $generation)
              <tr>
                <td>
                  {{ Carbon\Carbon::parse($generation->date_start)->toDateString() }} to {{ Carbon\Carbon::parse($generation->date_end)->toDateString() }}
                  <br>
                  @if($generation->is_final)
                    <span class="badge badge-success"><i>finalized</i></span>
                  @else
                    <span class="badge badge-warning"><i>draft</i></span>
                  @endif
                </td>
                <td>{{ $generation->project->project_name }}</td>
                {{-- <td>{{ count($generation->payrollList->groupBy('employee_id')) }}</td> --}}
                <td>{{ count($generation->project->employees) }}</td>
                <td>
                  @php
                    $grossPay = 0;
                    $netDeductions = 0;
                    foreach($generation->payrollList as $listItem) 
                      if($listItem->payrollItem->type==1)
                        $grossPay += $listItem->total;
                      else
                        $netDeductions += $listItem->total;
                  @endphp
                  {{ number_format($grossPay,2,'.',',') }}
                </td>
                <td>{{ number_format($netDeductions,2,'.',',') }}</td>
                <td>{{ number_format($grossPay - $netDeductions,2,'.',',') }}</td>
                <td><a href="{{ url('admin/payroll/generations/view/'.$generation->id) }}" class="btn btn-rounded btn-primary"><i class="mdi mdi-open-in-new"></i> View</a>
                  @if(!$generation->is_final)
                    <a onclick="return confirm('Are you sure you want to delete this item?')" href="{{ route('delete.generation',$generation->id) }}" class="btn btn-rounded btn-danger"><i class="mdi mdi-delete"></i> Delete</a>
                  @else
                    <a target="_blank" href="{{ route('view.payslip',$generation->id) }}" class="btn btn-rounded btn-warning"><i class="mdi mdi-file-eye-outline"></i> Payslip</a>
                  @endif
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<form id="frmNewGeneration">
{{ csrf_field() }}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Generate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-md-12">
            <label>Department/Project</label><br>
            <select name="project_id" class="form-control w-100" required>
              <option disabled selected>Please select project...</option>
              @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->project_name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Date Start</label>
            <input name="date_start" type="date" class="form-control" required />
          </div>
          <div class="col-md-6">
            <label>Date End</label>
            <input name="date_end" type="date" class="form-control" required />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="submitNewGenerationForm" type="button" class="btn btn-primary">OK</button>
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
  $(document).ready(function() {

    $('#table').DataTable();
    $('select').select2({ width: '100%'});

    changelabels() 

    $('#month').on('change', function() {
      changelabels()    
    });

    $('#submitNewGenerationForm').on('click', function() {
      $.ajax({
        method: 'post',
        url: "{{ route('set.generations.add') }}",
        data: $('#frmNewGeneration').serialize(),
        success: function(data) {
          location.replace('{{ url("admin/payroll/generations/view") }}/'+data.id)
        },
        error: function(data) {
          alert(data.responseJSON.message)
        }
      })

    })
  });
  
function changelabels() {
  
      $('.tolabel').remove()

      var period = $('#year').val()+"-"+$('#month').val()
      var daysinmonth = moment(period,'YYYY-M').daysInMonth();
      if(daysinmonth==31)
        periodlabel = daysinmonth+'st'
      else
        periodlabel = daysinmonth+'th'
      $('#period2').append('<span class="tolabel">16 to '+periodlabel+' of the month</span>')
}

</script>
@endpush