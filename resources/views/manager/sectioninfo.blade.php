@extends('manager.layout')
@section('title','Manager Panel')
@section('section','active')
@section('content')

      <div class="row mt-3 mb-0 mx-2">
                <div class="col-sm-3 my-2"> <h5 class="mt-0">Section  Information : {{$hallinfo->cur_year}}-{{$hallinfo->cur_month}}-{{$hallinfo->cur_section}} </h5></div>                    
                
                @if(manager_info()['role']=='admin')
                 <div class="col-sm-3 my-2">
                    <div class="d-grid gap-2 d-flex justify-content-start"> 
                        <h4>  <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addEmployeeModalday">Invoice Delete</button> </h4>
                    </div>    
                 </div>

               
                <div class="col-sm-3 my-2 ">
                   <div class="d-grid gap-3 d-flex justify-content-end">
                         <a href="{{url('manager/new_invoice_create')}}" onclick="return confirm('Are you sure you want to create new invoice')" class="btn btn-info">Invoice Create </a>
                    </div>
                </div>
                @endif

                <div class="col-sm-3 my-2 ">
                   <div class="d-grid gap-3 d-flex justify-content-end">
                       <a href="{{url('manager/section_update')}}" class="btn btn-warning">Refresh </a>
                   </div>
                </div>
             

                @if(Session::has('success'))
                  <div  class="alert alert-success"> {{Session::get('success')}}</div>
                   @endif
 
                     @if(Session::has('fail'))
                 <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
                  @endif
    </div> 
    
    
    <div class="row my-2">
    <div class="col-md-9">
    <div id="success_message"></div>
    </div>
    <div class="col-md-3">
     <div class="form-group">
      <input type="text" name="search" id="search" placeholder="Enter Search " class="form-control form-control-sm"  autocomplete="off"  />
     </div>
    </div>
   </div>
				
<div class="table-responsive">		
  <div class="x_content">
  <table id="employee_data"  class="table table-bordered table-hover">
    <thead>
     <tr>
         <th width="10%">Card No</th>
         <th width="10%">Name</th>
         <th width="10%">Registration/ Seat No</th>
         <th width="10%">Invoice No</th>
		     <th width="10%">Invoice Month</th>
		     <th width="10%">Invoice Section</th>
         <th width="10%">Previous Reserve Amount</th>
		     <th width="10%">Previous refund total</th>
		     <th width="10%">Previous month due</th>
         <th width="10%">Edit</th>

         <th width="10%">Hostel Fee</th>
		     <th width="10%">Total Section day </th>
	    	 <th width="10%">Breakfast rate</th>
         <th width="10%">Lunch rate</th>
         <th width="10%">Dinner rate</th>
		     <th width="10%">Total Meal Amount </th>

		     <th width="10%">Employee </th>
		     <th width="10%">Friday</th>
	    	 <th width="10%">Feast</th>
		     <th width="10%">Welfare</th>
		     <th width="10%">Others</th> 

		     <th width="10%">Gass</th> 
         <th width="10%">Electricity</th> 
         <th width="10%">Tissue</th> 
         <th width="10%">Water</th> 
         <th width="10%">Dirt</th> 
         <th width="10%">Wifi</th> 

	    	 <th width="10%">Card Fee</th>
         <th width="10%">Security Money</th>
         <th width="10%">Service Charge</th>
         <th width="10%">Meeting Penalty</th>
         <th width="10%">Total Others Amount</th>
		     <th width="10%">Total Amount</th>
         <th width="10%">Total Withdraw Amount</th>
         <th width="10%">Withdraw Status</th>
         <th width="10%">Total Inactive Meal Amount</th>
         <th width="10%">Paybale Amount</th>

         <th width="10%">First Meal No</th>
         <th width="10%">First Meal Amount</th>
         <th width="10%">First Others Amount</th>
         <th width="10%">First Paybale Amount</th>
         <th width="10%">First Paybale Status</th>

         <th width="10%">Second Meal No</th>
         <th width="10%">Second Meal Amount</th>
         <th width="10%">Second Others Amount</th>
         <th width="10%">Secound Paybale Amount</th>
         <th width="10%">Second Paybale Status</th>

		     <th width="10%">Breakfast ON Meal</th>
         <th width="10%">Breakfast OFF Meal</th>
         <th width="10%">Breakfast Inactive Meal</th>

         <th width="10%">Lunch ON Meal</th>
         <th width="10%">Lunch OFF Meal</th>
         <th width="10%">Lunch Inactive Meal</th>

         <th width="10%">Dinner ON Meal</th>
         <th width="10%">Dinner OFF Meal</th>
         <th width="10%">Dinner Inactive Meal</th>

        <th width="10%">Total ON Meal Amount</th>
       
     

      <th width="10%">Refund Breakfast rate</th>
      <th width="10%">Refund Lunch rate</th>
      <th width="10%">Refund Dinner rate</th>
      <th width="10%">Reduce Meal Amount</th>
      <th width="10%">Total OFF Meal Amount</th>

     <th width="10%">Refund feast </th>
     <th width="10%">Refund Welfare </th>
     <th width="10%">Refund friday</th>
		 <th width="10%">Refund employee</th>
		 <th width="10%">Refund Others</th>

		 <th width="10%">Refund tissue</th>
     <th width="10%">Refund gass</th>
     <th width="10%">Refund electricity</th>
     <th width="10%">Refund water</th>
     <th width="10%">Refund wifi</th>
     <th width="10%">Refund dirt</th>

     <th width="10%">Total refund</th>
		 <th width="10%">Due amount</th>
     <th width="10%">Reserve amount</th>


    </tr>
    </thead>
    <tbody>
       
    </tbody>
  </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
 
 
</div>
</div>


<script>  
  $(document).ready(function(){ 

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });


        fetchAll();
         function fetchAll(){
            $.ajax({
             type:'GET',
             url:'/manager/section_fetch',
             datType:'json',
             success:function(response){
                    $('tbody').html('');
                    $('.x_content tbody').html(response);
                }
            });
         }



     // update employee ajax request
     $("#edit_employee_form").submit(function(e) {
      e.preventDefault();

      const fd = new FormData(this);

      $.ajax({
        type: 'POST',
        url: '/manager/section_update_id',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend: function() {
          $('.loader').show();
        },
        success: function(response) {
          if (response.status == 200) {
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-success');
            $('#success_message').text(response.message);
            $("#edit_employee_form")[0].reset();
            $("#EditModal").modal('hide');
            $('.edit_err_registration').text('');
            $('.edit_err_phone').text('');
            $('.edit_err_email').text('');
            fetchAll();
          } else if (response.status == 300) {
            Swal.fire("Warning", response.message, "warning");
          } else if (response.status == 500) {
            Swal.fire("Warning", response.message, "warning");
          } else if (response.status == 700) {
            $('.edit_err_pre_reserve_amount').text(response.message.pre_reserve_amount);
            $('.edit_err_pre_refund').text(response.message.pre_refund);
            $('.edit_err_pre_monthdue').text(response.message.pre_monthdue);
            $('.edit_err_hostel_fee').text(response.message.hostel_fee);
          }

          $('.loader').hide();
        }

      });

    });

      

         
   $(document).on('click', '.edit', function(e) {
      e.preventDefault();
      var view_id = $(this).val();
      $('#EditModal').modal('show');
      $.ajax({
        type: 'GET',
        url: '/manager/section_view/' + view_id,
        success: function(response) {
          console.log(response);
          if (response.status == 404) {
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-danger');
            $('#success_message').text(response.message);
          } else {
            $('#edit_id').val(response.value.id);

            $('#edit_pre_reserve_amount').val(response.value.pre_reserve_amount);
            $('#edit_pre_refund').val(response.value.pre_refund);
            $('#edit_pre_monthdue').val(response.value.pre_monthdue);
            $('#edit_hostel_fee').val(response.value.hostel_fee);
          }
        }
      });
    });



 
      
      function fetch_data(page, sort_type="", sort_by="", search=""){
        $.ajax({
        url:"/manager/section/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&search="+search,
        success:function(data)
        {
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
        fetch_data(page, sort_type, column_name, search);
      });


      $(document).on('click', '.pagin_link a', function(event){
           event.preventDefault();
           var page = $(this).attr('href').split('page=')[1];
           var column_name = $('#hidden_column_name').val();
           var sort_type = $('#hidden_sort_type').val();
           var search = $('#search').val();
          fetch_data(page, sort_type, column_name, search);
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
          fetch_data(page, reverse_order, column_name, search);
          });


	




});

</script>


{{-- add new Student modal start --}}
<div class="modal fade" id="addEmployeeModalday" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Invoice Delete Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="{{url('/manager/invoice_all_delete')}}"  class="myform"  enctype="multipart/form-data" >
           {!! csrf_field() !!}

        <div class="modal-body p-4 bg-light">
          <ul class="alert alert-warning d-none" id="add_form_errlist"></ul>

                <label><b> Year-Month(2024-03) </b></label><br>
                 <input type="month" name="month"  class="form-control" required><br>

                 <label><b>Section  </b></label><br>
	                 <select name ="section" class="form-control" required>
				             <option   value="">Select one</option>
					                 <option   value="A">A</option>	
                           <option   value="B">B</option>					 
			               </select>	<br>

                    
              


     

                <p class="text-danger err_product"></p>



          <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div><br>


          <input type="submit" value="Submit" id="submit" class=" btn btn-success" />

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
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="edit_employee_form" enctype="multipart/form-data">
        <input type="hidden" name="edit_id" id="edit_id">
        <div class="modal-body p-4 bg-light">
          <div class="row">



            <div class="col-lg-12 my-2">
              <label> Previous Reserve Amount</label>
              <input name="pre_reserve_amount" type="number" id="edit_pre_reserve_amount" class="form-control" value="" required />
              <p class="text-danger edit_err_pre_reserve_amount"></p>
            </div>



            <div class="col-lg-12 my-2">
              <label> Previous Refund Amount</label>
              <input name="pre_refund" type="number" id="edit_pre_refund" class="form-control" value="" required />
              <p class="text-danger edit_err_pre_refund"></p>
            </div>


            <div class="col-lg-12 my-2">
              <label> Previous Month Due</label>
              <input name="pre_monthdue" type="number" id="edit_pre_monthdue" class="form-control" value="" required />
              <p class="text-danger edit_err_pre_monthdue"></p>
            </div>

    
            <div class="col-lg-12 my-2">
              <label> Hostel Fee</label>
              <input name="hostel_fee" type="number" id="edit_hostel_fee" class="form-control" value="" required />
              <p class="text-danger edit_err_hostel_fee"></p>
            </div>



          </div>

          <div class="mt-2" id="avatar">

          </div>


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






@endsection 