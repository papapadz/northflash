@extends('layout.master')

@push('plugin-styles')
@endpush

@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-rounded btn-success" data-toggle="modal" data-target="#exampleModalCenter">New</button>
        <hr>
        <div class="table-responsive">
          <table id="table" class="table table-striped">
            <thead>
              <tr>
                <th> Item Name </th>
                <th> Amount/Percentage </th>
                <th> Type </th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            @foreach($payrollItems as $item)
              <tr class="py-1">
                <td>{{ $item->item }}</td>
                <td>
                    @if($item->flexirate)
                       <i>*Flexible Rate</i>
                    @else
                      {{ $item->amount }}
                    @endif
                </td>
                <td>
                    @if($item->type==1)
                        <span class="text-success">Addition (+)</span>
                    @else
                        <span class="text-danger">Deduction (-)</span>
                    @endif
                </td>
                <td>
                  @if(!$item->flexirate)
                  <div class="btn-group dropdown">
                    <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Manage </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item"
                        data-toggle="modal" 
                        data-target="#updateModal" 
                        data-item_id="{{ $item->id }}"
                        data-item="{{ $item->item }}"
                        data-amount="{{ $item->amount }}"
                        data-type="{{ $item->type }}"
                      >Edit</a>
                      @if($item->id > 8)
                      <hr>
                      <a class="dropdown-item text-danger" onclick="buttonCRUD('payroll_items','{{ $item->id }}',3)">Delete</a>
                      @endif
                    </div>
                  </div>
                  @endif
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
<form method="POST" action="{{ url('admin/variables/payroll-item/add') }}">
{{ csrf_field() }}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label>Item Name: </label>
            <input required type="text" class="form-control" placeholder="ex. SSS" name="item">
          </div>
          <div class="form-group">
            <label>Amount (Php): </label>
            <input type="number" step="0.01" class="form-control" value="0.00" name="amount">
          </div>
          <!-- <div class="form-group">
            <label>Percentage (%): </label>
            <input type="number" step="0.01" class="form-control" value="0.00" name="percentage">
          </div> -->
          <div class="form-group">
            <label>Type: </label><br>
            <input type="radio" name="type" value="1" checked>
            <label class="mr-2 text-success">Addition (+)</label>
            <input type="radio" name="type" value="2" >
            <label class="text-danger">Deduction (-)</label>
          </div>
          <!-- <div class="form-group">
            <label>Date Effective: </label>
            <input type="date" value="{{ Carbon\Carbon::now()->firstOfYear()->toDateString() }}" class="form-control" name="date_effective" ></input>
          </div> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</form>

<form method="POST" action="{{ url('admin/variables/payroll-item/update') }}" onSubmit="return confirm('Are you sure you want to update this record?')">
{{ csrf_field() }}
<input type="text" id="item_id" name="item_id" hidden>
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModaltitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label>Item Name: </label>
            <input required type="text" class="form-control" placeholder="ex. SSS" id="item" name="item">
          </div>
          <div class="form-group">
            <label>Amount (Php): </label>
            <input type="number" step="0.01" class="form-control" value="0.00" id="amount" name="amount">
          </div>
          <!-- <div class="form-group">
            <label>Percentage (%): </label>
            <input type="number" step="0.01" class="form-control" value="0.00" name="percentage">
          </div> -->
          <div class="form-group">
            <label>Type: </label><br>
            <input type="radio" id="updatetype1" name="type" value="1" >
            <label class="mr-2 text-success">Addition (+)</label>
            <input type="radio" id="updatetype2" name="type" value="2" >
            <label class="text-danger">Deduction (-)</label>
          </div>
          <!-- <div class="form-group">
            <label>Date Effective: </label>
            <input type="date" value="{{ Carbon\Carbon::now()->firstOfYear()->toDateString() }}" class="form-control" name="date_effective" ></input>
          </div> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
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
  $(document).ready(function(){
    $('#table').DataTable();

    $('#updateModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var item_id = button.data('item_id')
      var item = button.data('item')
      var amount = button.data('amount')
      var type = button.data('type')

      var modal = $(this)
      modal.find('.modal-title').text(item)
      $('#item_id').val(item_id)
      $('#item').val(item)
      $('#amount').val(amount)
      if(type==1)
        $('#updatetype1').prop('checked',true)
      else
        $('#updatetype2').prop('checked',true)
    })
  });
</script>
@endpush