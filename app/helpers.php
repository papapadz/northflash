<?php

// For add'active' class for activated route nav-item
function active_class($path, $active = 'active') {
  return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

// For checking activated route
function is_active_route($path) {
  return call_user_func_array('Request::is', (array)$path) ? 'true' : 'false';
}

// For add 'show' class for activated route collapse
function show_class($path) {
  return call_user_func_array('Request::is', (array)$path) ? 'show' : '';
}

function computeTax($employee_salary) {
  $annualIncome = ($employee_salary * 12);
  if($annualIncome<=250000)
    return 0.00;
  elseif($annualIncome<=400000)
    return (($annualIncome-250000)*.20)/12;
}

function computeSSS($employee_salary) {
  $msc = 0;
  if($employee_salary>=19750)
    $msc=20000;
                                  elseif($employee_salary>=19250)
                                    $msc=19500;
                                  elseif($employee_salary>=18750)
                                    $msc=19000;
                                  elseif($employee_salary>=18250)
                                    $msc=18500;
                                  elseif($employee_salary>=17750)
                                    $msc=18000;
                                  elseif($employee_salary>=17250)
                                    $msc=17500;
                                  elseif($employee_salary>=16750)
                                    $msc=17000;
                                  elseif($employee_salary>=16250)
                                    $msc=16500;
                                  elseif($employee_salary>=15750)
                                    $msc=16000;
                                  elseif($employee_salary>=15250)
                                    $msc=15500;
                                  elseif($employee_salary>=14750)
                                    $msc=15000;
                                  elseif($employee_salary>=14250)
                                    $msc=14500;
                                  elseif($employee_salary>=13750)
                                    $msc=14000;
                                  elseif($employee_salary>=13250)
                                    $msc=13500;
                                  elseif($employee_salary>=12750)
                                    $msc=13000;
                                  elseif($employee_salary>=12250)
                                    $msc=12500;
                                  elseif($employee_salary>=11750)
                                    $msc=12000;
                                  elseif($employee_salary>=11250)
                                    $msc=11500;
                                  elseif($employee_salary>=10750)
                                    $msc=11000;
                                  elseif($employee_salary>=10250)
                                    $msc=10500;
                                  elseif($employee_salary>=9750)
                                    $msc=10000;
                                  elseif($employee_salary>=9250)
                                    $msc=9500;
                                  elseif($employee_salary>=8750)
                                    $msc=9000;
                                  elseif($employee_salary>=8250)
                                    $msc=8500;
                                  elseif($employee_salary>=7750)
                                    $msc=8000;
                                  elseif($employee_salary>=7250)
                                    $msc=7500;
                                  elseif($employee_salary>=6750)
                                    $msc=7000;
                                  elseif($employee_salary>=6250)
                                    $msc=6500;
                                  elseif($employee_salary>=5750)
                                    $msc=6000;
                                  elseif($employee_salary>=5250)
                                    $msc=5500;
                                  elseif($employee_salary>=4750)
                                    $msc=5000;
                                  elseif($employee_salary>=4250)
                                    $msc=4500;
                                  elseif($employee_salary>=3750)
                                    $msc=4000;
                                  elseif($employee_salary>=3250)
                                    $msc=3500;
                                  elseif($employee_salary>=2750)
                                    $msc=3000;
                                  elseif($employee_salary>=2250)
                                    $msc=2500;
                                  elseif($employee_salary < 2250)
                                    $msc=2000;
    return $msc*.04;
}

function computePhic($employee_salary) {
  if($employee_salary<=10000)
    return 150;
  elseif($employee_salary>=60000)
    return 900;
  else
    return ($employee_salary*.03)/2;
}

function computeOTPay($employee_salary) {
  $amount = ($employee_salary/26)/8;
  return $amount;
}

function findPayroll($deduction_id,$employee_salary,$deduction_amount,$emp_status) {
  $amount = 0.00;
  $new_employee_salary = $employee_salary;
  if(!$emp_status)
    $new_employee_salary = $employee_salary * 26;

                              switch($deduction_id) {

                                case 1:
                                  $amount = computeTax($new_employee_salary);
                                break;

                                case 2:
                                  $amount = computeSSS($new_employee_salary);
                                break;
                              
                                case 3:
                                  $amount = computePhic($new_employee_salary);
                                break;

                                case 5:
                                  $amount = computeOTPay($new_employee_salary);    
                                break;

                                case 6:
                                  $amount = computeOTPay($new_employee_salary)/60; 
                                break;

                                case 7:
                                  $amount = ($new_employee_salary/2);
                                break;

                                case 8:
                                  $amount = $employee_salary;
                                break;

                                default:
                                  $amount = $deduction_amount;  
                                break;
                              }
                              //$amount = number_format($amount, 2, '.', ',');
                              return $amount;
}