@extends('layout.master')

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
      <a class="btn btn-rounded btn-success" href="{{ url('admin/projects/add') }}" >Add New Project</a>
        <hr>
        <div class="table-responsive">
          <table id="table" class="table table-striped">
            <thead>
              <tr>
                <th> Project Name </th>
                <th> Location </th>
                <th> Type </th>
                <th> Date Start </th>
                <th> Contract With </th>
                <th> Contract Amount </th>
                <th> Status </th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            @foreach($projects as $proj)
              <tr class="py-1">
                <td>{{ $proj->project_name }}</td>
                <td>{{ $proj->location }}</td>
                <td>{{ $proj->project_type }}</td>
                <td>{{ Carbon\Carbon::parse($proj->start_date)->toFormattedDateString() }}</td>
                <td>{{ $proj->contract_by  }}</td>
                <td>{{ number_format($proj->amount,2,'.',',') }}</td>
                <td>
                  @if($proj->status)
                    <span class="text-success">Finished</span>
                  @else
                    <span class="text-danger">On-going</span>
                  @endif
                </td>
                <td>
                      <a class="btn btn-success" href="{{ url('admin/project/'.$proj->id) }}">View</a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
@endpush

@push('custom-scripts')
<script>
  $('#table').DataTable();
</script>
@endpush