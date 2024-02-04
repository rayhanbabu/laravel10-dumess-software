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
                       Daily Bazar Summary<br>
                       Date: {{$day1}}</h4>
        </center>

        <table>
          <tr>
            <th align="left" width="40">Serial</th>
            <th align="left" width="200">Product</th>
            <th align="left" width="140">Quantity</th>
            <th align="left" width="140">Per unit price</th>
            <th align="right" width="130">Total Price</th>
          </tr>


          @foreach($bazar as $user)
          <tr>
             <td align="left">{{$loop->iteration}}</td>
             <td align="left">{{$user->product}}</td>
             <td align="right">{{ $user->qty }}{{ $user->unit }}</td>
             <td align="right">{{ $user->price }}</td>
             <td align="right">{{ $user->total }}TK</td>
          </tr>
          @endforeach
          <tr>
               <td align="left"></td>
               <td align="left"> Breakfast meal: {{$b_meal_no}}</td>
               <td align="left"> Lunch Meal: {{$l_meal_no}}</td>
               <td align="left">Dinner Meal: {{$d_meal_no}}</td>
               <td align="right">Total Bazar : {{ $bazar->sum('total')}}TK</td>
          </tr> 

          <tr>
              <td align="left"></td>
              <td colspan="2" align="left"> Estimate bazar : {{$meal_amount}}</td>
              <td colspan="2" align="left"> 
              @if($meal_amount>=$bazar->sum('total'))
                  Reserve bazar amount  @else Extra bazar amount @endif
              : {{ abs($bazar->sum('total')-$meal_amount)}}</td>
          </tr>

        </table>


      </div>
    </div>
    <br>

  </center>



</body>

</html>