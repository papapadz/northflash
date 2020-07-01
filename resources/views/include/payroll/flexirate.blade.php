@php
                              $amount = 0.00;
                              switch($deductions->id) {

                                case 1:
                                  $annualIncome = ($e->employment->amount * 12);
                                  if($annualIncome<=250000)
                                    $amount = 0.00;
                                  elseif($annualIncome<=400000)
                                    $amount = (($annualIncome-250000)*.20)/12;
                                  break;

                                case 2:
                                  if($e->employment->amount>=19750)
                                    $msc=20000;
                                  elseif($e->employment->amount>=19250)
                                    $msc=19500;
                                  elseif($e->employment->amount>=18750)
                                    $msc=19000;
                                  elseif($e->employment->amount>=18250)
                                    $msc=18500;
                                  elseif($e->employment->amount>=17750)
                                    $msc=18000;
                                  elseif($e->employment->amount>=17250)
                                    $msc=17500;
                                  elseif($e->employment->amount>=16750)
                                    $msc=17000;
                                  elseif($e->employment->amount>=16250)
                                    $msc=16500;
                                  elseif($e->employment->amount>=15750)
                                    $msc=16000;
                                  elseif($e->employment->amount>=15250)
                                    $msc=15500;
                                  elseif($e->employment->amount>=14750)
                                    $msc=15000;
                                  elseif($e->employment->amount>=14250)
                                    $msc=14500;
                                  elseif($e->employment->amount>=13750)
                                    $msc=14000;
                                  elseif($e->employment->amount>=13250)
                                    $msc=13500;
                                  elseif($e->employment->amount>=12750)
                                    $msc=13000;
                                  elseif($e->employment->amount>=12250)
                                    $msc=12500;
                                  elseif($e->employment->amount>=11750)
                                    $msc=12000;
                                  elseif($e->employment->amount>=11250)
                                    $msc=11500;
                                  elseif($e->employment->amount>=10750)
                                    $msc=11000;
                                  elseif($e->employment->amount>=10250)
                                    $msc=10500;
                                  elseif($e->employment->amount>=9750)
                                    $msc=10000;
                                  elseif($e->employment->amount>=9250)
                                    $msc=9500;
                                  elseif($e->employment->amount>=8750)
                                    $msc=9000;
                                  elseif($e->employment->amount>=8250)
                                    $msc=8500;
                                  elseif($e->employment->amount>=7750)
                                    $msc=8000;
                                  elseif($e->employment->amount>=7250)
                                    $msc=7500;
                                  elseif($e->employment->amount>=6750)
                                    $msc=7000;
                                  elseif($e->employment->amount>=6250)
                                    $msc=6500;
                                  elseif($e->employment->amount>=5750)
                                    $msc=6000;
                                  elseif($e->employment->amount>=5250)
                                    $msc=5500;
                                  elseif($e->employment->amount>=4750)
                                    $msc=5000;
                                  elseif($e->employment->amount>=4250)
                                    $msc=4500;
                                  elseif($e->employment->amount>=3750)
                                    $msc=4000;
                                  elseif($e->employment->amount>=3250)
                                    $msc=3500;
                                  elseif($e->employment->amount>=2750)
                                    $msc=3000;
                                  elseif($e->employment->amount>=2250)
                                    $msc=2500;
                                  elseif($e->employment->amount < 2250)
                                    $msc=2000;
                                  $amount = $msc*.04;
                                  break;
                              
                                  case 3:
                                    if($e->employment->amount<=10000)
                                      $amount = 150;
                                    elseif($e->employment->amount>=60000)
                                      $amount = 900;
                                    else
                                      $amount = ($e->employment->amount*.03)/2;
                                  break;

                                  case 4:
                                    if($e->employment->amount>1500)
                                      $amount = ($e->employment->amount*.02);
                                    else
                                      $amount = ($e->employment->amount*.01);
                              }
                              echo number_format($amount, 2, '.', ',');
                            @endphp