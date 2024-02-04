@extends('manager.layout')
@section('page_title','Maintain Panel')
@section('report','active')
@section('content')


<div class="row my-3">


    <div class="col-xl-4 col-md-6 p-2">
        <div class="card bg-light shadow">
             <div class="mx-3 my-2">
                 <b class="text-center">Member List </b>
            </div>
            <form action="{{ url('pdf/memberlist_with_section') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}

            <div class="p-2">
                <input type="checkbox" name="check_status" id="check_author"></input>Checkbox Checked If show section 
                    wise verified member
             </div>
                
             <div class="row  author_input">
                  <div class="d-grid gap-3 d-flex justify-content-end p-3">
                      <select class="form-control form-control-sm" name="section" id="section" aria-label="Default select example" >
                          <option value="">Select Section </option>
                          <option value="A">A</option>
                          <option value="B">B</option>
                      </select>
                  <input type="month" name="month" class="form-control form-control-sm" value="" >
                 </div>
            </div>


                <div class="form-group  mx-3 my-3">
                       <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
                </div>

            </form>
        </div>
    </div>



    <div class="col-xl-4 col-md-6 p-2">
        <div class="card bg-light shadow">
            <div class="mx-3 my-2">
                <b class="text-center">Active member </b>
            </div>
            <form action="{{ url('pdf/active_member') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="d-grid gap-3 d-flex justify-content-end p-3">
                    <select class="form-control form-control-sm" name="section" id="section" aria-label="Default select example" required>
                        <option value="">Select Section </option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                    </select>

                    <input type="month" name="month" class="form-control form-control-sm" value="" >
                </div>

                <div class="form-group  mx-3 my-3">
                    <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
                </div>
            </form>
        </div>
    </div>



    <div class="col-xl-4 col-md-6 p-2">
        <div class="card bg-light shadow">
            <div class="mx-3 my-2">
                <b class="text-center">Monthly Payment  </b>
            </div>
            <form action="{{ url('pdf/monthly_payment') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="d-grid gap-3 d-flex justify-content-end p-3">
                    <select class="form-control form-control-sm" name="section" id="section" aria-label="Default select example" required>
                        <option value="">Select Section </option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                    </select>

                    <input type="month" name="month" class="form-control form-control-sm" value="" >
                </div>

                <div class="form-group  mx-3 my-3">
                    <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
                </div>
            </form>
        </div>
    </div>



    <div class="col-xl-4 col-md-6 p-2">
        <div class="card bg-light shadow">
            <div class="mx-3 my-2">
                <b class="text-center">Section Wise Invoice </b>
            </div>
            <form action="{{ url('pdf/section_invoice') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="d-grid gap-3 d-flex justify-content-end p-3">
                    <select class="form-control form-control-sm" name="section" id="section" aria-label="Default select example" required>
                        <option value="">Select Section </option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                    </select>

                    <input type="month" name="month" class="form-control form-control-sm" value="" >
                </div>

                <div class="form-group  mx-3 my-3">
                    <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
                </div>
            </form>
        </div>
    </div>



    <div class="col-xl-4 col-md-6 p-2">
        <div class="card bg-light shadow">
            <div class="mx-3 my-2">
                <b class="text-center">Overall Summary </b>
            </div>
            <form action="{{ url('pdf/overall_summary') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="d-grid gap-3 d-flex justify-content-end p-3">
                    <select class="form-control form-control-sm" name="section" id="section" aria-label="Default select example" required>
                        <option value="">Select Section </option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                    </select>

                    <input type="month" name="month" class="form-control form-control-sm" value="" >
                </div>

                <div class="form-group  mx-3 my-3">
                    <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
                </div>
            </form>
        </div>
    </div>



    <div class="col-xl-4 col-md-6 p-2">
        <div class="card bg-light shadow">
            <div class="mx-3 my-2">
                <b class="text-center">Rufund Summary </b>
            </div>
            <form action="{{ url('pdf/refund_summary') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="d-grid gap-3 d-flex justify-content-end p-3">
                    <select class="form-control form-control-sm" name="section" id="section" aria-label="Default select example" required>
                        <option value="">Select Section </option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                    </select>

                    <input type="month" name="month" class="form-control form-control-sm" value="" >
                </div>

                <div class="form-group  mx-3 my-3">
                    <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
                </div>
            </form>
        </div>
    </div>


</div>


<script>  
     $(document).ready(function(){
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
                $('.author_input').hide();

     $("#check_author").on('change', function(){
        if ($("#check_author").is(":checked")) {
           $('.author_input').show();
      }else{
           $('.author_input').hide();
      }
    })

         });
   </script>



@endsection