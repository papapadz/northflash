@extends('layout.master')

@push('plugin-styles')
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
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
            @foreach($employees as $e)
            @php
              $employee_salary = $e->employment->amount;
            @endphp
              <tr class="py-1">
                <td>{{ $e->employee_id }}</td>
                <td>{{ $e->last_name }}, {{ $e->first_name }} {{ $e->middle_name[0] ?? ''}}</td>
                <td class="row">
                  @if(count($e->payroll)>0)
                  <div class="col-md-6">
                    <span class="text-success">Additions (+)</span>
                    <div class="row">
                      @foreach($e->payroll as $additions)
                        @if($additions->payrollItem->type==1)
                        <div class="col-md-6">{{$additions->payrollItem->item}}: </div>
                          <div class="col-md-6 text-right">
                            {{ number_format($additions->amount,2,'.',',') }}
                          </div>
                        @endif
                      @endforeach
                    </div>
                  </div>
                  <div class="col-md-6">
                    <span class="text-danger">Deductions (-)</span>
                    <div class="row">
                      @foreach($e->payroll as $deductions)
                        @if($deductions->payrollItem->type==2)
                        <div class="col-md-6">{{$deductions->payrollItem->item}}: </div>
                          <div class="col-md-6 text-right">
                            {{ number_format($deductions->amount,2,'.',',') }}
                          </div>
                        @endif
                      @endforeach
                    </div>
                  </div>
                  @else
                  <span class="text-small text-danger">No Payroll Items Added</span>
                  @endif
                </td>
                <td>
                  <button class="btn btn-rounded btn-success" onclick="openPayrollModal({{$e->employee_id}})">Manage</button>
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
<div class="modal fade" id="addPayrollModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">
          <input name="employee_id" id="addPayrollModalInputEmployeeID" hidden>
          <span style="font-weight: bold" id="addPayrollModalSpanEmployeeName"></span>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <div class="col-8" style="font-weight: bold">Payroll Item</div>
              <div class="col-4" style="font-weight: bold">Amount (PHP)</div>
            </div>
            <hr>
            <div class="row">
              <div class="col-12" id="addPayrollModalSpanEmployeeNameAdditions">
                <small class="text-success">Additions</small>
                @foreach($payrollItems1 as $item1)
                <div class="row">
                  <div class="col-8">
                    <div class="custom-control custom-checkbox">
                      <input onclick="checkItem({{$item1->id}})" id="addPayrollModalCheck_{{ $item1->id }}" class="form-check-input is-invalid" type="checkbox" value="{{ $item1->id }}" name="item[]">
                      <label>{{ $item1->item }}</label>
                    </div>
                  </div>
                  <div class="col-4">
                    <input id="addPayrollModalInputVal_{{ $item1->id }}" class="form-control text-right clas-itemVal" name="itemVal[]" type="number" step="0.01" min="0" placeholder="{{ $item1->amount }}"/>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-12" id="addPayrollModalSpanEmployeeNameDeductions">
              <small class="text-danger">Deductions</small>
                @foreach($payrollItems2 as $item2)
                <div class="row">
                  <div class="col-8">
                    <div class="custom-control custom-checkbox">
                      <input onclick="checkItem({{$item2->id}})" id="addPayrollModalCheck_{{ $item2->id }}" class="form-check-input is-invalid" type="checkbox" value="{{ $item2->id }}" name="item[]">
                      <label>{{ $item2->item }}</label>
                    </div>
                  </div>
                  <div class="col-4">
                    <input id="addPayrollModalInputVal_{{ $item2->id }}" class="form-control text-right clas-itemVal" name="itemVal[]" type="number" step="0.01" min="0" placeholder="{{ $item2->amount }}"/>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
          {{-- <div class="form-group">
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
          </div> --}}
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

let pItemInstance = []

$(document).ready(function() {

  $('#table').DataTable();
  $('select').select2();

  $('.repeat').on('change',function() {
    if($(this).val()==1)
      $('#divFixedDate').hide();
    else
      $('#divFixedDate').show();
  });

  $('#updateModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      
      var modal = $(this)
      modal.find('.modal-title').text('Employee ID: '+button.data('id'))
      $('#employee_id_update').val(button.data('id'))
      $('#employee_name').val(button.data('name'))
      $.ajax({
        url: "{{ url('admin/get/employee/payroll') }}/"+button.data('id')
      }).done(function(data){
        console.log(data);
        data.map(function(payroll) {
          checkItem(payroll.id)
        })
      })
    })

})

function checkItem(id) {
  const x = pItemInstance.find(obj => obj.id === id)

  if($('#addPayrollModalCheck_'+id).is(':checked')) {
    $('#addPayrollModalInputVal_'+id).prop('disabled',false)

    $.ajax({
      url: "{{ url('admin/get/payroll/item') }}",
      data: {
        payroll_item: id,
        emp_id:  $('#addPayrollModalInputEmployeeID').val()
      },
      success: function(response) {
        console.log(response)
        $('#addPayrollModalInputVal_'+id).val(parseFloat(response).toFixed(2))
      }
    })
  } else {
    if(x===undefined)
      $('#addPayrollModalInputVal_'+id).prop('placeholder','0.00')
    else
      $('#addPayrollModalInputVal_'+id).prop('placeholder',x.amount)
    $('#addPayrollModalInputVal_'+id).val(null)
    $('#addPayrollModalInputVal_'+id).prop('disabled',true)
  }
}

function openPayrollModal(empid) {
  $('.custom-checkbox').prop('checked',false)
  $('.clas-itemVal').prop('disabled',true)
  $('.clas-itemVal').val(null)
  $('#addPayrollModalInputEmployeeID').val(empid)
  $.ajax({
    url: "{{ url('admin/get/employee/payroll') }}/"+empid,
    success: function(response) {
      console.log(response)
      $('#addPayrollModal').modal('show')
      $('#addPayrollModalSpanEmployeeName').html(response.last_name+', '+response.first_name+' '+response.middle_name)
      
      pItemInstance=[]
      for(let i=0; i<response.payroll.length;i++) {
        pItemInstance.push({
          id: response.payroll[i].payroll_item.id,
          amount: response.payroll[i].amount.toFixed(2)
        })
        $('#addPayrollModalInputVal_'+response.payroll[i].payroll_item.id).prop('disabled',false)
        $('#addPayrollModalInputVal_'+response.payroll[i].payroll_item.id).val(response.payroll[i].amount)
        $('#addPayrollModalCheck_'+response.payroll[i].payroll_item.id).prop('checked',true)
      }
    }
  })

  console.log(pItemInstance)
}
</script>
@endpush