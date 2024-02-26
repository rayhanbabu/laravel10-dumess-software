@extends('manager.layout')
@section('page_title','Manager Panel')
@section('booking'.$category,'active')
@section('content')


@if($category=='1' || $category=='2' || $category=='0' || $category=='5')

    <div class="row mt-3 mb-0 mx-2">
  <div class="col-sm-3 my-2">
       <h5 class="mt-0">@if($category=='1') 
          <h4 class="mt-0">Seat Booked View </h4>
       @elseif($category=='2')
          <h4 class="mt-0">Seat Pre-Booked View </h4>
       @elseif($category=='0')
          <h4 class="mt-0">Seat Pending View </h4>
       @else @endif </h5>
  </div>

  
  <div class="col-sm-6 my-2">
  <form action="{{url('pdf/booking_payment')}}" method="POST" enctype="multipart/form-data">
     {!! csrf_field() !!}
       <div class="d-grid gap-2 d-flex justify-content-start">
               <select class="form-control" name="type"  aria-label="Default select example"  required >
                       <option value="1">1st Payment</option>
                       <option value="2">2nd Payment</option>
                       <option value="3">3rd Payment</option>
                       <option value="4">All Payment</option>
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


  @if(Session::has('success'))
     <div class="alert alert-success"> {{Session::get('success')}}</div>
  @endif

  @if(Session::has('fail'))
     <div class="alert alert-danger"> {{Session::get('fail')}}</div>
  @endif
</div>


<div id="success_message"></div>
<div class="row p-2">
  <div class="col-md-9">

  </div>
  <div class="col-md-3">
    <div class="form-group">
      <input type="text" name="search" id="search" placeholder="Enter Search " class="form-control" autocomplete="off" />
    </div>
  </div>
</div>

<div class="table-responsive">
  <div class="x_content">
    <table id="employee_data" class="table table-bordered table-hover">
      <thead>
        <tr>
           <th width="10%" class="sorting" data-sorting_type="asc" data-column_name="seat_name" style="cursor: pointer">Seat Name
              <span id="seat_name_icon"><i class="fas fa-sort-amount-up-alt"></i></span>
          </th>
          <th width="5%"> Phone</th>
          <th width="5%"> Building</th>
          <th width="5%"> Room</th>
          <th width="5%"> Booking Status</th>
          <th width="5%"> Seat Rent</th>
          <th width="5%"> Service </th>
          <th width="5%"> Total Amount </th>
         
          <th width="5%"> Pay 1 </th>
          <th width="5%"> Pay 2 </th>
          <th width="5%"> Pay 3 </th>
          <th width="5%"> Due Amount </th>
          <th width="5%"> Edit  </th>
          <th width="5%"> Type 1 </th>
          <th width="5%"> Type 2 </th>
          <th width="5%"> Type 3</th> 
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
        url: '/manager/booking_fetch/{{$category}}',
        datType: 'json',
        success: function(response) {
          $('tbody').html('');
          $('.x_content tbody').html(response);

        }
      });
    }



    $(document).on('submit', '#edit_form', function(e) {
        e.preventDefault();
         var edit_id = $('#edit_id').val();

       let editData = new FormData($('#edit_form')[0]);
        $.ajax({
         type: 'POST',
         url: '/manager/booking_update/' + edit_id,
         data: editData,
         contentType: false,
         processData: false,
           beforeSend: function() {
               $('.loader').show();
           },
        success: function(response) {
          // console.log(response);
          if (response.status == 400) {
            $('#edit_form_errlist').html("");
            $('#edit_form_errlist').removeClass('d-none');
               $.each(response.message, function(key, err_values) {
               $('#edit_form_errlist').append('<li>' + err_values + '</li>');
            });
          } else {
            $('#edit_form_errlist').html("");
            $('#edit_form_errlist').addClass('d-none');
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-success');
            $('#success_message').text(response.message)
            $('#EditModal').modal('hide');
            fetch();
          }
          $('.loader').hide();
        }
      });
    });




    $(document).on('click', '.edit_id', function(e) {
      e.preventDefault();
       var edit_id = $(this).val();
         //alert(edit_id)
       $('#EditModal').modal('show');
       $.ajax({
         type: 'GET',
         url: '/manager/booking_edit/' + edit_id,
         success: function(response) {
            //console.log(response);
           if (response.status == 404) {
              $('#success_message').html("");
              $('#success_message').addClass('alert alert-danger');
              $('#success_message').text(response.message);
           } else {
              $('#edit_booking_status').val(response.edit_value.booking_status);
              $('#edit_seat_id').val(response.edit_value.seat_id);
              $('#edit_id').val(edit_id);
          }
        }
      });
    });



    $(document).on('click', '.payment_edit', function(e) {
      e.preventDefault();
       var edit_id = $(this).val();
         //alert(edit_id)
       $('#PaymentModal').modal('show');
       $.ajax({
         type: 'GET',
         url: '/manager/booking_edit/' + edit_id,
         success: function(response) {
              //console.log(response);
           if (response.status == 404) {
              $('#success_message').html("");
              $('#success_message').addClass('alert alert-danger');
              $('#success_message').text(response.message);
           } else {
               $('#edit_amount1').val(response.edit_value.amount1);
               $('#edit_amount2').val(response.edit_value.amount2);
               $('#edit_amount3').val(response.edit_value.amount3);
               $('#payment_id').val(response.edit_value.id);
          }
        }
      });
    });


    $(document).on('submit', '#payment_form', function(e) {
        e.preventDefault();
         var payment_id = $('#payment_id').val();

       let editData = new FormData($('#payment_form')[0]);
        $.ajax({
         type: 'POST',
         url: '/manager/payment_update/' + payment_id,
         data: editData,
         contentType: false,
         processData: false,
           beforeSend: function() {
               $('.loader').show();
           },
        success: function(response) {
          // console.log(response);
          if (response.status == 400) {
            $('#payment_form_errlist').html("");
            $('#payment_form_errlist').removeClass('d-none');
               $.each(response.message, function(key, err_values) {
               $('#payment_form_errlist').append('<li>' + err_values + '</li>');
            });
          } else {
            $('#payment_form_errlist').html("");
            $('#payment_form_errlist').addClass('d-none');
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-success');
            $('#success_message').text(response.message)
            $('#PaymentModal').modal('hide');
            fetch();
          }
          $('.loader').hide();
        }
      });
    });






    function fetch_data(page, sort_type = "", sort_by = "", search = "") {
      $.ajax({
        url: "/manager/booking/{{$category}}/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&search=" + search,
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









{{-- Edit Booking Status start --}}
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Booking Status Update</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" id="edit_form" enctype="multipart/form-data" >

        <div class="modal-body p-4 bg-light">
          <ul class="alert alert-warning d-none" id="add_form_errlist"></ul>

          <input type="hidden" name="id"  id="edit_id" >

          <input type="hidden" name="seat_id"  id="edit_seat_id" >

          <ul class="alert alert-warning d-none"  id="edit_form_errlist"></ul>

          <div class="my-2">
                 <label>Booking Status  </label>
                  <select class="form-control" id="edit_booking_status" name="booking_status" aria-label="Default select example" required>
                       <option value="0">Pending</option>
                       <option value="1">Booked</option>
                       <option value="2">Pre Booked</option>
                       <option value="5">Resign</option>
                  </select>
            </div>

          <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div><br>


          <input type="submit"  value="Update" class="btn btn-success" />

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        </div>
      </form>
    </div>
  </div>
</div>

{{-- Edit Booking Status modal end --}}





{{--Edit Booking Status start--}}
<div class="modal fade" id="PaymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment  Update</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" id="payment_form" enctype="multipart/form-data" >

        <div class="modal-body p-4 bg-light">
              <ul class="alert alert-warning d-none" id="add_form_errlist"></ul>

           <input type="hidden" name="payment_id"  id="payment_id" >  
                  <ul class="alert alert-warning d-none"  id="payment_form_errlist"></ul>

           <div class="my-2">
                 <label>Payment 1  </label>
                 <input name="amount1" id="edit_amount1"  type="number" class="form-control" required /><br>
            </div>


            <div class="my-2">
                 <label>Payment 2 </label>
                 <input name="amount2" id="edit_amount2"  type="number" class="form-control" required /><br>
            </div>


            <div class="my-2">
                 <label>Payment 3 </label>
                 <input name="amount3" id="edit_amount3"  type="number" class="form-control" required /><br>
            </div>

          <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div><br>


          <input type="submit"  value="Update" class="btn btn-success" />

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        </div>
      </form>
    </div>
  </div>
</div>

{{-- Edit Booking Status modal end --}}





@else
    <h1>Page not Found</h1>
   @endif



@endsection 