@extends('maintain.layout')
@section('page_title','Maintain Panel')
@section('text','active')
@section('content')


<div class="container p-4 ">
    <div class="row justify-content-md-center">
        <div class="col-md-12">
            <div class="text-center">
                <h1 class="">Summernote Text Editor with Image Upload CRUD </h1>
            </div> 
            <form action="/text/update/{{$data->id}}" method="post">
                @csrf
                <label for="">Title: </label>
                <input type="text" class="form-control" name="title" value="{{ $data->title }}">
                <label for="">Description: </label>
                <textarea name="description" id="description" cols="30" rows="10">{{ $data->description }}</textarea>
                <button type="submit" class="btn btn-lg btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    $('#description').summernote({
        placeholder:'description...',
        tabsize:2,
        height:300
    });
</script>
    

@endsection 