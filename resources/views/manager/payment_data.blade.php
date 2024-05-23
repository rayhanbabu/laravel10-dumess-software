@foreach($data as $row)
   <?php
           if($row['onmeal_amount']<=0){
                     $over = 'style="background:#fccccc"';
            }else{ $over = ''; } ?>
     <tr <?php echo  $over; ?> >
		      <td><?php echo $row['card']; ?></td>
		      <td><?php echo $row['name']; ?></td>
              <td><?php echo $row['registration']; ?></td>
		      <td><?php echo $row['id']; ?></td>

       @if($invoice_status==1)
	         
           <td> <?php echo $row['payble_amount']; ?>TK </td>
           <td> <?php echo $row['payble_amount1']; ?>TK </td>

          <?php if($row['payment_status1'] ==1){
               ?> <td> <button type="button" value="{{ $row->id }}"   class="payment1 btn btn-info btn-sm">Paid1</button> </td> <?php 
           }else{
                ?> <td> <button type="button" value="{{ $row->id }}"  class="payment1 btn btn-danger btn-sm">Unpaid1</button> </td> <?php
            } ?>
       


        <td><?php echo $row['payble_amount2']; ?>TK</td>
       <?php if($row['payment_status2'] ==1){
            ?> <td> <button type="button" value="{{ $row->id}}"  class="payment2 btn btn-info btn-sm">Paid2</button> </td> <?php 
        }else{
            ?> <td> <button type="button" value="{{ $row->id}}"  class="payment2 btn btn-danger btn-sm">Unpaid2</button> </td> <?php
        } ?>
       


        <td><?php echo $row['withdraw']; ?>TK</td>


         <?php if($row['withdraw_status'] ==1){
           ?> <td> <button type="button" value="{{ $row->id}}"  class="withdraw btn btn-info btn-sm">Paid </button> </td> <?php 
          }else{
             ?> <td> <button type="button" value="{{ $row->id}}"  class="withdraw btn btn-danger btn-sm">Unpaid </button> </td> <?php
          } ?>

        <td> <button type="button" value="{{$row->id}}" class="view_all btn btn-primary btn-sm">View </button> </td>

		<td><?php echo $row['payment_type1']; ?> , <?php echo $row['payment_time1']; ?>,  <?php echo $row['payment_method1']; ?></td>
        <td><?php echo $row['payment_type2']; ?> , <?php echo $row['payment_time2']; ?>,  <?php echo $row['payment_method2']; ?></td>
        <td><?php echo $row['withdraw_type']; ?> , <?php echo $row['withdraw_time']; ?></td>

       <?php if($row['block_status']==1){
           ?> <td> <button type="button" value="{{ $row->id}}" data-status="0" class="memberblock btn btn-success btn-sm">Blocked </button> </td> <?php 
        }else{
           ?> <td> <button type="button" value="{{ $row->id}}" data-status="1" class="memberblock btn btn-warning btn-sm">Unblock </button> </td> <?php
        } ?>
       
        <td><a  class="btn btn-primary btn-sm" href="{{ url('/manager/invoicepdf/'.$row->id)}}">Print</a></td>
           
        @elseif($invoice_status==5)
               <td><?php echo $row['withdraw']; ?>TK</td>
           <?php if($row['withdraw_status'] ==1){
               ?> <td> <button type="button" value="{{ $row->id}}"  class="withdraw btn btn-info btn-sm">Paid </button> </td> <?php 
            }else{
                ?> <td> <button type="button" value="{{ $row->id}}"  class="withdraw btn btn-danger btn-sm">Unpaid </button> </td> <?php
            } ?>

            <td><?php echo $row['withdraw_type']; ?> , <?php echo $row['withdraw_time']; ?></td>

        @endif

       
	
  </tr>
           
        
                   
      @endforeach

      <tr class="pagin_link">
       <td colspan="17" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  