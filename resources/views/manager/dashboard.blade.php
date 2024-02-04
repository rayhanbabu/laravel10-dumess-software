@extends('manager.layout')
@section('page_title','Maintain Panel')
@section('dashboard','active')
@section('content')
<div class="grey-bg container-fluid">
  <section id="minimal-statistics">
    <div class="row">
      <div class="col-12 mt-3 mb-1">
         <h4 class="text-uppercase">Current Section : {{$hallinfo->cur_year}}-{{$hallinfo->cur_month}}-{{$hallinfo->cur_section}}</h4>
      </div>
    </div>

    <div class="row">
       <div class="col-xl-3 col-sm-6 col-12 p-2">
         <div class="card shadow">
           <div class="card-content">
             <div class="card-body">
               <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">{{$invoice->count('id')}}</h3>
                  <span>Total Member</span>
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
                  <h3 class="success">{{$active_invoice->count('id')}}</h3>
                  <span> Active Member </span>
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
                  <h3 class="success">{{ ($invoice->count('id')-$active_invoice->count('id'))}}</h3>
                  <span> Inactive Member</span>
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
                  <h3 class="success"> {{($invoice->sum('pre_refund')+$exinvoice->sum('pre_refund')+
                    $invoice->sum('pre_reserve_amount')+$exinvoice->sum('pre_reserve_amount'))
                    -($invoice->sum('pre_monthdue')+$exinvoice->sum('pre_monthdue')) }}TK </h3>
                  <span> Recevied Previous Manager </span>
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
                  <h3 class="success">{{ $payment1->count('payble_amount1') }}</h3>
                  <span>1st Payment Paid Member</span>
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
                  <h3 class="success">{{ $payment2->count('payble_amount2') }}</h3>
                  <span>2nd Payment Paid Member</span>
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
                  <h3 class="success">{{ $payment1->sum('payble_amount1') }}TK</h3>
                  <span>1st Payment Amount</span>
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
                  <h3 class="success">{{ $payment2->sum('payble_amount2') }}TK</h3>
                  <span>2nd Payment Amount</span>
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
                  <h3 class="success">{{ $payment1->sum('payble_amount1')+$payment2->sum('payble_amount2') }}TK</h3>
                  <span> Total Payment Amount</span>
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
                  <h3 class="success">{{ $payment1->sum('payble_amount1')+$payment2->sum('payble_amount2')+$invoice->sum('withdraw') }}TK</h3>
                  <span> Total Cash(Manager recived+Total Amount+Resign)</span>
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
       
             <?php
                  $next =0;
                  $from_date = date('d-m-Y',strtotime("+".$next." days"));
                  $day = date('d-M',strtotime($from_date));
              ?>

      <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">{{$cur_meal}}</h3>
                  <span>{{ date('d-M',strtotime($hallinfo->meal_start_date))}} to {{$day}} Total Meal</span>
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
                  <h3 class="success">{{$estimate_bazar}}TK</h3>
                  <span>{{ date('d-M',strtotime($hallinfo->meal_start_date))}} to {{$day}} Estimated Bazar</span>
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
                  <h3 class="success"> {{$bazar->sum('total')}}TK </h3>
                  <span>{{ date('d-M',strtotime($hallinfo->meal_start_date))}} to {{$day}}  Total Bazar</span>
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
                  <h3 class="success">{{ abs($estimate_bazar-$bazar->sum('total')) }}TK</h3>
                  <span> @if($estimate_bazar>=$bazar->sum('total')) 
                  Reserve bazar amount  @else Extra bazar amount @endif</span>
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
                  <h3 class="success">{{ ($payment1->sum('payble_amount1')+$payment2->sum('payble_amount2')+$invoice->sum('withdraw'))-$bazar->sum('total')}}TK</h3>
                  <span> Reserve cash amount </span>
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
  </section>
</div>

@endsection 