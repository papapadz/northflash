<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th> Date </th>
            <th> Position </th>
            <th> Salary/Wage </th>
            <th> Status </th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach($employee->employments as $empl)
            <tr>
                <td> 
                    {{ Carbon\Carbon::parse($empl->date_hired)->toFormattedDateString() }}
                    @if($empl->date_expired!=null)
                        to {{ Carbon\Carbon::parse($empl->date_expired)->toFormattedDateString() }}
                    @else
                        to present
                    @endif
                </td>
                <td> {{ $empl->title }} </td>
                <td> {{ number_format($empl->amount,2,'.',',') }} </td>
                <td> {{ $empl->status }} </td>
                <td> 
                    <div class="btn-group dropdown">
                        <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Manage </button>
                        <div class="dropdown-menu">
                          <a 
                            class="dropdown-item" 
                            data-toggle="modal" 
                            data-target="#updateEmploymentModal"
                            data-id = "{{ $empl->employment_id }}"
                            data-position_id = "{{ $employee->getEmploymentDetails($empl->employment_id)->position_id }} "
                            data-position = "{{ $employee->getEmploymentDetails($empl->employment_id)->title }} "
                            data-salary_id = "{{ $employee->getEmploymentDetails($empl->employment_id)->salary_id }} "
                            data-salary = "{{ $employee->getEmploymentDetails($empl->employment_id)->amount }} "
                            data-status = "{{ $employee->getEmploymentDetails($empl->employment_id)->status }} "
                            data-date_hired = "{{ $employee->getEmploymentDetails($empl->employment_id)->date_hired }} "
                            data-date_expired = "{{ $employee->getEmploymentDetails($empl->employment_id)->date_expired }} "
                            data-monthly = "{{ $employee->getEmploymentDetails($empl->employment_id)->monthly }} "
                          >Update</a>
                          <hr>
                          <a class="dropdown-item text-danger" onclick="buttonCRUD('employment','{{ $empl->employment_id }}',3)">End Contract</a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<form method="POST" action="{{ url('admin/employee/employment/update') }}" onsubmit="return confirm('Are you sure you want to save these changes?')">
    {{ csrf_field() }}
    <input type="text" id="employment_id" name="employment_id" hidden>
    <div class="modal fade" id="updateEmploymentModal" tabindex="-1" role="dialog" aria-labelledby="updateEmploymentModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Employee ID: {{ $employee->employee_id }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-6">
                  <label>Position: </label><br>
                  <select required name="position" style="width: 100%">
                    @foreach($positions as $pos)
                      <option class="checkitem3" value="{{ $pos->id }}">{{ $pos->title }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>Salary (Php): </label><br>
                  <input required type="number" min="0.00" step="0.01" class="form-control" name="salary" id="salary" placeholder="x.xx">
                </div>
              </div>          
              <div class="row">
                <div class="form-group col-md-6">
                  <label>Rate: </label><br>
                  <input id="monthly1" type="radio" name="monthly" value=1 checked>
                  <span class="mr-2">Monthly</span>
                  <input id="monthly2" type="radio" name="monthly" value=0 >
                  <span>Daily</span>
                </div>
                <div class="form-group col-md-6">
                  <label>Employment Status: </label><br>
                  <select required name="status" style="width: 100%">
                    <option class="checkitem4" value="Regular">Regular</option>
                    <option class="checkitem4" value="Contractual">Contractual</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                    <label>Date Hired: </label>
                    <input id="date_hired" required type="date" class="form-control" name="date_hired">
                </div>
                <div style="display: none" class="form-group col-md-6" id="divdateexpired">
                    <label>Date Expired: </label>
                    <input id="date_expired" required type="date" class="form-control" name="date_expired">
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

@push('custom-scripts')
<script>
$(document).ready(function() {

    $('#updateEmploymentModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var employment_id = button.data('employment_id')
        var position_id = button.data('position_id')
        var status = button.data('status')
        var salary = button.data('salary')
        var monthly = button.data('monthly')
        var date_hired = button.data('date_hired')
        var date_expired = button.data('date_expired')
        
        if(date_expired!=null) {
            $('#date_expired').show()
            $('#date_expired').val(date_expired);
        }
        
        $('#date_hired').val(date_hired)
        $('#salary').val(salary)
        

        $('.checkitem3').each(function() {
            
            if(position_id==parseInt($(this).val()))
                $(this).attr('selected',true)
        })

        $('.checkitem4').each(function() {
            console.log(status==$(this).val())
            if(status==$(this).val())
                $(this).prop('selected',true)
        })
    })
})
</script>
@endpush