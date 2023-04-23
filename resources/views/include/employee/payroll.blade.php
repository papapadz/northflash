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
            @foreach($employee->payrollGenerations as $generation)
                @if($generation->total>0)
                <tr>
                    <td>{{ Carbon\Carbon::parse($generation->payrollMaster->date_start)->toDateString() }} to {{ Carbon\Carbon::parse($generation->payrollMaster->date_end)->toDateString() }}</td>
                    @if($generation->payrollItem->type==1)
                        <td class="text-success">{{ $generation->payrollItem->item }}</td>
                        <td align="right">{{ number_format($generation->amount,2,'.',',') }}</td>
                        <td align="center">{{ $generation->qty }}</td>
                        <td align="right">{{ number_format($generation->total,2,'.',',') }}</td>
                    @else
                        <td class="text-danger">{{ $generation->payrollItem->item }}</td>
                        <td align="right">({{ number_format($generation->amount,2,'.',',') }})</td>
                        <td align="center">{{ $generation->qty }}</td>
                        <td align="right">({{ number_format($generation->total,2,'.',',') }})</td>
                    @endif
                @endif
            @endforeach
        </tbody>
    </table>
</div>