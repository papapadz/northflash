@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="row">
            <div class="col-10">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-2">
                                <div class="row mb-2">
                                    <img src="{{ asset('assets/images/faces/face').rand(1, 27).'.jpg' }}">
                                </div>
                                <div class="row">
                                    <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <button class="btn btn-rounded btn-success" data-toggle="modal" data-target="#exampleModalCenter"><i class="mdi mdi-library-books"></i></button>
                                            <button class="btn btn-rounded btn-primary" data-toggle="modal" data-target="#updateBasicModal"><i class="mdi mdi-border-color"></i></button>
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-10 list-wrapper">
                                <div class="row">
                                    <ul class="d-flex flex-column todo-list todo-list-custom col-md-6">
                                        <li>
                                            <div class="form-check form-check-flat">
                                                <label class="form-check-label"><small>Employee ID:</small><b> {{ $employee->employee_id }}</b> </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check form-check-flat">
                                                <label class="form-check-label"><small>Name:</small><b> {{ $employee->last_name }}, {{ $employee->first_name }} {{ $employee->middle_name }} </b></label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check form-check-flat">
                                                <label class="form-check-label"><small>Position:</small><b> {{ $employee->employment->title }} </b></label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check form-check-flat">
                                                <label class="form-check-label"><small>Date Hired:</small><b> {{ $employee->employment->date_hired }} </b></label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check form-check-flat">
                                                <label class="form-check-label"><small>Employment Status:</small><b> {{ $employee->employment->status }} </b></label>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="d-flex flex-column todo-list todo-list-custom col-md-6">
                                        @forelse($employee->licensenos as $license)
                                        <li><div class="form-check form-check-flat">
                                            @switch($license->id)
                                                @case(1)
                                                    <label class="form-check-label"><small>TIN No:</small> <b>{{ $license->license_no }}</b></label>
                                                    @break
                                                @case(2)
                                                    <label class="form-check-label"><small>SSS No:</small> <b>{{ $license->license_no }}</b></label>
                                                    @break
                                                @case(3)
                                                    <label class="form-check-label"><small>PhilHEALTH No:</small> <b>{{ $license->license_no }}</b></label>
                                                    @break
                                                @case(4)
                                                    <label class="form-check-label"><small>Pag-IBIG No:</small> <b>{{ $license->license_no }}</b></label>
                                                    @break
                                                @case(5)
                                                    <label class="form-check-label"><small>PRC No:</small> <b>{{ $license->license_no }}</b></label>
                                                    @break
                                                @default
                                                    
                                            @endswitch
                                        </div></li>
                                        @empty
                                        <i class="text-danger">No licenses added</i>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Payroll</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Projects</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Employment</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <hr>
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                @include('include.employee.payroll')
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                @include('include.employee.project')
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                @include('include.employee.employment')
                            </div>
                        </div>
                        
                    </div>
                </div>                    
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-statistics mb-2">
            <div class="card-body">
                <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
                    <div class="float-left">
                        <i class="mdi mdi-cube text-danger icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">
                        @if($employee->employment->monthly)
                            Monthly Salary
                        @else
                            Daily Rate
                        @endif
                        </p>
                        <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">{{ number_format($employee->employment->amount,2,'.',',') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Payroll Items</h4>
                <div class="list-wrapper">
                    <ul class="d-flex flex-column todo-list todo-list-custom">
                        @foreach($employee->payroll as $payroll)
                        <li>
                            <div class="form-check form-check-flat">
                                <label class="form-check-label">
                                <input class="checkbox" type="checkbox" checked> {{ $payroll->item }}: {{ number_format(findPayroll($payroll->id,$employee->employment->amount,$payroll->amount,$employee->employment->status),2,'.',',') }} </label>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<form method="POST" action="{{ url('admin/employee/license/add') }}">
    {{ csrf_field() }}
    <input type="text" value="{{ $employee->employee_id }}" name="employee_id" hidden>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">New ID</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-12">
                <select required name="license_type_id" style="width: 100%">
                @foreach($licensetypes as $lic)
                    <option value="{{ $lic->id }}">{{ $lic->type }}</option>
                @endforeach
                </select>
              </div>
            </div>
            <div class="row">
                <div class="form-group col-12">
                  <label>ID No.: </label>
                  <input required type="text" class="form-control" placeholder="ID No." name="license_no">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                  <label>Date issued: </label>
                  <input required type="date" class="form-control" name="date_issued">
                </div>
                <div class="form-group col-md-6">
                    <label>Expiry date: </label>
                    <input type="date" class="form-control" name="date_expired">
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

    <form method="POST" action="{{ url('admin/employee/basic/update') }}" onsubmit="return confirm('Are you sure you want to save these changes?')">
        {{ csrf_field() }}
        <input type="text" value="{{ $employee->employee_id }}" name="employee_id" hidden>
        <div class="modal fade" id="updateBasicModal" tabindex="-1" role="dialog" aria-labelledby="updateBasicModal" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Employee ID: {{ $employee->employee_id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Last Name: </label>
                          <input value="{{ $employee->last_name }}" required type="text" class="form-control" placeholder="Last Name" name="last_name">
                      </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                      <label>First Name: </label>
                        <input value="{{ $employee->first_name }}" required type="text" class="form-control" placeholder="First Name" name="first_name">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Middle Name: </label>
                      <input value="{{ $employee->middle_name }}" type="text" class="form-control" placeholder="Middle Name" name="middle_name">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Birthday: </label>
                      <input value="{{ Carbon\Carbon::parse($employee->birthdate)->toDateString() }}" required type="date" class="form-control" name="birthdate">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Gender: </label><br>
                      <input type="radio" name="gender" value="M" @if($employee->gender=='M') checked @endif>
                      <span class="mr-2">Male</span>
                      <input type="radio" name="gender" value="F" @if($employee->gender=='F') checked @endif>
                      <span>Female</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-12">
                      <label>Civil Status: </label><br>
                      <input type="radio" name="civil_stat" value="Single" @if($employee->civil_stat=='Single') checked @endif>
                      <span class="mr-2">Single</span>
                      <input type="radio" name="civil_stat" value="Married" @if($employee->civil_stat=='Married') checked @endif>
                      <span class="mr-2">Married</span>
                      <input type="radio" name="civil_stat" value="Separated" @if($employee->civil_stat=='Separated') checked @endif>
                      <span class="mr-2">Separated</span>
                      <input type="radio" name="civil_stat" value="Widowed" @if($employee->civil_stat=='Widowed') checked @endif>
                      <span>Widowed</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-12">
                      <label>Address: </label>
                        <textarea value="{{ $employee->address }}" required class="form-control" name="address">{{ $employee->address }}</textarea>
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

@push('custom-scripts')
<script>
$(document).ready(function() {
    $('table').DataTable();
    $('select').select2();


})
</script>
@endpush