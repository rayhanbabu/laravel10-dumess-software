@extends('manager.layout')
@section('page_title','Manager Panel')
@section('building','active')
@section('content')

      <div class="row mt-3 mb-0 mx-2">
                 <div class="col-sm-3 my-2"> <h5 class="mt-0">Seat View </h5></div>
                     
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
       <div class="col-md-6"> </div>       
            
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

         <th width="20%" class="sorting" data-sorting_type="asc" data-column_name="seat_name" style="cursor: pointer">Seat Name 
              <span id="seat_name_icon" ><i class="fas fa-sort-amount-up-alt"></i></span> </th>
          <th  width="15%"> Building </th>
          <th  width="15%"> Floor </th>
          <th  width="15%"> Flat </th>
          <th  width="15%"> Room </th>
          <th  width="15%"> Price </th>
          <th  width="15%"> Service Charge </th>
          <th  width="15%">  Status </th>
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
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
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

            
          <div class="col-lg-6 my-2">
                  <label for="roll">Building  Name <span style="color:red;"> * </span> </label>
              <select class="form-select" id="building_id" name="building_id" aria-label="Default select example " required>
                       <option  value="">Select One </option>
                        @foreach($building as $row)
                            <option   value="{{$row->id}}">{{$row->building_name}}</option>
                        @endforeach  
               </select>
           </div>


          <div class="col-lg-6 my-2">
               <label> Room Name  <span style="color:red;"> * </span> </label>
                <select class="form-select" aria-label="Default select example" name="room_id"  id="room_id">
               
                 </select>     
           </div>

          <div class="col-lg-12 my-2">
                <label for="roll">Seat Name <span style="color:red;"> * </span></label>
                <input type="text" name="seat_no" id="seat_no" class="form-control" placeholder="" required>
           </div>


            <div class="col-lg-12 my-2">
                  <label for="roll">Seat Price <span style="color:red;"> * </span></label>
                  <input type="number" name="seat_price" id="seat_price" class="form-control" placeholder="" required>
            </div>

              
            <div class="col-lg-12 my-2">
                  <label for="roll">Service Charge <span style="color:red;"> * </span></label>
                  <input type="number" name="service_charge" id="service_charge" class="form-control" placeholder="" required>
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
     
         <div class="modal-body p-4 bg-light">
          <div class="row">
          <input type="hidden" name="edit_id" id="edit_id">


          <div class="col-lg-6 my-2">
                  <label for="roll">Building  Name  </label>
              <select class="form-select" id="edit_building_id" name="edit_building_id" aria-label="Default select example ">
                       <option  value="">Select One </option>
                        @foreach($building as $row)
                            <option   value="{{$row->id}}">{{$row->building_name}}</option>
                        @endforeach  
               </select>
           </div>


          <div class="col-lg-6 my-2">
               <label> Room Name   </label>
                  <select class="form-select" aria-label="Default select example" name="edit_room_id"  id="edit_room_id">
               
                 </select>     
           </div>



         <div class="col-lg-12 my-2">     
             <input type="text" name="building_name" id="edit_building_name" class="form-control" placeholder="" readonly>
         </div>

         <div class="col-lg-12 my-2">     
             <input type="text" name="room_name" id="edit_room_name" class="form-control" placeholder="" readonly>
         </div>

             <div class="col-lg-12 my-2">
                 <label for="roll">Seat Name<span style="color:red;"> * </span></label>
                 <input type="text" name="seat_name" id="edit_seat_name" class="form-control" placeholder="" required>
              </div>

              <div class="col-lg-12 my-2">
                  <label for="roll">Seat Price <span style="color:red;"> * </span></label>
                  <input type="number" name="seat_price" id="edit_seat_price" class="form-control" placeholder="" required>
              </div>

              <div class="col-lg-12 my-2">
                  <label for="roll">Service Charge <span style="color:red;"> * </span></label>
                  <input type="number" name="service_charge" id="edit_service_charge" class="form-control" placeholder="" required>
              </div>  

            <div class="col-lg-6 my-2">
                  <label class=""><b>Seat Status</b></label>
                   <select class="form-select" name="seat_status" id="edit_seat_status" aria-label="Default select example">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                  </select>
            </div>


            <div class="col-lg-6 my-2">
                  <label class=""><b>Price Status</b></label>
                   <select class="form-select" name="price_status" id="edit_price_status" aria-label="Default select example">
                      <option value="1"> Not Negotiable</option>
                      <option value="0">Negotiable</option>
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



       $('#building_id').on('change', function () {
                var building_id = this.value;
                 //console.log(building_id);
                $('#place').html('');
                $.ajax({
                    url: '/manager/room_fetch_building?id='+building_id,
                    type: 'get',
                    success: function (res) {
                        $('#room_id').html('<option value="" selected disabled>Select Place</option>');
                        $.each(res, function (key, value) {
                            $('#room_id').append('<option value="' + value
                                .id + '">' + value.room_name + '</option>');
                        });
                    }
                });
         });


         $('#edit_building_id').on('change', function () {
                var building_id = this.value;
                 //console.log(building_id);
                $('#place').html('');
                $.ajax({
                    url: '/manager/room_fetch_building?id='+building_id,
                    type: 'get',
                    success: function (res) {
                        $('#edit_room_id').html('<option value="" selected disabled>Select Place</option>');
                        $.each(res, function (key, value) {
                            $('#edit_room_id').append('<option value="' + value
                                .id + '">' + value.room_name + '</option>');
                        });
                    }
                });
         });


    
         fetchAll();
         function fetchAll(){
            $.ajax({
             type:'GET',
             url:'/manager/seat_fetch',
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
          url:'/manager/seat_store',
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
          url:'/manager/seat_edit',
          data: {
            id: id,
          },
          success: function(response){
               //console.log(response);
               $("#building_id").val(response.data.building_id);
               $("#edit_room_id").val(response.data.room_id);
               $("#edit_seat_name").val(response.data.seat_name);
               $("#edit_seat_price").val(response.data.seat_price);
               $("#edit_service_charge").val(response.data.service_charge);
               $("#edit_seat_status").val(response.data.seat_status);
               $("#edit_room_name").val(response.data.room_name);
               $("#edit_building_name").val(response.data.building_name);
               $("#edit_price_status").val(response.data.price_status);
               $("#edit_id").val(response.data.id);
          }
        });
      });




       // update employee ajax request
       $("#edit_employee_form").submit(function(e) {
        e.preventDefault();
      
        const fd = new FormData(this);

        $.ajax({
          type:'POST',
          url:'/manager/seat_update',
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
        console.log(id);
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
              url:'/manager/seat_delete',
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
      url:"/manager/seat/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&search="+search+"&range="+range,
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