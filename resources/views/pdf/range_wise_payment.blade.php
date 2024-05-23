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

    table,
    td,
    th {
      border: 2px solid #acacac;

    }

    table {
      border-collapse: collapse;
    }

    th,
    td {
      padding: 2px;
      font-size: 14px;
    }

    .area {

      width: 700px;
    }

    .btn {
      border: none;
      color: white;
      padding: 14px 28px;
      font-size: 14px;
      cursor: pointer;
    }

    .success {
      background-color: #4CAF50;
    }

    /* Green */
    .success:hover {
      background-color: #46a049;
    }
  </style>

</head>

<body>
  <center>
    <br>
    <button class="btn success" onclick="printContent('div1')">Print </button>
    <div id="div1">

      <div class="area">
        <center>
          <h4> {{ manager_info()['hall_name'] }} <br>
            Date: {{$date1 }} to  {{$date2 }}</h4>
        </center>


        <h5>First paymnet and Second paymnet: {{$payment2->sum('payble_amount2')+$payment1->sum('payble_amount1')}}TK
          <br>
               First Payment </h5>

        <table>
          <tr>
            <th align="left" width="60">Invoice Id</th>
            <th align="left" width="50">Card</th>
            <th align="left" width="50">Reg/Seat No</th>
            <th align="left" width="215">Name</th>
            <th align="left" width="60">Payment</th>
            <th align="right" width="155">Payment time</th>
            <th align="right" width="55">Pay type</th>
          </tr>


          @foreach($payment1 as $user)
          <tr>
            <td align="left">{{$user->id}}</td>
            <td align="left">{{$user->card}}</td>
            <td align="left">{{$user->registration}}</td>
            <td align="left">{{$user->name}}</td>
            <td align="left">{{$user->payble_amount1}}</td>
            <td align="left">{{$user->payment_time1}}</td>
            <td align="left">{{$user->payment_type1}}</td>

          </tr>
          @endforeach

          <tr>
            <td align="left"></td>
            <td colspan="3" align="left">First Payment Number : {{$payment1->count('id')}} </td>
            <td colspan="3" align="left">First Payment Amount : {{$payment1->sum('payble_amount1')}}TK</td>
          </tr>

        </table>



        <h5>Second Payment</h5>

        <table>
          <tr>
            <th align="left" width="60">Invoice Id</th>
            <th align="left" width="50">Card</th>
            <th align="left" width="50">Reg/Seat No</th>
            <th align="left" width="215">Name</th>
            <th align="left" width="60">Payment</th>
            <th align="right" width="155">Payment time</th>
            <th align="right" width="55">Pay type</th>
          </tr>


          @foreach($payment2 as $user)
          <tr>
            <td align="left">{{$user->id}}</td>
            <td align="left">{{$user->card}}</td>
            <td align="left">{{$user->registration}}</td>
            <td align="left">{{$user->name}}</td>
            <td align="left">{{$user->payble_amount2}}</td>
            <td align="left">{{$user->payment_time2}}</td>
            <td align="left">{{$user->payment_type2}}</td>

          </tr>
          @endforeach

          <tr>
            <td align="left"></td>
            <td colspan="3" align="left">Second Payment Number : {{$payment2->count('id')}} </td>
            <td colspan="3" align="left">Second Payment Amount : {{$payment2->sum('payble_amount2')}}TK</td>
          </tr>

        </table>


      </div>
    </div>
    <br>

  </center>



</body>

</html>