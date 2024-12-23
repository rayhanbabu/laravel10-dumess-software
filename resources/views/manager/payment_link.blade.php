@extends('manager.layout')
@section('title','Manager Panel')
@section('payment_link','active')
@section('content')

  <div class="row my-2">
     <div class="col-md-9">
       <h5> Payment Link Information </h5>
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
         <th width="10%">Invoice No</th>
		     <th width="10%">Invoice Month</th>
         <th width="10%">Payble 1 Tran ID</th>
         <th width="10%">Payble 1</th>
         <th width="10%">Payble 1 Status</th>
         <th width="10%">Payble 1 with (2.50%)</th>
         <th width="10%">Payble 1 Link</th>
         <th width="10%">Payble 2 Tran ID</th>
         <th width="10%">Payble 2</th>
         <th width="10%">Payble 2 Status</th>
         <th width="10%">Payble 2 with (2.50%)</th>
         <th width="10%">Payble 2 Link</th>
       

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
             url:'/manager/payment_link_fetch',
             datType:'json',
             success:function(response){
                    $('tbody').html('');
                    $('.x_content tbody').html(response);
                }
            });
         }

      
      function fetch_data(page, sort_type="", sort_by="", search=""){
        $.ajax({
        url:"/manager/payment_link/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&search="+search,
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
              <label>  Security Money</label>
              <input name="security" type="number" id="edit_security" class="form-control" value="" required />
              <p class="text-danger edit_err_security"></p>
            </div>

    
            <div class="col-lg-12 my-2">
              <input name="hostel_fee" type="hidden" id="edit_hostel_fee" class="form-control" value="" required />
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