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
            Date: {{$date1}}</h4>
        </center>


        @if($type==1)

        <h5>First Payment</h5>
        <table>
          <tr>
            <th align="left" width="60">Invoice Id</th>
            <th align="left" width="151">Name</th>
            <th align="left" width="151">Phone</th>
            <th align="left" width="60">Payment</th>
            <th align="right" width="155">Payment time</th>
            <th align="right" width="55">Pay type</th>
          </tr>


          @foreach($payment1 as $user)
          <tr>
            <td align="left">{{$user->id}}</td>
            <td align="left">{{$user->name}}</td>
            <td align="left">{{$user->phone}}</td>
            <td align="left">{{$user->amount1}}</td>
            <td align="left">{{$user->time1}}</td>
            <td align="left">{{$user->type1}}</td>

          </tr>
          @endforeach

          <tr>
            <td align="left"></td>
            <td colspan="3" align="left">First Payment Number : {{$payment1->count('id')}} </td>
            <td colspan="3" align="left">First Payment Amount : {{$payment1->sum('amount1')}}TK</td>
          </tr>

        </table>

        @elseif($type==2)

        <h5>Second Payment</h5>
        <table>
          <tr>
            <th align="left" width="60">Invoice Id</th>
            <th align="left" width="151">Name</th>
            <th align="left" width="151">Phone</th>
            <th align="left" width="60">Payment</th>
            <th align="right" width="155">Payment time</th>
            <th align="right" width="55">Pay type</th>
          </tr>
          @foreach($payment2 as $user)
          <tr>
            <td align="left">{{$user->id}}</td>
            <td align="left">{{$user->name}}</td>
            <td align="left">{{$user->phone}}</td>
            <td align="left">{{$user->amount2}}</td>
            <td align="left">{{$user->time2}}</td>
            <td align="left">{{$user->type2}}</td>

          </tr>
          @endforeach

          <tr>
            <td align="left"></td>
            <td colspan="3" align="left">Second Payment Number : {{$payment2->count('id')}} </td>
            <td colspan="3" align="left">Second Payment Amount : {{$payment2->sum('amount2')}}TK</td>
          </tr>

        </table>


        @elseif($type==3)

        <h5>Third Payment</h5>
        <table>
          <tr>
            <th align="left" width="60">Invoice Id</th>
            <th align="left" width="151">Name</th>
            <th align="left" width="151">Phone</th>
            <th align="left" width="60">Payment</th>
            <th align="right" width="155">Payment time</th>
            <th align="right" width="55">Pay type</th>
          </tr>
          @foreach($payment3 as $user)
          <tr>
            <td align="left">{{$user->id}}</td>
            <td align="left">{{$user->name}}</td>
            <td align="left">{{$user->phone}}</td>
            <td align="left">{{$user->amount3}}</td>
            <td align="left">{{$user->time3}}</td>
            <td align="left">{{$user->type3}}</td>

          </tr>
          @endforeach

          <tr>
            <td align="left"></td>
            <td colspan="3" align="left">Third Payment Number : {{$payment3->count('id')}} </td>
            <td colspan="3" align="left">Third Payment Amount : {{$payment3->sum('amount3')}}TK</td>
          </tr>

        </table>

        @else

        <h5>Total  paymnet: {{$payment1->sum('amount1')+$payment2->sum('amount2')+$payment3->sum('amount3')}}TK

        <h5>First Payment</h5>
        <table>
          <tr>
            <th align="left" width="60">Invoice Id</th>
            <th align="left" width="151">Name</th>
            <th align="left" width="151">Phone</th>
            <th align="left" width="60">Payment</th>
            <th align="right" width="155">Payment time</th>
            <th align="right" width="55">Pay type</th>
          </tr>


          @foreach($payment1 as $user)
          <tr>
            <td align="left">{{$user->id}}</td>
            <td align="left">{{$user->name}}</td>
            <td align="left">{{$user->phone}}</td>
            <td align="left">{{$user->amount1}}</td>
            <td align="left">{{$user->time1}}</td>
            <td align="left">{{$user->type1}}</td>

          </tr>
          @endforeach

          <tr>
            <td align="left"></td>
            <td colspan="3" align="left">First Payment Number : {{$payment1->count('id')}} </td>
            <td colspan="3" align="left">First Payment Amount : {{$payment1->sum('amount1')}}TK</td>
          </tr>

        </table>


        <h5>Second Payment</h5>
        <table>
          <tr>
            <th align="left" width="60">Invoice Id</th>
            <th align="left" width="151">Name</th>
            <th align="left" width="151">Phone</th>
            <th align="left" width="60">Payment</th>
            <th align="right" width="155">Payment time</th>
            <th align="right" width="55">Pay type</th>
          </tr>
          @foreach($payment2 as $user)
          <tr>
            <td align="left">{{$user->id}}</td>
            <td align="left">{{$user->name}}</td>
            <td align="left">{{$user->phone}}</td>
            <td align="left">{{$user->amount2}}</td>
            <td align="left">{{$user->time2}}</td>
            <td align="left">{{$user->type2}}</td>

          </tr>
          @endforeach

          <tr>
            <td align="left"></td>
            <td colspan="3" align="left">Second Payment Number : {{$payment2->count('id')}} </td>
            <td colspan="3" align="left">Second Payment Amount : {{$payment2->sum('amount2')}}TK</td>
          </tr>

        </table>


        <h5>Third Payment</h5>
        <table>
          <tr>
            <th align="left" width="60">Invoice Id</th>
            <th align="left" width="151">Name</th>
            <th align="left" width="151">Phone</th>
            <th align="left" width="60">Payment</th>
            <th align="right" width="155">Payment time</th>
            <th align="right" width="55">Pay type</th>
          </tr>
          @foreach($payment3 as $user)
          <tr>
            <td align="left">{{$user->id}}</td>
            <td align="left">{{$user->name}}</td>
            <td align="left">{{$user->phone}}</td>
            <td align="left">{{$user->amount3}}</td>
            <td align="left">{{$user->time3}}</td>
            <td align="left">{{$user->type3}}</td>

          </tr>
          @endforeach

          <tr>
            <td align="left"></td>
            <td colspan="3" align="left">Third Payment Number : {{$payment3->count('id')}} </td>
            <td colspan="3" align="left">Third Payment Amount : {{$payment3->sum('amount3')}}TK</td>
          </tr>

        </table>



        @endif


      </div>
    </div>
    <br>

  </center>



</body>

</html>