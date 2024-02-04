@foreach($data as $row)
<tr>
	<th width="10%"><?php echo $row['card']; ?> </th>
    <th width="10%"><?php echo $row['registration']; ?> </th>

	<th width="15%"><?php echo $row['pre_last_meal']; ?> </th>
	<th width="15%"><?php echo $row['pre_meeting_present']; ?> </th>



	<th width="15%"><?php echo empty($row['date1']) ? "" : $row['b1']; ?></th>
	<th width="15%"><?php echo empty($row['date1']) ? "" : $row['l1']; ?></th>
	<th width="15%"><?php echo empty($row['date1']) ? "" : $row['d1']; ?></th>

	<th width="15%"><?php echo empty($row['date2']) ? "" : $row['b2']; ?></th>
	<th width="15%"><?php echo empty($row['date2']) ? "" : $row['l2']; ?></th>
	<th width="15%"><?php echo empty($row['date2']) ? "" : $row['d2']; ?></th>

	<th width="15%"><?php echo empty($row['date3']) ? "" : $row['b3']; ?></th>
	<th width="15%"><?php echo empty($row['date3']) ? "" : $row['l3']; ?></th>
	<th width="15%"><?php echo empty($row['date3']) ? "" : $row['d3']; ?></th>

	<th width="15%"><?php echo empty($row['date4']) ? "" : $row['b4']; ?></th>
	<th width="15%"><?php echo empty($row['date4']) ? "" : $row['l4']; ?></th>
	<th width="15%"><?php echo empty($row['date4']) ? "" : $row['d4']; ?></th>

	<th width="15%"><?php echo empty($row['date5']) ? "" : $row['b5']; ?></th>
	<th width="15%"><?php echo empty($row['date5']) ? "" : $row['l5']; ?></th>
	<th width="15%"><?php echo empty($row['date5']) ? "" : $row['d5']; ?></th>

    <td> <button type="button" value="<?php echo $row['id']; ?>" class="edit btn btn-info btn-sm"> Edit </button> </td>

	<th width="15%"><?php echo empty($row['date6']) ? "" : $row['b6']; ?></th>
	<th width="15%"><?php echo empty($row['date6']) ? "" : $row['l6']; ?></th>
	<th width="15%"><?php echo empty($row['date6']) ? "" : $row['d6']; ?></th>

	<th width="15%"><?php echo empty($row['date7']) ? "" : $row['b7']; ?></th>
	<th width="15%"><?php echo empty($row['date7']) ? "" : $row['l7']; ?></th>
	<th width="15%"><?php echo empty($row['date7']) ? "" : $row['d7']; ?></th>

	<th width="15%"><?php echo empty($row['date8']) ? "" : $row['b8']; ?></th>
	<th width="15%"><?php echo empty($row['date8']) ? "" : $row['l8']; ?></th>
	<th width="15%"><?php echo empty($row['date8']) ? "" : $row['d8']; ?></th>

	<th width="15%"><?php echo empty($row['date9']) ? "" : $row['b9']; ?></th>
	<th width="15%"><?php echo empty($row['date9']) ? "" : $row['l9']; ?></th>
	<th width="15%"><?php echo empty($row['date9']) ? "" : $row['d9']; ?></th>

	<th width="15%"><?php echo empty($row['date10']) ? "" : $row['b10']; ?></th>
	<th width="15%"><?php echo empty($row['date10']) ? "" : $row['l10']; ?></th>
	<th width="15%"><?php echo empty($row['date10']) ? "" : $row['d10']; ?></th>

	<th width="15%"><?php echo empty($row['date11']) ? "" : $row['b11']; ?></th>
	<th width="15%"><?php echo empty($row['date11']) ? "" : $row['l11']; ?></th>
	<th width="15%"><?php echo empty($row['date11']) ? "" : $row['d11']; ?></th>

	<th width="15%"><?php echo empty($row['date12']) ? "" : $row['b12']; ?></th>
	<th width="15%"><?php echo empty($row['date12']) ? "" : $row['l12']; ?></th>
	<th width="15%"><?php echo empty($row['date12']) ? "" : $row['d12']; ?></th>

	<th width="15%"><?php echo empty($row['date13']) ? "" : $row['b13']; ?></th>
	<th width="15%"><?php echo empty($row['date13']) ? "" : $row['l13']; ?></th>
	<th width="15%"><?php echo empty($row['date13']) ? "" : $row['d13']; ?></th>

	<th width="15%"><?php echo empty($row['date14']) ? "" : $row['b14']; ?></th>
	<th width="15%"><?php echo empty($row['date14']) ? "" : $row['l14']; ?></th>
	<th width="15%"><?php echo empty($row['date14']) ? "" : $row['d14']; ?></th>

	<th width="15%"><?php echo empty($row['date15']) ? "" : $row['b15']; ?></th>
	<th width="15%"><?php echo empty($row['date15']) ? "" : $row['l15']; ?></th>
	<th width="15%"><?php echo empty($row['date15']) ? "" : $row['d15']; ?></th>

	<th width="15%"><?php echo empty($row['date16']) ? "" : $row['b16']; ?></th>
	<th width="15%"><?php echo empty($row['date16']) ? "" : $row['l16']; ?></th>
	<th width="15%"><?php echo empty($row['date16']) ? "" : $row['d16']; ?></th>

	<th width="15%"><?php echo empty($row['date17']) ? "" : $row['b17']; ?></th>
	<th width="15%"><?php echo empty($row['date17']) ? "" : $row['l17']; ?></th>
	<th width="15%"><?php echo empty($row['date17']) ? "" : $row['d17']; ?></th>

	<th width="15%"><?php echo empty($row['date18']) ? "" : $row['b18']; ?></th>
	<th width="15%"><?php echo empty($row['date18']) ? "" : $row['l18']; ?></th>
	<th width="15%"><?php echo empty($row['date18']) ? "" : $row['d18']; ?></th>

	<th width="15%"><?php echo empty($row['date19']) ? "" : $row['b19']; ?></th>
	<th width="15%"><?php echo empty($row['date19']) ? "" : $row['l19']; ?></th>
	<th width="15%"><?php echo empty($row['date19']) ? "" : $row['d19']; ?></th>

	<th width="15%"><?php echo empty($row['date20']) ? "" : $row['b20']; ?></th>
	<th width="15%"><?php echo empty($row['date20']) ? "" : $row['l20']; ?></th>
	<th width="15%"><?php echo empty($row['date20']) ? "" : $row['d20']; ?></th>

	<th width="15%"><?php echo empty($row['date21']) ? "" : $row['b21']; ?></th>
	<th width="15%"><?php echo empty($row['date21']) ? "" : $row['l21']; ?></th>
	<th width="15%"><?php echo empty($row['date21']) ? "" : $row['d21']; ?></th>

	<th width="15%"><?php echo empty($row['date22']) ? "" : $row['b22']; ?></th>
	<th width="15%"><?php echo empty($row['date22']) ? "" : $row['l22']; ?></th>
	<th width="15%"><?php echo empty($row['date22']) ? "" : $row['d22']; ?></th>

	<th width="15%"><?php echo empty($row['date23']) ? "" : $row['b23']; ?></th>
	<th width="15%"><?php echo empty($row['date23']) ? "" : $row['l23']; ?></th>
	<th width="15%"><?php echo empty($row['date23']) ? "" : $row['d23']; ?></th>

	<th width="15%"><?php echo empty($row['date24']) ? "" : $row['b24']; ?></th>
	<th width="15%"><?php echo empty($row['date24']) ? "" : $row['l24']; ?></th>
	<th width="15%"><?php echo empty($row['date24']) ? "" : $row['d24']; ?></th>

	<th width="15%"><?php echo empty($row['date25']) ? "" : $row['b25']; ?></th>
	<th width="15%"><?php echo empty($row['date25']) ? "" : $row['l25']; ?></th>
	<th width="15%"><?php echo empty($row['date25']) ? "" : $row['d25']; ?></th>

	<th width="15%"><?php echo empty($row['date26']) ? "" : $row['b26']; ?></th>
	<th width="15%"><?php echo empty($row['date26']) ? "" : $row['l26']; ?></th>
	<th width="15%"><?php echo empty($row['date26']) ? "" : $row['d26']; ?></th>

	<th width="15%"><?php echo empty($row['date27']) ? "" : $row['b27']; ?></th>
	<th width="15%"><?php echo empty($row['date27']) ? "" : $row['l27']; ?></th>
	<th width="15%"><?php echo empty($row['date27']) ? "" : $row['d27']; ?></th>

	<th width="15%"><?php echo empty($row['date28']) ? "" : $row['b28']; ?></th>
	<th width="15%"><?php echo empty($row['date28']) ? "" : $row['l28']; ?></th>
	<th width="15%"><?php echo empty($row['date28']) ? "" : $row['d28']; ?></th>

	<th width="15%"><?php echo empty($row['date29']) ? "" : $row['b29']; ?></th>
	<th width="15%"><?php echo empty($row['date29']) ? "" : $row['l29']; ?></th>
	<th width="15%"><?php echo empty($row['date29']) ? "" : $row['d29']; ?></th>

	<th width="15%"><?php echo empty($row['date30']) ? "" : $row['b30']; ?></th>
	<th width="15%"><?php echo empty($row['date30']) ? "" : $row['l30']; ?></th>
	<th width="15%"><?php echo empty($row['date30']) ? "" : $row['d30']; ?></th>

	<th width="15%"><?php echo empty($row['date31']) ? "" : $row['b31']; ?></th>
	<th width="15%"><?php echo empty($row['date31']) ? "" : $row['l31']; ?></th>
	<th width="15%"><?php echo empty($row['date31']) ? "" : $row['d31']; ?></th>


 	 <th width="15%"><?php echo $row['refund_feast']; ?></th>
	 <th width="15%"><?php echo $row['meeting_present']; ?></th>
	
</tr>
@endforeach

</tr>

<tr class="pagin_link">
	<td colspan="102" align="center">
		{!! $data->links() !!}
	</td>
</tr>