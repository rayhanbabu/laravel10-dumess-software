@extends('manager.layout')
@section('title','Manager Panel')
@section('section','active')
@section('content')

<div class="row mt-3 mb-0 mx-2">
    <div class="col-sm-3 my-2">
        <h5 class="mt-0">Section Information </h5>
    </div>
    @if(manager_info()['role']=='admin')
    <div class="col-sm-3 my-2">
        <div class="d-grid gap-2 d-flex justify-content-start">
            <h4> </h4>
        </div>
    </div>


    <div class="col-sm-3 my-2 ">
        <div class="d-grid gap-3 d-flex justify-content-end">

        </div>
    </div>
    @endif

    <div class="col-sm-3 my-2 ">
        <div class="d-grid gap-3 d-flex justify-content-end">

        </div>
    </div>


    @if(Session::has('success'))
    <div class="alert alert-success"> {{Session::get('success')}} </div>
    @endif

    @if(Session::has('fail'))
    <div class="alert alert-danger"> {{Session::get('fail')}} </div>
    @endif
</div>



<div class="card-block table-border-style">
    <div class="table-responsive">
        <table class="table table-bordered" id="employee_data">
            <thead>
                <tr>
                    <th width="10%">Card No</th>
                    <th width="10%">Name</th>
                    <th width="10%">Registration/ Seat No</th>
                    <th width="10%">Invoice No</th>
                    <th width="10%">Invoice Month</th>
                    <th width="10%">Invoice Section</th>
                    <th width="10%">Previous Reserve Amount</th>
                    <th width="10%">Previous refund total</th>
                    <th width="10%">Previous month due</th>
                    <th width="10%">Edit</th>

                    <th width="10%">Hostel Fee</th>
                    <th width="10%">Total Section day </th>
                    <th width="10%">Breakfast rate</th>
                    <th width="10%">Lunch rate</th>
                    <th width="10%">Dinner rate</th>
                    <th width="10%">Total Meal Amount </th>

                    <th width="10%">Employee </th>
                    <th width="10%">Friday</th>
                    <th width="10%">Feast</th>
                    <th width="10%">Welfare</th>
                    <th width="10%">Others</th>

                    <th width="10%">Gass</th>
                    <th width="10%">Electricity</th>
                    <th width="10%">Tissue</th>
                    <th width="10%">Water</th>
                    <th width="10%">Dirt</th>
                    <th width="10%">Wifi</th>

                    <th width="10%">Card Fee</th>
                    <th width="10%">Security Money</th>
                    <th width="10%">Service Charge</th>
                    <th width="10%">Meeting Penalty</th>
                    <th width="10%">Total Others Amount</th>
                    <th width="10%">Total Amount</th>
                    <th width="10%">Total Withdraw Amount</th>
                    <th width="10%">Withdraw Status</th>
                    <th width="10%">Total Inactive Meal Amount</th>
                    <th width="10%">Paybale Amount</th>

                    <th width="10%">First Meal No</th>
                    <th width="10%">First Meal Amount</th>
                    <th width="10%">First Others Amount</th>
                    <th width="10%">First Paybale Amount</th>
                    <th width="10%">First Paybale Status</th>

                    <th width="10%">Second Meal No</th>
                    <th width="10%">Second Meal Amount</th>
                    <th width="10%">Second Others Amount</th>
                    <th width="10%">Secound Paybale Amount</th>
                    <th width="10%">Second Paybale Status</th>

                    <th width="10%">Breakfast ON Meal</th>
                    <th width="10%">Breakfast OFF Meal</th>
                    <th width="10%">Breakfast Inactive Meal</th>

                    <th width="10%">Lunch ON Meal</th>
                    <th width="10%">Lunch OFF Meal</th>
                    <th width="10%">Lunch Inactive Meal</th>

                    <th width="10%">Dinner ON Meal</th>
                    <th width="10%">Dinner OFF Meal</th>
                    <th width="10%">Dinner Inactive Meal</th>

                    <th width="10%">Total ON Meal Amount</th>

                    <th width="10%">Refund Breakfast rate</th>
                    <th width="10%">Refund Lunch rate</th>
                    <th width="10%">Refund Dinner rate</th>
                    <th width="10%">Reduce Meal Amount</th>
                    <th width="10%">Total OFF Meal Amount</th>

                    <th width="10%">Refund feast </th>
                    <th width="10%">Refund Welfare </th>
                    <th width="10%">Refund friday</th>
                    <th width="10%">Refund employee</th>
                    <th width="10%">Refund Others</th>

                    <th width="10%">Refund tissue</th>
                    <th width="10%">Refund gass</th>
                    <th width="10%">Refund electricity</th>
                    <th width="10%">Refund water</th>
                    <th width="10%">Refund wifi</th>
                    <th width="10%">Refund dirt</th>

                    <th width="10%">Total refund</th>
                    <th width="10%">Due amount</th>
                    <th width="10%">Reserve amount</th>
                </tr>
            </thead>
            <tbody>

                @foreach($invoice as $row)
                <tr>
                    <?php if ($row['onmeal_amount'] <= 0) {
                        $over = 'style="background:#fccccc"';
                    } else {
                        $over = '';
                    } ?>
                <tr <?php echo  $over; ?>>
                    <td><?php echo $row['card']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['registration']; ?></td>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo date('M-Y', strtotime($row['invoice_date'])); ?></td>
                    <td><?php echo $row['invoice_section']; ?></td>
                    <td><?php echo $row['pre_reserve_amount']; ?></td>
                    <td><?php echo $row['pre_refund']; ?></td>
                    <td><?php echo $row['pre_monthdue']; ?></td>

                    <td> <button type="button" value="{{ $row->id}}" class="edit btn btn-info btn-sm">Edit </button> </td>


                    <td><?php echo $row['hostel_fee']; ?></td>
                    <td><?php echo $row['section_day']; ?></td>
                    <td><?php echo $row['breakfast_rate']; ?></td>
                    <td><?php echo $row['lunch_rate']; ?></td>
                    <td><?php echo $row['dinner_rate']; ?></td>
                    <td><?php echo $row['cur_meal_amount']; ?>TK</td>


                    <td><?php echo $row['employee']; ?>TK</td>
                    <td><?php echo $row['friday']; ?>TK</td>
                    <td><?php echo $row['feast']; ?>TK</td>
                    <td><?php echo $row['welfare']; ?>TK</td>
                    <td><?php echo $row['others']; ?>TK</td>
                    <td><?php echo $row['gass']; ?>TK</td>
                    <td><?php echo $row['electricity']; ?>TK</td>
                    <td><?php echo $row['tissue']; ?>TK</td>
                    <td><?php echo $row['water']; ?>TK</td>
                    <td><?php echo $row['dirt']; ?>TK</td>
                    <td><?php echo $row['wifi']; ?>TK</td>

                    <td><?php echo $row['card_fee']; ?>TK</td>
                    <td><?php echo $row['security']; ?>TK</td>
                    <td><?php echo $row['service_charge']; ?>TK</td>
                    <td><?php echo $row['meeting_penalty']; ?>TK</td>
                    <td><?php echo $row['cur_others_amount']; ?>TK</td>
                    <td><?php echo $row['cur_total_amount']; ?>TK</td>
                    <td><?php echo $row['withdraw']; ?> TK</td>
                    <td><?php echo $row['withdraw_status']; ?> </td>
                    <td><?php echo $row['inmeal_amount']; ?> TK</td>
                    <td><?php echo $row['payble_amount']; ?>TK</td>

                    <td><?php echo $row['first_pay_mealon']; ?> </td>
                    <td><?php echo $row['first_pay_mealamount']; ?>TK</td>
                    <td><?php echo $row['first_others_amount']; ?>TK</td>
                    <td><?php echo $row['payble_amount1']; ?>TK</td>
                    <td><?php echo $row['payment_status1']; ?></td>

                    <td><?php echo $row['second_pay_mealon']; ?></td>
                    <td><?php echo $row['second_pay_mealamount']; ?>TK</td>
                    <td><?php echo $row['second_others_amount']; ?>TK</td>
                    <td><?php echo $row['payble_amount2']; ?>TK</td>
                    <td><?php echo $row['payment_status2']; ?></td>

                    <td><?php echo $row['breakfast_onmeal']; ?></td>
                    <td><?php echo $row['breakfast_offmeal']; ?></td>
                    <td><?php echo $row['breakfast_inmeal']; ?></td>
                    <td><?php echo $row['lunch_onmeal']; ?></td>
                    <td><?php echo $row['lunch_offmeal']; ?></td>
                    <td><?php echo $row['lunch_inmeal']; ?></td>
                    <td><?php echo $row['dinner_onmeal']; ?></td>
                    <td><?php echo $row['dinner_offmeal']; ?></td>
                    <td><?php echo $row['dinner_inmeal']; ?></td>

                    <td><?php echo $row['onmeal_amount']; ?>TK</td>

                    <td><?php echo $row['refund_breakfast_rate']; ?> </td>
                    <td><?php echo $row['refund_lunch_rate']; ?> </td>
                    <td><?php echo $row['refund_dinner_rate']; ?> </td>
                    <td><?php echo $row['mealreducetk']; ?>TK</td>
                    <td><?php echo $row['offmeal_amount']; ?>TK</td>

                    <td><?php echo $row['refund_feast']; ?>TK</td>
                    <td><?php echo $row['refund_welfare']; ?>TK</td>
                    <td><?php echo $row['refund_friday']; ?>TK</td>
                    <td><?php echo $row['refund_employee']; ?>TK</td>
                    <td><?php echo $row['refund_others']; ?>TK</td>

                    <td><?php echo $row['refund_tissue']; ?>TK</td>
                    <td><?php echo $row['refund_gass']; ?>TK</td>
                    <td><?php echo $row['refund_electricity']; ?>TK</td>
                    <td><?php echo $row['refund_water']; ?>TK</td>
                    <td><?php echo $row['refund_wifi']; ?>TK</td>
                    <td><?php echo $row['refund_dirt']; ?>TK</td>

                    <td><?php echo $row['total_refund']; ?>TK</td>
                    <td><?php echo $row['total_due']; ?>TK</td>
                    <td><?php echo $row['reserve_amount']; ?>TK</td>

                </tr>


                @endforeach


            </tbody>
        </table>

        <script>
            $(document).ready(function() {
                $('#employee_data').DataTable({
                    "order": [
                        [0, "asc"]
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