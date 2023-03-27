@extends('layout.master')

@push('plugin-styles')
<style>
  label {
    font-weight: bold;
  }
</style>
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-rounded btn-success" data-toggle="modal" data-target="#exampleModalCenter">Add Employee</button>
        <hr>
        <div class="table-responsive">
          <table id="table" class="table table-striped">
            <thead>
              <tr>
                <th></th>
                <th> Reference # </th>
                <th> Name </th>
                <th> Work Exp </th>
                <th> Education </th>
                <th> Family Info </th>
                <th> Docs </th>
              </tr>
            </thead>
            <tbody>
            @foreach($employees as $emp)
              <tr class="py-1">
                <td>
                  <img src="{{ $emp->img }}" alt="image" />
                </td>
                <td>{{ $emp->employee_id }}</td>
                <td>{{ $emp->last_name }}, {{ $emp->first_name }} {{ $emp->middle_name }}</td>
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