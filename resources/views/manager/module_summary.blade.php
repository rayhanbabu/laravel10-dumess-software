@extends('manager.layout')
@section('title','Admin Panel')
@section('module_summary','active')
@section('content')


<div class="row mt-3 mb-0 mx-2">
  <div class="col-sm-3 my-2">
      <h4 class="mt-0"> Module Summary </h4>
  </div>

  <div class="col-sm-3 my-2">
    <div class="d-grid gap-2 d-flex justify-content-end">
     
    </div>
  </div>

  <div class="col-sm-6 my-2 ">
    <div class="d-grid gap-3 d-flex justify-content-end">

    </div>
  </div>
</div>


<div class="card-block table-border-style">
    <div class="table-responsive">
        <table class="table table-bordered" id="employee_data">
            <thead>
                <tr>
                    <th width="10%">Module (Month- year- section) </th>
                    <th width="10%">Meal Start Date </th>
                    <th width="10%">Module Day </th>
                    <th width="10%">Next Manager Get </th>
                    <th width="10%">Total Earn </th>
                    <th width="10%">Total Spend </th>
                    <th width="15%">Fund Transfer Next manager</th>
                    <th width="10%">(-Extra) / (+Reserve)</th>
                </tr>


            </thead>
            <tbody>

                @foreach($data as $row)
                   <tr>
                       @php
                          $resign_info=resign_info($row->hall_id,$row->invoice_year,$row->invoice_month,$row->invoice_section);
                          $next_manager_get=(($row->pre_refund+$row->pre_reserve_amount)-$row->pre_monthdue)+(($resign_info->sum('pre_refund')+$resign_info->sum('pre_reserve_amount'))-$resign_info->sum('pre_monthdue')) ;
                       @endphp
                    <td> {{$row->invoice_month}}-{{$row->invoice_year}}-{{$row->invoice_section}}  </td>
                    <td> {{$row->meal_start_date}}  </td> 
                    <td> {{$row->section_day}}  </td>
                    <td> {{$next_manager_get}}  </td>
                    <td> {{$next_manager_get+resign_amount($row->hall_id,$row->invoice_year,$row->invoice_month,$row->invoice_section)+$row->payble_amount1+$row->payble_amount2+extra_payment($row->hall_id,$row->invoice_year,$row->invoice_month,$row->invoice_section)}}  </td>
                   
                    <td> </td>
                    <td> {{($row->total_refund+$row->reserve_amount)-$row->total_due}} </td>
                     <td></td>

                   
                </tr>
                @endforeach

            </tbody>
        </table>

        <script>
            $(document).ready(function(){
                $('#employee_data').DataTable({
                    "order": [
                        [0, "desc"]
                    ],
                    "lengthMenu": [
                        [10, 50, 100, -1],
                        [10, 50, 100, "All"]
                    ]
                });
            });
        </script>
    </div>
</div>


@endsection