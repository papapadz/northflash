@extends('layout.master')

@push('plugin-styles')
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
                <th> ID </th>
                <th> Name </th>
                <th> Position </th>
                <th> Salary </th>
                <th> Status </th>
              </tr>
            </thead>
            <tbody>
            @foreach($employees as $emp)
              <tr class="py-1">
                <td>
                  <img src="{{ url('assets/images/faces-clipart/pic-1.png') }}" alt="image" />
                </td>
                <td>{{ $emp->last_name }}, {{ $emp->first_name }} {{ $emp->middle_name[0] }}</td>
                <td>{{ $emp->position }}</td>
                <td>{{ $emp->salary }}</td>
                <td>{{ $emp->status }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label>Last Name: </label>
            <input type="text" class="form-control" placeholder="Last Name">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
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