 @foreach($data as $row)
      <tr>
                 
                  <td>{{ $row->name}}</td>
                  <td>{{ $row->cur_month}}-{{$row->cur_year}},{{ $row->cur_section}}</td>
                  <td>{{ $row->description}} </td>
                  <td>{{ $row->amount}} </td>
                  <td> <button type="button" value="{{ $row->id}}" class="edit_id btn btn-primary btn-sm">Edit</button> </td>
                  <td> <button type="button" value="{{ $row->id}}" class="delete_id btn btn-danger btn-sm">Delete</button> </td>
                  <td>{{ $row->payment_type}}</td>
                  <td>{{ date($row->created_at)}}</td>
                  <td>{{ date($row->updated_at)}}</td>
      </tr>
  @endforeach

     
      <tr class="pagin_link">
       <td colspan="11" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  
      