@foreach($data as $row)
   <?php
           if($row['cur_daymeal']<=0){
                     $over = 'style="background:#fccccc"';
            }else{ $over = ''; } ?>
     <tr <?php echo  $over; ?> >
		      <td><?php echo $row['card']; ?></td>
              <td> <?php echo $row['invoice_year']; ?> - <?php echo $row['invoice_month']; ?> - <?php echo $row['invoice_section']; ?>  </td>
		      <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['phone']; ?></td>
              <td><?php echo $row['registration']; ?></td>
		      <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['pre_refund']; ?></td>
              <td><?php echo $row['pre_reserve_amount']; ?></td>
              <td><?php echo $row['security']; ?></td>
              <td><?php echo $row['pre_monthdue']; ?></td>
              <td><?php echo $row['withdraw']; ?>TK</td>
             <?php if($row['withdraw_status'] ==1){
                 ?> <td> <button type="button" value="{{ $row->id }}"  class="withdraw btn btn-info btn-sm">Paid </button> </td> <?php 
              }else{
                  ?> <td> <button type="button" value="{{ $row->id }}"  class="withdraw btn btn-danger btn-sm">Unpaid </button> </td> <?php
              } ?>

        <td> <?php echo $row['withdraw_type']; ?> , <?php echo $row['withdraw_time']; ?></td>               
             <?php if($row['invoice_year'] ==$hallinfo->cur_year && $row['invoice_month'] ==$hallinfo->cur_month){
                 ?> 
                    <td> </td>
                  <?php 
                }else{
                   ?>
                      <td> <a href="{{ url('manager/ex_payment_delete/'.$row->id) }}" onclick="return confirm('Are you sure you want to delete this Invoice')" class="btn btn-danger btn-sm">Delete<a>  </td>  
                  <?php
                }
             ?>


  </tr>
           
        
                   
      @endforeach

      <tr class="pagin_link">
       <td colspan="17" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  