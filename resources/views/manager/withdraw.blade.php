@extends('manager.layout')
@section('page_title','Manager Panel')
@section('text','active')
@section('content')


<div class="row mt-4 mb-3">
          <div class="col-6"> <h4 class="mt-0"> Settlement History </h4></div>
                     <div class="col-3">
                          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            
                          </div>
                      </div>
                      <div class="col-3">
                         <div class="d-grid gap-2 d-md-flex ">
                            
                </div>
          </div> 
    </div> 


<div id="success_message"></div>
 <div class="row mb-2">
    <div class="col-md-9">

    </div>
    <div class="col-md-3">
     <div class="form-group">
      <input type="text" name="search" id="search" placeholder="Enter Search " class="form-control"  autocomplete="off"  />
     </div>
    </div>
   </div>


   <div class="card-block table-border-style">                     
 <div class="table-responsive">
 <div class="x_content">
 <table class="table table-bordered" id="employee_data">
 <thead>
       <tr>
        <th  width="10%">Id</th>
        <th  width="10%">Hall Name</th>
        
        <th width="35%" class="sorting" data-sorting_type="asc" data-column_name="amount" style="cursor: pointer">Withdraw Amount
        <span id="amount_icon"><i class="fas fa-sort-amount-up-alt"></span></th>
        <th  width="10%"> Settlement Submitted time</th>
        <th  width="10%">Module</th>
        <th  width="10%">Settlement time</th>
		    <th  width="10%">Settlement Status</th>
        <th  width="10%">Settlement Type</th>
        <th  width="10%">Settlement Info</th>
        <th  width="10%">Image</th>
        <th  width="10%">Bank Informaation</th>
        <th  width="10%">Updated By</th>
        <th  width="10%">Updated By Time</th>
      </tr>
    </thead>
    <tbody>
       
    </tbody>
  </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
 
   </div>
  </div>
</div>

<script>  
$(document).ready(function(){ 
  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

     $('#add').click(function(){  
           $('#submit').val("Submit");  
           $('#add_form')[0].reset();   			   
      }); 


         fetch();
         function fetch(){
            $.ajax({
             type:'GET',
             url:'/manager/withdraw_fetch',
             datType:'json',
             success:function(response){
                    $('tbody').html('');
                    $('.x_content tbody').html(response);
                }
            });
         }

    
          
  
    function fetch_data(page, sort_type="", sort_by="", search=""){
        $.ajax({
           url:"/manager/withdraw/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&search="+search,
           success:function(data)
        {
           $('tbody').html('');
           $('.x_content tbody').html(data);
        }
        });
         }
   
       
    $(document).on('keyup', '#search', function(){
        var search = $('#search').val();
        var column_name = $('#hidden_column_name').val();
        var sort_type = $('#hidden_sort_type').val();
        var page = $('#hidden_page').val();
        fetch_data(page, sort_type, column_name, search);
      });


      $(document).on('click', '.pagin_link a', function(event){
           event.preventDefault();
           var page = $(this).attr('href').split('page=')[1];
           var column_name = $('#hidden_column_name').val();
           var sort_type = $('#hidden_sort_type').val();
           var search = $('#serach').val();
          fetch_data(page, sort_type, column_name, search);
        }); 


        $(document).on('click', '.sorting', function(){
          var column_name = $(this).data('column_name');
          var order_type = $(this).data('sorting_type');
          var reverse_order = '';
            if(order_type == 'asc')
             {
            $(this).data('sorting_type', 'desc');
            reverse_order = 'desc';
            $('#'+column_name+'_icon').html('<i class="fas fa-sort-amount-down"></i>');
             }
            else
            {
            $(this).data('sorting_type', 'asc');
            reverse_order = 'asc';
            $('#'+column_name+'_icon').html('<i class="fas fa-sort-amount-up-alt"></i>');
            }
           $('#hidden_column_name').val(column_name);
           $('#hidden_sort_type').val(reverse_order);
           var page = $('#hidden_page').val();
           var search = $('#serach').val();
          fetch_data(page, reverse_order, column_name, search);
          });


    
          $(document).on('click','.edit',function(){        
                    var withdraw_info = $(this).data("withdraw_info");
                    var withdraw_id = $(this).data("withdraw_id");
            
                     $('#edit_withdraw_info').val(withdraw_info);
                     $('#edit_withdarw_id').val(withdraw_id);

                
                     $('#updatemodal').modal('show');    
                });
            });  
     </script>   



  

@endsection 