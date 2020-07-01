<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            .page-break {
                page-break-after: always;
            }
            .column {
                float: left;
                width: 50%;
            }

            /* Clear floats after the columns */
            .row:after {
                content: "";
                display: table;
                clear: both;
            }
        </style>
    </head>
    <body>
        @foreach($data as $k => $emp)
            @if($k%2!=0)
            <div class="row">
                <div class="column">
                    <table>
                        <tr>
                            <td colspan="2" style="font-size: 11px"><center><b><u>North Flash Power and Builds, Inc.</u></b></center></td>
                        </tr>
                        <tr>
                            <td colspan="2"><center><b>Payslip for {{ Carbon\Carbon::parse($emp->payroll_date)->format('F Y') }}</b></center></td>
                        </tr>
                        <tr>
                            <td>Employee ID:</td>
                            <td>{{ $emp->employee_id }}</td>
                        </tr>
                        <tr>
                            <td>Name:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border: 1px"></td>
                        </tr>
                    </table>
                </div>
            </div>
            @else
            <div class="column">
                <table>
                    <tr>
                        <td colspan="2" style="font-size: 11px"><center><b><u>North Flash Power and Builds, Inc.</u></b></center></td>
                    </tr>
                    <tr>
                        <td colspan="2"><center><b>Payslip for {{ Carbon\Carbon::parse($emp->payroll_date)->format('F Y') }}</b></center></td>
                    </tr>
                    <tr>
                        <td>Employee ID:</td>
                        <td>{{ $emp->employee_id }}</td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: 1px"></td>
                    </tr>
                </table>
            </div>
            @endif
        @endforeach
    </body>
</html>
