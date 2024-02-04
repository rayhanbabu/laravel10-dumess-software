@extends('maintain.layout')
@section('page_title','Maintain Panel')
@section('text','active')
@section('content')


<br>

<div class="container p-4 ">
    <div class="text-center">
        <h1>Laravel 10 Summernote Text Editor with Image Upload CRUD (create read update and delete)</h1>
    </div>
    <a href="/text/create" class="btn btn-md btn-primary">Add new Post</a>
    <hr>
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($data as $post)
             <tr>
                <th scope="row">{{ $post->id }}</th>
                <td>{{ $post->title }}</td>
                <td>
                    <a href="/text/show/{{ $post->id }}" class="btn btn-success">Show</a>
                    <a href="/text/edit/{{ $post->id }}" class="btn btn-info">Edit</a>
                    <a href="/text/delete/{{ $post->id }}" class="btn btn-danger">Delete</a>              
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    

@endsection 