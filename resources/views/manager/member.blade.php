@extends('manager.layout')
@section('page_title','Manager Panel')
@section('member'.$member_status,'active')
@section('content')


@if($member_status=='1' || $member_status=='5')

@if($member_status=='1')
<div class="row mt-3 mb-0 mx-2">
  <div class="col-sm-3 my-2">
    <h5 class="mt-0">Member View </h5>
  </div>

  <div class="col-sm-6 my-2">
    <div class="d-grid gap-2 d-flex justify-content-end">
        Verified:<span class="text-success">{{$verify}}</span>,
        E-mail Verify Pending:<span class="text-danger">{{$email_verify}}</span>,
        Hall Verify Pending:<span class="text-danger">{{$not_verify}}</span>
        <a href="https://youtu.be/OsLo20KXg8o?t=177" target="_blank"> Member Tutorial</a>
    </div>
  </div>

  <div class="col-sm-3 my-2 ">
    <div class="d-grid gap-3 d-flex justify-content-end">

    </div>
  </div>

  @if(Session::has('success'))
  <div class="alert alert-success"> {{Session::get('success')}}</div>
  @endif

  @if(Session::has('fail'))
  <div class="alert alert-danger"> {{Session::get('fail')}}</div>
  @endif
</div>


 @else
 <div class="row mt-3 mb-0 mx-2">
    <div class="col-sm-3 my-2">
         <h5 class="mt-0">Ex-Member View </h5>
      </div>
  </div>

 @endif



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
    <table id="employee_data" class="table table-bordered table-hover table-sm">
      <thead>
        <tr>
          <th width="15%"> Image </th>
          <th width="15%">Card Pdf</th>
          <th width="8%" class="sorting" data-sorting_type="asc" data-column_name="card" style="cursor: pointer">
           Card No <span id="card_icon"> <i class="fas fa-sort-amount-up-alt"></i></span> </th>
          <th width="35%">Name</th>
          <th width="8%" class="sorting" data-sorting_type="asc" data-column_name="registration" style="cursor: pointer">
           Registration <span id="registration_icon"> <i class="fas fa-sort-amount-up-alt"></i></span> </th>
          <th width="35%">Mobile</th>
          <th width="35%">Session</th>
          <th width="35%">Security</th>
          <th width="15%">Edit</th>
          <th width="5%">View</th>

          <th width="8%" class="sorting" data-sorting_type="asc" data-column_name="email_verify" style="cursor: pointer">
            Email Verification <span id="email_verify_icon"><i class="fas fa-sort-amount-up-alt"></i></span> </th>

      @if($member_status==1)
          <th width="8%" class="sorting" data-sorting_type="asc" data-column_name="admin_verify" style="cursor: pointer">
            Member Verification <span id="admin_verify_icon"><i class="fas fa-sort-amount-up-alt"></i></span> </th>
           <th width="5%">Status</th>
           <th width="5%">Move</th>
        @else
          <th width="5%">Delete</th>
        @endif
          <th width="35%">Email </th>
          <th width="5%">Password</th>
          <th width="5%">Created at</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="admin_verify" />
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

    fetchAll();
    function fetchAll() {
      $.ajax({
        type: 'GET',
        url: '/manager/member_fetch/{{$member_status}}',
        datType: 'json',
        success: function(response) {
          $('tbody').html('');
          $('.x_content tbody').html(response);
        }
      });
    }



    $(document).on('click', '.edit', function(e) {
      e.preventDefault();
      var view_id = $(this).val();
      $('#EditModal').modal('show');
      $.ajax({
        type: 'GET',
        url: '/manager/member_view/' + view_id,
        success: function(response) {
          //console.log(response);
          if (response.status == 404) {
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-danger');
            $('#success_message').text(response.message);
          } else {
            $('#edit_id').val(response.value.id);
            $('#edit_name').val(response.value.name);
            $('#edit_card').val(response.value.card);
            $('#edit_registration').val(response.value.registration);
            $('#edit_email').val(response.value.email);
            $('#edit_phone').val(response.value.phone);
            $('#edit_session').val(response.value.session);
            $('#edit_security_money').val(response.value.security_money);
            $('#edit_hostel_fee').val(response.value.hostel_fee);
          }
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
        url: '/manager/member_view/' + view_id,
        success: function(response) {
          //console.log(response);
          if (response.status == 404) {
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-danger');
            $('#success_message').text(response.message);
          } else {
            var seesion2 = parseInt(response.value.session) + 1;
            var session = response.value.session + "-" + seesion2;
            $('#view_name').text(response.value.name);
            $('#view_card').text(response.value.card);
            $('#view_registration').text(response.value.registration);
            $('#view_email').text(response.value.email);
            $('#view_phone').text(response.value.phone);
            $('#view_security_money').text(response.value.security_money + "TK");
            $('#view_session').text(session);
            $('#view_father').text(response.value.father);
            $('#view_mother').text(response.value.mother);
            $('#view_nation').text(response.value.nation);
            $('#view_division').text(response.value.division);
            $('#view_zila').text(response.value.zila);
            $('#view_village').text(response.value.village);
            $('#view_religion').text(response.value.religion);
            $('#view_dept').text(response.value.dept);
            $('#view_old_card').text(response.value.custom3);
            $('#view_birth_date').text(response.value.birth_date);
            $('#view_upazila').text(response.value.upazila);
            $('#view_postcode').text(response.value.postcode);
            $('#view_custom2').text(response.value.custom2);
            $('#view_custom3').text(response.value.custom3);
            if (response.value.image) {
              $("#avatar").html(
                `<img src="/uploads/student/${response.value.image}" width="100" class="img-fluid img-thumbnail">`);
            } else {
              $("#avatar").html("");
            }

          }
        }
      });
    });




    // update employee ajax request
    $("#edit_employee_form").submit(function(e) {
      e.preventDefault();

      const fd = new FormData(this);

      $.ajax({
        type: 'POST',
        url: '/manager/member_update',
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
            $('.edit_err_hostel_fee').text('');
            fetchAll();
          } else if (response.status == 300) {
            Swal.fire("Warning", response.message,"warning");
          } else if (response.status == 500) {
            Swal.fire("Warning", response.message,"warning");
          } else if (response.status == 700) {
            $('.edit_err_registration').text(response.message.registration);
            $('.edit_err_phone').text(response.message.phone);
            $('.edit_err_email').text(response.message.email);
            $('.edit_err_hostel_fee').text(response.message.hostel_fee);
            $('.edit_err_card').text(response.message.card);
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
            url: '/maintain/hall_delete',
            method: 'delete',
            data: {
              id: id,
            },
            success: function(response) {
              //console.log(response);
              if (response.status == 400) {
                Swal.fire("Warning", response.message, "warning");
              } else if (response.status == 200)
                Swal.fire("Deleted", response.message, "success");
              fetchAll();
            }
          });
        }
      })
    });


    function fetch_data(page, sort_type = "", sort_by = "", search = "") {
      $.ajax({
        url: "/manager/member/{{$member_status}}/fetch_data?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&search=" + search,
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
      fetch_data(page,reverse_order,column_name,search);
    });



 

  });
</script>


{{-- edit employee modal start --}}
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="edit_employee_form" enctype="multipart/form-data">
        <input type="hidden" name="edit_id" id="edit_id">
        <div class="modal-body p-4 bg-light">
          <div class="row">


          <div class="col-lg-12 my-1">
              <label> Name</label>
              <input name="name" type="text" id="edit_name" class="form-control" value="" required />
              <p class="text-danger edit_err_name"></p>
            </div>

          

            <div class="col-lg-12 my-1">
              <label> Mobile No</label>
              <input name="phone" type="text" id="edit_phone" pattern="[0][1][3 4 5 6 7 8 9][0-9]{8}" class="form-control" value="" required />
              <p class="text-danger edit_err_phone"></p>
            </div>

           


            <div class="col-lg-12 my-1">
              <label>E-mail</label>
              <input name="email" type="email" id="edit_email" class="form-control" value="" required />
              <p class="text-danger edit_err_email"></p>
            </div>

            <div class="col-lg-12 my-1">
              <input name="hostel_fee" type="hidden" id="edit_hostel_fee" class="form-control" value="" required />
              <p class="text-danger edit_err_hostel_fee"></p>
            </div>

            <div class="col-lg-12 my-1">
              <label> Registration / Seat  No</label>
              <input name="registration" type="text" id="edit_registration" class="form-control" value="" required />
              <p class="text-danger edit_err_registration"></p>
            </div>

            <div class="col-lg-12 my-1">
              <label> Card No</label>
              <input name="card" type="text" id="edit_card" class="form-control" value="" required />
              <p class="text-danger edit_err_card"></p>
            </div>


            <div class="col-lg-12 my-1">
               <label> Session</label>
               <input name="session" type="number" id="edit_session" class="form-control" value="" required />
               <p class="text-danger edit_err_session"></p>
            </div>

            <div class="col-lg-12 my-1">
                <label> Security Money</label>
                <input name="security_money" type="number" id="edit_security_money" class="form-control" value="" required />
               <p class="text-danger edit_err_session"></p>
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





{{-- add new Student modal start --}}
<div class="modal fade" id="ViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="add_employee_form" enctype="multipart/form-data">

        <div class="modal-body p-4 bg-light">
          <div class="row">
              <div class="mt-2" id="avatar"></div>

             <div class="row">
              <div class="col-sm-4">
                <b>Name</b>
              </div>
              <div class="col-sm-8" id="view_name">
              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <b>Card No</b>
              </div>
              <div class="col-sm-8" id="view_card">
              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <b>Registration No</b>
              </div>
              <div class="col-sm-8" id="view_registration">
              </div>
              <hr>
            </div>


            <div class="row">
              <div class="col-sm-4">
                <b>Phone Number</b>
              </div>
              <div class="col-sm-8" id="view_phone">
              </div>
              <hr>
            </div>


            <div class="row">
              <div class="col-sm-4">
                <b>Custom Field 2 </b>
              </div>
              <div class="col-sm-8" id="view_custom2">
              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <b>Custom Field 3 </b>
              </div>
              <div class="col-sm-8" id="view_custom3">
              </div>
              <hr>
            </div>


            <div class="row">
              <div class="col-sm-4">
                <b>Security Money</b>
              </div>
              <div class="col-sm-8" id="view_security_money">
              </div>
              <hr>
            </div>


            <div class="row">
              <div class="col-sm-4">
                <b>Email</b>
              </div>
              <div class="col-sm-8" id="view_email">
              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <b>Department</b>
              </div>
              <div class="col-sm-8" id="view_dept">
              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <b>Old Card No</b>
              </div>
              <div class="col-sm-8" id="view_old_card">
              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <b>Session</b>
              </div>
              <div class="col-sm-8" id="view_session">
              </div>
              <hr>
            </div>


            <div class="row">
              <div class="col-sm-4">
                <b>Date of Birth</b>
              </div>
              <div class="col-sm-8" id="view_birth_date">
              </div>
              <hr>
            </div>


            <div class="row">
              <div class="col-sm-4">
                <b>Father's Name</b>
              </div>
              <div class="col-sm-8" id="view_father">
              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <b>Mother's Name</b>
              </div>
              <div class="col-sm-8" id="view_mother">
              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <b> Nationality</b>
              </div>
              <div class="col-sm-8" id="view_nation">
              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <b> Religion</b>
              </div>
              <div class="col-sm-8" id="view_religion">
              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <b> Division</b>
              </div>
              <div class="col-sm-8" id="view_division">
              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <b> District</b>
              </div>
              <div class="col-sm-8" id="view_zila">
              </div>
              <hr>
            </div>


            <div class="row">
              <div class="col-sm-4">
                <b> Upazila</b>
              </div>
              <div class="col-sm-8" id="view_upazila">
              </div>
              <hr>
            </div>


            <div class="row">
              <div class="col-sm-4">
                <b> Post Code</b>
              </div>
              <div class="col-sm-8" id="view_postcode">
              </div>
              <hr>
            </div>

            <div class="row">
              <div class="col-sm-4">
                <b> Village/House No</b>
              </div>
              <div class="col-sm-8" id="view_village">
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