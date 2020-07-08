@extends('layout.master')

@push('plugin-styles')
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
                <td>{{ Carbon\Carbon::parse($generation->payroll_date)->format('F Y') }}</td>
                <td>{{ count($generation->totalEmployees(Carbon\Carbon::parse($generation->payroll_date)->toDateString())) }}</td>
                <td>
                @php
                  $total = $totald = 0;
                  foreach($generation->totalEmployees(Carbon\Carbon::parse($generation->payroll_date)->toDateString()) as $emp) {
                    $empbenefits = $empdeductions = 0;
                    foreach($emp->employeePayroll(Carbon\Carbon::parse($generation->payroll_date)->toDateString(),$emp->employee_id,1) as $payroll) {
                      
                      if($payroll->payroll_item == 7 && (Carbon\Carbon::parse($generation->payroll_date)->month == 5 || Carbon\Carbon::parse($generation->payroll_date)->month == 11)) {
                        $empbenefits = $empbenefits + ($emp->employeeSalary($emp->employee_id)->amount/2);
                      } else if($payroll->payroll_item != 7) {
                          if($payroll->payroll_item == 5)
                            $empbenefits = $empbenefits + (findPayroll($payroll->payroll_item,$emp->employeeSalary($emp->employee_id)->amount,$payroll->amount) * $emp->ot);
                          else
                            $empbenefits = $empbenefits + findPayroll($payroll->payroll_item,$emp->employeeSalary($emp->employee_id)->amount,$payroll->amount);
                        }
                    }
                    foreach($emp->employeePayroll(Carbon\Carbon::parse($generation->payroll_date)->toDateString(),$emp->employee_id,2) as $payrolld) {
                      if($payroll->payroll_item == 6)
                        $empdeductions = $empdeductions + (findPayroll($payrolld->payroll_item,$emp->employeeSalary($emp->employee_id)->amount,$payrolld->amount) * $emp->ut);
                      else
                        $empdeductions = $empdeductions + findPayroll($payrolld->payroll_item,$emp->employeeSalary($emp->employee_id)->amount,$payrolld->amount);
                    }
                    $total = $total + $emp->employeeSalary($emp->employee_id)->amount + $empbenefits;
                    $totald = $totald + $empdeductions;
                  }
                  echo number_format($total, 2, '.', ',');
                @endphp
                </td>
                <td>
                  @php echo number_format($totald, 2, '.', ','); @endphp
                </td>
                <td>
                  @php echo number_format(($total-$totald), 2, '.', ','); @endphp
                </td>
                <td>
                  <div class="btn-group dropdown">
                    <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Manage </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{ url('admin/payrolls/generations/payslip/'.Carbon\Carbon::parse($generation->payroll_date)->toDateString()) }}">View payslips</a>
                      <hr>  
                      <a class="dropdown-item" href="#">Update</a>
                      <a class="dropdown-item" href="#">Delete</a>
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
        <div class="row">
          <div class="col-md-6">
            <label>Start Date <small>(1st or 15th)</small></label>
            <input style="width:100%" type="date" name="payroll_date_start">
          </div>
          <div class="col-md-6">
            <label>Start Date <small>(15th or 30th)</small></label>
            <input style="width:100%" type="date" name="payroll_date_end">
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
  $('#table').DataTable();
  $('select').select2();
</script>
@endpush