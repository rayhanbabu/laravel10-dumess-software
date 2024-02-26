@extends('maintain.layout')
@section('page_title','Maintain Panel')
@section('hall','active')
@section('content')

 <div class="row mt-3 mb-0 mx-2">
                <div class="col-sm-3 my-2"> <h5 class="mt-0">Hall View </h5></div>
                     
                 <div class="col-sm-3 my-2">
                 <div class="d-grid gap-2 d-flex justify-content-end"> 
                 <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add</button>  
                </div>    
                </div>

                <div class="col-sm-6 my-2 ">
                 <div class="d-grid gap-3 d-flex justify-content-end">
                   
                 </div>
                </div>

                @if(Session::has('success'))
                  <div  class="alert alert-success"> {{Session::get('success')}}</div>
                   @endif
 
                     @if(Session::has('fail'))
                 <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
                  @endif
    </div>             


    <div class="row my-2 ">
      <div class="col-md-3 p-2">
            <select class="form-select form-select-sm" id="range" name="range" aria-label="Default select example " required>
                   <option  value="10">10 </option>
                   <option  value="20">20 </option>
                   <option  value="50">50 </option>
                   <option  value="100">100 </option>
             </select>             
      </div> 
      <div class="col-md-6">   </div>       
            
    <div class="col-md-3 p-2">
     <div class="form-group">
         <input type="text" name="search" id="search" placeholder="Enter Search " class="form-control form-control-sm"  autocomplete="off"  />
     </div>
    </div>
   </div>
   <div id="success_message"></div>
				
 <div class="table-responsive">	
  <div class="x_content">
   <table id="employee_data"  class="table table-bordered table-hover table-sm shadow">
    <thead>
       <tr>
          <th  width="10%">University/Location </th>
           <th width="25%" class="sorting" data-sorting_type="asc" data-column_name="hall" style="cursor: pointer">Hall/Hostel 
                <span id="hall_icon" ><i class="fas fa-sort-amount-up-alt"></i></span> </th>
          <th  width="10%">Hall Id</th>
          <th  width="10%">Phone</th>
          <th  width="10%">Email</th>
          <th  width="10%">Password</th>
          <th  width="10%">login code</th>
          <th  width="10%">Status</th>
          <th  width="10%">Web Status</th>
		      <th  width="10%"></th>
		      <th  width="10%"></th>
      </tr>

       <tr>
          <td colspan="5">
            <div  class="loader_page text-center">
                <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
            </div>
         </td>
      </tr>
         
    </thead>
    <tbody>
       
    </tbody>
  </table>
       
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="hall" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
 
 
</div>
</div>



{{-- add new Student modal start --}}
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" id="add_employee_form" enctype="multipart/form-data">

        <div class="modal-body p-4 bg-light">
          <div class="row">

          <div class="col-lg-12 my-2">
              <select class="form-select" id="university_id" name="university_id" aria-label="Default select example " required>
                       <option  value="">Select One </option>
                        @foreach($data as $row)
                            <option   value="{{$row->id}}">{{$row->university}}</option>
                        @endforeach  
               </select>
           </div>



            <div class="col-lg-12 my-2">
               <label for="roll">Hall  Name<span style="color:red;"> * </span></label>
               <input type="text" name="hall" id="hall" class="form-control" placeholder="" required>
               <p class="text-danger error_hall"></p>
            </div>

            <div class="col-lg-12 my-2">
                <label for="roll">E-mail <span style="color:red;"> * </span></label>
                <input type="text" name="email" id="email" class="form-control" placeholder="" required>
                <p class="text-danger error_email"></p>
            </div>

            <div class="col-lg-12 my-2">
                <label for="roll">Phone Number <span style="color:red;"> * </span></label>
                <input type="text" name="phone" id="phone" class="form-control" placeholder="" required>
                <p class="text-danger error_phone"></p>
            </div>

            <div class="col-lg-12 my-2">
                <label for="roll">Password <span style="color:red;"> * </span></label>
                <input type="text" name="password" id="password" class="form-control" placeholder="" required>
                <p class="text-danger error_password"></p>
            </div>

            <div class="col-lg-12 my-2">
                <label for="roll">Custom appication Field 1 </span></label>
                <input type="text" name="custom1" id="custom1" class="form-control" placeholder="" >
            </div>

            <div class="col-lg-12 my-2">
                <label for="roll">Custom appication Field 2 </span></label>
                <input type="text" name="custom2" id="custom2" class="form-control" placeholder="" >
            </div>

            <div class="col-lg-12 my-2">
                <label for="roll">Custom appication Field 3 </span></label>
                <input type="text" name="custom3" id="custom3" class="form-control" placeholder="" >
            </div>


            <ul id="add_errorlist"> </ul>

            
          </div>    
          <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>

        <div class="mt-4">
          <button type="submit" id="add_employee_btn" class="btn btn-primary">Submit </button>
       </div>  

      </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
       
        </div>
      </form>
    </div>
  </div>
</div>

{{-- add new employee modal end --}}



{{-- edit employee modal start --}}
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" id="edit_employee_form" enctype="multipart/form-data">
        <input type="hidden" name="edit_id" id="edit_id">
         <div class="modal-body p-4 bg-light">
          <div class="row">


          <div class="col-lg-12 my-2">
              <select class="form-select" id="edit_university_id" name="university_id" aria-label="Default select example " required>
                       <option  value="">Select One </option>
                        @foreach($data as $row)
                            <option   value="{{$row->id}}">{{$row->university}}</option>
                        @endforeach  
               </select>
           </div>

          

            <div class="col-lg-12 my-2">
               <label for="roll">Hall Name<span style="color:red;"> * </span></label>
               <input type="text" name="hall" id="edit_hall" class="form-control" placeholder="" required>
               <p class="text-danger edit_error_hall"></p>
            </div>

            
            <div class="col-lg-12 my-2">
                <label for="roll">E-mail <span style="color:red;"> * </span></label>
                <input type="text" name="email" id="edit_email" class="form-control" placeholder="" required>
            </div>

            <div class="col-lg-12 my-2">
                <label for="roll">Phone Number <span style="color:red;"> * </span></label>
                <input type="text" name="phone" id="edit_phone" class="form-control" placeholder="" required>
            </div>

            <div class="col-lg-6 my-2">
                <label for="roll">Password <span style="color:red;"> * </span></label>
                <input type="text" name="password" id="edit_password" class="form-control" placeholder="" required>
                <p class="text-danger error_password"></p>
            </div>

            <div class="col-lg-6 my-2">
                  <label class=""><b>Web Status</b></label>
                   <select class="form-select" name="web_status" id="edit_web_status" aria-label="Default select example">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                  </select>
            </div>

            <div class="col-lg-12 my-2">
                <label for="roll">Webiste Link (--.org/) <span style="color:red;"> * </span></label>
                <input type="text" name="web_link" id="edit_web_link" class="form-control" placeholder="" required>
            </div>

            <div class="col-lg-6 my-2">
                  <label class=""><b>Status</b></label>
                   <select class="form-select" name="status" id="edit_status" aria-label="Default select example">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                  </select>
            </div>

            <div class="col-lg-6 my-2">
                <label for="roll">Level Custom  Field 1 </span></label>
                <input type="text" name="level_custom1" id="edit_level_custom1" class="form-control" placeholder="" >
            </div>

            <div class="col-lg-6 my-2">
                <label for="roll">Level Custom  Field 2 </span></label>
                <input type="text" name="level_custom2" id="edit_level_custom2" class="form-control" placeholder="" >
            </div>

            <div class="col-lg-6 my-2">
                <label for="roll">Level Custom  Field 3 </span></label>
                <input type="text" name="level_custom3" id="edit_level_custom3" class="form-control" placeholder="" >
            </div>

            <div class="col-lg-6 my-2">
                <label for="roll">Level Reg/ Seat No </span></label>
                <input type="text" name="level_registration" id="edit_level_registration" class="form-control" placeholder="" >
            </div>

            <div class="col-lg-6 my-2">
                <label for="roll">Level Profile Image </span></label>
                <input type="text" name="level_profile_image" id="edit_level_profile_image" class="form-control" placeholder="" >
            </div>

            <div class="col-lg-6 my-2">
                <label for="roll">Level File name  </span></label>
                <input type="text" name="level_file_name" id="edit_level_file_name" class="form-control" placeholder="" >
            </div>

            <div class="col-lg-6 my-2">
                <label for="roll">FrontEnd Link  </span></label>
                <input type="text" name="frontend_link" id="edit_frontend_link" class="form-control" placeholder="" >
            </div>


            <div class="col-lg-6 my-2">
            <label class="">Payment Access</label>
                <select class="form-control mb-2" id="payment" name="payment" aria-label="Default select example" required>
                  <option value="No">No</option>
                  <option value="Yes">Yes</option>
                </select>
           </div>

         <div class="col-lg-6 my-2">
              <label class="">Meal Access</label>
                <select class="form-control mb-2" id="meal" name="meal" aria-label="Default select example" required>
                  <option value="No">No</option>
                  <option value="Yes">Yes</option>
                </select>
           </div>

            <div class="col-lg-6 my-2">
                <label class="">Member Access</label>
                <select class="form-control mb-2" id="member" name="member" aria-label="Default select example" required>
                  <option value="No">No</option>
                  <option value="Yes">Yes</option>
                </select>
            </div>    

            <div class="col-lg-6 my-2">
                <label class="">Bazar Access</label>
                  <select class="form-control mb-2" id="bazar" name="bazar" aria-label="Default select example" required>
                     <option value="No">No</option>
                     <option value="Yes">Yes</option>
                  </select>
            </div>     

          <div class="col-lg-6 my-2">
                 <label class="">Application Access</label>
                 <select class="form-control mb-2" id="application" name="application" aria-label="Default select example" required>
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                 </select>
            </div>    


            <div class="col-lg-6 my-2">
                  <label class="">Resign Access</label>
                  <select class="form-control mb-2" id="resign" name="resign" aria-label="Default select example" required>
                     <option value="No">No</option>
                     <option value="Yes">Yes</option>
                  </select>
            </div>


           

            <div class="col-lg-6 my-2">
                  <label class="">Others Access</label>
                  <select class="form-control mb-2" id="others_access" name="others_access" aria-label="Default select example" required>
                     <option value="No">No</option>
                     <option value="Yes">Yes</option>
                  </select>
            </div>


            <div class="col-lg-6 my-2">
                  <label class="">E-mail Hash Entry</label>
                  <select class="form-control mb-2" id="storage" name="storage" aria-label="Default select example" required>
                     <option value="No">No</option>
                     <option value="Yes">Yes</option>
                  </select>
            </div>

  
            <div class="col-lg-6 my-2">
                  <label class="">Bookng Access</label>
                  <select class="form-control mb-2" id="booking" name="booking" aria-label="Default select example" required>
                     <option value="No">No</option>
                     <option value="Yes">Yes</option>
                  </select>
            </div>

            <div class="col-lg-6 my-2">
                  <label class="">Application Verify</label>
                   <select class="form-control mb-2" id="application_verify" name="application_verify" aria-label="Default select example" required>
                      <option value="No">No</option>
                      <option value="Yes">Yes</option>
                   </select>
            </div>


            <div class="col-lg-6 my-2">
                  <label class="">Refund Status </label>
                   <select class="form-control mb-2" id="refund_status" name="refund_status" aria-label="Default select example" required>
                      <option value="No">No</option>
                      <option value="Yes">Yes</option>
                   </select>
             </div>

             <div class="col-lg-6 my-2">
                  <label class="">Application email send </label>
                   <select class="form-control mb-2" id="email_send" name="email_send" aria-label="Default select example" required>
                      <option value="No">No</option>
                      <option value="Yes">Yes</option>
                   </select>
             </div>

         
         
            <ul id="edit_errorlist"> </ul>
         

         </div>

      <div class="mt-2" id="avatar"> </div>

             

         
          <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>

        <div class="mt-4">
            <button type="submit" id="edit_employee_btn" class="btn btn-success">Update </button>
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






<script>  
  $(document).ready(function(){ 

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });


        fetchAll();
         function fetchAll(){
            $.ajax({
             type:'GET',
             url:'/maintain/hall_fetch',
             datType:'json',
             beforeSend : function()
               {
               $('.loader_page').show();
               },
             success:function(response){
                    $('tbody').html('');
                   $('.x_content tbody').html(response);
                   $('.loader_page').hide();
                }
            });
         }
 
       // add new employee ajax request
       $("#add_employee_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
          type:'POST',
          url:'/maintain/hall_store',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          beforeSend : function()
               {
               $('.loader').show();
               $("#add_employee_btn").prop('disabled', true);
               },
          success: function(response){
            $('.loader').hide();
            $("#add_employee_btn").prop('disabled', false);
            if(response.status==200){
               $("#add_employee_form")[0].reset();
               $("#addEmployeeModal").modal('hide');
               $('#success_message').html("");
               $('#success_message').addClass('alert alert-success');
               $('#success_message').text(response.message);
               $('.error_hall').text('');
               $('#add_errorlist').html("");
               $('#add_errorlist').addClass('');
              
               fetchAll();
              }else if(response.status == 400){
                Swal.fire("Warning",response.message,"warning");
              }else if(response.status == 300){
                Swal.fire("Warning",response.message,"warning");
              }else if(response.status == 700){
                    $('#add_errorlist').html("");
                    $('#add_errorlist').addClass('alert alert-danger');
                    $.each(response.message,function(key,err_values){ 
                    $('#add_errorlist').append('<li>'+err_values+'</li>');
                    });     
              }
            
            
          }
        });

       
      });



        // edit employee ajax request
        $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
         //let id = $(this).attr('id');
         var id = $(this).val(); 
        $.ajax({
          type:'GET',
          url:'/maintain/hall_edit',
          data: {
            id: id,
          },
          success: function(response){
              console.log(response);
              $("#edit_hall").val(response.data.hall);
              $("#edit_university_id").val(response.data.university_id);
              $("#edit_email").val(response.data.email);
              $("#edit_phone").val(response.data.phone);
              $("#edit_password").val(response.data.password);
              $("#edit_status").val(response.data.status);
              $("#edit_level_custom1").val(response.data.level_custom1);
              $("#edit_level_custom2").val(response.data.level_custom2);
              $("#edit_level_registration").val(response.data.level_registration);
              $("#edit_level_custom3").val(response.data.level_custom3);
              $("#edit_level_profile_image").val(response.data.level_profile_image);
              $("#edit_level_file_name").val(response.data.level_file_name);
              $("#edit_frontend_link").val(response.data.frontend_link);
              $("#bazar").val(response.data.bazar);
               $("#payment").val(response.data.payment);
               $("#meal").val(response.data.meal);
               $("#member").val(response.data.member);
               $("#application").val(response.data.application);
               $("#resign").val(response.data.resign);
               $("#booking").val(response.data.booking);
               $("#others_access").val(response.data.others_access);
               $("#refund_status").val(response.data.refund_status);
               $("#storage").val(response.data.storage);
               $("#application_verify").val(response.data.application_verify);
               $("#edit_web_link").val(response.data.web_link);
               $("#email_send").val(response.data.email_send);
              $("#edit_id").val(response.data.id);
              $("#edit_web_status").val(response.data.web_status);
          }
        });
      });




       // update employee ajax request
       $("#edit_employee_form").submit(function(e) {
        e.preventDefault();
      
        const fd = new FormData(this);

        $.ajax({
          type:'POST',
          url:'/maintain/hall_update',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          beforeSend : function()
               {
               $('.loader').show();
               },
          success: function(response){
            if (response.status == 200){
               $('#success_message').html("");
               $('#success_message').addClass('alert alert-success');
               $('#success_message').text(response.message);
               $("#edit_employee_form")[0].reset();
               $("#editEmployeeModal").modal('hide');
               $('#edit_errorlist').html("");
               $('#edit_errorlist').addClass('');
               fetchAll();
             }else if(response.status == 400){
                 Swal.fire("Warning",response.message, "warning");
             }else if(response.status == 300){
                 Swal.fire("Warning",response.message, "warning");
             }else if(response.status == 700){
                    $('#edit_errorlist').html("");
                    $('#edit_errorlist').addClass('alert alert-danger');
                    $.each(response.message,function(key,err_values){ 
                    $('#edit_errorlist').append('<li>'+err_values+'</li>');
                    });     
              }
          
            $('.loader').hide();
          }
         
        });
      
      });


        
        // delete employee ajax request
        $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        var id = $(this).val(); 
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url:'/maintain/hall_delete',
              method: 'delete',
              data: {
                id: id,
              },
              success: function(response) {
                //console.log(response);
                 if(response.status == 200){
                    Swal.fire("Warning",response.message, "warning");
                 }else if(response.status == 300)
                    Swal.fire("Deleted",response.message, "success");
                   fetchAll();
              }
            });
          }
        })
      });






      function fetch_data(page, sort_type="", sort_by="", search="",range=""){
    $.ajax({
    url:"/maintain/hall/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&search="+search+"&range="+range,
    beforeSend : function()
               {
               $('.loader_page').show();
               },
    success:function(data)
    {
      $('.loader_page').hide();
    $('tbody').html('');
    $('.x_content tbody').html(data);
  
    }
    });
     }


       
$(document).on('keyup', '#search', function(){
    var search = $('#search').val();
    var column_name = $('#hidden_column_name').val();
    var sort_type = $('#hidden_sort_type').val();
    var page = $('#hidden_page').val();
    var range = $('#range').val();
    fetch_data(page, sort_type, column_name, search,range);
  });


  $(document).on('click', '.pagin_link a', function(event){
       event.preventDefault();
       var page = $(this).attr('href').split('page=')[1];
       var column_name = $('#hidden_column_name').val();
       var sort_type = $('#hidden_sort_type').val();
       var search = $('#search').val();
       var range = $('#range').val();
      fetch_data(page, sort_type, column_name, search,range);
    }); 


    $(document).on('click', '.sorting', function(){
          var column_name = $(this).data('column_name');
          var order_type = $(this).data('sorting_type');
          var reverse_order = '';
            if(order_type == 'asc')
             {
            $(this).data('sorting_type', 'desc');
            reverse_order = 'desc';
            $('#'+column_name+'_icon').html('<i class="fas fa-sort-amount-down"></i>');
             }
            else
            {
            $(this).data('sorting_type', 'asc');
            reverse_order = 'asc';
            $('#'+column_name+'_icon').html('<i class="fas fa-sort-amount-up-alt"></i>');
            }
           $('#hidden_column_name').val(column_name);
           $('#hidden_sort_type').val(reverse_order);
           var page = $('#hidden_page').val();
           var search = $('#search').val();
           var range = $('#range').val();
           fetch_data(page, reverse_order, column_name, search, range);
          });




   

  $(document).on('change', '#range', function(){
    var search = $('#search').val();
    var column_name = $('#hidden_column_name').val();
    var sort_type = $('#hidden_sort_type').val();
    var page = $('#hidden_page').val();
    var range = $('#range').val();
    fetch_data(page, sort_type, column_name, search,range);
  });


	




});

</script>





 


 







@endsection 