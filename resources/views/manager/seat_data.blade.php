 @foreach($data as $row)
         <tr>
                <td>  {{ $row->seat_name}}</td>
                <td>  {{ $row->building_name}}</td>
                <td>  {{ $row->floor_name}}</td>
                <td>  {{ $row->flat_name}}</td>
                <td>  {{ $row->room_name}}</td>
                <td>  {{ $row->seat_price}}</td>
                <td>  {{ $row->service_charge}}</td>

                <td> <button type="button"  class="btn btn- btn-sm"> 
                     @if($row->seat_booking_status==1) <p class="text-danger">Booked </p>
                     @elseif($row->seat_booking_status==0)<p class="text-success">Available </p>
                     @elseif($row->seat_booking_status==2) <p class="text-warning">Pre-Booked </p>
                     @else @endif 
                  </button> </td>
             <td>
                @if($row->seat_status == 1)
                   <a href="#" class="btn btn-success btn-sm">Active<a>
                @else
                   <a href="#"  class="btn btn-danger btn-sm"> Inactive<a>
                @endif
            </td>

            <td>
                @if($row->price_status == 1)
                  Not Nego
                @else
                   Nego
                @endif
            </td>
                <td> <button type="button" value="{{ $row->id}}" class="btn btn-primary btn-sm editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal">Edit</button>  </td>
                <td> <button type="button" value="{{ $row->id}}" class="btn btn-danger btn-sm deleteIcon" >Delete</button>  </td>
            </tr>            
@endforeach
  <tr class="pagin_link">
        <td colspan="4" align="center">
           {!! $data->links() !!}
        </td>
   </tr>  