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

            td.mid {
                width: 40%;
            }
        </style>
    </head>
    <body>
        {{ dd($data) }}
        @foreach($data as $k => $emp)
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
