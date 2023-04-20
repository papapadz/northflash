@php
    $grossPay = 0;
    $totalDeductions = 0;
@endphp
<div class="column">
    <table>
        <tr>
            <td colspan="2">
                <img src="http://localhost/northflash/public/assets/images/nfpb.jpg" width="120px"/>
            </td>
            <td colspan="6">
                <p>
                    <center>
                        <b class="title">NORTHFLASH POWER AND BUILDS, INC.</b><br>
                        <span class="sub-title">Dacuycuy St., Centro 3, Claveria, Cagayan</span>
                    </center>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="8" class="bordered-top">
                <center>
                    <b class="sub-title">Payslip for the period {{ Carbon\Carbon::parse($payrollGeneration->date_start)->format('M') }} {{ Carbon\Carbon::parse($payrollGeneration->date_start)->day }} to {{ Carbon\Carbon::parse($payrollGeneration->date_end)->toFormattedDateString() }}</b>
                </center>
            </td>
        </tr>
        <tr>
            <td colspan="8" class="bordered-top sub-title"><center><b>{{ $payrollGeneration->project->project_name }}</b></center></td>
        </tr>
        <tr><td class="bordered-top" colspan="8"></td></tr>
        <tr>
            <td class="sub-title">Name: </td>
            <td class="sub-title" colspan="4">{{ $employeePayroll->employee->last_name }}, {{ $employeePayroll->employee->first_name }} {{ $employeePayroll->employee->middle_name ?? $employeePayroll->middle_name[0] ?? '' }}</td>
            <td class="sub-title">
                @if($employeePayroll->employee->employment->salary->monthly)
                    Salary:
                @else
                    Daily Rate:
                @endif
            </td>
            <td class="sub-title" colspan="2">
                @php
                    $pay = 0;
                    $qty = 0;
                    $empPayrollItem = $payrollGeneration->payrollList->where('employee_id',$employeePayroll->employee_id)->where('payroll_item',8)->first();

                    if($employeePayroll->employee->employment->salary->monthly)
                        $pay = $empPayrollItem->total;
                    else
                        $pay = $empPayrollItem->amount;
                    $qty = $empPayrollItem->qty;
                    $grossPay += $empPayrollItem->total
                @endphp
                {{ number_format($pay,2,'.',',') }}
            </td>
        </tr>
        <tr><td class="bordered-top" colspan="8"></td></tr>
        <tr>
            <td class="sub-title">Position:</td>
            <td class="sub-title" colspan="4">{{ $employeePayroll->employee->employment->salary->position->title }}</td>
            <td class="sub-title" colspan="2">
                @if($employeePayroll->employee->employment->salary->monthly)
                    Days Absent:
                @else
                    Days Rendered:
                @endif
            </td>
            <td class="sub-title">{{ $qty }}</td>
        </tr>
        <tr><td class="blank-line" colspan="8"></td></tr>
        <tr>
            <td colspan="2"><b class="sub-title">Earnings</b></td>
            <td colspan="2"><b class="sub-title">Amount</b></td>
            <td colspan="2"><b class="sub-title">Deductions</b></td>
            <td colspan="2"><b class="sub-title">Amount</b></td>
        </tr>
        <tr><td class="bordered-top" colspan="8"></td></tr>
        @php
            $max = 5;
            $finalArray = [];
            $arrRowsAdd = [];
            $arrRowsDed = [];
            $empPayrollList = $payrollGeneration->payrollList->where('employee_id',$employeePayroll->employee_id);

            foreach($employeePayroll->employee->payroll as $pItem) {
                $newPItem = $empPayrollList->where('payroll_item',$pItem->payroll_item)->first();
                $pushedItem = array(
                    'item' => $pItem->payrollItem->item,
                    'val' => ($newPItem ? $newPItem->total : '-')
                );
                
                if($pItem->payrollItem->type==1) {
                    if($newPItem)
                        $grossPay+=$newPItem->total;
                    array_push($arrRowsAdd,$pushedItem);
                }
                else {
                    if($newPItem)
                        $totalDeductions+=$newPItem->total;
                    array_push($arrRowsAdd,$pushedItem);
                }
            }
            
            for($index=0; $index<$max; $index++) {
                array_push($finalArray, array(
                    'add' => (count($arrRowsAdd)>$index) ? $arrRowsAdd[$index] : null,
                    'ded' => (count($arrRowsDed)>$index) ? $arrRowsDed[$index] : null,
                ));
            }
        @endphp
        @foreach($finalArray as $k => $data)
        <tr>
            <td colspan="2" class="sub-title">
                @if($data['add'] !== null && $data['add']['item'] !== null)
                    {{ $data['add']['item'] }}
                @endif
            </td>
            <td colspan="2" class="sub-title" align="right">
                @if($data['add'] !== null && $data['add']['val'] !== null)
                    {{ $data['add']['val'] }}
                @endif
            </td>
            <td colspan="2" class="sub-title">
                @if($data['ded'] !== null && $data['ded']['item'] !== null)
                    {{ $data['ded']['item'] }}
                @endif
            </td>
            <td colspan="2" class="sub-title" align="right">
                @if($data['ded'] !== null && $data['ded']['val'] !== null)
                    {{ $data['ded']['val'] }}
                @endif
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="3"><b class="sub-title">Gross Pay</b></td>
            <td><b class="sub-title">{{ number_format($grossPay,2,'.',',') }}</b></td>
            <td colspan="3"><b class="sub-title">Total Deductions</b></td>
            <td><b class="sub-title">{{ number_format($totalDeductions,2,'.',',') }}</b></td>
        </tr>
    </table>
</div>