@extends('manager.layout')
@section('page_title','Maintain Panel')
@section('ex_payment'.$invoice_status,'active')
@section('content')

@if($invoice_status=='5')

  <div class="row mt-3 mb-0 mx-2">
      <div class="col-sm-3 my-2">
             <h5 class="mt-0"> Ex member Payment Info</h5>
      </div>

 
  @if(Session::has('success'))
          <div class="alert alert-success"> {{Session::get('success')}}</div>
  @endif

  @if(Session::has('fail'))
  <div class="alert alert-danger"> {{Session::get('fail')}}</div>
  @endif
</div>


<div class="row my-2">
  <div class="col-md-9">
    <div id="success_message"></div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <input type="text" name="search" id="search" placeholder="Enter Search " class="form-control form-control-sm" autocomplete="off" />
    </div>
  </div>
</div>

<div class="table-responsive">
  <div class="x_content">
    <table id="employee_data" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th width="">Card No</th>
          <th width="">Invoice Month-Section</th>
          <th width="">Name</th>
          <th width="">Reg/Seat No</th>
          <th width="">Invoice No</th>  
          <th width="">Pre Refund</th>
          <th width="">Pre Reserve</th>   
          <th width="">Security Money</th> 
          <th width="">Pre Due</th> 
          <th width="">Payment Amount(+Hall Get) (-Member Get) </th>
          <th width="">Payment Status </th>
          <th width="">Payemnt by </th>
          <th width=""> </th>
   


        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>

      <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
      <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="registration"/>
      <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc"/>


  </div>
</div>


<script>
  $(document).ready(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


    fetch();

    function fetch() {
      $.ajax({
        type: 'GET',
        url: '/manager/ex_payment_fetch/{{$invoice_status}}',
        datType: 'json',
        success: function(response) {
          $('tbody').html('');
          $('.x_content tbody').html(response);
        }
      });
    }




       $(document).on('click', '.withdraw', function(e){ 
            e.preventDefault(); 
            var edit_id = $(this).val(); 
            $.ajax({
             type:'GET',
             url:'/manager/payment1_view/'+edit_id,
             success:function(response){
               // console.log(response);
                if(response.status == 404){
                  $('#success_message').html("");
                  $('#success_message').addClass('alert alert-danger');
                  $('#success_message').text(response.message);
                }else{
                  $('#WithModal').modal('show');
                  $('#withdraw_id').val(response.value.id);
                  $('#withdraw_name').text(response.value.name);
                  $('#withdraw').text(response.value.withdraw);
                  $('#withdraw_registration').text(response.value.registration);                
                }
             }
          });
       });


       $(document).on('submit', '#withdraw_form', function(e){ 
        e.preventDefault(); 
        //var invoice_id=$('#invoice_id').val();

        let editData=new FormData($('#withdraw_form')[0]);
        $.ajax({
             type:'POST',
             url:'/manager/withdraw_update',
             data:editData,
             contentType: false,
             processData:false,
             beforeSend : function()
               {
               $('.loader').show();
               $("#withdraw_btn").prop('disabled', true)
               },
             success:function(response){
              if(response.status == 200){
                      $('#success_message').html("");
                      $('#success_message').addClass('alert alert-success');
                      $('#success_message').text(response.message)
                      $('#WithModal').modal('hide');
                      fetch(); 
                   }else{
                      $('#success_message').html("");
                      $('#success_message').addClass('alert alert-success');
                      $('#success_message').text(response.message)
                      $('#WithModal').modal('hide');
                    }
                  $("#withdraw_btn").prop('disabled', false) 
                  $('.loader').hide();
             }
          });
       });








    function fetch_data(page, sort_type = "", sort_by = "", search = "") {
      $.ajax({
        url: "/manager/ex_payment/{{$invoice_status}}/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&search=" + search,
        success: function(data) {
          $('tbody').html('');
          $('.x_content tbody').html(data);
        }
      });
    }


    $(document).on('keyup', '#search', function() {
      var search = $('#search').val();
      var column_name = $('#hidden_column_name').val();
      var sort_type = $('#hidden_sort_type').val();
      var page = $('#hidden_page').val();
      fetch_data(page, sort_type, column_name, search);
    });


    $(document).on('click', '.pagin_link a', function(event) {
      event.preventDefault();
      var page = $(this).attr('href').split('page=')[1];
      var column_name = $('#hidden_column_name').val();
      var sort_type = $('#hidden_sort_type').val();
      var search = $('#search').val();
      fetch_data(page, sort_type, column_name, search);
    });


    $(document).on('click', '.sorting', function() {
      var column_name = $(this).data('column_name');
      var order_type = $(this).data('sorting_type');
      var reverse_order = '';
      if (order_type == 'asc') {
        $(this).data('sorting_type', 'desc');
        reverse_order = 'desc';
        $('#' + column_name + '_icon').html('<i class="fas fa-sort-amount-down"></i>');
      } else {
        $(this).data('sorting_type', 'asc');
        reverse_order = 'asc';
        $('#' + column_name + '_icon').html('<i class="fas fa-sort-amount-up-alt"></i>');
      }
      $('#hidden_column_name').val(column_name);
      $('#hidden_sort_type').val(reverse_order);
      var page = $('#hidden_page').val();
      var search = $('#search').val();
      fetch_data(page, reverse_order, column_name, search);
    });




  });
</script>


{{-- withdraw start --}}
<div class="modal fade" id="MemberModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Block Member </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" id="member_form" enctype="multipart/form-data" >
        <input type="hidden" name="edit_id" id="edit_id">
         <div class="modal-body p-4 bg-light">
        
          <input type="hidden" name="member_edit_id" id="member_edit_id" value="" />
           <input type="hidden" name="member_status" id="member_status" value="" />
          
               	  		  
			          <h3>Are you sure change status ??</h3>   
               
         <br><br>

         <button type="submit" id="member_btn" class="btn btn-success">Update </button>
	  
         <div class="loader">
                 <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
			 </div><br>

       
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
         
        </div>
      </form>
    </div>
  </div>
</div>

{{-- withdraw modal end --}}




{{-- withdraw start --}}
<div class="modal fade" id="WithModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Refund Withdraw </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" id="withdraw_form" enctype="multipart/form-data" >

         <div class="modal-body p-4 bg-light">
        
         <input type="hidden" name="withdraw_id" id="withdraw_id" value="" />
               <b> name : <span id="withdraw_name"> </span> </b>	<br>  
               <b> Reg/Seat No : <span id="withdraw_registration"> </span> </b>	<br> 
               <b> Withdraw Amount : <span id="withdraw"> </span>TK </b>	<br> 
               <h5>Are you sure change Withdraw  status ??</h5>    
               <br> 
               <button type="submit" id="withdraw_btn" class="btn btn-success">Update </button>
	  
         <div class="loader">
                 <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
			 </div><br>

       
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
         
        </div>
      </form>
    </div>
  </div>
</div>

{{-- withdraw modal end --}}


@else
    <h1>Page not Found</h1>
   @endif


@endsection 