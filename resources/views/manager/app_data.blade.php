@foreach($data as $row)
      <tr>
                  <td>{{ $row->id}}</td>
                  <td>{{ $row->serial}}</td>
                  <td>{{ $row->phone}}</td>
                  <td> <button type="button" value="{{ $row->id}}" class="edit_id btn btn-primary btn-sm">Edit</button> </td>
                 <td> <button type="button" value="{{ $row->id}}" class="delete_id btn btn-danger btn-sm">Delete</button> </td>
      </tr>
      @endforeach

      <tr class="pagin_link">
       <td colspan="4" align="center">
        {!! $data->links() !!}
     </td>
</tr> 