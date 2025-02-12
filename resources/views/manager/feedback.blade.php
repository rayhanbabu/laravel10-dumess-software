@extends('manager.layout')
@section('title','Admin Panel')
@section('feedback','active')
@section('content')

<div class="row mt-3 mb-0 mx-2">
  <div class="col-sm-3 my-2">
      <h4 class="mt-0"> Feedback  View </h4>
  </div>

  <div class="col-sm-3 my-2">
    <div class="d-grid gap-2 d-flex justify-content-end">
    <a href="https://youtu.be/OsLo20KXg8o?t=2156" target="_blank">  Tutorial</a>
    </div>
  </div>

  <div class="col-sm-6 my-2 ">
    <div class="d-grid gap-3 d-flex justify-content-end">

    </div>
  </div>

  @if(Session::has('success'))
      <div class="alert alert-success"> {{Session::get('success')}}</div>
  @endif

  @if(Session::has('fail'))
      <div class="alert alert-danger"> {{Session::get('fail')}}</div>
  @endif
</div>


<div class="card-block table-border-style">
    <div class="table-responsive">
        <table class="table table-bordered" id="employee_data">
            <thead>
                <tr>
                    <th width="10%">Card No</th>
                    <th width="10%">Name</th>
                    <th width="15%">Submited Date</th>
                    <th width="15%">Subject </th>
                    <th width="30%">Message </th>
                    <th width="10%"></th>
                </tr>
            </thead>
            <tbody>

                @foreach($data as $item)
                <tr>
                    <td>{{$item->card}}</td>
                    <td>{{$item->name}}</td>
                    <td> <?php echo date('d-m-Y ,l', strtotime($item->submited_time)); ?> </td>
                    <td>{{$item->subject}}</td>
                    <td>{{$item->text}}</td>
                    <td>
                        <form method="POST" action="{{ url('manager/feedback/'.$item->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Contact" onclick="return confirm('Are you sure delete this item')"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

        <script>
            $(document).ready(function() {
                $('#employee_data').DataTable({
                    "order": [
                        [0, "asc"]
                    ],
                    "lengthMenu": [
                        [10, 50, 100, -1],
                        [10, 50, 100, "All"]
                    ]
                });
            });
        </script>
    </div>
</div>


@endsection