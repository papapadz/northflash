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
        <button class="btn btn-rounded btn-success" data-toggle="modal" data-target="#exampleModalCenter">Generate</button>
        <hr>
        <div class="table-responsive">
          <table id="table" class="table table-striped">
            <thead>
              <tr>
                <th> Date </th>
                <th> No. of Employees </th>
                <th> Gross Salary </th>
                <th> Total Deductions </th>
                <th> Net Pay </th>
                <th></th>
              </tr> 
            </thead>
            <tbody>
            @foreach($payrollGenerations as $generation)
              {{-- <tr class="py-1">
                <td>
                  {{ Carbon\Carbon::parse($generation->payroll_date)->format('M ') }}
                  @if(Carbon\Carbon::parse($generation->payroll_date)->day == 1)
                    {{ Carbon\Carbon::parse($generation->payroll_date)->day }} - 15
                  @else
                    16 - {{ Carbon\Carbon::parse($generation->payroll_date)->endOfMonth()->day }}
                  @endif
                  ,{{ Carbon\Carbon::parse($generation->payroll_date)->year }}
                </td>
                <td></td>
                <td> @php $gross = $generation->monthlySalaryAmount($generation->payroll_date); echo number_format($gross,2,'.',','); @endphp </td>
                <td> @php $grossd = $generation->monthlyDeductionAmount($generation->payroll_date);  echo number_format($grossd,2,'.',','); @endphp </td>
                <td> @php echo number_format($gross-$grossd,2,'.',',') @endphp </td>
                <td>
                  <div class="btn-group dropdown">
                    <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Manage </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{ url('admin/payrolls/generations/payslip/'.Carbon\Carbon::parse($generation->payroll_date)->toDateString()) }}">View payslips</a>
                      <hr>  
                      <a class="dropdown-item text-danger" onclick="buttonCRUD('payroll_generations','{{ $generation->payroll_date }}',3)">Delete</a>
                    </div>
                  </div>
                </td>
              </tr> --}}
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<form method="POST" action="{{ route('generations.add') }}">
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
          <div class="col-12">
            <label>Department/Project</label><br>
            <select name="project_id" class="form-control">
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
            <input name="date_start" type="date" class="form-control" />
          </div>
          <div class="col-md-6">
            <label>Date End</label>
            <input name="date_end" type="date" class="form-control" />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">OK</button>
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
    $('select').select2();

    changelabels() 

    $('#month').on('change', function() {
      changelabels()    
    });

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