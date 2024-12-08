@foreach($data as $row)
<tr>
  @if(!empty($row->profile_image))
  <td><a href="{{asset('/uploads/profile/'.$row->profile_image) }}">Image</a></td>
  @else <td><a href="">{{$row->profile_image}}</a></td> @endif

  @if(!empty($row->file_name))
  <td><a href="{{ asset('/uploads/file_name/'.$row->file_name) }}">Card</a></td>
  @else <td><a href="">{{$row->file_name}}</a></td> @endif
  <td>{{ $row->card}}</td>
  <td>{{ $row->name}}</td>
  <td>{{ $row->registration}}</td>
  <td>{{ $row->phone}}</td>
  <td>{{ $row->session}}</td>
  <td>{{ $row->security_money}}</td>
  <td> <button type="button" value="{{ $row->id}}" class="edit btn btn-info btn-sm">Edit </button> </td>
  <td> <button type="button" value="{{ $row->id}}" class="view_all btn btn-primary btn-sm">View</button> </td>


   <td>
     @if($row->email_verify == 1)
    <a href="{{ url('manager/member/email/deactive/'.$row->id) }}" onclick="return confirm('Are you sure you want to Change this status')" class="btn btn-success btn-sm">verified<a>
         @else
        <a href="{{ url('manager/member/email/active/'.$row->id) }}" onclick="return confirm('Are you sure you want to Move this status')" class="btn btn-danger btn-sm"> Pending verification<a>
         @endif
   </td>

 @if($member_status==1)
   <td>
     @if($row->admin_verify == 1)
    <a href="{{ url('manager/member/verify/deactive/'.$row->id) }}" onclick="return confirm('Are you sure Hall Varification this profile')" class="btn btn-success btn-sm">verifed<a>
         @else
        <a href="{{ url('manager/member/verify/active/'.$row->id) }}" onclick="return confirm('Are you sure Hall Varification this profile')" class="btn btn-danger btn-sm">Pending verification<a>
            @endif
    </td>


  <td>
      @if($row->status ==1)
       <a href="{{ url('manager/member/status/deactive/'.$row->id) }}" onclick="return confirm('Are you sure you want to Change this status')" class="btn btn-success btn-sm">Active<a>
        @else
        <a href="{{ url('manager/member/status/active/'.$row->id) }}" onclick="return confirm('Are you sure you want to Change this status')" class="btn btn-danger btn-sm"> Inactive<a>
       @endif
  </td>


  <td>
      @if($row->member_status ==1)
       <a href="{{ url('manager/member/member_status/deactive/'.$row->id) }}" onclick="return confirm('Are you sure you want to Change this status')" class="btn btn-danger btn-sm">Move<a>
        @else
        <a href="{{ url('manager/member/member_status/active/'.$row->id) }}" onclick="return confirm('Are you sure you want to Change this status')" class="btn btn-info btn-sm">Recover<a>
       @endif
  </td>

  @else
      <td> <a href="{{ url('manager/member_delete/'.$row->id) }}" onclick="return confirm('Are you sure you want to delete this Member')" class="btn btn-danger btn-sm">Delete<a>  </td>  
  @endif

  <td>{{ $row->email}} </td>
  
  <td>{{ $row->password}}</td>
  <td>{{ $row->created_at}}</td>

  @endforeach
</tr>

<tr class="pagin_link">
  <td colspan="17" align="center">
    {!! $data->links() !!}
  </td>
</tr>