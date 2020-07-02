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
                margin-bottom: 20px;
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
                text-align:right;
            }
        </style>
    </head>
    <body>
    @php $ctr = 1; @endphp
        @foreach($data as $k => $emp)
            @php
                $ctr = $k + 1;
            @endphp
           
            @if($k%2!=0)
                @if($ctr==4)
                    @php $ctr = 1; @endphp
                    <div class="row page-break">
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
