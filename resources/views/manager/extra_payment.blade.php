@extends('manager.layout')
@section('page_title','Manager Panel')
@section('extra_payment','active')
@section('content')
<div class="row mt-3 mb-0 mx-2">


  <div class="col-sm-4 my-2">
    <div class="d-grid gap-2 d-flex justify-content-start">
      <h4> Extra Payment View </h4>
      <a href="https://youtu.be/OsLo20KXg8o?t=2218" target="_blank">  Tutorial</a>
    </div>
  </div>

  <div class="col-sm-2 my-2">
    <div class="d-grid gap-2 d-flex justify-content-start">
   
      <button type="button" class="bazar_entry btn btn-success btn-sm"> Add</button>
    </div>
  </div>

  <div class="col-sm-3 my-2 ">
    <form action="{{url('pdf/bazarmonth')}}" method="POST" enctype="multipart/form-data">
     
  </div>


  <div class="col-sm-2 my-2">
    <div class="d-grid gap-2 d-flex justify-content-start">
     
    </div>
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


<div class="bazar-entry-show" style="background-color:aliceblue; padding:10px;">
  <h4> Extra Payment Entry Form</h4>
  <form method="post" id="add_form" enctype="multipart/form-data">
   
    <div class="row">
      <div class="col-sm-3">
            <label>Name/Organization</label>
            <input type="text" name="name" id="name" class="form-control form-control-sm" required>
      </div>

      <div class="col-sm-3">
          <label>Description</label>
            <input type="text" name="description" id="description" class="form-control form-control-sm" required>
      </div>

      <div class="col-sm-2">
          <label>Amount</label>
            <input type="number" name="amount" id="anount" class="form-control form-control-sm" required>
      </div>

      <div class="col-sm-2">
        <br>
        <div class="loader">
          <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
        </div>
      </div>

      <div class="col-sm-2">
        <br>
        <input type="submit" value="Submit" id="submit" class=" btn btn-success btn-sm" />
      </div>
    </div>
    <ul class="alert alert-warning d-none" id="add_form_errlist"></ul>
  </form>
  <br><br>
</div>






<div class="row p-2">
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
    <table id="employee_data" class="table table-bordered table-hover table-sm">
      <thead>
        <tr>
          <th width="10%" class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">Name
            <span id="name_icon"><i class="fas fa-sort-amount-up-alt"></i></span>
          </th>

          <th width="10%">Month,Section</th>
          <th width="15%">Product Name</th>
          <th width="15%">Amount</th>
          <th width="10%"></th>
          <th width="10%"></th>
          <th width="10%">Payemnt Type</th>
          <th width="10%">Created_at</th>
          <th width="10%">Updated_at</th>
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









<script>
  $(document).ready(function() {



    $(".js-example-disabled-results").select2();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });



    fetch();

    function fetch() {
      $.ajax({
        type: 'GET',
        url: '/manager/extra_payment_fetch',
        datType: 'json',
        success: function(response) {
          $('tbody').html('');
          $('.x_content tbody').html(response);

        }
      });
    }



    $(document).on('click', '.delete_id', function(e) {
      e.preventDefault();
      var delete_id = $(this).val();
      if (confirm("Are you sure you want to delete this?")) {
        $.ajax({
          type: 'DELETE',
          url: '/manager/extra_payment_delete/' + delete_id,
          success: function(response) {
            //console.log(response);
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-success alert-sm');
            $('#success_message').text(response.message)
            $('#deleteexampleModal').modal('hide');
            fetch();

          }
        });

      } else {
        return false;
      }
    });





    $(document).on('submit', '#edit_form', function(e) {
      e.preventDefault();
      var edit_id = $('#edit_id').val();

      let editData = new FormData($('#edit_form')[0]);
      $.ajax({
        type: 'POST',
        url: '/manager/extra_payment_update/' + edit_id,
        data: editData,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('.loader').show();
        },
        success: function(response) {
          console.log(response);
          if (response.status == 700) {
            $('#edit_form_errlist').html("");
            $('#edit_form_errlist').removeClass('d-none');
            $.each(response.message, function(key, err_values) {
              $('#edit_form_errlist').append('<li>' + err_values + '</li>');
            });
          } else {
            $('#edit_form_errlist').html("");
            $('#edit_form_errlist').addClass('d-none');
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-success alert-sm');
            $('#success_message').text(response.message)
            $('#EditModal').modal('hide');
            fetch();
          }
          $('.loader').hide();
        }
      });
    });


    $(document).on('click', '.bazar_entry', function(e) {
      e.preventDefault();
            //console.log('Rayhan babu');
      $('.bazar-entry-show').show();

    });


    $(document).on('click', '.edit_id', function(e) {
      e.preventDefault();
       var edit_id = $(this).val();
       //alert(edit_id)
      $('#EditModal').modal('show');
      $.ajax({
        type: 'GET',
        url: '/manager/extra_payment_edit/' + edit_id,
        success: function(response) {
          //console.log(response);
          if (response.status == 404) {
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-danger');
            $('#success_message').text(response.message);
          } else {
            $('#edit_name').val(response.edit_value.name);
            $('#edit_description').val(response.edit_value.description);
            $('#edit_cur_month').val(response.edit_value.cur_month);
            $('#edit_cur_year').val(response.edit_value.cur_year);
            $('#edit_cur_section').val(response.edit_value.cur_section);
            $('#edit_amount').val(response.edit_value.amount);
            $('#edit_id').val(edit_id);
          }
        }
      });
    });




    $(document).on('submit', '#add_form', function(e) {
      e.preventDefault();

      let formData = new FormData($('#add_form')[0]);

      $.ajax({
        type: 'POST',
        url: '/manager/extra_payment',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('.loader').show();
        },
        success: function(response) {
          //console.log(response);
          if (response.status == 700) {
            $('#add_form_errlist').html("");
            $('#add_form_errlist').removeClass('d-none');
            $.each(response.message, function(key, err_values) {
              $('#add_form_errlist').append('<li>' + err_values + '</li>');
            });
          } else {
            //console.log(response.message);
            $('#add_form_errlist').html("");
            $('#add_form_errlist').addClass('d-none');
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-success alert-sm');
            $('#success_message').text(response.message)
            $('#add_form')[0].reset();
            $('.bazar-entry-show').hide();
            fetch();
          }
          $('.loader').hide();

        }
      });

    });



    function fetch_data(page, sort_type = "", sort_by = "", search = "") {
      $.ajax({
        url: "/manager/extra_payment/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&search=" + search,
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



{{-- Edit new Student modal start --}}
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" id="edit_form" enctype="multipart/form-data">

        <div class="modal-body p-2 bg-light">
         

          <input type="hidden" name="edit_id" id="edit_id">

           <label>Name/ Organization</label>
           <input type="text" name="name" id="edit_name" class="form-control" required>
            <br />

           <label>Description</label>
           <input type="text" name="description" id="edit_description" class="form-control" required>
            <br />

            <label>Amount</label>
           <input type="text" name="amount" id="edit_amount" class="form-control" required>
            <br />


          <?php $name = "off" ?>

          @if($name=="off")
          <div class="row">
            <div class="col-sm-4">
              <label>Month </label>
              <input name="cur_month" id="edit_cur_month" type="number" class="form-control" placeholder="" required />
            </div>
            <div class="col-sm-3">
              <label> Year </label>
              <input name="cur_year" id="edit_cur_year" type="number" class="form-control" placeholder="" required />
            </div>

            <div class="col-sm-3">
              <label> Section </label>
              <select class="form-control" name="cur_section" id="edit_cur_section">
                <option value="A">A</option>
                <option value="B">B</option>
              </select>
            </div>
          </div>

          @else
          <input name="bazar_month" id="edit_bazar_month" type="hidden" class="form-control" placeholder="" required />
          <input name="bazar_year" id="edit_bazar_year" type="hidden" class="form-control" placeholder="" required />
          <input name="bazar_section" id="edit_bazar_section" type="hidden" class="form-control" placeholder="" required />
          @endif

         

          
          

       

          <ul class="alert alert-warning d-none" id="edit_form_errlist"></ul>

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


@endsection 