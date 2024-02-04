<!DOCTYPE html>
<html>
 <head>
	 <script>
 function printContent(e1){
      var restorepage=document.body.innerHTML;
      var printcontent=document.getElementById(e1).innerHTML;
       document.body.innerHTML=printcontent;
       window.print();
       document.body.innerHTML=restorepage;
  }
  
</script>

         <style>
	 table,td,th{  
  border: 1px solid #acacac;
  *text-align: left;
}

table {
  border-collapse: collapse;
  *width: 100%;
}

th, td {
  padding:2px;
  font-size:14px;
}

.area{
	
    *height:950px;
    *background-color:gray;
    width:700px;
}

.btn {
  border: none;
  color: white;
  padding: 14px 28px;
  font-size: 14px;
  cursor: pointer;
}

.success {background-color: #4CAF50;} /* Green */
.success:hover {background-color: #46a049;}
	  	   
	  </style>	   

	</head>
<body>
  <center>
      <br>
	 <button class="btn success" onclick ="printContent('div1')">Print </button>
    <div id="div1">

    <div class="area">
    <center>

<h4>Title Name</h4>
</center>

<table>
  <tr>
    <th align="left" width="40">Serial</th>
	<th align="left" width="270">Product</th>
    <th align="left" width="80">Quantity</th>
    <th align="left" width="130">Per unit price</th>
    <th align="right" width="130">Total Price</th>
  </tr>
  
 
    <tr>
        <td align="left" ></td>
	    <td align="left" ></td>
	    <td align="right"></td>
        <td align="right"></td>
		<td align="right"></td>
    </tr>






  
</table>


</div>	 
    </div>
		   <br>
	  
	</center>
			
			

</body>
</html>