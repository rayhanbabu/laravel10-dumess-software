<?php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Mail;
    use App\Helpers\MaintainJWTToken;
    use App\Helpers\ManagerJWTToken;
    use Illuminate\Support\Facades\Cookie;
    use App\Models\Invoice;
    use App\Models\Hallinfo;

       function prx($arr){
           echo "<pre>";
           print_r($arr);
           die();
       }

       function rayhan(){
          return 'Md Rayhan Babu';
       }

       function admin_name($admin_id){
           $admin=DB::table('admins')->where('id',$admin_id)->first();
           return $admin->name;
        }


        function baseimage($path){
            //$path = 'image/slide1.jpg';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
           return  $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
       }

       function SendEmail($email,$subject,$body,$otp,$name){
           $details = [
             'subject' => $subject,
             'otp_code' =>$otp,
             'body' => $body,
             'name' => $name,
           ];
          Mail::to($email)->send(new \App\Mail\LoginMail($details));
       }


        function maintainaccess(){
            $token_maintain=Cookie::get('token_maintain');
            $result=MaintainJWTToken::ReadToken($token_maintain);
            if($result=="unauthorized"){
                  return redirect('/maintain/login');
            }
            else if($result->role=="supperadmin"){
                 return true;
            }else{
                 return false;
            }
        }

        function manager_info(){
            $manager_info=Cookie::get('manager_info');
            $result=unserialize($manager_info);
            return $result;
        }


        
        function adminaccess(){
            $token_manager=Cookie::get('token_manager');
            $result=ManagerJWTToken::ReadToken($token_manager);
            if($result=="unauthorized"){
                return redirect('/maintain/login');
            }
            else if($result->role=="admin"){
                return true;
            }else{
                return false;
            }
        }


        function adminauditoraccess(){
            $token_manager=Cookie::get('token_manager');
            $result=ManagerJWTToken::ReadToken($token_manager);
            if($result=="unauthorized"){
                return redirect('/maintain/login');
            } else if($result->role=="admin" OR $result->role2=="auditor"){
                return true;
            }else{
                return false;
            }
        }



         function manager_access_info(){
              $token_manager=Cookie::get('token_manager');
              $result=ManagerJWTToken::ReadToken($token_manager);
              $hall=DB::table('halls')->where('id',$result->id)->where('hall_id',$result->hall_id)->first();
              return $hall;
          }


          function admin_access_info(){
               $token_manager=Cookie::get('token_manager');
               $result=ManagerJWTToken::ReadToken($token_manager);
               $hall=DB::table('halls')->where('hall_id',$result->hall_id)->where('role','admin')->first();
               return $hall;
           }

           function manager_access_payment(){
                $token_manager=Cookie::get('token_manager');
                $result=ManagerJWTToken::ReadToken($token_manager);
                $cur_date = date('Y-m-d');

                $value=DB::table('hallinfos')->where('hall_id_info',$result->hall_id)->where('refresh_date',$cur_date)
                        ->where('refresh_no','>=',2)->first();
                if($value){
                    return true;
                }else{
                    return false;
                }        
                
            }



         function application_access(){               
                if(admin_access_info()->application=="Yes"){
                       if(manager_access_info()->application=="Yes"){
                            return true;
                       }else{
                           return false;
                       }
                }else{
                       return false;
                }       
          }


        function bazar_access(){               
             if(admin_access_info()->bazar=="Yes"){
                   if(manager_access_info()->bazar=="Yes"){
                         return true;
                   }else{
                         return false;
                   }
              }else{
                   return false;
              }       
         }


     function member_access(){               
           if(admin_access_info()->member=="Yes"){
                  if(manager_access_info()->member=="Yes"){
                         return true;
                  }else{
                         return false;
                   }
            }else{
                     return false;
            }       
        }

        function member_edit_access(){               
            if(admin_access_info()->member_edit=="Yes"){
                   if(manager_access_info()->member_edit=="Yes"){
                          return true;
                   }else{
                          return false;
                    }
             }else{
                      return false;
             }       
         }


        function resign_access(){               
            if(admin_access_info()->member=="Yes"){
                   if(manager_access_info()->member=="Yes"){
                          return true;
                    }else{
                          return false;
                     }
              }else{
                       return false;
               }       
          }


          function meal_access(){               
            if(admin_access_info()->meal=="Yes"){
                   if(manager_access_info()->meal=="Yes"){
                          return true;
                    }else{
                          return false;
                     }
               }else{
                       return false;
                }       
           }


        function booking_access(){               
            if(admin_access_info()->booking=="Yes"){
                   if(manager_access_info()->booking=="Yes"){
                          return true;
                    }else{
                          return false;
                     }
               }else{
                       return false;
                }       
           }



           function payment_access() {               
                  if(admin_access_info()->payment=="Yes"){
                       if(manager_access_info()->payment=="Yes"){
                          if(manager_access_payment()){
                              return true;
                           }else{
                               return false;
                           }
                         }else{
                          return false;
                       }
                  }else{
                       return false;
                  }       
             }



             function getDaysBetween2Dates(DateTime $date1, DateTime $date2, $absolute = true)
             {
               $interval = $date2->diff($date1);
               return (!$absolute and $interval->invert) ? - $interval->days : $interval->days;
             }
         




   function member_meal_update($data){
    
            $lunch_off=0;
            $dinner_off=0;
            $breakfast_off=0;
            $lunch_on=0;
            $dinner_on=0;
            $breakfast_on=0;

         for($y = 1; $y <= $data->section_day; $y++) {
              $l_off=Invoice::where('id',$data->id)->where('l'.$y,0)->count(); 
              $lunch_off+=$l_off;

              $l_on=Invoice::where('id',$data->id)->where('l'.$y,1)->count(); 
              $lunch_on+=$l_on;
          }

         for($y = 1; $y <= $data->section_day; $y++) {
              $d=Invoice::where('id',$data->id)->where('d'.$y,0)->count(); 
              $dinner_off+=$d;

              $d_on=Invoice::where('id',$data->id)->where('d'.$y,1)->count(); 
              $dinner_on+=$d_on;
          }

          for($y = 1; $y <= $data->section_day; $y++) {
               $b=Invoice::where('id',$data->id)->where('b'.$y,0)->count(); 
               $breakfast_off+=$b;

               $b_on=Invoice::where('id',$data->id)->where('b'.$y,1)->count(); 
               $breakfast_on+=$b_on;
           }


           $invoiceupdate = Invoice::find($data->id);
           $invoiceupdate->lunch_offmeal = $lunch_off;
           $invoiceupdate->lunch_onmeal = $lunch_on;
           $invoiceupdate->lunch_inmeal = $data->section_day-($lunch_off+$lunch_on);
           $invoiceupdate->dinner_offmeal = $dinner_off;
           $invoiceupdate->dinner_onmeal = $dinner_on;
           $invoiceupdate->dinner_inmeal = $data->section_day-($dinner_off+$dinner_on);
           $invoiceupdate->breakfast_offmeal = $breakfast_off;
           $invoiceupdate->breakfast_onmeal = $breakfast_on;
           $invoiceupdate->breakfast_inmeal = $data->section_day-($breakfast_off+$breakfast_on);
           $invoiceupdate->onmeal_amount = ($data->lunch_rate*$lunch_on+$data->breakfast_rate*$breakfast_on+$data->lunch_rate*$dinner_on);
           $invoiceupdate->save();

          }


          function resign_amount($hall_id,$year,$month,$section){
              $resign_amount=DB::table('invoices')->where('invoice_month',$month)->where('hall_id', $hall_id)
              ->where('invoice_year',$year)->where('invoice_section',$section)->where('invoice_status',5)
              ->where('withdraw_status',1)->sum('withdraw');
              return $resign_amount;
          }

        function resign_info($hall_id,$year,$month,$section){
           $resign_info=DB::table('invoices')->where('invoice_month',$month)->where('hall_id', $hall_id)
           ->where('invoice_year',$year)->where('invoice_section',$section)->where('invoice_status',5)->get();
           return $resign_info;
        }

        function extra_payment($hall_id,$year,$month,$section){
            $extra_payment=DB::table('expayemnts')->where('cur_month',$month)->where('hall_id', $hall_id)
            ->where('cur_year',$year)->where('cur_section',$section)->sum('amount');
            return $extra_payment;
         }



         function section_update($hall_id){
             DB::beginTransaction();

             $hall=DB::table('halls')->where('hall_id',$hall_id)->where('role','admin')->first();
             $data=Hallinfo::where('hall_id_info',$hall_id)->first();
             $friday1=$data->friday1;
             $friday2=$data->friday2;
             $friday3=$data->friday3;
             $friday4=$data->friday4;
             $friday5=$data->friday5;
             $feast_day=$data->feast_day;
          
             $friday1t=$data->friday1t;
             $friday2t=$data->friday2t;
             $friday3t=$data->friday3t;
             $friday4t=$data->friday4t;
             $friday5t=$data->friday5t;
             $feast=$data->feast;
             $section_day=$data->section_day;
  
            //   $result= inactive_module($data,25974,23);
            //   return $result;
            //   die();

             $invoice = Invoice::where('invoice_month',$data->cur_month)->where('invoice_year',$data->cur_year)
               ->where('invoice_section',$data->cur_section)->where('invoice_status',1)->where('hall_id',$hall_id)->get();
     
            

            $payment_date = date('Y-m-d');
            $inactive_day1 = getDaysBetween2Dates(new DateTime($payment_date), new DateTime($data->meal_start_date), false) + 1;
            if($inactive_day1<=31){
                  $inactive_day=$inactive_day1;
            }else{
                  $inactive_day=31;
             }
     
             foreach ($invoice as $row) {
     
               $lunch_off = $lunch_on = $dinner_off = $dinner_on = $breakfast_off = $breakfast_on = 0;
     
               // Loop for lunch, dinner, and breakfast
               for ($y = 1; $y <= $data->section_day; $y++) {

                   $l_off = Invoice::where('id', $row->id)->where('l'.$y, 0)->count();
                   $l_on = Invoice::where('id', $row->id)->where('l'.$y, 1)->count();
                   $d_off = Invoice::where('id', $row->id)->where('d'.$y, 0)->count();
                   $d_on = Invoice::where('id', $row->id)->where('d'.$y, 1)->count();
                   $b_off = Invoice::where('id', $row->id)->where('b'.$y, 0)->count();
                   $b_on = Invoice::where('id', $row->id)->where('b'.$y, 1)->count();
     
                   $lunch_off += $l_off;
                   $lunch_on += $l_on;
                   $dinner_off += $d_off;
                   $dinner_on += $d_on;
                   $breakfast_off += $b_off;
                   $breakfast_on += $b_on;
               }
           
              
               $invoiceupdate = Invoice::find($row->id);
               $invoiceupdate->block_status = inactive_module($data,$row->id,$row->member_id);
               $invoiceupdate->lunch_offmeal = $lunch_off;
               $invoiceupdate->lunch_onmeal = $lunch_on;
               $invoiceupdate->lunch_inmeal = $data->section_day - ($lunch_off + $lunch_on);
               $invoiceupdate->dinner_offmeal = $dinner_off;
               $invoiceupdate->dinner_onmeal = $dinner_on;
               $invoiceupdate->dinner_inmeal = $data->section_day - ($dinner_off + $dinner_on);
               $invoiceupdate->breakfast_offmeal = $breakfast_off;
               $invoiceupdate->breakfast_onmeal = $breakfast_on;
               $invoiceupdate->breakfast_inmeal = $data->section_day - ($breakfast_off + $breakfast_on);
           
               if ($invoiceupdate->payment_status1 == 1 || $invoiceupdate->payment_status2 == 1 || $invoiceupdate->onmeal_amount > 1) {
                   // Do nothing if payment status conditions are met
               } else {
                   // // Process breakfast
                   if ($invoiceupdate->breakfast_rate > 0) {
                       if ($inactive_day <= 0) {
                           for ($y =1; $y <= $section_day; $y++) {
                               $day = "b" . $y;
                               $invoiceupdate->$day = 0;
                           }
                       } else {
                           for ($y = $inactive_day; $y >= 1; $y--) {
                               $day = "b" . $y;
                               $invoiceupdate->$day = 9;
                           }
                       }
                   }
           
                   // Process lunch
                   if ($invoiceupdate->lunch_rate > 0) {
                       if ($inactive_day <= 0) {
                           for ($y =1; $y <= $section_day; $y++) {
                               $day = "l" . $y;
                               $invoiceupdate->$day = 0;
                           }
                       } else {
                       
                           for ($y = $inactive_day; $y >= 1; $y--) {
                               $day = "l" . $y;
                               $invoiceupdate->$day = 9;
                           }
                        }
                   }
           
                   // // Process dinner
                   if ($invoiceupdate->dinner_rate > 0) {
                       if ($inactive_day <= 0) {
                           for ($y =1; $y <= $section_day; $y++) {
                               $day = "d" . $y;
                               $invoiceupdate->$day = 0;
                           }
                       } else {
                           for ($y = $inactive_day; $y >= 1; $y--) {
                               $day = "d" . $y;
                               $invoiceupdate->$day = 9;
                           }
                       }
                   }  
               }
               $invoiceupdate->save();
           }
             
         if($data->first_payment_meal>0){
                   if($data->fridayf==1){$friday_value=$data->friday;}else{$friday_value=0;}
                   if($data->feastf==1){$feast_value=$data->feast;}else{$feast_value=0;}
                   if($data->welfaref==1){$welfare_value=$data->welfare;}else{$welfare_value=0;}
                   if($data->othersf==1){$others_value=$data->others;}else{$others_value=0;}
                   if($data->waterf==1){$water_value=$data->water;}else{$water_value=0;}
                   if($data->wifif==1){$wifi_value=$data->wifi;}else{$wifi_value=0;}
                   if($data->dirtf==1){$dirt_value=$data->dirt;}else{$dirt_value=0;}
                   if($data->gassf==1){$gass_value=$data->gass;}else{$gass_value=0;}
                   if($data->electricityf==1){$electricity_value=$data->electricity;}else{$electricity_value=0;}
                   if($data->tissuef==1){$tissue_value=$data->tissue;}else{$tissue_value=0;}
                   if($data->employeef==1){$employee_value=$data->employee;}else{$employee_value=0;}
       
                  $first_others_amount=$friday_value+$feast_value+$welfare_value+$others_value+$water_value+$wifi_value+$dirt_value
                     +$gass_value+$electricity_value+$tissue_value+$employee_value;
             }else{
                  $first_others_amount=0;
             }
        
            $cur_meal_amount=($data->section_day*($data->breakfast_rate+$data->lunch_rate+$data->dinner_rate));
           DB::update(
               "update invoices set  
                breakfast_rate='$data->breakfast_rate',
                lunch_rate='$data->lunch_rate',
                dinner_rate='$data->dinner_rate',
                breakfast_status='$data->breakfast_status',
                lunch_status='$data->lunch_status',
                dinner_status='$data->dinner_status',
                refund_breakfast_rate='$data->refund_breakfast_rate',
                refund_lunch_rate='$data->refund_lunch_rate',
                refund_dinner_rate='$data->refund_dinner_rate',
                friday='$data->friday',
                section_day='$data->section_day',
                employee='$data->employee',
                feast='$data->feast',
                welfare='$data->welfare',
                others='$data->others',
                water='$data->water',
                electricity='$data->electricity',
                tissue='$data->tissue',
                wifi='$data->wifi',
                dirt='$data->dirt',
                gass='$data->gass',
                cur_meal_amount='$cur_meal_amount',
                meal_start_date='$data->meal_start_date',
                meeting_amount='$data->meeting_amount',
                cur_others_amount=friday+employee+feast+welfare+others+water+electricity
                +tissue+dirt+gass+wifi+card_fee+service_charge+security+hostel_fee+meeting_penalty,
     
                 cur_total_amount=cur_meal_amount+cur_others_amount,
                 withdraw=pre_reserve_amount+pre_refund-pre_monthdue,
                inmeal_amount=(breakfast_inmeal*breakfast_rate+lunch_inmeal*lunch_rate+dinner_inmeal*dinner_rate),
     
     
                meeting_penalty=(CASE 
                  WHEN pre_meeting_present>=1 THEN meeting_amount 
                  ELSE 0  END),
     
                payble_amount=(CASE 
                      WHEN withdraw_status>=1 THEN cur_total_amount-inmeal_amount 
                      ELSE cur_total_amount-(inmeal_amount+withdraw)  END),
     
     
                first_pay_mealon=(CASE 
                       WHEN  $data->first_payment_meal<=0 THEN 0 
                       WHEN  $data->first_payment_meal<=lunch_inmeal THEN 0 
                       WHEN  payment_status1<=0 && payment_status2>=1 THEN 0   
                       ELSE $data->first_payment_meal  END),
                first_pay_mealamount=first_pay_mealon*(breakfast_rate+lunch_rate+dinner_rate),    
     
                first_others_amount=(CASE 
                      WHEN first_pay_mealon<=0 THEN 0 
                      ELSE '$first_others_amount'+security+service_charge+card_fee  END),
     
                payble_amount1=(CASE 
                      WHEN first_pay_mealon<=0 THEN 0
                      WHEN withdraw_status>=1 THEN  first_pay_mealamount+first_others_amount-inmeal_amount
                      ELSE first_pay_mealamount+first_others_amount-(inmeal_amount+withdraw) END),
    
                second_pay_mealon=section_day-first_pay_mealon,
                second_pay_mealamount=cur_meal_amount-first_pay_mealamount,
                second_others_amount=cur_others_amount-first_others_amount,
                
                payble_amount2=(CASE 
                     WHEN payment_status1>=1 THEN second_pay_mealamount+second_others_amount
                     WHEN withdraw_status>=1 THEN cur_total_amount-inmeal_amount
                     ELSE cur_total_amount-(inmeal_amount+withdraw)  END),
     
                 onmeal_amount=breakfast_onmeal*breakfast_rate+lunch_onmeal*lunch_rate+dinner_onmeal*dinner_rate,
                
                
                 mealreducetk=breakfast_offmeal*(breakfast_rate-refund_breakfast_rate)
                 +lunch_offmeal*(lunch_rate-refund_lunch_rate)+dinner_offmeal*(dinner_rate-refund_dinner_rate),
     
                 offmeal_amount=(breakfast_offmeal*breakfast_rate+lunch_offmeal*lunch_rate+dinner_offmeal*dinner_rate)-mealreducetk,
     
                 friday1='$friday1', friday2='$friday2', friday3='$friday3', friday4='$friday4', friday5='$friday5'
     
                , fridayt1=(CASE WHEN $friday1=1  THEN 0 ELSE $friday1t END)
                , fridayt2=(CASE WHEN $friday2=1  THEN 0 ELSE $friday2t END)
                , fridayt3=(CASE WHEN $friday3=1  THEN 0 ELSE $friday3t END)
                , fridayt4=(CASE WHEN $friday4=1  THEN 0 ELSE $friday4t END)
                , fridayt5=(CASE WHEN $friday5=1  THEN 0 ELSE $friday5t END)
     
                , refund_feast=(CASE WHEN $feast_day<=0 OR $feast_day>=9 THEN $feast ELSE 0 END)
                , refund_friday=fridayt1+fridayt2+fridayt3+fridayt4+fridayt5
                , refund_welfare=(CASE WHEN onmeal_amount<=0 THEN $data->refund_welfare ELSE 0 END)
                , refund_employee=(CASE 
                     WHEN block_status=1 THEN $data->employee
                     WHEN onmeal_amount<=0 THEN $data->refund_employee
                     ELSE 0 END)
                , refund_others=(CASE WHEN onmeal_amount<=0 THEN $data->refund_others ELSE 0 END)
     
                , refund_tissue=(CASE WHEN onmeal_amount<=0 THEN $data->refund_tissue ELSE 0 END)
                , refund_gass=(CASE WHEN onmeal_amount<=0 THEN $data->refund_gass ELSE 0 END)
                , refund_electricity=(CASE WHEN onmeal_amount<=0 THEN $data->refund_electricity ELSE 0 END)
                , refund_water=(CASE WHEN onmeal_amount<=0 THEN $data->refund_water ELSE 0 END)
                , refund_wifi=(CASE WHEN onmeal_amount<=0 THEN $data->refund_wifi ELSE 0 END)
                , refund_dirt=(CASE WHEN onmeal_amount<=0 THEN $data->refund_dirt ELSE 0 END)
     
                , total_refund=offmeal_amount+refund_feast+refund_friday+refund_welfare+refund_employee+refund_others
                          +refund_tissue+refund_gass+refund_electricity+refund_water+refund_wifi+refund_dirt  
     
                , first_payment_due=(CASE 
                          WHEN payment_status1<=0 THEN payble_amount1 
                          ELSE 0 END)
     
                , second_payment_due=(CASE 
                         WHEN payble_amount2<0 AND payment_status2<=0 THEN 0 
                         WHEN payment_status2<=0 THEN payble_amount2   
                         ELSE 0 END)
     
               , total_due=first_payment_due+second_payment_due
     
               , reserve_amount=(CASE 
                     WHEN payble_amount2<0 THEN -payble_amount2
                     WHEN payble_amount1<0 THEN -payble_amount1
                  ELSE 0  END)
     
               ,gateway_fee='$hall->gateway_fee'    
               ,amount1=(payble_amount1+payble_amount1*gateway_fee/100)   
               ,amount2=(payble_amount2+payble_amount2*gateway_fee/100)
               
               ,date1='$data->date1',date2='$data->date2',date3='$data->date3',date4='$data->date4',date5='$data->date5'
               ,date6='$data->date6',date7='$data->date7',date8='$data->date8',date9='$data->date9',date10='$data->date10'
               ,date11='$data->date11',date12='$data->date12',date13='$data->date13',date14='$data->date14',date15='$data->date15'
               ,date16='$data->date16',date17='$data->date17',date18='$data->date18',date19='$data->date19',date20='$data->date20'
               ,date21='$data->date21',date22='$data->date22',date23='$data->date23',date24='$data->date24',date25='$data->date25'
               ,date26='$data->date26',date27='$data->date27',date28='$data->date28',date29='$data->date29',date30='$data->date30'
               ,date31='$data->date31'            
                where invoice_status=1 AND invoice_month=$data->cur_month AND invoice_year=$data->cur_year  AND invoice_section='$data->cur_section' AND hall_id='$hall_id'");
     
           if($data->refresh_date==$payment_date){
                $number=$data->refresh_no+1;
                DB::update("update hallinfos set refresh_date='$payment_date', refresh_no='$number'  where hall_id_info = '$hall_id' ");
           }else{
                DB::update("update hallinfos set refresh_date='$payment_date', refresh_no='0'  where hall_id_info = '$hall_id' ");
           }  
           
           DB::commit();  
         }




         function inactive_module($data,$invoice_id,$member_id){

           $current_date = date('Y-m-d');
           $operation_date = getDaysBetween2Dates(new DateTime($data->meal_end_date), new DateTime($current_date), false) + 1;
           $salary_penalty_module=$data->salary_penalty_module;
           
            if($operation_date<=2){
             $invoice=Invoice::where('invoice_status',1)->where('id','!=',$invoice_id)->where('hall_id',$data->hall_id_info)
             ->where('member_id',$member_id)
             ->limit($salary_penalty_module)->orderby('id','desc')->get();   
               $inactive_module=0;
               foreach($invoice as $row){
                     if($row->onmeal_amount<=0){
                       $inactive_module+=1;
                     }   

                }
                if($salary_penalty_module==$inactive_module){
                   return 1;
                }else{
                   return 0;
                }
            }else{
                  return 0;
            }

         }

          

        // function hall_information(){
        //      $hall=Hallinfo::get();   
        //         // foreach($hall as $row){
        //         //     //section_update($row->hall_id_info);
        //         //      $row->hall_id_info;
        //         // }
        //         return $hall;
             
        // }

      

?>