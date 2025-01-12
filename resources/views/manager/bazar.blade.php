@extends('manager.layout')
@section('page_title','Manager Panel')
@section('bazar','active')
@section('content')
<div class="row mt-3 mb-0 mx-2">


  <div class="col-sm-2 my-2">
    <div class="d-grid gap-2 d-flex justify-content-start">
      <h4> Bazar  View </h4>
      <a href="https://youtu.be/OsLo20KXg8o?t=995" target="_blank"> Tutorial</a>
    </div>
  </div>

  <div class="col-sm-2 my-2">
    <div class="d-grid gap-2 d-flex justify-content-start">
   
      <button type="button" class="bazar_entry btn btn-success btn-sm">Bazar Add</button>
    </div>
  </div>

  <div class="col-sm-6 my-2 ">
    <form action="{{url('pdf/bazarmonth')}}" method="POST" enctype="multipart/form-data">
      {!! csrf_field() !!}
      <div class="d-grid gap-3 d-flex justify-content-end">
        <select class="form-control form-control-sm" name="section" id="section" aria-label="Default select example" required>
          <option value="">Select Section </option>
          <option value="A">A</option>
          <option value="B">B</option>
        </select>
        <input type="month" name="month" class="form-control form-control-sm" value="" required>
      </div>
  </div>


  <div class="col-sm-2 my-2">
    <div class="d-grid gap-2 d-flex justify-content-start">
      <button type="submit" name="search" class="btn btn-primary">Monthly Bazar </button>
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
  <h4>Bazar Entry Form</h4>
  <form method="post" id="add_form" enctype="multipart/form-data">
    <div class="row">
      <div class="col-sm-4">
        <label>Date</label>
        <input type="date" name="date" id="date" class="form-control form-control-sm" required>
      </div>
      <div class="col-sm-4">
        <label>Product name</label><br>
        <select name="product_id" id="product_id" class="js-example-disabled-results" style="width:300px;" required>
          <option value="">Select Product</option>
          @foreach($product as $row)
          <option value="{{ $row->id}}">{{ $row->product}}</option>
          @endforeach
        </select>
      </div>

      <div class="col-sm-3">
        <label>Quantity(Kg/Unit)</label>
        <input name="qty" id="qty" type="text" class="form-control form-control-sm" placeholder="" required />

      </div>
      <div class="col-sm-1">
        <label></label>
        <select class="form-control form-control-sm" name="unit" id="unit">
          <option value="Kg">Kg</option>
          <option value="Litter">Litter</option>
          <option value="Unit">Unit</option>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-4">
        <label>Per unit price</label>
        <input type="text" name="price" id="price" class="form-control form-control-sm" required>
        <input type="hidden" name="category" value="bazar">
      </div>

      <div class="col-sm-4">
        <br>
        <div class="loader">
          <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
        </div>
      </div>

      <div class="col-sm-4">
        <br>
        <input type="submit" value="Submit" id="submit" class=" btn btn-success btn-sm" />
      </div>
    </div>
    <ul class="alert alert-warning d-none" id="add_form_errlist"></ul>
  </form>
  <br><br>
</div>



<div class="row mt-4 mb-0 mx-2">

  <div class="col-sm-4 my-2">
    <form action="{{url('pdf/bazarday')}}" method="POST" enctype="multipart/form-data">
      <div class="d-grid gap-2 d-flex justify-content-end">
           {!! csrf_field() !!}
           <input type="date" name="bazardate" class="form-control form-control-sm"  required>
           <button type="submit" name="search" class="btn btn-primary btn-sm">Daily_bazar </button>
     </form>
  </div>
</div>

<div class="col-sm-5 my-2 ">
<form action="{{url('pdf/product_wise')}}" method="POST" enctype="multipart/form-data">
     {!! csrf_field() !!}
  <div class="d-grid gap-3 d-flex justify-content-start">
    <select class="js-example-disabled-results" name="product_id" style="width:300px;" required>
      <option value="">Select_Product </option>
      @foreach($product as $row)
      <option value="{{ $row->id}}">{{ $row->product}}</option>
      @endforeach
    </select>
    <input type="month" name="month" class="form-control form-control-sm" value="" required>
  </div>
</div>

<div class="col-sm-3 my-2 ">
  <div class="d-grid gap-3 d-flex justify-content-start">
    <select class="form-control form-control-sm" name="section" id="section" aria-label="Default select example" required>
      <option value="">Select Section </option>
      <option value="A">A</option>
      <option value="B">B</option>
    </select>
    <input type="submit" value="Product_wise" id="submit" class="btn btn-success btn-sm" />
  </div>
</div>
</form>
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
          <th width="10%" class="sorting" data-sorting_type="asc" data-column_name="date" style="cursor: pointer">date
            <span id="date_icon"><i class="fas fa-sort-amount-up-alt"></i></span>
          </th>

          <th width="10%">Month,Section</th>
          <th width="15%">Product Name</th>
          <th width="10%">Quantity(Kg/Unit)</th>
          <th width="20%">Price per unit</th>
          <th width="20%">Total price</th>
          <th width="10%"></th>
          <th width="10%"></th>
          <th width="10%">Created By</th>
          <th width="10%">Updated By</th>
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
        url: '/manager/bazar_fetch',
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
          url: '/manager/bazar_delete/' + delete_id,
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
        url: '/manager/bazar_update/' + edit_id,
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
            console.log('Rayhan babu');
      $('.bazar-entry-show').show();

    });


    $(document).on('click', '.edit_id', function(e) {
      e.preventDefault();
      var edit_id = $(this).val();
      //alert(edit_id)
      $('#EditModal').modal('show');
      $.ajax({
        type: 'GET',
        url: '/manager/bazar_edit/' + edit_id,
        success: function(response) {
          //console.log(response);
          if (response.status == 404) {
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-danger');
            $('#success_message').text(response.message);
          } else {
            $('#edit_date').val(response.edit_value.date);
            $('#edit_product_id').val(response.edit_value.product_id);
            $('#edit_qty').val(response.edit_value.qty);
            $('#edit_unit').val(response.edit_value.unit);
            $('#edit_bazar_month').val(response.edit_value.bazar_month);
            $('#edit_bazar_year').val(response.edit_value.bazar_year);
            $('#edit_bazar_section').val(response.edit_value.bazar_section);
            $('#edit_price').val(response.edit_value.price);
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
        url: '/manager/bazar',
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
        url: "/manager/bazar/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&search=" + search,
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
        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" id="edit_form" enctype="multipart/form-data">

        <div class="modal-body p-2 bg-light">
         

          <input type="hidden" name="edit_id" id="edit_id">

          <label>Date</label>
          <input type="date" name="date" id="edit_date" class="form-control" required>
          <br />


          <?php $name = "off" ?>

          @if($name=="off")
          <div class="row">
            <div class="col-sm-4">
              <label>Month </label>
              <input name="bazar_month" id="edit_bazar_month" type="number" class="form-control" placeholder="" required />
            </div>
            <div class="col-sm-3">
              <label> Year </label>
              <input name="bazar_year" id="edit_bazar_year" type="number" class="form-control" placeholder="" required />
            </div>

            <div class="col-sm-3">
              <label> Section </label>
              <select class="form-control" name="bazar_section" id="edit_bazar_section">
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

          <label>Product name</label>
          <select name="product_id" id="edit_product_id" class="form-control" required>
            <option value="">Select Product </option>
            @foreach($product as $row)
            <option value="{{ $row->id}}">{{ $row->product}}</option>
            @endforeach

          </select><br>




          <label>Quantity(Kg/Unit)</label><br>
          <div class="row">
            <div class="col-sm-5">
              <input name="qty" id="edit_qty" type="text" class="form-control" placeholder="" required />
            </div>
            <div class="col-sm-3">
              <select class="form-control" name="unit" id="edit_unit">
                <option value="Kg">Kg</option>
                <option value="Litter">Litter</option>
                <option value="Unit">Unit</option>
              </select><br>
            </div>

            <div class="col-sm-4">
              <select class="form-control" name="category" id="edit_category">
                <option value="bazar">bazar</option>

              </select><br>
            </div>
          </div>

          <label>Per unit price</label>
          <input type="text" name="price" id="edit_price" class="form-control" required>
          <br />

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