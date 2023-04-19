@extends('layout.master')

@push('plugin-styles')

@endpush

@section('content')
{{ csrf_field() }}
<input type="text" name="payroll_master_id" value="{{ $payrollMaster->id }}" hidden>
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-header">
        <h2>Site: {{ $payrollMaster->project->project_name }}</h2>
        <b>Payroll Period: 
          {{ Carbon\Carbon::parse($payrollMaster->start_date)->toFormattedDateString() }} to {{ Carbon\Carbon::parse($payrollMaster->end_date)->toFormattedDateString() }}
        </b>
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
                <th> Net Pay </th>
              </tr>
            </thead>
            <tbody>
            @foreach($payrollMaster->project->employees as $k => $e)
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
                  <input id="{{ $k }}_dr" type="number" class="form-control" onchange="updateGrossPay(101,{{$k}},8)" min="0" @if($e->employee->employment->salary->monthly) disabled @endif />
                </td>
                <td>
                  <input id="{{ $k }}_da" type="number" class="form-control" onchange="updateGrossPay(102,{{$k}},8)" min="0" @if(!$e->employee->employment->salary->monthly) disabled @endif />
                </td>
                @foreach($payroll_items as $ppitem)
                <td><input class="form-control" @if(isset($e->employee->payroll[$ppitem->id])) disabled @endif id="{{$k}}_{{ $ppitem->id }}_pitem" type="number" name="{{ $ppitem->id }}_pitem[]" placeholder=0 min=0  onchange="updateGrossPay({{$ppitem->type}},{{$k}},{{$ppitem->amount}})"></td>
                @endforeach
                <td><input type="number" id="net_pay_{{ $k }}"></td>
              </tr>
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
})

function updateGrossPay(flag, index, pid) {
    console.log($('#'+index+'_da').val())
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
        console.log(data)
    })
  }
</script>
@endpush