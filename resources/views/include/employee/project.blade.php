<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th> Project Name </th>
            <th> Location </th>
            <th> Type </th>
            <th> Contract by </th>
            <th> Date </th>
            <th> Status </th>
        </tr>
        </thead>
        <tbody>
            @foreach($employee->projects as $project)
            <tr>
                <td> {{ $project->project_name }} </td>
                <td> {{ $project->location }} </td>
                <td> {{ $project->type }} </td>
                <td> {{ $project->contract_by }} </td>
                <td> 
                    {{ Carbon\Carbon::parse($project->start_date)->toFormattedDateString() }}
                    @if($project->end_date!=null)
                        to {{ Carbon\Carbon::parse($project->end_date)->toFormattedDateString() }}
                    @endif
                </td>
                <td>
                    @if($project->status)
                        <span class="text-success">Completed</span>
                    @else
                        <span class="text-danger">On-going</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>