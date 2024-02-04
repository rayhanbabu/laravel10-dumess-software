@foreach($data as $row)
            <tr>
                  <td>  <img src="{{ asset('/uploads/booking/'.$row->image1) }}" width="100" class="img-thumbnail" alt="Image"></td>
                  <td>  {{ $row->room_name}}</td>
                  <td>  {{ $row->building_name}}</td>
                  <td>  {{ $row->floor_name}}</td>
                  <td>  {{ $row->flat_name}}</td>
                  <td>  {!! $row->room_details !!}</td>
              <td>
                  @if($row->room_status == 1)
                     <a href="#" class="btn btn-success btn-sm">Active<a>
                  @else
                     <a href="#"  class="btn btn-danger btn-sm"> Inactive<a>
                   @endif
              </td>

             <td> <button type="button" value="{{ $row->id}}" class="btn btn-primary btn-sm editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal">Edit</button>  </td>  
             <td> <img src="{{ asset('/uploads/booking/'.$row->image2) }}" width="100" class="img-thumbnail" alt="Image"> </td>
             <td> <img src="{{ asset('/uploads/booking/'.$row->image3) }}" width="100" class="img-thumbnail" alt="Image"> </td>
             <td> <button type="button" value="{{ $row->id}}" class="btn btn-danger btn-sm deleteIcon"> Delete </button>  </td>
           
            </tr> 
@endforeach
  <tr class="pagin_link">
        <td colspan="4" align="center">
           {!! $data->links() !!}
        </td>
   </tr>  