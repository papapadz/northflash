@extends('layout.master')

@push('plugin-styles')

@endpush

@section('content')
{{ csrf_field() }}
<input type="text" name="payroll_master_id" value="{{ $payrollMaster->id }}" hidden>
@php
  $grandTotal = 0;
@endphp
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-header">
        <h2>Site: {{ $payrollMaster->project->project_name }}</h2>
        <b>Payroll Period: 
          {{ Carbon\Carbon::parse($payrollMaster->date_start)->toFormattedDateString() }} to {{ Carbon\Carbon::parse($payrollMaster->date_end)->toFormattedDateString() }}
        </b><br>
        <b id="displayGrandTotalElement">Total Amount: Php </b>
        <button class="btn btn-rounded btn-success float-right" type="submit">Save</button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="table" class="table table-striped table-responsive">
            <thead>
              <tr>
                <th> ID </th>
                <th> Name </th>
                <th> Position </th>
                <th> Employment Status </th>
                <th> Pay </th>
                <th style="background-color:cornflowerblue"> Days Rendered </th>
                <th style="background-color:cornflowerblue"> Days Absent </th>
                @foreach($payroll_items as $pitem)
                <th style="min-width: 50px; background-color: @if($pitem->type==1) lightgreen @else lightcoral @endif" > {{ $pitem->item }} @if($pitem->unit) ({{$pitem->unit}}) @endif </th>
                @endforeach
                <th> Net Pay (Php) </th>
              </tr>
            </thead>
            <tbody>
            @foreach($payrollMaster->project->employees as $k => $e)
            @php $totalNetPay = 0; @endphp
            <tr class="py-1">
                <td><input type="text" id="{{$k}}_emp" name="emp[]" value="{{ $e->employee_id }}" hidden>{{ $e->employee_id }}</td>
                <td>{{ $e->employee->last_name }}, {{ $e->employee->first_name }} {{ $e->employee->middle_name[0] ?? ''}}</td>
                <td>{{ $e->employee->employment->salary->position->title }}</td>
                <td>{{ $e->employee->employment->status }}</td>
                <td>
                  @if($e->employee->employment->salary->monthly)
                    @php $ssalary = $e->employee->employment->salary->amount/2; @endphp
                  @else
                    @php $ssalary = $e->employee->employment->salary->amount; @endphp
                  @endif
                  <input id="{{ $k }}_salary" type="number" value="{{ $ssalary }}" hidden/>
                  {{ $ssalary }} @if($e->employee->employment->salary->monthly) <span> (half month)</span> @else <span>(daily)</span> @endif
                </td>
                <td>
                    @if(!$e->employee->employment->salary->monthly)
                      @php
                         $empPayrollItem = $payrollMaster->payrollList->where('employee_id',$e->employee_id)->where('payroll_item',8)->first();
                         $pay = 0;
                          if($empPayrollItem) {
                            $pay = $empPayrollItem->qty;
                            $totalNetPay += $empPayrollItem->total;
                          }
                      @endphp
                      <input 
                        value="{{ $pay }}" 
                        id="{{ $k }}_dr" 
                        type="number" 
                        class="form-control" 
                        onchange="updateGrossPay(101,{{$k}},8)" 
                        min="0" />
                    @else
                      <input class="form-control" disabled>  
                    @endif
                </td>
                <td>
                    @if($e->employee->employment->salary->monthly)
                      @php
                        $empPayrollItem = $payrollMaster->payrollList->where('employee_id',$e->employee_id)->where('payroll_item',8)->first();
                        $pay = 0;
                          if($empPayrollItem) {
                            $pay = $empPayrollItem->qty;
                            $totalNetPay += $empPayrollItem->total;
                          }
                      @endphp
                      <input value="{{ $pay }}" id="{{ $k }}_da" type="number" class="form-control" onchange="updateGrossPay(102,{{$k}},8)" min="0" />
                    @else
                        <input class="form-control" disabled>  
                    @endif
                </td>
                @foreach($payroll_items as $ppitem)
                <td>
                  @if($e->employee->payroll->contains('payroll_item',$ppitem->id))
                      @php
                          $empPayrollItem = $payrollMaster->payrollList->where('employee_id',$e->employee_id)->where('payroll_item',$ppitem->id)->first();
                          $pay = 0;
                          if($empPayrollItem) {
                            $pay = $empPayrollItem->qty;
                            $totalNetPay += $empPayrollItem->total;
                          }
                      @endphp
                      <input value="{{ $pay }}" class="form-control" id="{{$k}}_{{ $ppitem->id }}_pitem" type="number" name="{{ $ppitem->id }}_pitem[]" min=0  onchange="updateGrossPay({{$ppitem->type}},{{$k}},{{$ppitem->id}})" />
                  @else
                    <input class="form-control" disabled>  
                  @endif  
                </td>
                @endforeach
                <td><input type="text" id="{{$k}}_netPay" class="form-control class-netpays" value="{{ $totalNetPay }}" disabled/></td>
              </tr>
              @php $grandTotal += $totalNetPay; @endphp
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('plugin-scripts')
@endpush

@push('custom-scripts')
<script>
  
  $(document).ready(function() {
    var table = $('#table').DataTable()

    table.columns.adjust().draw();
    
  $('select').select2();

  $('.repeat').on('change',function() {
    if($(this).val()==1)
      $('#divFixedDate').hide();
    else
      $('#divFixedDate').show();
  });

  $('#displayGrandTotalElement').append('<span class="spanGrandTotal">{{ number_format($grandTotal,2,".",",") }}</span>')
})

function updateGrossPay(flag, index, pid) {
  
    let n = 1
    switch(flag) {
      case 101:
        n =  $('#'+index+'_dr').val()
      break;
      case 102:
        n = $('#'+index+'_da').val()
      break;
      case 1:
        n = $('#'+index+'_'+pid+"_pitem").val()
      break;
      case 2:
        n = $('#'+index+'_'+pid+"_pitem").val()
      break;
    }
    
    $.ajax({
      url: "{{ route('set.payroll.generation.add') }}",
      data: {
        payroll_master_id: "{{ $payrollMaster->id }}",
        employee_id: $('#'+index+'_emp').val(),
        payroll_item_id: pid,
        qty: n
      }
    }).done(function(data){

        const sumOfType1 = data
          .filter(obj => obj.payroll_item.type === 1)
          .reduce((acc, obj) => acc + obj.total, 0);

        const sumOfType2 = data
          .filter(obj => obj.payroll_item.type === 2)
          .reduce((acc, obj) => acc + obj.total, 0);

        const netpay = sumOfType1-sumOfType2
        
        $('#'+index+'_netPay').val(netpay.toFixed(2) )

        var sum = 0;
        $('.class-netpays').each(function() {
          console.log(parseFloat($(this).val()))
            sum += parseFloat($(this).val());
        });
        $('.spanGrandTotal').remove()
        $('#displayGrandTotalElement').append('<span class="spanGrandTotal">'+sum.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })+'</span>')
    })
  }
</script>
@endpush