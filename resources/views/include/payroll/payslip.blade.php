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
            .row {
                width: 100%;
                margin-bottom: 10px;
            }
            .row:after {
                content: "";
                display: table;
                clear: both;
            }

            table {
                border-style: solid;
                width:100%;
                margin-left: 10px;
            }

            .right {
                text-align: right;
            }

            td.first {
                width: 35%;
            }

            td.mid {
                width: 40%;
            }

            .title {
                font-size: 12px;
            }

            .sub-title {
                font-size: 10px;
            }

            .bordered-top {
                border-top-style: solid;
            }

            .blank-line {
                border-top-style: solid;
                border-bottom-style: solid;
                height:10px
            }
        </style>
    </head>
    <body>
        @foreach($payrollGeneration->project->employees as $k => $employeePayroll)
            @if($k%2!=0)
                @if(($k+1)%4==0)
                    <div class="page-break">
                @else
                    <div class="row">
                @endif
                @include('include.payroll.payslip-details')
            </div>
            @else
                @include('include.payroll.payslip-details')
            @endif
        @endforeach
    </body>
</html>
