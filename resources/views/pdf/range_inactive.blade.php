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
    <button class="btn success" onclick="printContent('div1')" >Print </button>
    <div id="div1">

      <div class="area">
        <center>
                 <h4> {{ manager_info()['hall_name'] }} <br>
                      Range Wise Inactive Member List<br>
                       {{$date1}} to {{$date2}}</h4>
        </center>

        <table>
            <tr>
              <th align="left" width="100">Card </th>
              <th align="left" width="100">Section Info </th>
              <th align="left" width="150">Name </th>
              <th align="left" width="120">Phone </th>
              <th align="left" width="120">1st payment, Status</th>
              <th align="left" width="120">2nd payment, Status</th>
            </tr>

            @foreach($invoice as $user)
            <tr>
               <td align="left">{{ $user->card }}  </td>
               <td align="left"> {{ $user->invoice_year }}-{{ $user->invoice_month }}-{{ $user->invoice_section }}  </td>
               <td align="left">{{ $user->name }}</td>
               <td align="left">{{ $user->phone }}</td>
               <td align="left">{{ $user->payble_amount1 }}, {{ $user->payment_status1 }}</td>
               <td align="left">{{ $user->payble_amount2 }}, {{ $user->payment_status2 }}</td>
            </tr>
            @endforeach

           
        
        </table>


      </div>
    </div>
    <br>

  </center>



</body>

</html>