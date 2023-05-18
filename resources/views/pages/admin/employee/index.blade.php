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
        {{-- <button class="btn btn-rounded btn-success" data-toggle="modal" data-target="#exampleModalCenter">Add Employee</button> --}}
        <a class="btn btn-rounded btn-success" href="http://nfpb.binarybee.org/" target="_blank">Add Employee</a>
        <hr>
        <div class="table-responsive">
          <table id="table" class="table table-striped">
            <thead>
              <tr>
                <th></th>
                <th> ID </th>
                <th> Name </th>
                <th> Position </th>
                <th> Docs </th>
                <th> Status </th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            @foreach($employees as $emp)
              <tr class="py-1">
                <td>
                  <img src="{{ $emp->avatar->url }}" alt="image" />
                </td>
                <td>{{ $emp->employee_id }}</td>
                <td>{{ $emp->last_name }}, {{ $emp->first_name }} {{ $emp->middle_name[0] ?? '' }}</td>
                <td>{{ $emp->employment->salary->position->title }}</td>
                {{-- <td>
                  @if($emp->employment->salary->monthly)
                    @php $ssalary = $emp->employment->salary->amount; @endphp
                  @else
                    @php $ssalary = $emp->employment->salary->amount; @endphp
                  @endif
                  {{ $ssalary }} @if($emp->employment->salary->monthly) <span>/month</span> @else <span>/day</span> @endif
                </td> --}}
                <td>
                    @forelse($emp->licenses as $license)
                    <div class="row mb-2">
                      <div class="col-md-6 m2">{{ $license->type->type }}</div>
                      <div class="col-md-6">{{ $license->license_no }}</div>
                    </div>
                    @empty
                    <i class="text-danger">No Record</i>
                    @endforelse
                </td>
                <td>{{ $emp->employment->status }}</td>
                <td>
                  <div class="btn-group dropdown">
                    <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Manage </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{ url('admin/employee/'.$emp->employee_id) }}">View</a>
                      <hr>
                      <a class="dropdown-item text-danger" onclick="buttonCRUD('employees','{{ $emp->employee_id }}',3)">Delete</a>
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
        <div class="row">
          <div class="form-group col-md-6">
            <label>Employee ID No.: </label>
            <input required type="text" class="form-control" placeholder="ID No." name="employee_id">
          </div>
          <div class="form-group col-md-6">
            <label>Last Name: </label>
            <input required type="text" class="form-control" placeholder="Last Name" name="last_name">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <label>First Name: </label>
            <input required type="text" class="form-control" placeholder="First Name" name="first_name">
          </div>
          <div class="form-group col-md-6">
            <label>Middle Name: </label>
            <input type="text" class="form-control" placeholder="Middle Name" name="middle_name">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <label>Birthday: </label>
            <input required type="date" class="form-control" name="birthdate">
          </div>
          <div class="form-group col-md-6">
            <label>Gender: </label><br>
            <input type="radio" name="gender" value="M" checked>
            <span class="mr-2">Male</span>
            <input type="radio" name="gender" value="F" >
            <span>Female</span>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-12">
            <label>Civil Status: </label><br>
            <input type="radio" name="civil_stat" value="Single" checked>
            <span class="mr-2">Single</span>
            <input type="radio" name="civil_stat" value="Married" >
            <span class="mr-2">Married</span>
            <input type="radio" name="civil_stat" value="Separated">
            <span class="mr-2">Separated</span>
            <input type="radio" name="civil_stat" value="Widowed" >
            <span>Widowed</span>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-12">
            <label>Address: </label>
            <textarea required class="form-control" name="address"></textarea>
          </div> 
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <label>Position: </label><br>
            <select required name="position" style="width: 100%">
              @foreach($positions as $pos)
                <option value="{{ $pos->id }}">{{ $pos->title }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>Salary (Php): </label><br>
            <input required type="number" min="0.00" step="0.01" class="form-control" name="salary" placeholder="x.xx">
          </div>
        </div>          
        <div class="row">
          <div class="form-group col-md-6">
            <label>Rate: </label><br>
            <input type="radio" name="monthly" value=1 checked>
            <span class="mr-2">Monthly</span>
            <input type="radio" name="monthly" value=0 >
            <span>Daily</span>
          </div>
          <div class="form-group col-md-6">
            <label>Date Hired: </label>
            <input required type="date" class="form-control" name="date_hired">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <label>Employment Status: </label><br>
            <select required name="status" style="width: 100%">
              <option value="Regular">Regular</option>
              <option value="Contractual">Contractual</option>
            </select>
          </div>
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