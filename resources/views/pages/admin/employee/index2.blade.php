@extends('layout.master')

@push('plugin-styles')
<style>
  label {
    font-weight: bold;
  }

  .not-synced {
    border-top: solid;
  }
</style>
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <a class="btn btn-rounded btn-success" href="{{ route('data.sync') }}">Sync Data</a>
        <hr>
        <div class="table-responsive">
          <table id="table" class="table table-striped">
            <thead>
              <tr>
                <th></th>
                <th></th>
                <th> Reference # </th>
                <th> Name </th>
                <th> Birthdate </th>
                <th> Email </th>
                <th> Address </th>
                <th> Work Exp </th>
                <th> Education </th>
                <th> Family Info </th>
                <th> Docs </th>
              </tr>
            </thead>
            <tbody>
            @foreach($employees as $emp)
              <tr class="py-1">
                @php
                $class = 'bg-success';
                $text = 'Synced';

                $eee = $existingEmployees->where('last_name',$emp->last_name)
                ->where('first_name',$emp->first_name)
                ->where('middle_name',$emp->middle_name)
                ->where('birthdate',$emp->birthdate)
                ->first();

                if(!$eee) {
                  $text = '!';
                  $class = 'bg-danger>';
                }
                @endphp
                <td>
                  @if($eee)
                  <span class="badge badge-success">Synced</span>
                  @else
                  <span class="badge badge-danger">!</span>
                  @endif
                </td>
                <td>
                  <img src="{{ $emp->avatar ? $emp->avatar->url : null }}" alt="image" />
                </td>
                <td>{{ $emp->employee_id }}</td>
                <td>{{ $emp->last_name }}, {{ $emp->first_name }} {{ $emp->middle_name }}</td>
                <td>{{ Carbon\Carbon::parse($emp->birthdate)->toFormattedDateString() }}</td>
                <td>{{ $emp->email }}</td>
                <td>{{ $emp->address }}</td>
                <td>
                    <ul>
                    @foreach($emp->employment as $employment)
                    <li>{{ $employment->salary->position->title }} @ {{ $employment->company }}</li>
                    @endforeach
                    </ul>
                </td>
                <td>
                    <ul>
                    @foreach($emp->education as $education)
                    <li>{{ $education->level }}</li>
                    @endforeach
                    </ul>
                </td>
                <td>
                    <ul>
                    @foreach($emp->family as $family)
                    <li>{{ $family->relationship }} - {{ $family->name }}</li>
                    @endforeach
                    </ul>
                </td>
                <td>
                    <ul>
                    @foreach($emp->licenses as $license)
                    <li>{{ $license->type->type }} - {{ $license->license_no }}</li>
                    @endforeach
                    </ul>
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
  $('select').select2();
</script>
@endpush