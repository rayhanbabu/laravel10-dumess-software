@extends('maintain.layout')
@section('page_title','Maintain Panel')
@section('dashboard','active')
@section('content')
<div class="grey-bg container-fluid">
  <section id="minimal-statistics">
  <div class="row mt-3 mb-0 mx-2">
         <div class="col-sm-2 my-2"> <h4 class="mt-0"> Dashboard </h4> </div>
                 <div class="col-sm-4 my-2">
                     <div class="d-grid gap-3 d-flex justify-content-end"> 
                       <form method="post" action="{{url('maintain/member_export')}}"  class="myform"  enctype="multipart/form-data" >
                         {!! csrf_field() !!}
                            <select class="form-select" id="hall_id" name="hall_id" aria-label="Default select example " required>
                                  <option  value="">Select One </option>
                                   @foreach($data as $row)
                                     <option   value="{{$row->hall_id}}">{{$row->hall}}</option>
                                   @endforeach  
                            </select>
                         <input type="submit"   id="insert" onclick="return confirm('Are you sure')" value="Export list" class="btn btn-success mx-3 mt-2"/>
                       </form>  
                     </div>    
                  </div>

                <div class="col-sm-6 my-2 ">
                 <div class="d-grid gap-3 d-flex justify-content-end">
                    <form method="post" action="{{url('maintain/member_import')}}"  class="myform"  enctype="multipart/form-data" >
                      {!! csrf_field() !!}
                        <input type="file" name="file" class="" required>
                        <input type="submit"   id="insert" onclick="return confirm('Are you sure')" value="Import student list" class="btn btn-success mx-3 mt-2"/>
                    </form> 
                 </div>
                </div>
         </div>



    <div class="row">

      <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">64.89 %</h3>
                  <span>Bounce Rate</span>
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


      <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">64.89 %</h3>
                  <span>Bounce Rate</span>
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


      <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">64.89 %</h3>
                  <span>Bounce Rate</span>
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


      <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">64.89 %</h3>
                  <span>Bounce Rate</span>
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


      <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">64.89 %</h3>
                  <span>Bounce Rate</span>
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


      <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">64.89 %</h3>
                  <span>Bounce Rate</span>
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


      <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">64.89 %</h3>
                  <span>Bounce Rate</span>
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



    </div>

       <h4>Excel Import Format</h4>
         <p> 'hall_id'=>$row[0],
            'name'=>$row[1],
            'phone '=>$row[2],
            'card'=>$row[3],
            'registration'=>$row[4],
            'email_verify'=>$row[5],
            'email '=>$row[6],
            'email2'=>$row[7],
            'password'=>$row[8], </p>
  </section>
</div>

@endsection 