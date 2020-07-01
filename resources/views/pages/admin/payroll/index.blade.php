@extends('layout.master')

@push('plugin-styles')
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-rounded btn-success" data-toggle="modal" data-target="#exampleModalCenter">New Payroll</button>
        <a class="btn btn-rounded btn-warning" href="{{ url('admin/payrolls/generations') }}">Generate Payroll</a>
        <hr>
        <div class="table-responsive">
          <table id="table" class="table table-striped">
            <thead>
              <tr>
                <th> ID </th>
                <th> Name </th>
                <th> Payroll </th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            @foreach($employeePayrolls as $e)
            @php
              $employee_salary = $e->employment->amount;
            @endphp
              <tr class="py-1">
                <td>{{ $e->employee_id }}</td>
                <td>{{ $e->last_name }}, {{ $e->first_name }} {{ $e->middle_name[0] ?? ''}}</td>
                <td class="row">
                  <div class="col-6">
                    <span class="text-success">Additions (+)</span>
                    <div class="row">
                      <div class="col-6">Salary:</div>
                      <div class="col-6">@php echo number_format($employee_salary, 2, '.', ',') @endphp</div>
                    </div>
                    <div class="row">
                      @foreach($e->payroll->where('type',1) as $additions)
                        <div class="col-6">{{$additions->item}}: </div>
                        <div class="col-6">{{$additions->amount}} /hr</div>
                      @endforeach
                    </div>
                  </div>
                  <div class="col-6">
                    <span class="text-danger">Deductions (-)</span>
                      @foreach($e->payroll->where('type',2) as $deductions)
                        <div class="row">
                          <div class="col-6">
                          {{ $deductions->item }}:
                          </div>
                          <div class="col-6">
                          @php
                            $deduction_id = $deductions->id;
                            $deduction_amount = $deductions->amount;
                          @endphp
                          @if($deduction_id==6)
                            {{number_format($deductions->amount, 2, '.', ',')}} /min
                          @elseif($deductions->flexirate)
                            {{ findPayroll($deduction_id,$employee_salary,$deduction_amount,0,0) }}
                          @elseif($deductions->percentage>0)
                            {{($deductions->percentage*100)}}% 
                          @else
                            {{number_format($deduction_amount, 2, '.', ',')}}
                          @endif
                          </div>
                        </div>
                      @endforeach
                  </div>
                </td>
                <td>
                  <div class="btn-group dropdown">
                    <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Manage </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">View</a>
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
<form method="POST" action="{{ url('admin/payroll/add') }}">
{{ csrf_field() }}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New Payroll</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label>Employee: </label><br>
            <select required name="employee_id" style="width: 100%">
              @foreach($employees as $emp)
                <option value="{{ $emp->employee_id }}">{{ $emp->last_name }}, {{ $emp->first_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            Payroll Items:<br>
            <div class="row">
              <div class="col-6">
              <small class="text-success">Additions</small>
                @foreach($payrollItems1 as $item1)
                <div class="custom-control custom-checkbox">
                  <input class="form-check-input is-invalid" type="checkbox" value="{{ $item1->id }}" name="item[]">
                  <label>{{ $item1->item }}</label>
                </div>
                @endforeach
              </div>
              <div class="col-6">
              <small class="text-danger">Deductions</small>
                @foreach($payrollItems2 as $item2)
                <div class="custom-control custom-checkbox">
                  <input class="form-check-input is-invalid" type="checkbox" value="{{ $item2->id }}" name="item[]">
                  <label>{{ $item2->item }}</label>
                </div>
                @endforeach
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Payroll Date: </label><br>
            <input type="radio" class="repeat" name="repeat" value="1" checked>
            <label class="mr-2">Indefinite</label>
            <input type="radio" class="repeat" name="repeat" value="2" >
            <label class="mr-2">Set Fixed Date</label>
          </div>
          <div class="form-group row">
            <div class="col-6">
              <label>Start Date</label>
              <input type="date" class="form-control" name="payroll_date_start" required>
            </div>
            <div class="col-6" id="divFixedDate" style="display:none">
              <label>End Date</label>
              <input type="date" class="form-control" name="payroll_date_end">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
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