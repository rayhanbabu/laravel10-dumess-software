<html>
 
 <head>
   
	
	 <script>
 function printContent(e1){
   var restorepage= document.body.innerHTML;
   var printcontent= document.getElementById(e1).innerHTML;
   document.body.innerHTML=printcontent;
   window.print();
   document.body.innerHTML=restorepage;
  }
  
</script>

         <style>
	.area{
	
	    *height:950px;
		*background-color:gray;
		*width:700px;
	}
	* {
  box-sizing: border-box;
  }
  .row::after {
  content: "";
  clear: both;
  display: table;
}

[class*="col-"] {
  float: left;
  padding:4px;
  font-size:18px;
  
  border: 1px solid gray;
}

.col-sm-1 {width: 8.33%;}

  

	
	  </style>	   

	</head>
<body>
      <center>
	     <button class="btn success" onclick ="printContent('div1')">Print </button><br><br>
<div id="div1">

	  
<div class="area">
   <div class="row">
    <h3> @if($meal_type=='b') Breakfast @elseif($meal_type=='l') Lunch @else Dinner @endif
         Meal ON  : {{$sum}},  Date : {{$month1}} </h3>
	
	
    @foreach($meal as $row)		
       <div class="col-sm-1">
		 <?php echo $row['card'];?>
        </div>
        @endforeach
	
   </div>

</div> 
		   </div>
		   <br>
	  
			</center>
			
			

</body>
</html>