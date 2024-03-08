@extends('manager.layout')
@section('title','Admin Panel')
@section('feedback','active')
@section('content')

<h3>  Meeting Info View </h3>
<form  method="get">
	  <div class="row">
    
         <div class="col-sm-4">
                
         </div>
		

        <div class="col-sm-4">
            <label>Session of Year<label>
            <input name="session" type="text"  class="form-control" autocomplete="off"  value=""  required >
        </div>

       <div class="col-sm-2">
          
           <button type="submit" value="submit"  name="submit"  class="btn btn-success">Submit</button>
      </div>    
 
   </div>
   </form> 
   <br>

   <div class="table-responsive">
  <form  method="POST" id="update_form" enctype="multipart/form-data">
   <table class="table table-bordered" style="font-size:15px;" >
     <thead>
     <tr style="background: whitesmoke;">

              
                  <th width ="10%">Card No</th>
                  <th width ="25%"> Name of Student </th>	
                  <th width="10%">Present Status </th> 
               					   
        </tr>
   </thead>
     <tbody>


     </tbody>
  </table>
  <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>


  <div class="mt-4 my-3 mx-3">
            <button type="submit" id="edit_employee_btn" class="btn btn-success">Update </button>
            <br><br>
       </div>  
 </form>
</div>
   
  


  
<script>  
$(document).ready(function(){  

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
    
    fetch_data();

      function fetch_data() {
        $.ajax({
          type:'GET',
          url:'/manager/meeting/{{$session}}',
          beforeSend:function(){ 
            var html = ''; 
            html += '<tr>';
            html += '<td colspan="3">Looading...</td>';
            html += '</tr>';
            
            $('tbody').html(html);
                 },
          success: function(response) {
            //console.log(response);
            var html = '';
                for(var count = 0; count < response.data.length; count++)
                {
	 html += '<tr>';
     html += '<input type="hidden" id="'+response.data.length+'"  name="id[]" value="'+response.data[count].id+'" />';
     html += '<td>'+response.data[count].card+'</td>';
     html += '<td>'+response.data[count].name+'</td>';
     html += '<td><input type="number"  min="0" max="1" name="meeting_present[]"   class="form-control"  value="'+response.data[count].meeting_present+'"/></td>';
     html += '</tr>';		
   }
            $('tbody').html(html);
          }
        });
      }
   

  
	
	

    $('#update_form').on('submit', function(event){
        event.preventDefault();
        if($(this).attr("id").length > 0)
        {
            $.ajax({
                url:"/manager/meeting-update",
                type:"POST",
                dataType: 'json',
                data:$(this).serialize(),
                beforeSend:function(){  
                   $('.loader').show();
                   $("#edit_employee_btn").prop('disabled',true)
                 }, 
                success:function(response)
                {
                 console.log(response)
               if(response.status == 100){
                  alert('Data Update Successfull')
                  }
                $("#edit_employee_btn").prop('disabled', false)  
                $('.loader').hide();
                fetch_data();
               }
            })
        }
    });

});  
</script> 



@endsection