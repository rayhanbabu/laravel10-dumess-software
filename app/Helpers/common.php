<?php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Mail;
    use App\Helpers\MaintainJWTToken;
    use App\Helpers\ManagerJWTToken;
    use Illuminate\Support\Facades\Cookie;
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


        
        function manageraccess(){
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



           function payment_access(){               
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
         






          


      

?>