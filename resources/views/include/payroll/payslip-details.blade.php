<div class="column">
    <table>
        <tr>
            <td colspan="3" style="font-size: 16px"><center><b><u>NORTHFLASH POWER AND BUILDS, INC.</u></b></center></td>
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
            <td colspan="2"> {{ title_case($emp->employeeInfo->last_name) }}, {{ title_case($emp->employeeInfo->first_name) }} {{ title_case($emp->employeeInfo->middle_name[0]) ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="3" style="border-top: solid"><i>Additions</i></td>
        </tr>
        <tr>
            <td>Salary:</td>
            <td class="right mid">
            @php
                $totalAdd = $totalDeduct = 0;
                $salary = number_format($emp->employeeSalary($emp->employee_id)->amount,2,'.',',');
                echo $salary;
            @endphp
            </td>
            <td></td>
        </tr>
        @foreach($emp->employeePayroll($emp->payroll_date,$emp->employee_id,1) as $payroll)
        <tr>
            <td>{{ $payroll->item }}:</td>
            <td class="right mid">
            @php
                $pamount = 0;
                if($payroll->payroll_item == 5)
                    $pamount = findPayroll($payroll->payroll_item,floatval($salary),$payroll->amount) * $emp->ot;
                else
                    $pamount = $payroll->amount;

                $totalAdd = $totalAdd + $pamount;
                echo number_format($pamount,2,'.',',');
            @endphp
            </td>
            <td></td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2" style="text-align:right"><b>Total: </b></td>
            <td  style="text-align:right"><u><b>
            @php
                $gross = $emp->employeeSalary($emp->employee_id)->amount + $totalAdd;
                echo number_format($gross,2,'.',',');
            @endphp
            </b></u></td>
        </tr>
        <tr>
            <td colspan="3" style="border-top: solid"><i>Deductions</i></td>
        </tr>
        @foreach($emp->employeePayroll($emp->payroll_date,$emp->employee_id,2) as $payroll)
        {{ dd($emp->employeePayroll($emp->payroll_date,$emp->employee_id,2)) }}
        <tr>
            <td>{{ $payroll->item }}:</td>
            <td class="right mid">
            @php
               $pdeduct = findPayroll($payroll->payroll_item,floatval($salary),$payroll->amount);

                if($payroll->payroll_item == 6)
                    $pdeduct = $pdeduct * $emp->ut;

                $totalDeduct = $totalDeduct + $pdeduct;

                echo number_format($pdeduct,2,'.',',');
            @endphp
            </td>
            <td></td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2" style="text-align:right"><b>Total: </b></td>
            <td  style="text-align:right"><u><b>
            @php
                $net = $gross - $totalDeduct;
                echo number_format($totalDeduct,2,'.',',');
            @endphp
            </b></u></td>
        </tr>
        <tr><td style="border-top: solid" colspan="3"></td></tr>
        <tr>
            <td rowspan="2" class="right"><b>Total: </b></td>
            <td class="right">15th</td>
            <td class="right">
                @php echo number_format($net/2,2,'.',','); @endphp
            </td>
        </tr>
        <tr>
            <td class="right">30th</td>
            <td class="right">
                @php echo number_format($net/2,2,'.',',') @endphp
            </td>
        </tr>
        <tr><td style="border-top: solid" colspan="3"></td></tr>
        <tr>
            <td colspan="2" class="right">Net Pay</td>
            <td class="right">
                <u><b>@php echo number_format($net,2,'.',',') @endphp </b></u>
            </td>
        </tr>
    </table>
</div>