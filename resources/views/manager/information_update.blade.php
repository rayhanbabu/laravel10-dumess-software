@extends('manager.layout')
@section('page_title','Manager Panel')
@section('information_update','active')
@section('content')


<div class="p-2"> 
   <h4>Information Update</h4>
</div>



   
@if(session('status'))
<h5 class="alert alert-success">{{ session('status')}} </h5>
@endif

@if(session('fail'))
<h5 class="alert alert-danger">{{ session('fail')}} </h5>
@endif


<div class="table-responsive">
  <div id="employee_table">
    <table id="employee_data" class="table table-bordered table-hover">
      <thead>

        <th width="10%">Current month , Year , Section , last Meal </th>
        <th width="10%">Previous month , Year , Section, last Meal </th>
        <th width="10%">Meal start date </th>
        <th width="10%">Meal end date </th>

        <th width="10%"> Current Section Meal Total </th>
        <th width="10%"> Extra Minute </th>
        <th width="10%"> Max Meal OFF </th>
        <th width="10%">Edit</th>
        <th width="10%"> Breakfast, Lunch, Dinner Status</th>
        <th width="10%"> Breakfast Meal Rate & Refund Meal rate</th>
        <th width="10%"> Lunch Meal Rate & Refund Meal rate</th>
        <th width="10%"> Dinner Meal Rate & Refund Meal rate</th>
        <th width="10%">Friday </th>
        <th width="10%">Feast, FeastMeal</th>
        <th width="10%">Employee & Refund Employee</th>
        <th width="10%">Welfare & Refund Welfare</th>
        <th width="10%">Others & Refund Others</th>
        <th width="10%">Service charge, Card Fee</th>
        <th width="10%">Sucurity Money </th>
        <th width="10%">Friday 1 </th>
        <th width="10%">Friday 2 </th>
        <th width="10%">Friday 3 </th>
        <th width="10%">Friday 4 </th>
        <th width="10%">Friday 5 </th>
        <th width="10%">Unpaid Day , mealon without payment </th> 
        <th width="10%">last meal off</th>
        <th width="10%">First meal off</th>
        <th width="10%">Meeting panelty</th>
        <th width="10%">Pdf Order</th>
        <th width="10%">Auto Section Update Count </th>
        <th width="10%">E-mail Send, Salary Panelty Module</th>
       
      </thead>
      <tbody>

        <tr>
          @foreach($data as $row)
          <td>{{ $row->cur_month}}, {{ $row->cur_year}} , {{ $row->cur_section}} , Meal_{{$row->section_day}}</td>
          <td>{{ $row->pre_month}} , {{ $row->pre_year}}, {{ $row->pre_section}} , Meal_{{$row->pre_section_last_day}} </td>
          <td> <?php echo date('d-M-Y', strtotime($row->meal_start_date)); ?></td>
          <td> <?php echo date('d-M-Y', strtotime($row->meal_end_date)); ?></td>

          <td>{{ $row->section_day}} day</td>
          <td> {{$row->add_minute}} </td>
          <td> {{ $row->max_meal_off}}</td>
          <td> <button type="button" value="{{ $row->id}}" class="edit btn btn-primary btn-sm">Edit </button> </td>
          <td>{{ $row->breakfast_status}}, {{ $row->lunch_status}}, {{ $row->dinner_status}}</td>
          <td>{{ $row->breakfast_rate}} & {{ $row->refund_breakfast_rate}}</td>
          <td>{{ $row->lunch_rate}} & {{ $row->refund_lunch_rate}}</td>
          <td>{{ $row->dinner_rate}} & {{ $row->refund_dinner_rate}}</td>
          <td>{{ $row->friday}}</td>
          <td>{{ $row->feast}}, Meal_{{ $row->feast_day}}</td>
          <td>{{ $row->employee}} & {{ $row->refund_employee}}</td>
          <td>{{ $row->welfare}} & {{ $row->refund_welfare}}</td>
          <td>{{ $row->others}} & {{ $row->refund_others}}</td>
          <td>{{ $row->service_charge}} , {{ $row->card_fee}}</td>
          <td>{{ $row->security_money}}</td>
       
          <td>{{ $row->friday1}}_Meal {{ $row->friday1t}}TK </td>
          <td>{{ $row->friday2}}_Meal {{ $row->friday2t}}TK </td>
          <td>{{ $row->friday3}}_Meal {{ $row->friday3t}}TK </td>
          <td>{{ $row->friday4}}_Meal {{ $row->friday4t}}TK </td>
          <td>{{ $row->friday5}}_Meal {{ $row->friday5t}}TK </td>

          <td> {{ $row->unpaid_day}} , {{ $row->mealon_without_payment}} </td> 
          <td>{{ $row->last_meal_off}}</td>
          <td>{{ $row->first_meal_off}}</td>
          <td>{{ $row->meeting_amount}}</td>
          <td>{{ $row->pdf_order}}</td>
          <td>{{ $row->refresh_no}} </td>
          <td>{{ $row->email_send}} , {{ $row->salary_penalty_module}}</td>
        </tr>

        <tr>
          <th width="20%">Meal_1 date </th>
          <th width="10%">Meal_2 date</th>
          <th width="10%">Meal_3 date </th>
          <th width="10%">Meal_4 date </th>
          <th width="20%">Meal_5 date </th>
          <th width="10%">Meal_6 date</th>
          <th width="10%">Meal_7 date </th>
          <th width="10%">Meal_8 date </th>
          <th width="10%">Meal_9 date </th>
          <th width="10%">Meal_10 date </th>
          <th width="20%">Meal_11 date </th>
          <th width="10%">Meal_12 date</th>
          <th width="10%">Meal_13 date </th>
          <th width="10%">Meal_14 date </th>
          <th width="20%">Meal_15 date </th>
          <th width="10%">Meal_16 date</th>
          <th width="10%">Meal_17 date </th>
          <th width="10%">Meal_18 date </th>
          <th width="10%">Meal_19 date </th>
          <th width="10%">Meal_20 date </th>
          <th width="10%">Meal_21 date </th>
          <th width="20%">Meal_22 date </th>
          <th width="10%">Meal_23 date</th>
          <th width="10%">Meal_24 date </th>
          <th width="10%">Meal_25 date </th>
          <th width="20%">Meal_26 date </th>
          <th width="10%">Meal_27 date</th>
          <th width="10%">Meal_28 date </th>
          <th width="10%">Meal_29 date </th>
          <th width="10%">Meal_30 date </th>
          <th width="10%">Meal_31 date </th>
        </tr>

        <tr>
          <td> <?php echo !empty($row->date1) ? date('D,d-M-y', strtotime($row->date1)) : ""; ?> </td>
          <td> <?php echo !empty($row->date2) ? date('D,d-M-y', strtotime($row->date2)) : ""; ?> </td>
          <td> <?php echo !empty($row->date3) ? date('D,d-M-y', strtotime($row->date3)) : ""; ?> </td>
          <td> <?php echo !empty($row->date4) ? date('D,d-M-y', strtotime($row->date4)) : ""; ?> </td>
          <td> <?php echo !empty($row->date5) ? date('D,d-M-y', strtotime($row->date5)) : ""; ?> </td>
          <td> <?php echo !empty($row->date6) ? date('D,d-M-y', strtotime($row->date6)) : ""; ?> </td>
          <td> <?php echo !empty($row->date7) ? date('D,d-M-y', strtotime($row->date7)) : ""; ?> </td>
          <td> <?php echo !empty($row->date8) ? date('D,d-M-y', strtotime($row->date8)) : ""; ?> </td>
          <td> <?php echo !empty($row->date9) ? date('D,d-M-y', strtotime($row->date9)) : ""; ?> </td>
          <td> <?php echo !empty($row->date10) ? date('D,d-M-y', strtotime($row->date10)) : ""; ?> </td>
          <td> <?php echo !empty($row->date11) ? date('D,d-M-y', strtotime($row->date11)) : ""; ?> </td>
          <td> <?php echo !empty($row->date12) ? date('D,d-M-y', strtotime($row->date12)) : ""; ?> </td>
          <td> <?php echo !empty($row->date13) ? date('D,d-M-y', strtotime($row->date13)) : ""; ?> </td>
          <td> <?php echo !empty($row->date14) ? date('D,d-M-y', strtotime($row->date14)) : ""; ?> </td>
          <td> <?php echo !empty($row->date15) ? date('D,d-M-y', strtotime($row->date15)) : ""; ?> </td>
          <td> <?php echo !empty($row->date16) ? date('D,d-M-y', strtotime($row->date16)) : ""; ?> </td>
          <td> <?php echo !empty($row->date17) ? date('D,d-M-y', strtotime($row->date17)) : ""; ?> </td>
          <td> <?php echo !empty($row->date18) ? date('D,d-M-y', strtotime($row->date18)) : ""; ?> </td>
          <td> <?php echo !empty($row->date19) ? date('D,d-M-y', strtotime($row->date19)) : ""; ?> </td>
          <td> <?php echo !empty($row->date20) ? date('D,d-M-y', strtotime($row->date20)) : ""; ?> </td>
          <td> <?php echo !empty($row->date21) ? date('D,d-M-y', strtotime($row->date21)) : ""; ?> </td>
          <td> <?php echo !empty($row->date22) ? date('D,d-M-y', strtotime($row->date22)) : ""; ?> </td>
          <td> <?php echo !empty($row->date23) ? date('D,d-M-y', strtotime($row->date23)) : ""; ?> </td>
          <td> <?php echo !empty($row->date24) ? date('D,d-M-y', strtotime($row->date24)) : ""; ?> </td>
          <td> <?php echo !empty($row->date25) ? date('D,d-M-y', strtotime($row->date25)) : ""; ?> </td>
          <td> <?php echo !empty($row->date26) ? date('D,d-M-y', strtotime($row->date26)) : ""; ?> </td>
          <td> <?php echo !empty($row->date27) ? date('D,d-M-y', strtotime($row->date27)) : ""; ?> </td>
          <td> <?php echo !empty($row->date28) ? date('D,d-M-y', strtotime($row->date28)) : ""; ?> </td>
          <td> <?php echo !empty($row->date29) ? date('D,d-M-y', strtotime($row->date29)) : ""; ?> </td>
          <td> <?php echo !empty($row->date30) ? date('D,d-M-y', strtotime($row->date30)) : ""; ?> </td>
          <td> <?php echo !empty($row->date31) ? date('D,d-M-y', strtotime($row->date31)) : ""; ?> </td>
        </tr>

        @endforeach

      </tbody>
    </table>

  </div>
</div>


<script>
  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(document).on('click', '.edit', function(e) {
      e.preventDefault();
      var id = $(this).val();
      $('#EditModal').modal('show');
      $.ajax({
        type: 'GET',
        url: '/manager/information_update_view/' + id,
        success: function(response) {
          console.log(response);
          if (response.status == 404) {
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-danger');
            $('#success_message').text(response.message);
          } else {
            $('#edit_id').val(response.value.id);
            $('#cur_date').val(response.value.cur_date);
            $('#cur_section').val(response.value.cur_section);
            $('#pre_date').val(response.value.pre_date);
            $('#pre_section').val(response.value.pre_section);
            $('#datetime').val(response.value.update_time);
            $('#section_day').val(response.value.section_day);
            $('#pre_section_last_day').val(response.value.pre_section_last_day.substring(1,3));
            $('#last_day_daytype').val(response.value.pre_section_last_day.substring(0,1));

            $('#meal_start_date').val(response.value.meal_start_date);
            $('#meal_end_date').val(response.value.meal_end_date);

            $('#breakfast_status').val(response.value.breakfast_status);
            $('#lunch_status').val(response.value.lunch_status);
            $('#dinner_status').val(response.value.dinner_status);

            $('#fixed_payment').val(response.value.fixed_payment);

            $('#breakfast_rate').val(response.value.breakfast_rate);
            $('#refund_breakfast_rate').val(response.value.refund_breakfast_rate);
            $('#lunch_rate').val(response.value.lunch_rate);
            $('#refund_lunch_rate').val(response.value.refund_lunch_rate);
            $('#dinner_rate').val(response.value.dinner_rate);
            $('#refund_dinner_rate').val(response.value.refund_dinner_rate);

            $('#max_meal_off').val(response.value.max_meal_off);
            $('#last_meal_off').val(response.value.last_meal_off);
            $('#first_meal_off').val(response.value.first_meal_off);
            $('#add_minute').val(response.value.add_minute);

            $('#meeting_amount').val(response.value.meeting_amount);
            $('#security_money').val(response.value.security_money);
            $('#card_fee').val(response.value.card_fee);
            $('#service_charge').val(response.value.service_charge);

            $('#employee').val(response.value.employee);
            $('#refund_employee').val(response.value.refund_employee);
            $('#welfare').val(response.value.welfare);
            $('#refund_welfare').val(response.value.refund_welfare);
            $('#others').val(response.value.others);
            $('#refund_others').val(response.value.refund_others);
            
            $('#water').val(response.value.water);
            $('#refund_water').val(response.value.refund_water);
            $('#wifi').val(response.value.wifi);
            $('#refund_wifi').val(response.value.refund_wifi);
            $('#dirt').val(response.value.dirt);
            $('#refund_dirt').val(response.value.refund_dirt);

            $('#electricity').val(response.value.electricity);
            $('#refund_electricity').val(response.value.refund_electricity);
            $('#tissue').val(response.value.tissue);
            $('#refund_tissue').val(response.value.refund_tissue);

            $('#gass').val(response.value.gass);
            $('#refund_gass').val(response.value.refund_gass);
            $('#feast').val(response.value.feast);
            $('#feast_day').val(response.value.feast_day.substring(1,3));
            $('#feast_daytype').val(response.value.feast_day.substring(0,1));
            $('#unpaid_day').val(response.value.unpaid_day);
        
           
            $('#friday1').val(response.value.friday1.substring(1,3));
            $('#friday2').val(response.value.friday2.substring(1,3));
            $('#friday3').val(response.value.friday3.substring(1,3));
            $('#friday4').val(response.value.friday4.substring(1,3));
            $('#friday5').val(response.value.friday5.substring(1,3));
            $('#fridaytype1').val(response.value.friday1.substring(0,1));
            $('#fridaytype2').val(response.value.friday2.substring(0,1));
            $('#fridaytype3').val(response.value.friday3.substring(0,1));
            $('#fridaytype4').val(response.value.friday4.substring(0,1));
            $('#fridaytype5').val(response.value.friday5.substring(0,1));
            $('#friday1t').val(response.value.friday1t);
            $('#friday2t').val(response.value.friday2t);
            $('#friday3t').val(response.value.friday3t);
            $('#friday4t').val(response.value.friday4t);
            $('#friday5t').val(response.value.friday5t);

            $('#first_payment_meal').val(response.value.first_payment_meal);
            $('#fridayf').val(response.value.fridayf);
            $('#feastf').val(response.value.feastf);
            $('#welfaref').val(response.value.welfaref);
            $('#othersf').val(response.value.othersf);
            $('#employeef').val(response.value.employeef);

            $('#waterf').val(response.value.waterf);
            $('#wifif').val(response.value.wifif);
            $('#dirtf').val(response.value.dirtf);
            $('#gassf').val(response.value.gassf);
            $('#electricityf').val(response.value.electricityf);
            $('#tissuef').val(response.value.tissuef);

            $('#pdf_order').val(response.value.pdf_order);
            $('#web_link').val(response.value.web_link);
            $('#gateway_fee').val(response.value.gateway_fee);
            $('#email_send').val(response.value.email_send);
            $('#salary_penalty_module').val(response.value.salary_penalty_module);
            $('#mealon_without_payment').val(response.value.mealon_without_payment);
           

          }
        }
      });
    });

  });
</script>




{{-- edit employee modal start --}}
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="{{ url('manager/information_update_submit') }}" class="myform" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <input type="hidden" name="edit_id" id="edit_id">
        <div class="modal-body p-4 bg-light">
          <div class="row">

            <div class="col-lg-3 my-2"> 
                <label>Current Month</label>
                <input type="date" name="cur_date" id="cur_date" class="form-control" required />
            </div>

            <div class="col-lg-3 my-2">
               <label for="lname">Current Section <span style="color:red;"> * </span></label>
               <select class="form-control" name="cur_section" id="cur_section" aria-label="Default select example" required>
                      <option value="A">A</option>
                      <option value="B">B </option>
                </select>
            </div>

            <div class="col-lg-6 my-2">
                 <label>Update Time(yyyy-mm-dd h:m:s)</label>
                 <input type="datetime" name="update_time" id="datetime" class="form-control"  />
            </div>


            <div class="col-lg-3 my-2">
              <label>Previous Month</label>
              <input type="date" name="pre_date" id="pre_date" class="form-control" required />
            </div>


            <div class="col-lg-3 my-2">
                <label for="lname">Previous Section <span style="color:red;"> * </span></label>
                <select class="form-control" name="pre_section" id="pre_section" aria-label="Default select example" required>
                    <option value="A">A</option>
                    <option value="B">B </option>
                </select>
            </div>

              <div class="col-lg-2 my-2">
                  <label> Section  day</label>
                  <input type="number" name="section_day" id="section_day" class="form-control" readonly />
              </div>

              <div class="col-sm-2 my-2">
                  <label>last Day type</label>
                  <select class="form-control" id="last_day_daytype" name="last_day_daytype" aria-label="Default select example" required>
                        <option value="b">Breakfast</option>
                        <option value="l">Lunch</option>
                        <option value="d">Dinner</option>
                  </select>
            </div>

             <div class="col-lg-2 my-2">
                 <label>Pre section last Day</label>
                 <input type="number" name="pre_section_last_day" id="pre_section_last_day" class="form-control" required />
            </div>

           

             <div class="col-lg-3 my-2">
                 <label for="lname"> Breakfast Status  <span style="color:red;"> * </span></label>
                 <select class="form-control" name="breakfast_status" id="breakfast_status" aria-label="Default select example" required>
                    <option value="0">No</option>
                    <option value="1">Yes </option>
                 </select>
             </div> 
             
             
             <div class="col-lg-2 my-2">
                 <label for="lname"> Lunch Status  <span style="color:red;"> * </span></label>
                 <select class="form-control" name="lunch_status" id="lunch_status" aria-label="Default select example" required>
                    <option value="0">No</option>
                    <option value="1">Yes </option>
                 </select>
             </div> 
             
             <div class="col-lg-3 my-2">
                 <label for="lname"> Dinner Status  <span style="color:red;"> * </span></label>
                 <select class="form-control" name="dinner_status" id="dinner_status" aria-label="Default select example" required>
                    <option value="0">No</option>
                    <option value="1">Yes </option>
                 </select>
             </div> 
             
             
             <div class="col-sm-4 my-2">
              <label>Meal On Without Payment</label>
              <input type="number" name="mealon_without_payment" id="mealon_without_payment" class="form-control" required />
            </div>



            <div class="col-lg-3 my-2">
              <label>Meal start date </label>
              <input type="date" name="meal_start_date" id="meal_start_date" class="form-control" required />
            </div>

            <div class="col-lg-3 my-2">
              <label>Meal end date </label>
              <input type="date" name="meal_end_date" id="meal_end_date" class="form-control" required />
            </div>


            <div class="col-sm-3 my-2">
              <label>Breakfast Meal Rate</label>
              <input type="number" name="breakfast_rate" id="breakfast_rate" class="form-control" required />
            </div>

            <div class="col-sm-3 my-2">
              <label>Ref. Br. Meal Rate</label>
              <input type="number" name="refund_breakfast_rate" id="refund_breakfast_rate" class="form-control" required />
            </div>

            <div class="col-sm-3 my-2">
              <label>Lunch Meal Rate</label>
              <input type="number" name="lunch_rate" id="lunch_rate" class="form-control" required />
            </div>

            <div class="col-sm-3 my-2">
              <label>Ref. Lunch Meal Rate</label>
              <input type="number" name="refund_lunch_rate" id="refund_lunch_rate" class="form-control" required />
            </div>

            <div class="col-sm-3 my-2">
              <label>Dinner Meal Rate</label>
              <input type="number" name="dinner_rate" id="dinner_rate" class="form-control" required />
            </div>

            <div class="col-sm-3 my-2">
              <label>Ref. Dinner Meal Rate</label>
              <input type="number" name="refund_dinner_rate" id="refund_dinner_rate" class="form-control" required />
            </div>

            <div class="col-sm-3 my-2">
              <label>Max Meal OFF </label>
              <input type="number" name="max_meal_off" id="max_meal_off" class="form-control" required />
            </div>

            <div class="col-sm-3 my-2">
              <label>last No of meal off </label>
              <input type="number" name="last_meal_off" id="last_meal_off" class="form-control" required />
            </div>

            <div class="col-sm-3 my-2">
              <label>First No of meal off </label>
              <input type="number" name="first_meal_off" id="first_meal_off" class="form-control" required />
            </div>

            <div class="col-sm-3 my-2">
               <label>Extra minute Add </label>
               <input type="number" name="add_minute" id="add_minute" class="form-control" required />
            </div>

            <div class="col-sm-3 my-2">
               <label>Meeting penalty </label>
                <input type="number" name="meeting_amount" id="meeting_amount" class="form-control" required />
            </div>

            <div class="col-sm-3 my-2">
               <label>Card Fee</label>
               <input type="number" name="card_fee" id="card_fee" class="form-control" required />
            </div>


            <div class="col-sm-3 my-2">
                  <label>Service Charge</label>
                  <input type="number" name="service_charge" id="service_charge" class="form-control" required />
             </div>

             <div class="col-sm-3 my-2">
                  <label>Security Money</label>
                  <input type="number" name="security_money" id="security_money" class="form-control" required />
             </div>
         
            <div class="col-sm-2 my-2">
                <label>Employee</label>
                 <input type="number" name="employee" id="employee" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
                <label>Ref. Employee</label>
                <input type="number" name="refund_employee" id="refund_employee" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
               <label>Welfare</label>
               <input type="number" name="welfare" id="welfare" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
               <label> Ref. Welfare</label>
               <input type="number" name="refund_welfare" id="refund_welfare" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
              <label >Others</label>
              <input type="number" name="others" id="others" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
              <label >Ref. Others</label>
              <input type="number" name="refund_others" id="refund_others" class="form-control" required />
            </div>


            <div class="col-sm-2 my-2">
                <label>Water</label>
                <input type="number" name="water" id="water" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
                <label>Ref. Water</label>
                <input type="number" name="refund_water" id="refund_water" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
                <label>Wifi</label>
                <input type="number" name="wifi" id="wifi" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
                <label>Ref. Wifi</label>
                <input type="number" name="refund_wifi" id="refund_wifi" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
                <label> Dirt</label>
                <input type="number" name="dirt" id="dirt" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
                <label>Ref.  Dirt</label>
                <input type="number" name="refund_dirt" id="refund_dirt" class="form-control" required />
            </div>


            <div class="col-sm-2 my-2">
                <label>electricity</label>
                <input type="number" name="electricity" id="electricity" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
                <label>Ref. electricity</label>
                <input type="number" name="refund_electricity" id="refund_electricity" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
                <label> tissue</label>
                <input type="number" name="tissue" id="tissue" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
                <label>Ref.  tissue</label>
                <input type="number" name="refund_tissue" id="refund_tissue" class="form-control" required />
            </div>


            <div class="col-sm-2 my-2">
                <label> Gass</label>
                <input type="number" name="gass" id="gass" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
                <label>Ref. Gass</label>
                <input type="number" name="refund_gass" id="refund_gass" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
              <label>Feast amount</label>
              <input type="number" name="feast" id="feast" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
               <label>Feast Type</label>
               <select class="form-control" id="feast_daytype" name="feast_daytype" aria-label="Default select example" required>
                        <option value="b">Breakfast</option>
                        <option value="l">Lunch</option>
                        <option value="d">Dinner</option>
                  </select>
            </div>

            <div class="col-sm-2 my-2">
              <label>Feast Meal No</label>
              <input type="number" min="1" max="31" name="feast_day" id="feast_day" class="form-control" required />
            </div>



            <div class="col-sm-3 my-2">
               <label>Paid Status change hour</label>
               <input type="number" name="unpaid_day" id="unpaid_day" class="form-control" required />
            </div>

            <div class="col-sm-3 my-2">
                  <label> Pdf Order  </label>
                  <select class="form-control" id="pdf_order" name="pdf_order" aria-label="Default select example" required>
                      <option value="registration">Registration</option>
                      <option value="card">Card</option>
                  </select>
            </div>


            <div class="col-sm-6 my-2">
                  <label> No of Salary Penalty Module  </label>

                  <input type="number" min="0" max="5" name="salary_penalty_module" id="salary_penalty_module" class="form-control" required />
             </div>


           


            <p>First Pay Include</p>
            <div class="col-sm-2 my-2">
               <label>Meal No </label>
               <input type="number" name="first_payment_meal" id="first_payment_meal" class="form-control" required />
            </div>

            <div class="col-sm-2 my-2">
                 <label>friday  </label>
                  <select class="form-control" id="fridayf" name="fridayf" aria-label="Default select example" required>
                      <option value="0">No</option>
                      <option value="1">Yes</option>
                  </select>
            </div>

            <div class="col-sm-2 my-2">
                 <label>feast  </label>
                  <select class="form-control" id="feastf" name="feastf" aria-label="Default select example" required>
                      <option value="0">No</option>
                      <option value="1">Yes</option>
                  </select>
            </div>

             <div class="col-sm-2 my-2">
                    <label>welfare  </label>
                    <select class="form-control" id="welfaref" name="welfaref" aria-label="Default select example" required>
                       <option value="0">No</option>
                       <option value="1">Yes</option>
                    </select>
             </div>

            <div class="col-sm-2 my-2">
                 <label>others  </label>
                  <select class="form-control" id="othersf" name="othersf" aria-label="Default select example" required>
                      <option value="0">No</option>
                      <option value="1">Yes</option>
                  </select>
            </div>


            <div class="col-sm-2 my-2">
                 <label>employee  </label>
                  <select class="form-control" id="employeef" name="employeef" aria-label="Default select example" required>
                      <option value="0">No</option>
                      <option value="1">Yes</option>
                  </select>
            </div>

            <div class="col-sm-2 my-2">
                 <label>water  </label>
                  <select class="form-control" id="waterf" name="waterf" aria-label="Default select example" required>
                      <option value="0">No</option>
                      <option value="1">Yes</option>
                  </select>
            </div>

            <div class="col-sm-2 my-2">
                 <label>wifi  </label>
                  <select class="form-control" id="wifif" name="wifif" aria-label="Default select example" required>
                      <option value="0">No</option>
                      <option value="1">Yes</option>
                  </select>
            </div>

            <div class="col-sm-2 my-2">
                 <label>dirt  </label>
                  <select class="form-control" id="dirtf" name="dirtf" aria-label="Default select example" required>
                      <option value="0">No</option>
                      <option value="1">Yes</option>
                  </select>
            </div>

            <div class="col-sm-2 my-2">
                 <label>gass </label>
                  <select class="form-control" id="gassf" name="gassf" aria-label="Default select example" required>
                      <option value="0">No</option>
                      <option value="1">Yes</option>
                  </select>
            </div>

            <div class="col-sm-2 my-2">
                 <label>electricity  </label>
                  <select class="form-control" id="electricityf" name="electricityf" aria-label="Default select example" required>
                      <option value="0">No</option>
                      <option value="1">Yes</option>
                  </select>
            </div>


            <div class="col-sm-2 my-2">
                 <label>tissue </label>
                  <select class="form-control" id="tissuef" name="tissuef" aria-label="Default select example" required>
                      <option value="0">No</option>
                      <option value="1">Yes</option>
                  </select>
            </div>

          
                <p1>Friday </p1>
    
            <div class="col-sm-2 my-2">1-5 friday Meal No </div>
            <div class="col-sm-2 my-2"><input type="number" id="friday1" name="friday1" class="form-control" required /></div>
            <div class="col-sm-2 my-2"><input type="number" id="friday2" name="friday2" class="form-control" required /></div>
            <div class="col-sm-2 my-2"><input type="number" id="friday3" name="friday3" class="form-control" required /></div>
            <div class="col-sm-2 my-2"><input type="number" id="friday4" name="friday4" class="form-control" required /></div>
            <div class="col-sm-2 my-2"><input type="number" id="friday5" name="friday5" class="form-control" required /></div>


            <div class="col-sm-2 my-2">
                 Type 1-5
            </div>

            <div class="col-sm-2 my-2">
                  <select class="form-control" id="fridaytype1" name="fridaytype1" aria-label="Default select example" required>
                        <option value="b">Breakfast</option>
                        <option value="l">Lunch</option>
                        <option value="d">Dinner</option>
                  </select>
            </div>

            <div class="col-sm-2 my-2">
                  <select class="form-control" id="fridaytype2" name="fridaytype2" aria-label="Default select example" required>
                        <option value="b">Breakfast</option>
                        <option value="l">Lunch</option>
                        <option value="d">Dinner</option>
                  </select>
            </div>

            <div class="col-sm-2 my-2">
                   <select class="form-control" id="fridaytype3" name="fridaytype3" aria-label="Default select example" required>
                        <option value="b">Breakfast</option>
                        <option value="l">Lunch</option>
                        <option value="d">Dinner</option>
                  </select>
            </div>


            <div class="col-sm-2 my-2">
                   <select class="form-control" id="fridaytype4" name="fridaytype4" aria-label="Default select example" required>
                        <option value="b">Breakfast</option>
                        <option value="l">Lunch</option>
                        <option value="d">Dinner</option>
                  </select>
            </div>

            <div class="col-sm-2 my-2">
                   <select class="form-control" id="fridaytype5" name="fridaytype5" aria-label="Default select example" required>
                        <option value="b">Breakfast</option>
                        <option value="l">Lunch</option>
                        <option value="d">Dinner</option>
                  </select>
            </div>


            <div class="col-sm-2 my-2">1-5 friday TK </div>
            <div class="col-sm-2 my-2"><input type="number" id="friday1t" name="friday1t" class="form-control" required /></div>
            <div class="col-sm-2 my-2"><input type="number" id="friday2t" name="friday2t" class="form-control" required /></div>
            <div class="col-sm-2 my-2"><input type="number" id="friday3t" name="friday3t" class="form-control" required /></div>
            <div class="col-sm-2 my-2"><input type="number" id="friday4t" name="friday4t" class="form-control" required /></div>
            <div class="col-sm-2 my-2"><input type="number" id="friday5t" name="friday5t" class="form-control" required /></div>

          </div>
           



          <div class="mt-2" id="avatar"> </div>



          <div class="mt-4">

            <input type="submit" value="Update" class="btn btn-success " />
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit employee modal end --}}


@endsection 