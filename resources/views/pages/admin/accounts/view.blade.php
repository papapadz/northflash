@extends('layout.master')

@push('plugin-styles')
<style>
  label {
    font-weight: bold;
  }
</style>
@endpush

@section('content')
<form method="POST" action="{{ route('user.update') }}" onsubmit="return confirm('Are you sure you want to save this changes?');">
{{ csrf_field() }}
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-header">
          <h3 class="float-left">Account Details</h3>
      </div>
      <div class="card-body">
            <div class="row mb-2">
                <input value="{{ $account->id }}" name="id" type="text" hidden>
                <div class="col-md-6">
                    <label>Name</label>
                    <input value="{{ $account->name }}" name="name" type="text" class="form-control fillables" required>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Email</label>
                    <input value="{{ $account->email }}" name="email" type="email" class="form-control fillables" placeholder="ex. Civil, Electrical, etc." required>
                </div>
                <div class="col-md-6">
                    <label>Password</label>
                    <input name="password" type="password" class="form-control fillables" required>
                </div>
            </div>
      </div>
      <div class="card-footer">
        <button style="display: none" id="btnsave" class="btn btn-rounded btn-success" type="submit">Save</button>
        <button id="btnedit" class="btn btn-rounded btn-primary" onclick="edit()" type="button">Edit</button>
        <a href="{{ route('user.index') }}" class="btn btn-rounded btn-warning">Back</a>
      </div>
    </div>
  </div>
</div>
</form>  
@endsection

@push('custom-scripts')
<script>
$(document).ready(function(){
    $('.fillables').prop('disabled',true);
});

function edit() {
    $('.fillables').prop('disabled',false);
    $('#btnedit').hide();
    $('#btnsave').show();
  }
</script>
@endpush