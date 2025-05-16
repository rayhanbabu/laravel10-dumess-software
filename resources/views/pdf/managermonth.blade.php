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
                       Module wise {{$category}} Summary<br>
                        {{$month1}} -{{$section}}</h4>
        </center>

        <table>
            <tr>
              <th align="left" width="100">Module</th>
              <th align="left" width="150">Name</th>
              @if($category == 'Manager')
              <th align="right" width="200">Registartion</th>
              @else
              <th align="right" width="200">Salary Amount</th>
              @endif
            </tr>

            @foreach($data as $user)
            <tr>
              <td align="left"> {{ $user->invoice_year }}-{{ $user->invoice_month }}-{{ $user->invoice_section }}  </td>
              <td align="left">{{ $user->name }}</td>
              @if($category == 'Manager')
              <td align="right">{{ $user->registration }}</td>
              @else
              <td align="right">{{ $user->amount }}TK</td>
              @endif
              
            </tr>
            @endforeach

            @if($category == 'Salary')
            <tr>
              <td></td>
              <td>Total Salary</td>
              <td align="right">{{$data->sum('amount')}}TK</td>
            </tr>
            @endif
        
        </table>


      </div>
    </div>
    <br>

  </center>



</body>

</html>