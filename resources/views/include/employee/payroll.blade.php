<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th> Date </th>
            <th> Payroll </th>
            <th> Unit Amount </th>
            <th> Qty </th>
            <th> Total </th>
        </tr>
        </thead>
        <tbody>
            @foreach($employee->generations as $generation)
            <tr>
                <td>
                    {{ Carbon\Carbon::parse($generation->payroll_date)->format('M ') }}
                    @if(Carbon\Carbon::parse($generation->payroll_date)->day == 1)
                      {{ Carbon\Carbon::parse($generation->payroll_date)->day }} - 15,
                    @else
                      16 - {{ Carbon\Carbon::parse($generation->payroll_date)->endOfMonth()->day }},
                    @endif
                    {{ Carbon\Carbon::parse($generation->payroll_date)->year }}
                </td>
                <td> {{ $generation->item }} </td>
                <td class="text-right"> 
                    <span @if($generation->type==1) class="text-success" @else class="text-danger" @endif>
                        {{ number_format(findPayroll($generation->payroll_item,$employee->employment->amount,$generation->unit_amount,$employee->employment->status),2,'.',',') }}
                    </span>
                </td>
                <td class="text-right"> {{ $generation->num_days }} </td>
                <td class="text-right"> 
                    <span @if($generation->type==1) class="text-success" @else class="text-danger" @endif>
                        {{ number_format($generation->total_amount,2,'.',',') }} 
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>