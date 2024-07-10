@extends('manager.layout')
@section('page_title','Maintain Panel')
@section('report','active')
@section('content')
<div class="grey-bg container-fluid">
  <section id="minimal-statistics">
    <div class="row">
      <div class="col-12 mt-3 mb-1">
         <h4 class="text-uppercase"> Reports/ Current Module : {{$hallinfo->cur_year}} - {{$hallinfo->cur_month}} - {{$hallinfo->cur_section}} </h4>
      </div>
    </div>



    <div class="row">


    <div class="col-xl-4 col-sm-6 col-12 p-2">
          <div class="card shadow">
           <div class="card-content">
             <div class="card-body">
               <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">{{ $payment1->sum('payble_amount1')+$payment2->sum('payble_amount2')}} TK </h3>
                  <span> Online Amount Collection </span>
                </div>
                  <div class="align-self-center">
                    <i class="icon-cup success font-large-2 float-right"></i>
                  </div>
               </div>
                <div class="progress mt-1 mb-0" style="height: 7px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
          </div>
        </div>
      </div>


      <div class="col-xl-4 col-sm-6 col-12 p-2">
          <div class="card shadow">
           <div class="card-content">
             <div class="card-body">
               <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">{{ $withdraw->sum('withdraw_amount')}} TK</h3>
                  <span> Online Settled  </span>
                </div>
                  <div class="align-self-center">
                    <i class="icon-cup success font-large-2 float-right"></i>
                  </div>
               </div>
                <div class="progress mt-1 mb-0" style="height: 7px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
          </div>
        </div>
      </div>


      <div class="col-xl-4 col-sm-6 col-12 p-2">
          <div class="card shadow">
           <div class="card-content">
             <div class="card-body">
               <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">{{ ($payment1->sum('payble_amount1')+$payment2->sum('payble_amount2')) - $withdraw->sum('withdraw_amount')}} TK </h3>
                  <span> Available Online Amount  </span>
                </div>
                  <div class="align-self-center">
                    <i class="icon-cup success font-large-2 float-right"></i>
                  </div>
               </div>
                <div class="progress mt-1 mb-0" style="height: 7px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
          </div>
        </div>
      </div>


      <div class="col-xl-4 col-md-6 p-2">
        <div class="card bg-light shadow">
             <div class="mx-3 my-2">
                 <b class="text-center">Table:1 Member List </b>
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
                <b class="text-center">Table:2 Active member </b>
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
                <b class="text-center">Table:3 Module Wise Invoice </b>
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
                 <b class="text-center">Table:4 Date Wise Payment</b>
            </div>
            <form action="{{ url('pdf/range_wise_payment') }}" method="post" enctype="multipart/form-data">
                   {!! csrf_field() !!}
                  <div class="d-grid gap-3 d-flex justify-content-end p-3">
                        <select class="form-control form-control-sm" name="payment_type" id="payment_type" aria-label="Default select example" required>
                            <option value=""> Type </option>
                            <option value="Offline">Offline</option>
                            <option value="Online">Online</option>
                        </select>

                       <input type="date" name="date1" class="form-control form-control-sm" value="" >      
                          To
                       <input type="date" name="date2" class="form-control form-control-sm" value="" >
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
                 <b class="text-center">Table:5 Module wise Payment </b>
            </div>
            <form action="{{ url('pdf/monthly_payment_invoice') }}" method="post" enctype="multipart/form-data">
                   {!! csrf_field() !!}
                  <div class="d-grid gap-3 d-flex justify-content-end p-3">
                     <select class="form-control form-control-sm" name="payment_type" id="payment_type" aria-label="Default select example" required>
                           <option value="">Type </option>
                           <option value="Offline">Offline</option>
                           <option value="Online">Online</option>
                       </select>
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
                <b class="text-center">Table:6 Module Wise Payment Summary </b>
            </div>
            <form action="{{ url('pdf/monthly_payment') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="d-grid gap-3 d-flex justify-content-end p-3">
                    
                     <select class="form-control form-control-sm" name="payment_type" id="payment_type" aria-label="Default select example" required>
                           <option value="">Type </option>
                           <option value="Offline">Offline</option>
                           <option value="Online">Online</option>
                       </select>

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
                  <b class="text-center">Table:7 Online Settlement Payment </b>
              </div>
            <form action="{{ url('pdf/settlement_history') }}" method="post" enctype="multipart/form-data">
                   {!! csrf_field() !!}
                  <div class="d-grid gap-3 d-flex justify-content-end p-3">
                    
                       <select class="form-control form-control-sm" name="section" id="section" aria-label="Default select example" required>
                           <option value="">Select Section</option>
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
                 <b class="text-center"> Table:8 Due Invoice Summary  </b>
            </div>
            <form action="{{ url('pdf/due_invoice') }}" method="post" enctype="multipart/form-data">
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
                <b class="text-center">Table:9 Rufund Summary </b>
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


    <div class="col-xl-4 col-md-6 p-2">
        <div class="card bg-light shadow">
            <div class="mx-3 my-2">
                 <b class="text-center">Table:10 Withdraw Invoice Summary  </b>
            </div>
            <form action="{{ url('pdf/withdraw_invoice') }}" method="post" enctype="multipart/form-data">
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
                 <b class="text-center">Table:11 Member Invoice Summary  </b>
            </div>
            <form action="{{ url('pdf/member_invoice_summary') }}" method="post" enctype="multipart/form-data">
                   {!! csrf_field() !!}         
                      <div class="d-grid gap-3 d-flex justify-content-end p-3">
                         <label>Card </label>
                         <input type="text" name="card" class="form-control form-control-sm" value="" >
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
                 <b class="text-center">Table:12 Range wise Inactive Member </b>
            </div>
            <form action="{{ url('pdf/range_inactive_member') }}" method="post" enctype="multipart/form-data">
                   {!! csrf_field() !!}
                  <div class="d-grid gap-3 d-flex justify-content-end p-3">
                       <input type="date" name="date1" class="form-control form-control-sm" value="" >      
                          To
                       <input type="date" name="date2" class="form-control form-control-sm" value="" >
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
                  <b class="text-center">Table:13 Extra Payment Summary </b>
              </div>
            <form action="{{ url('pdf/extra_payment') }}" method="post" enctype="multipart/form-data">
                   {!! csrf_field() !!}
                  <div class="d-grid gap-3 d-flex justify-content-end p-3">
                      <select class="form-control form-control-sm" name="section" id="section" aria-label="Default select example" required>
                          <option value="">Select Section</option>
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
                <b class="text-center">Table:14 Overall Summary </b>
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