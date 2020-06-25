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
                <th></th>
              </tr>
            </thead>
            <tbody>
            @foreach($employees as $emp)
              <tr class="py-1">
                <td>
                  <img src="{{ url('assets/images/faces-clipart/pic-1.png') }}" alt="image" />
                </td>
                <td>{{ $emp->employee_id }}</td>
                <td>{{ $emp->last_name }}, {{ $emp->first_name }} {{ $emp->middle_name[0] }}</td>
                <td>{{ $emp->title }}</td>
                <td>{{ $emp->amount }}</td>
                <td>{{ $emp->status }}</td>
                <td>
                  <div class="btn-group dropdown">
                    <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Manage </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">View</a>
                      <a class="dropdown-item" href="#">Update</a>
                      <a class="dropdown-item" href="#">Delete</a>
                    </div>
                  </div>
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

<!-- Modal -->
<form method="POST" action="{{ url('admin/employee/add') }}">
{{ csrf_field() }}
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
          <div class="form-group">
            <label>Employee ID No.: </label>
            <input required type="text" class="form-control" placeholder="ID No." name="employee_id">
          </div>
          <div class="form-group">
            <label>Last Name: </label>
            <input required type="text" class="form-control" placeholder="Last Name" name="last_name">
          </div>
          <div class="form-group">
            <label>First Name: </label>
            <input required type="text" class="form-control" placeholder="First Name" name="first_name">
          </div>
          <div class="form-group">
            <label>Middle Name: </label>
            <input type="text" class="form-control" placeholder="Middle Name" name="middle_name">
          </div>
          <div class="form-group">
            <label>Birthday: </label>
            <input required type="date" class="form-control" name="birthdate">
          </div>
          <div class="form-group">
            <label>Gender: </label><br>
            <input type="radio" name="gender" value="M" checked>
            <label class="mr-2">Male</label>
            <input type="radio" name="gender" value="F" >
            <label>Female</label>
          </div>
          <div class="form-group">
            <label>Civil Status: </label><br>
            <input type="radio" name="civil_stat" value="Single" checked>
            <label class="mr-2">Single</label>
            <input type="radio" name="civil_stat" value="Married" >
            <label class="mr-2">Married</label>
            <input type="radio" name="civil_stat" value="Separated">
            <label class="mr-2">Separated</label>
            <input type="radio" name="civil_stat" value="Widowed" >
            <label>Widowed</label>
          </div>
          <div class="form-group">
            <label>Address: </label>
            <textarea required class="form-control" name="address"></textarea>
          </div>
          <div class="form-group">
            <label>Position: </label><br>
            <select required name="position" style="width: 100%">
              @foreach($positions as $pos)
                <option value="{{ $pos->id }}">{{ $pos->title }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Salary (Php): </label><br>
            <input required type="number" min="0.00" step="0.01" class="form-control" name="salary" placeholder="x.xx">
          </div>
          <div class="form-group">
            <label>Date Hired: </label>
            <input required type="date" class="form-control" name="date_hired">
          </div>
          <div class="form-group">
            <label>Employment Status: </label><br>
            <select required name="status" style="width: 100%">
              <option value="Regular">Regular</option>
              <option value="Contractual">Contractual</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</form>
@endsection

@push('plugin-scripts')
@endpush

@push('custom-scripts')
<script>
  $('#table').DataTable();
  $('select').select2();
</script>
@endpush