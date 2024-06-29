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
               Product wise Bazar Summary <br>
               Prodct :{{$product['0']['product']}} <br>
               {{$month1}} - {{$section}}
          </h4>
        </center>

        <table>
          <th align="left" width="130">Date</th>
          <th align="left" width="130">Quantity</th>
          <th align="left" width="150">Per unit price</th>
          <th align="right" width="130">Total Price</th>
          </tr>

          @foreach($product as $user)
          <tr>
            <td align="left">{{ $user->date }}</td>
            <td align="left">{{ $user->qty }}{{ $user->unit }}</td>
            <td align="left">{{ $user->price }}</td>
            <td align="right">{{ $user->total }}TK</td>
          </tr>
          @endforeach

          <tr>
            <td></td>
            <td colspan="1"> {{$product->sum('qty')}}</td>
            <td colspan="1"> </td>
            <td align="right">{{$product->sum('total')}}TK</td>
          </tr>

        </table>


      </div>
    </div>
    <br>

  </center>



</body>

</html>