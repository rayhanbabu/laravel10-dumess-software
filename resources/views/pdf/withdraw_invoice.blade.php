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
      font-size: 16px;
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
             Withdraw Summary: {{$month1}}, Section : {{ $section }} </h4>
        </center>
             
      

        <table>
          <tr>
            <th align="left" width="60">Invoice Id</th>
            <th align="left" width="50">Card</th>
            <th align="left" width="50">Reg/Seat No</th>
            <th align="left" width="215">Name</th>
            <th align="left" width="60">Withdraw</th>
            <th align="right" width="155">withdraw time</th>
            <th align="right" width="55">Pay type</th>
          </tr>


          @foreach($withdraw as $user)
          <tr>
            <td align="left">{{$user->id}}</td>
            <td align="left">{{$user->card}}</td>
            <td align="left">{{$user->registration}}</td>
            <td align="left">{{$user->name}}</td>
            <td align="left">{{$user->withdraw}}</td>
            <td align="left">{{$user->withdraw_time}}</td>
            <td align="left">{{$user->withdraw_type}}</td>

          </tr>
          @endforeach

          <tr>
            <td align="left"></td>
            <td colspan="3" align="left">First Payment Number : {{$withdraw->count('id')}} </td>
            <td colspan="3" align="left">First Payment Amount : {{$withdraw->sum('withdraw')}}TK</td>
          </tr>

        </table>



      



      </div>
    </div>
    <br>

  </center>



</body>

</html>