@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="card mb-2">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-2">
                        <div class="row mb-2">
                            <img src="{{ asset('assets/images/faces/face').rand(1, 27).'.jpg' }}">
                        </div>
                        <div class="row">
                            <div class="col-12">
                            <button class="btn btn-rounded btn-success" data-toggle="modal" data-target="#exampleModalCenter">Add ID</button>
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
                <div class="row">
                    <div class="col-md-6">
                        
                    </div>
                    <div class="col-md-6">
                    <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th> Project </th>
                                        <th> Progress </th>
                                        <th> Amount </th>
                                        <th> Sales </th>
                                        <th> Deadline </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <td class="font-weight-medium"> 5 </td>
                                        <td> Edward </td>
                                        <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger progress-bar-striped" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        </td>
                                        <td> $ 160.25 </td>
                                        <td class="text-success"> 18.32% <i class="mdi mdi-arrow-up"></i>
                                        </td>
                                        <td> May 03, 2015 </td>
                                    </tr>
                                    </tbody>
                                </table>
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
                                <input class="checkbox" type="checkbox" checked> {{ $payroll->item }}: {{ findPayroll($payroll->id,$employee->employment->amount,$payroll->amount) }} </label>
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
@endsection