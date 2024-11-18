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
            Month : {{ date('n-Y',strtotime($date1)) }} to  {{ date('n-Y',strtotime($date2)) }} </h4>
        </center>


        <h5> Manager List </h5>

        <table>
          <tr>
             <th align="left" width="80">Module</th>
             <th align="left" width="200">Name</th>
             <th align="left" width="50">Registartion</th>
             <th align="left" width="60">Phone</th>
             <th align="right" width="75">Department </th>
           
          </tr>


     @foreach($data as $user)
      <tr>
       <td align="left">{{$user->invoice_year}}-{{$user->invoice_month}}-{{$user->invoice_section}} </td>
             <td align="left">{{$user->name}}</td>
             <td align="left">{{$user->registration}}</td>
             <td align="left">{{$user->phone}}</td>
             <td align="left">{{$user->department}}</td>
      </tr>
    @endforeach

        

        </table>



      



</body>

</html>