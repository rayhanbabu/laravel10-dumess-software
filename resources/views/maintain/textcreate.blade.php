@extends('maintain.layout')
@section('page_title','Maintain Panel')
@section('text','active')
@section('content')


<div class="container shadow p-4">
      <form method="POST" action="/text/store">
        @csrf
   <div class="mb-3"> 
       <label for="exampleFormControlInput1" class="form-label">Name</label>
       <input type="text" name="title" class="form-control" id="exampleFormControlInput1" placeholder="">
    </div>

    <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label"> textarea</label>
          <textarea name="description" id="summernote" cols="30" rows="10"></textarea>
    </div> 

 <button type="submit" class="btn btn-primary">Submit</button>

</form>




</div>



    <script>
      $('#summernote').summernote({
        placeholder: 'Description...',
        tabsize: 2,
        height: 100
      });
    </script>
    

@endsection 