@extends('layout.master')

@push('plugin-styles')
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-rounded btn-success" data-toggle="modal" data-target="#exampleModalCenter">Add User Account</button>
        <hr>
        <div class="table-responsive">
          <table id="table" class="table table-striped">
            <thead>
              <tr>
                <th> Name </th>
                <th> Email </th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            @foreach($accounts as $acct)
              <tr class="py-1">
                <td>{{ $acct->name }}</td>
                <td>{{ $acct->email }}</td>
                <td>
                <button class="btn btn-sm btn-primary" onclick="buttonCRUD('users','{{ $acct->id }}',1)">View</button>
                <button class="btn btn-sm btn-danger" onclick="buttonCRUD('users','{{ $acct->id }}',3)">Delete</button>
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
<form method="POST" action="{{ route('user.add') }}">
{{ csrf_field() }}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New User Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password">
          </div>
          @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
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