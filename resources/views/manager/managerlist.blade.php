@extends('manager.layout')
@section('page_title','Manager Panel')
@section('managerlist_'.$category,'active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
     <div class="card-header">
       <div class="row ">
               <div class="col-sm-4"> <h5 class="mt-0"> {{$category}} List  </h5></div>
                     <div class="col-sm-6">
                    
           <form action="{{url('pdf/managermonth')}}" method="POST" enctype="multipart/form-data">
      {!! csrf_field() !!}
      <div class="d-grid gap-3 d-flex justify-content-end">
        <select class="form-control form-control-sm" name="section" id="section" aria-label="Default select example" required>
          <option value="">Select Section </option>
          <option value="A">A</option>
          <option value="B">B</option>
        </select>
           <input type="month" name="month" class="form-control form-control-sm" value="" required>
           <input type="hidden" name="category" value="{{$category}}">
           <button type="submit" class="btn btn-primary btn-sm">Generate_PDF</button>

         </form>
      </div>
                                     
                      
                     </div>

                    
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                         <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add</button>
                         </div>
                     </div> 
         </div>
           
         @if(Session::has('fail'))
             <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
         @endif
                        
        @if(Session::has('success'))
              <div  class="alert alert-success"> {{Session::get('success')}}</div>
            @endif


      </div>
  <div class="card-body">   

   <div class="row">
         <div class="col-md-12">
           <div class="table-responsive">
                <table class="table  table-bordered data-table">
                   <thead>
                     <tr>
                         <td>  Module </td>
                         <td>  Name </td>
                       
                         <td>  Department/Designattion </td>
                         <td>  Phone </td>
                         @if($category == 'Manager')
                           <td>  Registration </td>
                           <td>  Role </td>
                          @else
                            <td>  Salary Amount </td>
                          @endif
                         <td> Edit </td>
                         <td> Delete </td>
                      </tr>
                   </thead>
                   <tbody>

                   </tbody>

                </table>
          </div>
       </div>
    </div>


  </div>
</div>


<script>
  $(document).ready(function() {

    var category = @json($category);
    

     $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});

      fetchAll();
     function fetchAll() {
            // Destroy existing DataTable if it exists
             if ($.fn.DataTable.isDataTable('.data-table')) {
                 $('.data-table').DataTable().destroy();
              }

        // Initialize DataTable
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/manager/managerlist/"+category,
                error: function(xhr, error, code) {
                   // console.log(xhr.response);
                }
            },
            columns: [
               { data: 'status', name: 'status' },
                { data: 'name', name: 'name' },
              
                { data: 'department', name: 'department' },
                { data: 'phone', name: 'phone' },
                @if($category == 'Manager')
                  { data: 'role', name: 'role' },
                  { data: 'registration', name: 'registration' },
                @else 
                  { data: 'amount', name: 'amount' },
                @endif
                { data: 'edit', name: 'edit', orderable: false, searchable: false },
                { data: 'delete', name: 'delete', orderable: false, searchable: false },
            ]
        });
    }


    $(document).on('click', '.delete', function(e) {
      e.preventDefault();
      var delete_id = $(this).data('id');
      if (confirm("Are you sure you want to delete this?")) {
        $.ajax({
          type: 'DELETE',
          url: '/manager/managerlist_delete/' + delete_id,
          success: function(response) {
            //console.log(response);
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-success');
            $('#success_message').text(response.message)
            $('#deleteexampleModal').modal('hide');
             fetchAll();

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
        url: '/manager/managerlist_update/' + edit_id,
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
            fetchAll();
          }
          $('.loader').hide();
        }
      });
    });




    $(document).on('click', '.edit', function(e) {
      e.preventDefault();
      var edit_id = $(this).data('id'); 
      
      $('#EditModal').modal('show');
      $.ajax({
        type: 'GET',
        url: '/manager/managerlist_edit/' + edit_id,
        success: function(response) {
          //console.log(response);
          if (response.status == 404) {
             $('#success_message').html("");
             $('#success_message').addClass('alert alert-danger');
             $('#success_message').text(response.message);
          } else {
             $('#edit_phone').val(response.edit_value.phone);
             $('#edit_invoice_month').val(response.edit_value.invoice_month);
             $('#edit_invoice_year').val(response.edit_value.invoice_year);
             $('#edit_invoice_section').val(response.edit_value.invoice_section);
             $('#edit_name').val(response.edit_value.name);
             $('#edit_role').val(response.edit_value.role);
             $('#edit_registration').val(response.edit_value.registration);
             $('#edit_department').val(response.edit_value.department);
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
        url: '/manager/managerlist',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('.loader').show();
        },
        success: function(response) {
          //console.log(response);
          if (response.status == 700) {
            $('.err_product').text(response.message.phone);
          } else {
            //console.log(response.message);
            $('.err_product').text('');
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-success');
            $('#success_message').text(response.message)
            $('#addEmployeeModal').modal('hide');
            // $('#AddModal').find('input').val("");
            $('#add_form')[0].reset();
            fetchAll();
          }
          $('.loader').hide();
        }
      });

     });


   });
</script>




{{-- Edit modal start --}}
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

          <ul class="alert alert-warning d-none"  id="edit_form_errlist"></ul>

      
          <label><b> Module Year <span style="color:red;"> * </span> </b></label><br>
            <input name="invoice_year" id="edit_invoice_year" type="number" class="form-control" required />
            <p class="text-danger err_product"></p>

            <label><b> Module Month <span style="color:red;"> * </span> </b></label><br>
            <input name="invoice_month" id="edit_invoice_month" type="number" class="form-control" required />
            <p class="text-danger err_product"></p>

            <label><b> Module Section <span style="color:red;"> * </span> </b></label><br>
            <input name="invoice_section" id="edit_invoice_section" type="text" class="form-control" required />
            <p class="text-danger err_product"></p>


            <label><b> Name  <span style="color:red;"> * </span> </b></label><br>
            <input name="name" id="edit_name" type="text" class="form-control" required />
            <p class="text-danger err_product"></p>

         
            <label><b>Phone Number </b></label><br>
            <input name="phone" id="edit_phone"   pattern="[0][1][3 4 7 6 5 8 9][0-9]{8}" title="
				      Please select Valid mobile number" type="text" class="form-control"  /><br>
            <p class="text-danger err_product"></p>


            <label><b> Department/Designation </b></label><br>
            <input name="department" id="edit_department" type="text" class="form-control" />
            <p class="text-danger err_product"></p>



          @if($category == 'Manager')
              <label><b> Role Type </b></label><br>
              <input name="role" id="edit_role" type="text" class="form-control" required />
              <p class="text-danger err_product"></p>

              <label><b> Du Registration </b></label><br>
              <input name="registration" id="edit_registration" type="text" class="form-control" />
              <p class="text-danger err_product"></p>
          @else
              <label><b>  Salary Amount  <span style="color:red;"> * </span>  </b></label><br>
              <input name="amount" id="edit_amount" type="number" class="form-control" required />
              <p class="text-danger err_product"></p>
          @endif
        
        

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

            
            <input type="hidden" name="category"  id="category" value="{{$category}}" >

            <label><b> Module Year <span style="color:red;"> * </span> </b></label><br>
            <input name="invoice_year" id="invoice_year" type="number" class="form-control" required />
            <p class="text-danger err_product"></p>

            <label><b> Module Month <span style="color:red;"> * </span> </b></label><br>
            <input name="invoice_month" id="invoice_month" type="number" class="form-control" required />
            <p class="text-danger err_product"></p>

            <label><b> Module Section  <span style="color:red;"> * </span> </b></label><br>
            <input name="invoice_section" id="invoice_section" type="text" class="form-control" required />
            <p class="text-danger err_product"></p>


            <label><b> Name  <span style="color:red;"> * </span> </b></label><br>
            <input name="name" id="name" type="text" class="form-control" required />
            <p class="text-danger err_product"></p>

         
            <label><b>Phone Number </b></label><br>
            <input name="phone" id="phone"  pattern="[0][1][3 4 7 6 5 8 9][0-9]{8}" title="
				      Please select Valid mobile number" type="text" class="form-control"  /><br>
            <p class="text-danger err_product"></p>


            <label><b> Department/Designation </b></label><br>
            <input name="department" id="department" type="text" class="form-control" />
            <p class="text-danger err_product"></p>

            @if($category == 'Manager')
                 <label><b> Role Type </b></label><br>
                 <input name="role" id="role" type="text" class="form-control"  />
                 <p class="text-danger err_product"></p>

                  <label><b> Du Registration </b></label><br>
                  <input name="registration" id="registration" type="text" class="form-control" />
                  <p class="text-danger err_product"></p>
            @else

                  <label><b>  Salary Amount  <span style="color:red;"> * </span>  </b></label><br>
                  <input name="amount" id="amount" type="number" class="form-control"  required />
                  <p class="text-danger err_product"></p>
            @endif


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