<div class="column">
    <table>
        <tr>
            <td colspan="3" style="font-size: 16px"><center><b><u>North Flash Power and Builds, Inc.</u></b></center></td>
        </tr>
        <tr>
            <td colspan="3"><center><b>Payslip for {{ Carbon\Carbon::parse($emp->payroll_date)->format('F Y') }}</b></center></td>
        </tr>
        <tr><td colspan="3"></td></tr>
        <tr>
            <td>Employee ID:</td>
            <td colspan="2" >{{ $emp->employee_id }}</td>
        </tr>
        <tr>
            <td>Name:</td>
            <td colspan="2">{{ $emp->employee->last_name }}, {{ $emp->employee->first_name }} {{ $emp->employee->middle_name[0] ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="3" style="border-top: solid"><i>Additions</i></td>
        </tr>
        <tr>
            <td>Salary:</td>
            <td colspan="2" class="right">
            @php
                $totalAdd = $totalDeduct = 0;
                $salary = number_format($emp->employeeSalary($emp->employee_id,Carbon\Carbon::parse($emp->payroll_date)->toDateString())->amount,2,'.',',');
                echo $salary;
            @endphp
            </td>
        </tr>
        @foreach($emp->employeePayroll($emp->payroll_date,$emp->employee_id,1) as $payroll)
        <tr>
            <td>{{ $payroll->item }}:</td>
            <td colspan="2" class="right">
            @php
                $pamount = 0;
                if($payroll->payroll_item == 5)
                    $pamount = $payroll->amount*$emp->ot;
                else
                    $pamount = $payroll->amount;

                $totalAdd = $totalAdd + $pamount;
                echo number_format($pamount,2,'.',',');
            @endphp
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2" style="text-align:right"><b>Total: </b></td>
            <td class="right"><u><b>
            @php
                $gross = $emp->employeeSalary($emp->employee_id,Carbon\Carbon::parse($emp->payroll_date)->toDateString())->amount + $totalAdd;
                echo number_format($gross,2,'.',',');
            @endphp
            </b></u></td>
        </tr>
        <tr>
            <td colspan="3" style="border-top: solid"><i>Deductions</i></td>
        </tr>
        @foreach($emp->employeePayroll($emp->payroll_date,$emp->employee_id,2) as $payroll)
        <tr>
            <td>{{ $payroll->item }}:</td>
            <td colspan="2" class="right">
            @php
               $pdeduct = findPayroll($payroll->payroll_item,$emp->employeeSalary($emp->employee_id,Carbon\Carbon::parse($emp->payroll_date)->toDateString())->amount,$payroll->amount,$payroll->ot,$payroll->ut);
               $totalDeduct = $totalDeduct + $pdeduct;
               echo $pdeduct;
            @endphp
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2" class="right"><b>Total: </b></td>
            <td class="right"><u><b>
            @php
                echo number_format($totalDeduct,2,'.',',');
            @endphp
            </b></u></td>
        </tr>
        <tr>
            <td colspan="3" style="border-top: solid"></td>
        </tr>
        <tr>
            <td rowspan="2"><b>Net Pay</b></td>
            <td class="right">15th</td>
            <td class="right">
            @php
                $net = $gross - $totalDeduct;
                echo number_format($net/2,2,'.',',');
            @endphp
            </td>
        </tr>
        <tr>
            <td class="right">30th</td>
            <td class="right">
            @php
                echo number_format($net/2,2,'.',',');
            @endphp</td>
        </tr>
        <tr>
            <td style="border-top: solid" colspan="3"></td>
        </tr>
        <tr>
            <td class="right" colspan="2" ><b>Total: </b></td>
            <td class="right"><b><u>{{ number_format($net,2,'.',',') }}</u></b></td>
        </tr>
    </table>
</div>