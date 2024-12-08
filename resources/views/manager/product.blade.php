@extends('manager.layout')
@section('page_title','Admin Panel')
@section('product','active')
@section('content')


<div class="row mt-3 mb-0 mx-2">
  <div class="col-sm-3 my-2">
    <h4 class="mt-0">Product View </h4>
  </div>

  <div class="col-sm-3 my-2">
    <div class="d-grid gap-2 d-flex justify-content-end">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add</button>
    </div>
  </div>

  <div class="col-sm-6 my-2 ">
    <div class="d-grid gap-3 d-flex justify-content-end">
       <a href="https://youtu.be/OsLo20KXg8o?t=966" target="_blank">  Tutorial</a>
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
          <th width="25%" class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer"> id
             <span id="id_icon"><i class="fas fa-sort-amount-up-alt"></i></span>
          </th>
          <th width="35%" class="sorting" data-sorting_type="asc" data-column_name="product" style="cursor: pointer">Product Name
             <span id="product_icon"><i class="fas fa-sort-amount-up-alt"></i></span>
          </th>
          <th width="10%"></th>
          <th width="10%"></th>
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
        url: '/manager/product_fetch',
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
          url: '/manager/product_delete/' + delete_id,
          success: function(response) {
            //console.log(response);
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-success');
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
        url: '/manager/product_update/' + edit_id,
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
            $.each(response.errors, function(key, err_values) {
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
        url: '/manager/product_edit/' + edit_id,
        success: function(response) {
          //console.log(response);
          if (response.status == 404) {
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-danger');
            $('#success_message').text(response.message);
          } else {
            $('#edit_code').val(response.edit_value.code);
            $('#edit_product').val(response.edit_value.product);
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
        url: '/manager/product',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('.loader').show();
        },
        success: function(response) {
          //console.log(response);
          if (response.status == 400) {
            $('.err_product').text(response.message);
          } else {
            //console.log(response.message);
            $('.err_product').text('');
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-success');
            $('#success_message').text(response.message)
            $('#addEmployeeModal').modal('hide');
            // $('#AddModal').find('input').val("");
            $('#add_form')[0].reset();
            fetch();
          }
          $('.loader').hide();
        }
      });

    });



    function fetch_data(page, sort_type = "", sort_by = "", search = "") {
      $.ajax({
        url: "/manager/product/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&search=" + search,
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









{{-- add new Student modal start --}}
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" id="edit_form" enctype="multipart/form-data" >

        <div class="modal-body p-4 bg-light">
          <ul class="alert alert-warning d-none" id="add_form_errlist"></ul>

          <input type="hidden" name="id"  id="edit_id" >

          <label><b> </b></label>
          <input name="code" id='edit_code' min="1" type="hidden" value="100" class="form-control" />

          <label><b>Product Name</b></label><br>
          <input name="product" id="edit_product" type="text" class="form-control" required /><br>
        



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

{{-- add new employee modal end --}}



{{-- add new Student modal start --}}
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" id="add_form" enctype="multipart/form-data" >

        <div class="modal-body p-4 bg-light">
          <ul class="alert alert-warning d-none" id="add_form_errlist"></ul>

          <label><b> </b></label>
          <input name="code" id='code' min="1" type="hidden" value="100" class="form-control" />

          <label><b>Product Name</b></label><br>
          <input name="product" id="phone" type="text" class="form-control" required /><br>
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





@endsection 