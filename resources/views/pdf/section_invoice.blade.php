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
                        Section Invoice List<br>
                        @if($section) {{$month1}} -{{$section}} @else  @endif</h4>
        </center>

        <table>
            <tr>
               <th align="left" width="100"> Card </th>
               <th align="left" width="100"> Reg/Seat </th>
               <th align="left" width="180"> Name </th>
               <th align="left" width="70"> Previous refund </th>
               <th align="left" width="70"> Previous due </th>
               <th align="left" width="70"> Reserve amount </th>
               <th align="left" width="100"> Total Payable amount </th>
               <th align="left" width="100"> 1st Payable amount</th>
               <th align="left" width="100"> 2nd Payable amount</th>
            </tr>

            @foreach($invoice as $user)
            <tr>
               <td align="left"> {{ $user->card }} </td>
               <td align="left"> {{ $user->registration }} </td>
               <td align="left"> {{ $user->name }} </td>
               <td align="left"> {{ $user->pre_refund }} </td>
               <td align="left"> {{ $user->pre_monthdue }} </td>
               <td align="left"> {{ $user->pre_reserve_amount }} </td>
               <td align="left"> {{ $user->payble_amount }} </td>
               <td align="left"> {{ $user->payble_amount1 }} </td>
               <td align="left"> {{ $user->payble_amount2 }} </td>
            </tr>
            @endforeach

            <tr>
              <td></td>
              <td colspan="2"> Total Invoice </td>
              <td colspan="2" align="left">{{$invoice->count()}}</td>
            </tr>
        
        </table>


      </div>
    </div>
    <br>

  </center>



</body>

</html>