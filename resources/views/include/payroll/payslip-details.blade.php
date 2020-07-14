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
            <td colspan="2"> {{ title_case($emp->employeeInfo->last_name) }}, {{ title_case($emp->employeeInfo->first_name) }} {{ $emp->employeeInfo->middle_name[0] ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="3" style="border-top: solid"><i>Additions</i></td>
        </tr>
        @php $totalAdd = $totalDeduct = 0; @endphp
        @foreach($emp->getPayslipDetails($emp->payroll_date,$emp->employee_id)->where('type',1)->orderBy('payroll_item','desc')->get() as $payroll)
        <tr>
            <td class="first">{{ $payroll->item }}:</td>
            <td class="right mid">
            @php
                if($payroll->payroll_item==8)
                    $salary = $payroll->amount;
                $pamount = $payroll->amount;
                
                echo number_format($pamount,2,'.',',');
                $totalAdd = $totalAdd + $pamount;
            @endphp
            </td>
            <td></td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2" style="text-align:right"><b>Total: </b></td>
            <td  style="text-align:right"><u><b>
            @php
                echo number_format($totalAdd,2,'.',',');
            @endphp
            </b></u></td>
        </tr>
        <tr>
            <td colspan="3" style="border-top: solid"><i>Deductions</i></td>
        </tr>
        @php $deductcount = 0; @endphp
        @foreach($emp->getPayslipDetails($emp->payroll_date,$emp->employee_id)->where('type',2)->get() as $k => $payroll)
        <tr>
            <td>{{ $payroll->item }}:</td>
            <td class="right mid">
            @php
                $deductcount++;
                $pdeduct = $payroll->amount;
                $totalDeduct = $totalDeduct + $pdeduct;

                echo number_format($pdeduct,2,'.',',');
            @endphp
            </td>
            <td></td>
        </tr>
        @endforeach
        @while($deductcount<5)
            {{ $deductcount++ }}
            <tr><td colspan="3"><br></td></tr>
        @endwhile
        <tr>
            <td colspan="2" style="text-align:right"><b>Total: </b></td>
            <td  style="text-align:right"><u><b>
            @php
                $net = $totalAdd - $totalDeduct;
                echo number_format($totalDeduct,2,'.',',');
            @endphp
            </b></u></td>
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