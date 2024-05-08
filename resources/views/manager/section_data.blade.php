@foreach($data as $row)
    <tr>
         <?php if($row['onmeal_amount']<=0){
                     $over = 'style="background:#fccccc"';
             }else{ $over = ''; } ?>
	     <tr <?php echo  $over; ?> >
	     <td><?php echo $row['card']; ?></td>
		 <td><?php echo $row['name']; ?></td>
         <td><?php echo $row['registration']; ?></td>
         <td><?php echo $row['id']; ?></td>
		 <td><?php echo date('M-Y',strtotime($row['invoice_date']));?></td>
	     <td><?php echo $row['invoice_section']; ?></td>
         <td><?php echo $row['pre_reserve_amount']; ?></td>
         <td><?php echo $row['pre_refund']; ?></td>
         <td><?php echo $row['pre_monthdue']; ?></td>

         <td> <button type="button" value="{{ $row->id}}" class="edit btn btn-info btn-sm">Edit </button> </td>
		

        <td><?php echo $row['hostel_fee']; ?></td>
		<td><?php echo $row['section_day']; ?></td>
		<td><?php echo $row['breakfast_rate']; ?></td>
		<td><?php echo $row['lunch_rate']; ?></td>
		<td><?php echo $row['dinner_rate']; ?></td>
		<td><?php echo $row['cur_meal_amount']; ?>TK</td>


        <td><?php echo $row['employee']; ?>TK</td>
		<td><?php echo $row['friday']; ?>TK</td>
		<td><?php echo $row['feast']; ?>TK</td>
		<td><?php echo $row['welfare']; ?>TK</td>
		<td><?php echo $row['others']; ?>TK</td>
        <td><?php echo $row['gass']; ?>TK</td>
        <td><?php echo $row['electricity']; ?>TK</td>
        <td><?php echo $row['tissue']; ?>TK</td>
        <td><?php echo $row['water']; ?>TK</td>
        <td><?php echo $row['dirt']; ?>TK</td>
        <td><?php echo $row['wifi']; ?>TK</td>
          
        <td><?php echo $row['card_fee']; ?>TK</td>
        <td><?php echo $row['security']; ?>TK</td>
        <td><?php echo $row['service_charge']; ?>TK</td>
        <td><?php echo $row['meeting_penalty']; ?>TK</td>
        <td><?php echo $row['cur_others_amount']; ?>TK</td>
        <td><?php echo $row['cur_total_amount']; ?>TK</td>
        <td><?php echo $row['withdraw']; ?> TK</td>
        <td><?php echo $row['withdraw_status']; ?> </td>
        <td><?php echo $row['inmeal_amount']; ?> TK</td>
        <td><?php echo $row['payble_amount']; ?>TK</td>

        <td><?php echo $row['first_pay_mealon']; ?> </td>
        <td><?php echo $row['first_pay_mealamount']; ?>TK</td>
        <td><?php echo $row['first_others_amount']; ?>TK</td>
        <td><?php echo $row['payble_amount1']; ?>TK</td>
        <td><?php echo $row['payment_status1']; ?></td>

        <td><?php echo $row['second_pay_mealon']; ?></td>
        <td><?php echo $row['second_pay_mealamount']; ?>TK</td>
        <td><?php echo $row['second_others_amount']; ?>TK</td>
        <td><?php echo $row['payble_amount2']; ?>TK</td>
        <td><?php echo $row['payment_status2']; ?></td>
 
		<td><?php echo $row['breakfast_onmeal']; ?></td>
		<td><?php echo $row['breakfast_offmeal']; ?></td>
		<td><?php echo $row['breakfast_inmeal']; ?></td>
        <td><?php echo $row['lunch_onmeal']; ?></td>
		<td><?php echo $row['lunch_offmeal']; ?></td>
		<td><?php echo $row['lunch_inmeal']; ?></td>
        <td><?php echo $row['dinner_onmeal']; ?></td>
		<td><?php echo $row['dinner_offmeal']; ?></td>
		<td><?php echo $row['dinner_inmeal']; ?></td>

		<td><?php echo $row['onmeal_amount']; ?>TK</td>
       
        <td><?php echo $row['refund_breakfast_rate']; ?> </td>
        <td><?php echo $row['refund_lunch_rate']; ?> </td>
        <td><?php echo $row['refund_dinner_rate']; ?> </td>
        <td><?php echo $row['mealreducetk']; ?>TK</td>
        <td><?php echo $row['offmeal_amount']; ?>TK</td>

        <td><?php echo $row['refund_feast']; ?>TK</td>
        <td><?php echo $row['refund_welfare']; ?>TK</td>
        <td><?php echo $row['refund_friday']; ?>TK</td>
        <td><?php echo $row['refund_employee']; ?>TK</td>
        <td><?php echo $row['refund_others']; ?>TK</td>

        <td><?php echo $row['refund_tissue']; ?>TK</td>
        <td><?php echo $row['refund_gass']; ?>TK</td>
        <td><?php echo $row['refund_electricity']; ?>TK</td>
        <td><?php echo $row['refund_water']; ?>TK</td>
        <td><?php echo $row['refund_wifi']; ?>TK</td>
        <td><?php echo $row['refund_dirt']; ?>TK</td>

        <td><?php echo $row['block_status']; ?>TK</td>
        <td><?php echo $row['total_refund']; ?>TK</td>
        <td><?php echo $row['total_due']; ?>TK</td>
        <td><?php echo $row['reserve_amount']; ?>TK</td>

    </tr>
        
                   
      @endforeach

      <tr class="pagin_link">
       <td colspan="48" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  