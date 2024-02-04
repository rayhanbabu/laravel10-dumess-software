@foreach($data as $row)
        <tr>
                  <td>{{ $row->building_name}}</td>
                  <td>{{ $row->phone}}</td>
                  <td>{{ $row->room_name}}</td>
                  <td>{{ $row->seat_name}}</td>
                  <td> <button type="button" value="{{ $row->id}}" class="edit_id btn btn-primary btn-sm"> 
                        @if($row->booking_status==1) Booked @elseif($row->booking_status==0) 
                        Pending @elseif($row->booking_status==2) Pre-Booked 
                        @elseif($row->booking_status==5) Resign @else @endif 
                  </button> </td>
                  <td>{{ $row->seat_amount}}</td>
                  <td>{{ $row->service_amount}}</td>
                  <td>{{ $row->total_amount}}</td>
               
                  <td>{{ $row->amount1}}</td>
                  <td>{{ $row->amount2}}</td>
                  <td>{{ $row->amount3}}</td>
                  <td>{{ $row->due_amount}}</td>
                  <td> <button type="button" value="{{ $row->id}}" class="payment_edit btn btn-success btn-sm">Edit</button> </td>
                  <td> {{ $row->type1}}  {{ $row->time1}}</td>
                  <td> {{ $row->type2}}  {{ $row->time2}}</td>
                  <td> {{ $row->type3}}  {{ $row->time3}}</td>
                  
               
                 
      </tr>
      @endforeach

      <tr class="pagin_link">
       <td colspan="4" align="center">
        {!! $data->links() !!}
     </td>
</tr> 