@extends('manager.layout')
@section('page_title','Maintain Panel')
@section('payment'.$invoice_status,'active')
@section('content')

@if($invoice_status=='1' )
<div class="row mt-3 mb-0 mx-2">
  <div class="col-sm-3 my-2">
       <h5 class="mt-0">Payment Info : {{$hallinfo->cur_year}}-{{$hallinfo->cur_month}}-{{$hallinfo->cur_section}} </h5>
  </div>

  @if($invoice_status=='1')
  <div class="col-sm-6 my-2">
  <form action="{{url('pdf/daily_payment')}}" method="POST" enctype="multipart/form-data">
     {!! csrf_field() !!}
       <div class="d-grid gap-2 d-flex justify-content-start">
               <select class="form-control" name="type"  aria-label="Default select example"  required >
                       <option value="1">1st Payment</option>
                       <option value="2">2nd Payment</option>
                       <option value="3">All Payment</option>
               </select>

               <input type="date" name="date" class="form-control" value="" required>  
        </div>
  </div>

   <div class="col-sm-3 my-2 ">
      <div class="d-grid gap-3 d-flex justify-content-end">
              <button type="submit" name="search" class="btn btn-primary"> Daily payment pdf  </button>
              </form>

       </div>
 
  </div>

      @else
      @endif

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

<div class="overflow">
  <div class="x_content">
    <table id="employee_data" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th width="">Card No</th>
          <th width="">Name</th>
          <th width="">Reg/Seat No</th>
          <th width="">Invoice No</th>

      @if($invoice_status==1)
          <th width="">Total Payable Amount </th>
          <th width="">First Payable Amount </th>
          <th width="">First Payable Status </th>

          <th width="">Second Payable Amount </th>
          <th width="">Second Payable Status </th>

          <th width="">Refund withdraw </th>
          <th width="">Refund withdraw Status </th>
          <th width="">View</th>

          <th width="">First Payable By </th>
          <th width="">Second Payable By </th>
          <th width="">withdraw by </th>

           <th width="">Status</th>
           <th width="">Print</th>
       
      @elseif($invoice_status==5)      
          <th width="">Refund withdraw </th>
          <th width="">Refund withdraw Status </th>
          <th width="">withdraw by </th>
      @endif


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
        url: '/manager/payment_fetch/{{$invoice_status}}',
        datType: 'json',
        success: function(response) {
          $('tbody').html('');
          $('.x_content tbody').html(response);
        }
      });
    }



       $(document).on('click', '.payment1', function(e){ 
            e.preventDefault(); 
            var edit_id = $(this).val(); 
            $.ajax({
             type:'GET',
             url:'/manager/payment1_view/'+edit_id,
             success:function(response){
                console.log(response);
                if(response.status == 404){
                   $('#success_message').html("");
                   $('#success_message').addClass('alert alert-danger');
                   $('#success_message').text(response.message);
                }else{
                   $('#payment1_Modal').modal('show');
                   $('#payment1_id').val(response.value.id);
                   $('#payment1_name').text(response.value.name);
                   $('#payment1_amount').text(response.value.payble_amount1);
                   $('#payment1_registration').text(response.value.registration);            
                }
             }
          });
       });



       $(document).on('submit', '#payment1_form', function(e){ 
        e.preventDefault(); 
        //var invoice_id=$('#invoice_id').val();

        let editData=new FormData($('#payment1_form')[0]);
        $.ajax({
             type:'POST',
             url:'/manager/payment1_update',
             data:editData,
             contentType: false,
             processData:false,
             beforeSend : function()
               {
               $('.loader').show();
               $("#payment1_btn").prop('disabled', true)
               },
             success:function(response){
                   //console.log(response);
                  if(response.status == 200){
                     $('#success_message').html("");
                     $('#success_message').addClass('alert alert-success');
                     $('#success_message').text(response.message)
                     $('#payment1_Modal').modal('hide');
                     fetch(); 
                   }else{
                     $('#success_message').html("");
                     $('#success_message').addClass('alert alert-success');
                     $('#success_message').text(response.message)
                     $('#payment1_Modal').modal('hide');
                    }
                  $("#payment1_btn").prop('disabled', false) 
                  $('.loader').hide();
             }
          });
       });


       $(document).on('click', '.payment2', function(e){ 
            e.preventDefault(); 
            var edit_id = $(this).val(); 
            $.ajax({
             type:'GET',
             url:'/manager/payment1_view/'+edit_id,
             success:function(response){
                console.log(response);
                if(response.status == 404){
                   $('#success_message').html("");
                   $('#success_message').addClass('alert alert-danger');
                   $('#success_message').text(response.message);
                }else{
                   $('#payment2_Modal').modal('show');
                   $('#payment2_id').val(response.value.id);
                   $('#payment2_name').text(response.value.name);
                   $('#payment2_amount').text(response.value.payble_amount2);
                   $('#payment2_registration').text(response.value.registration);            
                }
             }
          });
       });



       $(document).on('submit', '#payment2_form', function(e){ 
        e.preventDefault(); 
        
        let editData=new FormData($('#payment2_form')[0]);
        $.ajax({
             type:'POST',
             url:'/manager/payment2_update',
             data:editData,
             contentType: false,
             processData:false,
             beforeSend : function()
               {
               $('.loader').show();
               $("#payment2_btn").prop('disabled', true)
               },
             success:function(response){
                   //console.log(response);
                   if(response.status == 200){
                      $('#success_message').html("");
                      $('#success_message').addClass('alert alert-success');
                      $('#success_message').text(response.message)
                      $('#payment2_Modal').modal('hide');
                      fetch(); 
                   }else{
                      $('#success_message').html("");
                      $('#success_message').addClass('alert alert-success');
                      $('#success_message').text(response.message)
                      $('#payment2_Modal').modal('hide');
                    }
                  $("#payment2_btn").prop('disabled', false) 
                  $('.loader').hide();
             }
          });
       });


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



       
       $(document).on('click', '.memberblock', function(e){ 
            e.preventDefault(); 
            var edit_id = $(this).val(); 
            var status = $(this).data("status");

            $('#member_status').val(status);
            $('#member_edit_id').val(edit_id);
            $('#MemberModal').modal('show');
           
       });



       $(document).on('submit', '#member_form', function(e){ 
        e.preventDefault(); 
        //var invoice_id=$('#invoice_id').val();

        let editData=new FormData($('#member_form')[0]);
        $.ajax({
             type:'POST',
             url:'/manager/member_status_edit',
             data:editData,
             contentType: false,
             processData:false,
             beforeSend : function()
               {
               $('.loader').show();
               $("#member_btn").prop('disabled', true)
               },
             success:function(response){
                 console.log(response);
                  if(response.status == 400){
                    $('.edit_err_dureg').text(response.validate_err.dureg);
                  }else{
                    $('#edit_form_errlist').html("");
                    $('#edit_form_errlist').addClass('d-none');
                    $('#success_message').html("");
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message)
                    $('#MemberModal').modal('hide');
                    fetch();
                  }
                  $("#member_btn").prop('disabled', false) 
                  $('.loader').hide();
             }
          });
       });
    








    $(document).on('click', '.view_all', function(e) {
      e.preventDefault();
      var view_id = $(this).val();
      //alert(edit_id)
      $('#ViewModal').modal('show');
      $.ajax({
        type: 'GET',
        url: '/manager/payment_view/' + view_id,
        success: function(response) {
          //console.log(response);
          if (response.status == 404) {
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-danger');
            $('#success_message').text(response.message);
          } else {
            $('#view_name').text(response.value.name);
            $('#view_card').text(response.value.card_id);
            $('#view_dureg').text(response.value.dureg);
            $('#view_pre_duemeal').text(response.value.pre_duemeal);
            $('#view_pre_duemealrate').text(response.value.pre_duemealrate);
            $('#view_pre_duemealamount').text(response.value.pre_duemealamount);
            $('#view_pre_dayfeast').text(response.value.pre_dayfeast);
            $('#view_pre_employee').text(response.value.pre_employee);
            $('#view_pre_friday').text(response.value.pre_friday);
            $('#view_others').text(response.value.pre_others);
            $('#view_welfare').text(response.value.pre_welfare);
            $('#view_pre_refund').text(response.value.pre_refund);
            $('#view_pre_monthdue').text(response.value.pre_monthdue);
            $('#view_security').text(response.value.security);
            $('#view_cur_budget').text(response.value.cur_budget);
            $('#view_cur_total').text(response.value.cur_total);
            $('#view_payment2').text(response.value.cur_payment);
            $('#view_payment1').text(response.value.cur_payment1);
            $('#view_withdraw').text(response.value.withdraw);

          }
        }
      });
    });





    function fetch_data(page, sort_type = "", sort_by = "", search = "") {
      $.ajax({
        url: "/manager/payment/{{$invoice_status}}/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&search=" + search,
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




{{-- payment 1 start --}}
<div class="modal fade" id="payment1_Modal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment 1 </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" id="payment1_form" enctype="multipart/form-data" >
       
         <div class="modal-body p-4 bg-light">
        
               <input type="hidden" name="payment1_id" id="payment1_id" value="" />
               <b> name : <span id="payment1_name"> </span> </b>	<br>  
               <b> Reg/Seat No : <span id="payment1_registration"> </span> </b>	<br> 
               <b> First payable Amount : <span id="payment1_amount"> </span>TK </b>	<br> 
               <h4>Are you sure change 1st Payment  status ??</h4>    
          <br> 

         <button type="submit" id="payment1_btn" class="btn btn-success">Update </button>
	  
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
{{-- payment 1 modal end --}}



{{-- payment 2 start --}}
<div class="modal fade" id="payment2_Modal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment 2 </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" id="payment2_form" enctype="multipart/form-data" >

         <div class="modal-body p-4 bg-light">

               <input type="hidden" name="payment2_id" id="payment2_id" value="" />
               <b> name : <span id="payment2_name"> </span> </b>	<br>  
               <b> Reg/Seat No : <span id="payment2_registration"> </span> </b>	<br> 
               <b> Second payable Amount : <span id="payment2_amount"> </span>TK </b>	<br> 
               <h5>Are you sure change 2nd Payment  status ??</h5>    
               <br> 
               <button type="submit" id="payment2_btn" class="btn btn-success">Update </button>
	  
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
{{-- payment 2 modal end --}}



{{-- add new Student modal start --}}
<div class="modal fade" id="ViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment Info View</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="add_employee_form" enctype="multipart/form-data">

        <div class="modal-body p-4 bg-light">
          <div class="row">



            <div class="mt-2" id="avatar"></div>


            <div class="row">
              <div class="col-sm-5">
                <b>Name</b>
              </div>
              <div class="col-sm-7" id="view_name">
              </div>
              <hr>
            </div>



            <div class="row">
              <div class="col-sm-8">
                <b>Card No</b>
              </div>
              <div class="col-sm-4" id="view_card">

              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-8">
                <b>Registration No</b>
              </div>
              <div class="col-sm-4" id="view_dureg">

              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-8">
                <b>previous Due Meal </b>
              </div>
              <div class="col-sm-4" id="view_pre_duemeal">

              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-8">
                <b>Reduce meal rate</b>
              </div>
              <div class="col-sm-4" id="view_pre_duemealrate">

              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-8">
                <b>Previous section meal amount</b>
              </div>
              <div class="col-sm-4" id="view_pre_duemealamount">

              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-8">
                <b>Previous Month refund Feast amount</b>
              </div>
              <div class="col-sm-4" id="view_pre_dayfeast">

              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-8">
                <b>Previous section refund employee amount</b>
              </div>
              <div class="col-sm-4" id="view_pre_employee">

              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-8">
                <b>Previous section refund friday amount</b>
              </div>
              <div class="col-sm-4" id="view_pre_friday">

              </div>
              <hr>
            </div>


            <div class="row">
              <div class="col-sm-8">
                <b>Previous section refund others amount</b>
              </div>
              <div class="col-sm-4" id="view_others">

              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-8">
                <b>Previous section refund welfare amount</b>
              </div>
              <div class="col-sm-4" id="view_welfare">

              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-8">
                <b>Previous section total refund amount</b>
              </div>
              <div class="col-sm-4" id="view_pre_refund">

              </div>
              <hr>
            </div>


            <div class="row">
              <div class="col-sm-8">
                <b>Previous section total refund Withdraw</b>
              </div>
              <div class="col-sm-4" id="view_withdraw">

              </div>
              <hr>
            </div>


            <div class="row">
              <div class="col-sm-8">
                <b>Previous section Due amount</b>
              </div>
              <div class="col-sm-4" id="view_pre_monthdue">

              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-8">
                <b>Security Money </b>
              </div>
              <div class="col-sm-4" id="view_security">

              </div>
              <hr>
            </div>


            <div class="row">
              <div class="col-sm-8">
                <b>Curreunt section Budget </b>
              </div>
              <div class="col-sm-4" id="view_cur_budget">

              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-8">
                <b>Total Amount </b>
              </div>
              <div class="col-sm-4" id="view_cur_total">

              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-8">
                <b>Curreunt section Payment 2 </b>
              </div>
              <div class="col-sm-4" id="view_payment2">

              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-8">
                <b>Curreunt section Payment 1 </b>
              </div>
              <div class="col-sm-4" id="view_payment1">

              </div>
              <hr>
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

@else
    <h1>Page not Found</h1>
   @endif


@endsection 