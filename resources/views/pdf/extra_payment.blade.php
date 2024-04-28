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
             Extra Payment Summary: {{$month1}}, Section : {{ $section }} </h4>
        </center>
             
      

        <table>
          <tr>
            <th align="left" width="215">Name/ Orgaanization</th>
            <th align="left" width="130">Description</th>
            <th align="left" width="100">Amount</th>
            <th align="right" width="85">Payment type</th>
          </tr>


          @foreach($extra_payment as $user)
          <tr>
             <td align="left">{{$user->name}}</td>
             <td align="left">{{$user->description}}</td>
             <td align="left">{{$user->amount}}</td>
             <td align="left">{{$user->payment_type}}</td>
          </tr>
          @endforeach

          <tr>
        
            <td colspan="1" align="left"> Number : {{$extra_payment->count('id')}} </td>
            <td colspan="4" align="left"> Payment Amount : {{$extra_payment->sum('amount')}}TK</td>
          </tr>

        </table>



      



      </div>
    </div>
    <br>

  </center>



</body>

</html>