@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="card mb-2">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-3">
                        <img style="height:100%" src="{{ asset('assets/images/faces/face').rand(1, 27).'.jpg' }}">
                    </div>
                    <div class="col-md-9 list-wrapper">
                        <ul class="d-flex flex-column todo-list todo-list-custom">
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
                        @if($employee->employment->status == 'Regular')
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
@endsection