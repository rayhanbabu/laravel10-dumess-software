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
                          Refund Summary <br>
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
               
            </tr>

            @foreach($invoice as $user)
            <tr>
               <td align="left"> {{ $user->card }} </td>
               <td align="left"> {{ $user->registration }} </td>
               <td align="left"> {{ $user->name }} </td>
               <td align="left"> {{ $user->total_refund }} </td>
               <td align="left"> {{ $user->total_due }} </td>
               <td align="left"> {{ $user->reserve_amount }} </td>
               
            </tr>
            @endforeach

            <tr>
                 <td></td>
                 <td></td>
                 <td> Total sum</td>
                 <td> {{$invoice->sum('total_refund')}} </td>
                 <td> {{$invoice->sum('total_due')}}  </td>
                 <td> {{$invoice->sum('reserve_amount')}}  </td>
            </tr>

            <tr>
              <td></td>
              <td colspan="2"> Total Invoice : {{$invoice->count()}}</td>
              <td colspan="3" align="left">Total Refund :
                 {{($invoice->sum('total_refund')+$invoice->sum('reserve_amount'))-$invoice->sum('total_due')}} </td>
            </tr>
        
        </table>


      </div>
    </div>
    <br>

  </center>



</body>

</html>