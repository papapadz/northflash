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
              <tr class="py-1">
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
<form method="POST" action="{{ url('admin/payrolls/generations/add') }}">
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
          <div class="col-md-6">
            <label>Month: </label><br>
            <select required name="month" id="month" style="width: 100%">
              <option value="1" @if(Carbon\Carbon::now()->month==1) selected @endif>January</option>
              <option value="2" @if(Carbon\Carbon::now()->month==2) selected @endif>February</option>
              <option value="3" @if(Carbon\Carbon::now()->month==3) selected @endif>March</option>
              <option value="4" @if(Carbon\Carbon::now()->month==4) selected @endif>April</option>
              <option value="5" @if(Carbon\Carbon::now()->month==5) selected @endif>May</option>
              <option value="6" @if(Carbon\Carbon::now()->month==6) selected @endif>June</option>
              <option value="7" @if(Carbon\Carbon::now()->month==7) selected @endif>July</option>
              <option value="8" @if(Carbon\Carbon::now()->month==8) selected @endif>August</option>
              <option value="9" @if(Carbon\Carbon::now()->month==9) selected @endif>September</option>
              <option value="10" @if(Carbon\Carbon::now()->month==10) selected @endif>October</option>
              <option value="11" @if(Carbon\Carbon::now()->month==11) selected @endif>November</option>
              <option value="12" @if(Carbon\Carbon::now()->month==12) selected @endif>December</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Year: </label><br>
            <select required name="year" id="year" style="width: 100%">
              <option value="2018" @if(Carbon\Carbon::now()->year==2018) selected @endif>2018</option>
              <option value="2019" @if(Carbon\Carbon::now()->year==2019) selected @endif>2019</option>
              <option value="2020" @if(Carbon\Carbon::now()->year==2020) selected @endif>2020</option>
              <option value="2021" @if(Carbon\Carbon::now()->month==2) selected @endif>2021</option>
              <option value="2022" @if(Carbon\Carbon::now()->month==3) selected @endif>2022</option>
            </select>
          </div>
        </div>
        <div class="row">
            <div class="col-12">
              <label>Period: </label><br>
              <input type="radio" name="period" value="1" checked>
              <span class="mr-2" >1 to 15th day of the month</span>
              <input type="radio" name="period" value="16" >
              <span class="mr-2" id="period2"></span>  
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