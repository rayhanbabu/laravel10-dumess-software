
<html><head><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js">

</script><style>.card {
margin-bottom: 1.5rem
}
.card {
position: relative;
display: -ms-flexbox;
display: flex;
-ms-flex-direction: column;
flex-direction: column;
min-width: 0;
word-wrap: break-word;
background-color: #fff;
background-clip: border-box;
border: 1px solid #c8ced3;
border-radius: .25rem
}
.card-header:first-child {
border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0
}
.card-header {
padding: .75rem 1.25rem;
margin-bottom: 0;
background-color: #f0f3f5;
border-bottom: 1px solid #c8ced3
}

.disabled {
      background-color: #ccc;
      cursor: not-allowed;
    }


</style>
</head><body>
    <div class="container">
<div id="ui-view" data-select2-id="ui-view">
<div>
<div class="card">
<div class="card-header">
      
      <strong> {{$hall}}</strong>
      
    </p>
   
</div>
<div class="card-body">
<div class="row mb-4">
<div class="col-sm-6">

<div>
<strong>{{$name}}</strong>
</div>
<div>Phone: {{$phone}}</div>
<div>E-mail: {{$email}}</div>

</div>

<div class="col-sm-6">
 <div>Invoice ID: 
  <strong>{{$invoice_id}}</strong>
</div>
<div>Section Name : {{$invoice_month}}-{{$invoice_year}}-{{$invoice_section}} </div>
<div> Payment Category : {{$payment}} </div>
<div>Invoice Status : @if($payment_status==1) <button class="btn btn-success btn-sm"> Paid</button> @else<button class="btn btn-danger btn-sm"> Unpaid</button>   @endif </div>

</div>
</div>
<div class="table-responsive-sm">
<table class="table table-striped p-2">
<thead>
<tr>
<th class="center">#</th>
<th>Description</th>
<th class="right">Amount</th>
</tr>
</thead>
<tbody>
<tr>
<td class="center">1</td>
<td class="left"> {{$payment}} {{$invoice_month}}-{{$invoice_year}}-{{$invoice_section}} </td>
<td class="right"> {{$payble_amount+($payble_amount*$gateway_fee/100)}}  BDT</td>
</tr>

</tbody>
</table>
</div>
<div class="row">

<div class="col-lg-8 col-sm-5 ml-auto">
<table class="table table-clear">
<tbody>

<tr>
<td class="left">
<strong>Total</strong>
</td>
<td class="right">
<strong>BDT {{$payble_amount+($payble_amount*$gateway_fee/100)}} </strong>
</td>
</tr>
</tbody>
</table>
<img src="{{ asset('images/paymentnotice.jpeg') }}" alt="" style="width:auto;height:100px;">
<div>

  @if($payment_status==1)
    
    @else 
         <input type="checkbox" id="myCheck" onclick="myFunction()">
                  <label for="required">I Agree  <a href="https://amaderthikana.com/policy">Privacy Policy</a> & 
                    <a href="https://amaderthikana.com/term"> Terms and Conditions</a>  </label>
          </div>

          <br>

          <div id="text1" >
                <a class="btn btn-success disabled" href="#">
                 Pay Now</a>
          </div>   

        <div id="text" style="display:none" >
               <a href="{{url('amarpay_payment/'.$hall_id.'/'.$invoice_id.'/'.$tran_id)}}" class="btn btn-success" > 
                    Pay Now
               </a>
          </div>

          
          
         @endif


</div>
</div>
</div>
</div>
</div>
</div>
</div> <script type="text/javascript"></script></body></html>


<script>
function myFunction() {
  var checkBox = document.getElementById("myCheck");
  var text = document.getElementById("text");
  if (checkBox.checked == true){
    text.style.display = "block";
    text1.style.display = "none";
  } else {
     text.style.display = "none";
     text1.style.display = "block";
  }
}
</script>
