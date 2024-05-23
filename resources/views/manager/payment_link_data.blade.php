<?php
 use Illuminate\Support\Facades\URL;
?>
@foreach($data as $row)
    <tr>
          <?php if($row['onmeal_amount']<=0){
                  $over='style="background:#fccccc"';
             }else{ $over = ''; } ?>
	      <tr <?php echo  $over; ?> >
	      <td><?php echo $row['card']; ?></td>
		    <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['id']; ?></td>
		    <td><?php echo date('M-Y',strtotime($row['invoice_date']));?> - <?php echo $row['invoice_section']; ?></td>
        <td><?php echo $row['tran_id1']; ?></td>
        <td><?php echo $row['payble_amount1']; ?></td>
        <td><?php echo $row['payment_status1']; ?></td>
        <td><?php echo $row['amount1']; ?></td>
           <td> 
                 <a  target="_blank"  href="<?php echo URL::to('epay/'.$row->hall_id.'/'.$row->id.'/'.$row->tran_id1) ?>">
                   <?php echo URL::to('epay/'.$row->hall_id.'/'.$row->id.'/'.$row->tran_id1) ?></a> 
          </td>

         <td><?php echo $row['tran_id2']; ?></td>  
        <td><?php echo $row['payble_amount2']; ?></td>
        <td><?php echo $row['payment_status2']; ?></td>
        <td><?php echo $row['amount2']; ?></td>
        <td> 
                 <a  target="_blank"  href="<?php echo URL::to('epay/'.$row->hall_id.'/'.$row->id.'/'.$row->tran_id2) ?>">
                   <?php echo URL::to('epay/'.$row->hall_id.'/'.$row->id.'/'.$row->tran_id2) ?></a> 
          </td>

    </tr>
        
                   
      @endforeach

      <tr class="pagin_link">
       <td colspan="48" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  