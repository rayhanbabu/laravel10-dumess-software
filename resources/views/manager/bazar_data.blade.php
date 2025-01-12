 @foreach($data as $row)
      <tr>
                  <td>{{ $row->date}}</td>
                  <td>{{ $row->bazar_month}}-{{$row->bazar_year}},{{ $row->bazar_section}}</td>
                  <td>{{ $row->product}}</td>
                  <td>{{ $row->qty}} {{ $row->unit}}</td>
                  <td>{{ $row->price}} TK</td>
                  <td>{{ $row->total}} TK</td>
                  <td> <button type="button" value="{{ $row->id}}" class="edit_id btn btn-primary btn-sm">Edit</button> </td>
                  <td> <button type="button" value="{{ $row->id}}" class="delete_id btn btn-danger btn-sm">Delete</button> </td>
                  <td>{{ $row->bazar_type}}</td>
                  <td>{{ $row->updated_by}}</td>
                  <td>{{ date($row->created_at)}}</td>
                  <td>{{ date($row->updated_at)}}</td>
      </tr>
  @endforeach

     
      <tr class="pagin_link">
       <td colspan="11" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  
      