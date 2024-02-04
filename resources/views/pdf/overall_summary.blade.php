<!DOCTYPE html>
<html>

<head>
  <script>
    function printContent(e1) {
      var restorepage = document.body.innerHTML;
      var printcontent = document.getElementById(e1).innerHTML;
      document.body.innerHTML = printcontent;
      window.print();
      document.body.innerHTML = restorepage;
    }
  </script>
  <title> </title>

  <style>
    @media print {
      @page {
        margin: 0;
      }

      body {
        margin: 1.6cm;
      }
    }

    * {
      box-sizing: border-box;
    }

    .row {
      margin-left: -5px;
      margin-right: -5px;
    }

    .column {
      float: left;
      width: 350px;
      padding: 10px;
    }

    /* Clearfix (clear floats) */
    .row::after {
      content: "";
      clear: both;
      display: table;
    }

    table {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
    }

    td,
    th {
      border: 2px solid #acacac;
    }

    td,
    th {
      padding: 3px;
      font-size: 17px;
    }
  </style>

</head>

<body>
  <center>
    <br>
    <button class="btn success" onclick="printContent('div1')">Print </button>
    <div id="div1">


      <center>
        <h4> {{ manager_info()['hall_name'] }} <br>
          Section Invoice List<br>
          @if($section) {{$month1}} -{{$section}} @else @endif</h4>
      </center>

      @php 
              $admin_get=($invoice->sum('mealreducetk')+$invoice->sum('card_fee')
                +$invoice->sum('service_charge')+$invoice->sum('security')) - $invoice->sum('security_money');
           
           @endphp 

      <div class="row">

        <div class="column">
          <table>
            <tr>
              <td colspan="2" width="240"><b>Table 1:Manager get in </b></td>
            </tr>

            <tr>
              <td align="left" width="160">Total Refund Previous Month</td>
              <td align="right" width="80"> {{ $invoice->sum('pre_refund')+$exinvoice->sum('pre_refund')}} TK</td>
            </tr>

            <tr>
              <td align="left" width="160">Total Reserve Previous Month</td>
              <td align="right" width="80"> {{ $invoice->sum('pre_reserve_amount')+$exinvoice->sum('pre_reserve_amount') }} TK</td>
            </tr>

            <tr>
              <td align="left" width="160">Due amount Previous Month</td>
              <td align="right" width="80"> {{ $invoice->sum('pre_monthdue')+$exinvoice->sum('pre_monthdue') }} TK</td>
            </tr>

            <tr>
              <th align="left" width="160">Total Manager get</th>
              <th align="right" width="80">{{($invoice->sum('pre_refund')+$exinvoice->sum('pre_refund')+
                    $invoice->sum('pre_reserve_amount')+$exinvoice->sum('pre_reserve_amount'))
                    -($invoice->sum('pre_monthdue')+$exinvoice->sum('pre_monthdue')) }} TK</th>

                   @php 
                      $manager_get=($invoice->sum('pre_refund')+$exinvoice->sum('pre_refund')+
                          $invoice->sum('pre_reserve_amount')+$exinvoice->sum('pre_reserve_amount'))
                         -($invoice->sum('pre_monthdue')+$exinvoice->sum('pre_monthdue'));
                   @endphp
            </tr>

          </table>
        </div>

        <div class="column">

        <table>

<tr>
  <td colspan="2" width="240"><b>Table 2:Bazar summary</b></td>
</tr>

  <tr>
     <td align="left" width="160">Active Meal Amount</td>
     <td align="right" width="80">{{ $invoice->sum('onmeal_amount') }}TK</td>
  </tr>


<tr>
   <td align="left" width="160"> Friday Amount</td>
   <td align="right" width="80">{{ ($invoice->sum('friday')- $invoice->sum('refund_friday')) }}TK</td>
</tr>

<tr>
   <td align="left" width="160">Feast Amount</td>
   <td align="right" width="80">{{ ($invoice->sum('feast')-$invoice->sum('refund_feast')) }}TK</td>
</tr>

<tr>
  <th align="left" width="160">Monthly estimated bazar</th>
  <th align="right" width="80">{{($invoice->sum('onmeal_amount')+($invoice->sum('friday')- $invoice->sum('refund_friday'))
    +($invoice->sum('feast')-$invoice->sum('refund_feast'))) }}TK</th>
</tr>


<tr>
  <td align="left" width="160"></td>
  <td align="right" width="80"></td>
</tr>



<tr>
  <td align="left" width="160">Monthly Total Bazar</td>
  <td align="right" width="80">{{$bazar->sum('total')}}TK</td>
</tr>

<tr>
    <td align="left" width="160">Extra Bazar</td>
    <td align="right" width="80"> {{($invoice->sum('onmeal_amount')+($invoice->sum('friday')- $invoice->sum('refund_friday'))
    +($invoice->sum('feast')-$invoice->sum('refund_feast')))-$bazar->sum('total')}}TK </td>
</tr>

</table>


         
        </div>
      </div>
  

      <div class="row">
        <div class="column">
          <table>

            <tr>
              <td colspan="2" width="240"><b>Table 3:Invoice summary</b></td>
            </tr>

            <tr>
              <td align="left" width="160">Total meal amount</td>
              <td align="right" width="80"> {{$invoice->sum('cur_meal_amount')}}TK </td>
            </tr>

            <tr>
              <td align="left" width="160">Total friday amount</td>
              <td align="right" width="80"> {{$invoice->sum('friday')}}TK </td>
            </tr>

            <tr>
              <td align="left" width="160">Feast</td>
              <td align="right" width="80"> {{$invoice->sum('feast')}}TK </td>
            </tr>

            <tr>
              <td align="left" width="160">Employee</td>
              <td align="right" width="80"> {{$invoice->sum('employee')}}TK </td>
            </tr>

            <tr>
              <td align="left" width="160">Welfare</td>
              <td align="right" width="80"> {{$invoice->sum('welfare')}}TK </td>
            </tr>


            <tr>
              <td align="left" width="160">Others</td>
              <td align="right" width="80"> {{$invoice->sum('others')}}TK </td>
            </tr>

            <tr>
              <td align="left" width="160">Gass</td>
              <td align="right" width="80"> {{$invoice->sum('gass')}}TK </td>
            </tr>

            <tr>
              <td align="left" width="160">Electicity</td>
              <td align="right" width="80"> {{$invoice->sum('electricity')}}TK </td>
            </tr>


            <tr>
              <td align="left" width="160">Tissue</td>
              <td align="right" width="80"> {{$invoice->sum('tissue')}}TK </td>
            </tr>


            <tr>
              <td align="left" width="160">Water</td>
              <td align="right" width="80"> {{$invoice->sum('water')}}TK </td>
            </tr>

            <tr>
              <td align="left" width="160">Dirt</td>
              <td align="right" width="80"> {{$invoice->sum('dirt')}}TK </td>
            </tr>

            <tr>
              <td align="left" width="160">Wifi</td>
              <td align="right" width="80"> {{$invoice->sum('wifi')}}TK </td>
            </tr>



            <tr>
              <td align="left" width="160">Card Fee</td>
              <td align="right" width="80"> {{$invoice->sum('card_fee')}}TK </td>
            </tr>


            <tr>
              <td align="left" width="160">Meeting Fee</td>
              <td align="right" width="80">{{$invoice->sum('meeting_penalty')}}TK </td>
            </tr>

            <tr>
              <td align="left" width="160">Security Money</td>
              <td align="right" width="80"> {{$invoice->sum('security')}}TK </td>
            </tr>

            <tr>
              <td align="left" width="160">Service Charge</td>
              <td align="right" width="80"> {{$invoice->sum('service_charge')}}TK </td>
            </tr>

            <tr>
              <th align="left" width="160">Total Invoice amount</th>
              <th align="right" width="80"> {{$invoice->sum('cur_total_amount')}}TK </th>
            </tr>

            <tr>
              <th align="left" width="160"> Inactive Meal Amount </th>
              <th align="right" width="80"> {{$invoice->sum('inmeal_amount')}}TK </th>
            </tr>

            <tr>
              <th align="left" width="160"> Manager get </th>
              <th align="right" width="80"> {{ $manager_get }}TK </th>
            </tr>

            <tr>
              <th align="left" width="160"> Payment Invoice </th>
              <th align="right" width="80"> {{$invoice->sum('cur_total_amount')-$invoice->sum('inmeal_amount')-$manager_get}}TK </th>
              @php 
                   $payment_invoice=$invoice->sum('cur_total_amount')-$invoice->sum('inmeal_amount')-$manager_get;
              @endphp
           
            </tr>

          </table>
        </div>




       <div class="column">
       <table>
            <tr>
                 <td colspan="2" width="240"><b>Table :4 Total Spends </b></td>
            </tr>

            <tr>
              <td align="left" width="160"> Monthly total bazar </td>
              <td align="right" width="80"> {{$bazar->sum('total')}}TK </td>
            </tr>
 
            <tr>
              <td align="left" width="160">Fund transfer to next manager</td>
              <td align="right" width="80">{{$invoice->sum('total_refund')-($payment_invoice -($payment1->sum('payble_amount1')+$payment2->sum('payble_amount2')))}} </td>
            </tr>
             @php 
              $refund= $invoice->sum('total_refund')-($payment_invoice -($payment1->sum('payble_amount1')+$payment2->sum('payble_amount2')))
             @endphp

            <tr>
              <td align="left" width="160">Employee salary</td>
              <td align="right" width="80"> {{$invoice->sum('employee')-$invoice->sum('refund_employee')}}TK </td>
            </tr>


            <tr>
              <td align="left" width="160"> Meeting fee </td>
              <td align="right" width="80">{{$invoice->sum('meeting_penalty')}}TK </td>
            </tr>

             

            <tr>
              <td align="left" width="160">Welfare</td>
              <td align="right" width="80">{{$invoice->sum('welfare')-$invoice->sum('refund_welfare')}}TK  </td>
            </tr>


            <tr>
              <td align="left" width="160">Others</td>
              <td align="right" width="80"> {{$invoice->sum('others')-$invoice->sum('refund_others')}}TK </td>
            </tr>

            <tr>
              <td align="left" width="160">Gass</td>
              <td align="right" width="80"> {{$invoice->sum('gass')-$invoice->sum('refund_gass')}}TK </td>
            </tr>

            <tr>
              <td align="left" width="160">Electicity</td>
              <td align="right" width="80"> {{$invoice->sum('electricity')-$invoice->sum('refund_electricity')}}TK </td>
            </tr>


            <tr>
              <td align="left" width="160">Tissue</td>
              <td align="right" width="80"> {{$invoice->sum('tissue')-$invoice->sum('refund_tissue')}}TK </td>
            </tr>


            <tr>
              <td align="left" width="160">Water</td>
              <td align="right" width="80"> {{$invoice->sum('water')-$invoice->sum('refund_water')}}TK </td>
            </tr>

            <tr>
              <td align="left" width="160">Dirt</td>
              <td align="right" width="80"> {{$invoice->sum('dirt')-$invoice->sum('refund_dirt')}}TK </td>
            </tr>

            <tr>
              <td align="left" width="160">Wifi</td>
              <td align="right" width="80"> {{$invoice->sum('wifi')-$invoice->sum('refund_wifi')}}TK </td>
            </tr>



            <tr>
              <th align="left" width="160">Admin get</th>
              <th align="right" width="80">{{$admin_get}} </th>
            </tr>


          <tr>
             <th align="left" width="160">Total Spends</th>
             <th align="right" width="80">{{ $bazar->sum('total')+$refund +$admin_get+
                ($invoice->sum('employee')-$invoice->sum('refund_employee'))+$invoice->sum('meeting_penalty')
                +($invoice->sum('others')-$invoice->sum('refund_others'))+($invoice->sum('gass')-$invoice->sum('refund_gass'))
                +($invoice->sum('electricity')-$invoice->sum('refund_electricity'))+($invoice->sum('tissue')-$invoice->sum('refund_tissue'))
                +($invoice->sum('water')-$invoice->sum('refund_water'))+($invoice->sum('wifi')-$invoice->sum('refund_wifi'))
                +($invoice->sum('welfare')-$invoice->sum('refund_welfare')) }}</th>
          </tr>

            <tr>
               <th align="left" width="160">Extra Spends</th>
               <th align="right" width="80"> {{ ($payment1->sum('payble_amount1')+$payment2->sum('payble_amount2')+$invoice->sum('withdraw'))
                 -($bazar->sum('total')+$refund +$admin_get+
                 ($invoice->sum('employee')-$invoice->sum('refund_employee'))+$invoice->sum('meeting_penalty')
                 +($invoice->sum('others')-$invoice->sum('refund_others'))+($invoice->sum('gass')-$invoice->sum('refund_gass'))
                 +($invoice->sum('electricity')-$invoice->sum('refund_electricity'))+($invoice->sum('tissue')-$invoice->sum('refund_tissue'))
                 +($invoice->sum('water')-$invoice->sum('refund_water'))+($invoice->sum('wifi')-$invoice->sum('refund_wifi'))
                 +($invoice->sum('welfare')-$invoice->sum('refund_welfare')))}}</th>
             </tr>

          </table>
        </div>
      </div>

             <br><br><br><br>
      <div class="row">
        <div class="column">
          <table>

            <tr>
              <td colspan="2" width="240"><b>Table 5:Payment summary </b></td>
            </tr>

            <tr>
              <td align="left" width="160">Total member</td>
              <td align="right" width="80">{{$invoice->count('id')}}</td>
            </tr>

            <tr>
              <td align="left" width="160">Active member</td>
              <td align="right" width="80">{{$active_invoice->count('id')}}</td>
            </tr>

            <tr>
              <td align="left" width="160">Inactive member</td>
              <td align="right" width="80">{{ ($invoice->count('id')-$active_invoice->count('id'))}}</td>
            </tr>

            <tr>
              <td align="left" width="160">Resign member</td>
              <td align="right" width="80">{{$exinvoice->count('id')}}</td>
            </tr>

            <tr>
              <td align="left" width="160">1st Invoice payment</td>
              <td align="right" width="80">{{ $payment1->sum('payble_amount1') }}TK</td>
            </tr>

            <tr>
              <td align="left" width="160">2nd Invoice payment</td>
              <td align="right" width="80">{{ $payment2->sum('payble_amount2') }}TK</td>
            </tr>

            <tr>
              <th align="left" width="160">Total Payment</th>
              <th align="right" width="80"> {{ $payment1->sum('payble_amount1')+$payment2->sum('payble_amount2') }}TK</th>
            </tr>

            <tr>
              <th align="left" width="160">Invoice due amount</th>
              <th align="right" width="80">{{ $payment_invoice -($payment1->sum('payble_amount1')+$payment2->sum('payble_amount2'))}}TK</th>
            </tr>

          </table>
        </div>

        <div class="column">
          <table>

            <tr>
              <td colspan="2" width="240"><b>Table :6 Refund next manager and get employee </b></td>
            </tr>

            <tr>
              <td align="left" width="160">Refund next manager</td>
              <td align="right" width="80">{{$invoice->sum('total_refund')}}TK</td>
            </tr>

            <tr>
              <td align="left" width="160">Reserve Amount</td>
              <td align="right" width="80">{{$invoice->sum('reserve_amount')}}TK</td>
            </tr>


            <tr>
              <td align="left" width="160">Employee Salary</td>
              <td align="right" width="80">{{$invoice->sum('employee')-$invoice->sum('refund_employee')}}TK</td>
            </tr>

          </table>
        </div>
      </div>


      <div class="row">
        <div class="column">
          <table>

            <tr>
                <td colspan="2" width="240"><b>Table 7: Total Earns </b></td>
            </tr>

            <tr>
                <th align="left" width="160">Total Payment</th>
                <th align="right" width="80">{{$payment1->sum('payble_amount1')+$payment2->sum('payble_amount2')}}TK</th>
            </tr>

            <tr>
                <th align="left" width="160">Received by Previous manager</th>
                <th align="right" width="80">{{$manager_get}}TK</th>
            </tr>

            <tr>
              <td align="left" width="160">Total Resign payment</td>
              <td align="right" width="80"> {{$exinvoice_payment->sum('withdraw')}}TK</td>
            </tr>

            <tr>
                 <th align="left" width="160">Total Received</th>
                 <th align="right" width="80">{{ $payment1->sum('payble_amount1')+$payment2->sum('payble_amount2')+$manager_get-$exinvoice_payment->sum('withdraw') }}TK</th>
            </tr>
          </table>
        </div>



        <div class="column">
        <table>
            <tr>
              <td colspan="2" width="240"> <b>Table 8:Admin get </b> </td>
            </tr>

            <tr>
              <td align="left" width="160"> Day of this Section</td>
              <td align="right" width="80">{{$invoice->max('section_day')}} day</td>
            </tr>


       
            <tr>
              <td align="left" width="160">Breakfat Meal rate, ON </td>
              <td align="right" width="80">{{$invoice->max('breakfast_rate')}}, {{$invoice->sum('breakfast_onmeal')}} </td>
            </tr>
           

            <tr>
              <td align="left" width="160">Lunch Meal rate, ON </td>
              <td align="right" width="80">{{$invoice->max('lunch_rate')}}, {{$invoice->sum('lunch_onmeal')}} </td>
            </tr>

            
            <tr>
              <td align="left" width="160">Dinner Meal rate, ON </td>
              <td align="right" width="80">{{$invoice->max('dinner_rate')}}, {{$invoice->sum('dinner_onmeal')}} </td>
            </tr>

            <tr>
              <td align="left" width="160"> Reduce due meal amount </td>
              <td align="right" width="80">{{ $invoice->sum('mealreducetk') }}TK</td>
            </tr>

            <tr>
              <td align="left" width="160"> Card Fee </td>
              <td align="right" width="80">{{ $invoice->sum('card_fee') }}TK</td>
            </tr>

            <tr>
               <td align="left" width="160"> Serviec Charge </td>
               <td align="right" width="80">{{ $invoice->sum('service_charge') }}TK</td>
            </tr>

            <tr>
                <td align="left" width="160">Security</td>
                <td align="right" width="80">{{ $invoice->sum('security') }}TK</td>
             </tr>

             <tr>
                <td align="left" width="160">Refund Security(-) </td>
                <td align="right" width="80">{{ $invoice->sum('security_money') }}TK</td>
            </tr>

            <tr>
              <th align="left" width="160">Total admin get</th>
              <th align="right" width="80"> {{ ($invoice->sum('mealreducetk')+$invoice->sum('card_fee')
                +$invoice->sum('service_charge')+$invoice->sum('security')) - $invoice->sum('security_money')}}TK</th>
            </tr>
          </table>

          
        
        </div>
      </div>












    </div>

    </div>


  </center>



</body>

</html>