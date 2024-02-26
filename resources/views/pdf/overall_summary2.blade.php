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

    table {
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 30px;
        width: 350px;
        margin-top: 20px;
        margin-bottom: 20px;
      }
      td,
      th {
        border: 2px solid black;
        padding: 3px 8px;
      }
   
      .text {
        font-size: 16px;
        font-weight: 600;
      }

      .direction {
        display: flex;
        gap: 30px;
        justify-items: center;
        justify-content: center;
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

    <div class="main">
      <div class="direction">
        <!-- first colunm  -->
        <div>

        @php
       $admin_get=($invoice->sum('mealreducetk')+$invoice->sum('card_fee')
        +$invoice->sum('service_charge')+$invoice->sum('security')) - $exinvoice->sum('security');
     @endphp

        @php
            $refund= ($invoice->sum('total_refund')+$invoice->sum('reserve_amount')) - $invoice->sum('total_due');
    
        $total_payment=($payment1->sum('payble_amount1')+$payment2->sum('payble_amount2'))+$exinvoice_payment->sum('withdraw');
        @endphp

           <!-- Table 1:Manager get in -->
           <table>
            <thead>
              <tr>
                <th colspan="3">Table 1: Manager Get </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Total Refund Previous Month</td>
                <td align="right"> {{ $invoice->sum('pre_refund')+$exinvoice->sum('pre_refund')}} TK</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Total Reserve Previous Month</td>
                <td align="right">{{ $invoice->sum('pre_reserve_amount')+$exinvoice->sum('pre_reserve_amount') }} TK</td>
              </tr>
              <tr>
                <td >3</td>
                <td>Due amount Previous Month</td>
                <td align="right">{{ $invoice->sum('pre_monthdue')+$exinvoice->sum('pre_monthdue') }} TK</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td class="text" colspan="2" >Total Manager get</td>
                <td align="right">{{($invoice->sum('pre_refund')+$exinvoice->sum('pre_refund')+
                    $invoice->sum('pre_reserve_amount')+$exinvoice->sum('pre_reserve_amount'))
                    -($invoice->sum('pre_monthdue')+$exinvoice->sum('pre_monthdue')) }} TK</td>

               @php
                    $manager_get=($invoice->sum('pre_refund')+$exinvoice->sum('pre_refund')+
                    $invoice->sum('pre_reserve_amount')+$exinvoice->sum('pre_reserve_amount'))
                    -($invoice->sum('pre_monthdue')+$exinvoice->sum('pre_monthdue'));
               @endphp     
              </tr>
            </tfoot>
          </table>



          <!-- Table 3: Invoice summary -->
          <table>
            <thead>
              <tr>
                <th colspan="3">Table 3:Invoice summary </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Total meal amount</td>
                <td align="right"> {{$invoice->sum('cur_meal_amount')}} TK </td>
              </tr>
              <tr>
                <td>2</td>
                <td> Total friday amount </td>
                <td align="right">{{$invoice->sum('friday')}} TK </td>
              </tr>
              <tr>
                 <td >3</td>
                 <td>Feast</td>
                 <td align="right">{{$invoice->sum('feast')}} TK </td>
              </tr>

              <tr>
                 <td >4</td>
                 <td>Employee</td>
                 <td align="right">{{$invoice->sum('employee')}} TK </td>
              </tr>

              <tr>
                 <td >5</td>
                 <td>Welfare</td>
                 <td align="right">{{$invoice->sum('welfare')}} TK  </td>
              </tr>

              <tr>
                 <td >6</td>
                 <td>Others</td>
                 <td align="right">{{$invoice->sum('others')}} TK  </td>
              </tr>

              <tr>
                 <td >7</td>
                 <td>Gass</td>
                 <td align="right"> {{$invoice->sum('gass')}} TK  </td>
              </tr>

              <tr>
                 <td >8</td>
                 <td>Electicity</td>
                 <td align="right">{{$invoice->sum('electricity')}} TK  </td>
              </tr>


              <tr>
                 <td >9</td>
                 <td>Gass</td>
                 <td align="right"> {{$invoice->sum('gass')}} TK  </td>
              </tr>


              <tr>
                 <td >10</td>
                 <td>Tissue</td>
                 <td align="right"> {{$invoice->sum('tissue')}} TK   </td>
              </tr>


              <tr>
                 <td >11</td>
                 <td>Water</td>
                 <td align="right"> {{$invoice->sum('water')}} TK  </td>
              </tr>


              <tr>
                 <td >12</td>
                 <td>Dirt</td>
                 <td align="right"> {{$invoice->sum('dirt')}} TK  </td>
              </tr>

              <tr>
                 <td >13</td>
                 <td>Wifi</td>
                 <td align="right">  {{$invoice->sum('wifi')}} TK  </td>
              </tr>


              <tr>
                 <td >14</td>
                 <td>Card Fee</td>
                 <td align="right">  {{$invoice->sum('card_fee')}} TK  </td>
              </tr>


              <tr>
                 <td >15</td>
                 <td>Meeting Fee</td>
                 <td align="right"> {{$invoice->sum('meeting_penalty')}} TK</td>
              </tr>


              <tr>
                 <td >16</td>
                 <td>Security Money</td>
                 <td align="right"> {{$invoice->sum('security')}} TK  </td>
              </tr>


              <tr>
                 <td >17</td>
                 <td>Service Charge</td>
                 <td align="right">   {{$invoice->sum('service_charge')}} TK  </td>
              </tr>


              <tr>
                 <td >18</td>
                 <td>Total Invoice amount(1+...+17)</td>
                 <td align="right">  {{$invoice->sum('cur_total_amount')}} TK</td>
              </tr>


              <tr>
                 <td >19</td>
                 <td>Inactive Meal Amount</td>
                 <td align="right"> {{$invoice->sum('inmeal_amount')}} TK  </td>
              </tr>

              <tr>
                 <td >20</td>
                 <td> Manager get</td>
                 <td align="right">  {{ $manager_get }} TK </td>
              </tr>

              <tr>
                 <td >21</td>
                 <td>Refund Security </td>
                 <td align="right"> {{ $exinvoice->sum('security')}} TK  </td>
              </tr>


              <tr>
                 <td >22</td>
                 <td>Withdraw Amount</td>
                 <td align="right">  {{ $withdraw->sum('withdraw')}} TK  </td>
              </tr>


            </tbody>
            <tfoot>
              <tr>
                <td class="text" colspan="2" >Payment Invoice (18-19-20-21+22)</td>
                <td align="right">{{$invoice->sum('payble_amount')+$exinvoice->sum('withdraw')}} TK  </td>  
              </tr>
            </tfoot>
          </table>

      <br><br>

         <!-- Table 5: Payment summary -->
         <table>
            <thead>
              <tr>
                <th colspan="3">Table 5: Payment summary </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Total member</td>
                <td align="right"> {{$invoice->count('id')}}</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Active member</td>
                <td align="right">{{$active_invoice->count('id')}}</td>
              </tr>

              <tr>
                <td >3</td>
                <td>Inactive member</td>
                <td align="right">{{ ($invoice->count('id')-$active_invoice->count('id'))}}</td>
              </tr>


              <tr>
                <td>4</td>
                <td>Resign member </td>
                <td align="right">{{$exinvoice->count('id')}}</td>
              </tr>


              <tr>
                <td>5</td>
                <td>1st Invoice payment </td>
                <td align="right">{{ $payment1->sum('payble_amount1') }} TK</td>
              </tr>

              <tr>
                <td>6</td>
                <td>2nd Invoice payment </td>
                <td align="right">{{ $payment2->sum('payble_amount2') }} TK</td>
              </tr>


              <tr>
                <td>7</td>
                <td>Total Invoice Payment</td>
                <td align="right">{{ $payment1->sum('payble_amount1')+$payment2->sum('payble_amount2') }} TK </td>
              </tr>


              <tr>
                <td>8</td>
                <td>Total Resign Payment </td>
                <td align="right">{{ $exinvoice_payment->sum('withdraw')}} TK</td>
              </tr>


              <tr>
                <td>9</td>
                <td>Total Payment(7+8) </td>
                <td align="right">{{ ($payment1->sum('payble_amount1')+$payment2->sum('payble_amount2'))+$exinvoice_payment->sum('withdraw') }} TK</td>
              </tr>

            </tbody>
            <tfoot>
              <tr>
                <td class="text" colspan="2" >Invoice due amount(table 3-9)</td>
                <td align="right">{{$invoice->sum('total_due')}} TK</td>

              </tr>
            </tfoot>
          </table>


           <!-- Table 7: Total Earns -->
           <table>
            <thead>
              <tr>
                <th colspan="3">Table 7: Total Earns </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Total Payment</td>
                <td align="right">{{ $total_payment }} TK</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Received by Previous manager</td>
                <td align="right">{{$manager_get}} TK</td>
              </tr>

              <tr>
                <td>3</td>
                <td>Reserve Amount </td>
                <td align="right">{{$invoice->sum('reserve_amount')}} TK</td>
              </tr>
             
             
            </tbody>
            <tfoot>
              <tr>
                <td class="text" colspan="2" >Total Received amount</td>
                <td align="right">{{$total_payment+$manager_get+$invoice->sum('reserve_amount') }} TK</td> 
              </tr>
            </tfoot>
          </table>





         


        </div>




        <!-- secend colunm  -->
        <div>

              <!-- Table 2:Admin get  -->
          <table>
            <thead>
              <tr>
                <th colspan="3">Table 2:Admin get </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td> Day of this Section</td>
                <td align="right">{{$invoice->max('section_day')}} day</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Breakfat Meal rate, ON</td>
                <td align="right">{{$invoice->max('breakfast_rate')}}, {{$invoice->sum('breakfast_onmeal')}}</td>
              </tr>

              <tr>
                <td>3</td>
                <td>Lunch Meal rate, ON</td>
                <td align="right">{{$invoice->max('lunch_rate')}}, {{$invoice->sum('lunch_onmeal')}}</td>
              </tr>

              <tr>
                <td>4</td>
                <td>Dinner Meal rate, ON </td>
                <td align="right">{{$invoice->max('dinner_rate')}}, {{$invoice->sum('dinner_onmeal')}} </td>
              </tr>

              <tr>
                <td>5</td>
                <td>Reduce due meal amount </td>
                <td align="right">{{ $invoice->sum('mealreducetk') }} TK</td>
              </tr>

              <tr>
                <td>6</td>
                <td>Card Fee</td>
                <td align="right">{{ $invoice->sum('card_fee') }} TK</td>
              </tr>

              <tr>
                <td>7</td>
                <td>Serviec Charge </td>
                <td align="right">{{ $invoice->sum('service_charge') }} TK</td>
              </tr>

              <tr>
                <td>8</td>
                <td>Security</td>
                <td align="right"> {{ $invoice->sum('security') }} TK</td>
              </tr>

              <tr>
                <td>9</td>
                <td>Refund Security(-)</td>
                <td align="right">{{ $exinvoice->sum('security') }} TK</td>
              </tr>

             






            </tbody>
            <tfoot class="text">
              <tr>
                <td colspan="2">Total admin get(5+...+8-9)</td>
                <td align="right">{{ ($invoice->sum('mealreducetk')+$invoice->sum('card_fee')
                +$invoice->sum('service_charge')+$invoice->sum('security')) - $exinvoice->sum('security')}} TK</td>
              </tr>
            
            </tfoot>
          </table>



          <!-- Table 4:Bazar summary -->
          <table>
            <thead>
              <tr>
                <th colspan="3">Table 4:Bazar Summary</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Active Meal Amount</td>
                <td align="right">{{ $invoice->sum('onmeal_amount') }} TK</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Friday Amount</td>
                <td align="right">{{ ($invoice->sum('friday')- $invoice->sum('refund_friday')) }} TK</td>
              </tr>
              <tr>
                <td>3</td>
                <td>Feast Amount</td>
                <td align="right">{{ ($invoice->sum('feast')-$invoice->sum('refund_feast')) }} TK</td>
              </tr>
               <td>4</td>
               <td >Monthly estimated bazar(1+2+3)</td>
                <td align="right">{{($invoice->sum('onmeal_amount')+($invoice->sum('friday')- $invoice->sum('refund_friday'))
    +($invoice->sum('feast')-$invoice->sum('refund_feast'))) }}TK</td>
              </tr>
              <tr>
              <td>5</td>
                <td >Monthly Total Bazar</td>
                <td align="right">{{$bazar->sum('total')}} TK</td>
              </tr>
            </tbody>
            <tfoot class="text">
              <tr>
             
              <tr>
                <td colspan="2">Extra Bazar(4-5)</td>
                <td align="right">{{($invoice->sum('onmeal_amount')+($invoice->sum('friday')- $invoice->sum('refund_friday'))
    +($invoice->sum('feast')-$invoice->sum('refund_feast')))-$bazar->sum('total')}} TK </td>
              </tr>
            </tfoot>
          </table>


           <!-- Table :6 Refund next manager and get employee -->
           <table>
            <thead>
              <tr>
                <th colspan="3">Table :6 Refund next manager and get employee </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td> Refund next manager</td>
                <td align="right">{{$invoice->sum('total_refund')}} TK</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Refund Reserve Amount</td>
                <td align="right">{{$invoice->sum('reserve_amount')}} TK</td>
              </tr>

              <td>3</td>
                <td>Employee Salary</td>
                <td align="right">{{$invoice->sum('employee')-$invoice->sum('refund_employee')}} TK</td>
              </tr>


            </tfoot>
          </table>


<br><br><br> <br><br><br>  <br><br><br> <br><br>


            <!--Table :8 Total Spends   -->
            <table>
            <thead>
              <tr>
                <th colspan="3">Table :8 Total Spends </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td> Monthly total bazar</td>
                <td align="right">{{$bazar->sum('total')}} TK</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Fund transfer to next manager</td>
                <td align="right">{{ ($invoice->sum('total_refund')+$invoice->sum('reserve_amount')) - $invoice->sum('total_due') }} </td>
              </tr>

              <tr>
                <td>3</td>
                <td>Employee salary</td>
                <td align="right">{{$invoice->sum('employee')-$invoice->sum('refund_employee')}}TK</td>
              </tr>

              <tr>
                <td>4</td>
                <td> Meeting fee </td>
                <td align="right">{{$invoice->sum('meeting_penalty')}} TK</td>
              </tr>

              <tr>
                <td>5</td>
                <td>Welfare </td>
                <td align="right">{{$invoice->sum('welfare')-$invoice->sum('refund_welfare')}} TK </td>
              </tr>

              <tr>
                <td>6</td>
                <td>Others</td>
                <td align="right"> {{$invoice->sum('others')-$invoice->sum('refund_others')}}TK</td>
              </tr>

              <tr>
                <td>7</td>
                <td>Gass </td>
                <td align="right">{{$invoice->sum('gass')-$invoice->sum('refund_gass')}} TK </td>
              </tr>

              <tr>
                <td>8</td>
                <td>Electicity</td>
                <td align="right"> {{$invoice->sum('electricity')-$invoice->sum('refund_electricity')}} TK</td>
              </tr>

              <tr>
                <td>9</td>
                <td>Tissue</td>
                <td align="right">{{$invoice->sum('tissue')-$invoice->sum('refund_tissue')}} TK</td>
              </tr>

              <tr>
                <td>10</td>
                <td>Water</td>
                <td align="right">{{$invoice->sum('water')-$invoice->sum('refund_water')}} TK</td>
              </tr>

              <tr>
                <td>11</td>
                <td>Dirt</td>
                <td align="right">{{$invoice->sum('dirt')-$invoice->sum('refund_dirt')}} TK </td>
              </tr>

              <tr>
                <td>12</td>
                <td>Wifi</td>
                <td align="right">{{$invoice->sum('wifi')-$invoice->sum('refund_wifi')}} TK</td>
              </tr>

              <tr>
                <td>13</td>
                <td>Admin get</td>
                <td align="right">{{$admin_get}} </td>
              </tr>

              <tr>
                <td>14</td>
                <td>Withdraw Amount</td>
                <td align="right">{{$withdraw->sum('withdraw')}}  TK</td>
              </tr>

              <tr>
                <td>15</td>
                <td>Total Spends(1+...+14)</td>
                <td align="right">{{ $bazar->sum('total')+$refund +$admin_get+$withdraw->sum('withdraw')+
                ($invoice->sum('employee')-$invoice->sum('refund_employee'))+$invoice->sum('meeting_penalty')
                +($invoice->sum('others')-$invoice->sum('refund_others'))+($invoice->sum('gass')-$invoice->sum('refund_gass'))
                +($invoice->sum('electricity')-$invoice->sum('refund_electricity'))+($invoice->sum('tissue')-$invoice->sum('refund_tissue'))
                +($invoice->sum('water')-$invoice->sum('refund_water'))+($invoice->sum('wifi')-$invoice->sum('refund_wifi'))
                +($invoice->sum('welfare')-$invoice->sum('refund_welfare')) }} TK</td>
              </tr>

           
            


            </tbody>
            <tfoot class="text">
              <tr>
                <td colspan="2">Extra Spends (table 7-15)</td>
                <td align="right">{{ ($total_payment+$manager_get+$invoice->sum('reserve_amount'))
                 -($bazar->sum('total')+$refund +$admin_get+$withdraw->sum('withdraw')+
                ($invoice->sum('employee')-$invoice->sum('refund_employee'))+$invoice->sum('meeting_penalty')
                +($invoice->sum('others')-$invoice->sum('refund_others'))+($invoice->sum('gass')-$invoice->sum('refund_gass'))
                +($invoice->sum('electricity')-$invoice->sum('refund_electricity'))+($invoice->sum('tissue')-$invoice->sum('refund_tissue'))
                +($invoice->sum('water')-$invoice->sum('refund_water'))+($invoice->sum('wifi')-$invoice->sum('refund_wifi'))
                +($invoice->sum('welfare')-$invoice->sum('refund_welfare')))}} TK</td>
              </tr>
            
            </tfoot>
          </table>


         
          


        </div>
      </div>
    </div>
     



    </div>


  </center>



</body>

</html>