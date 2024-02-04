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
                       Section wise Bazar Summary<br>
                        {{$month1}} -{{$section}}</h4>
        </center>

        <table>
            <tr>
              <th align="left" width="100">Day</th>
              <th align="left" width="150">Bazar Item</th>
              <th align="right" width="200">Total Price</th>
            </tr>

            @foreach($bazar as $user)
            <tr>
              <td align="left">{{ $user->bazar_day }}</td>
              <td align="left">{{ $user->id_total }}</td>
              <td align="right">{{ $user->bazar_total }}TK</td>
            </tr>
            @endforeach

            <tr>
              <td></td>
              <td>Total Bazar</td>
              <td align="right">{{$bazar->sum('bazar_total')}}TK</td>
            </tr>
        
        </table>


      </div>
    </div>
    <br>

  </center>



</body>

</html>