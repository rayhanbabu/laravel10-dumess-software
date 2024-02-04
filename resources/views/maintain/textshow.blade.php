@extends('maintain.layout')
@section('page_title','Maintain Panel')
@section('text','active')
@section('content')


<div class="container p-4 ">
    <div class="row justify-content-md-center">
        <div class="col-md-12">
            <div class="text-center">
            <h1 class="">Laravel 10 Summernote Text Editor with Image Upload CRUD (create read update and delete)</h1>
            <hr>
            </div>
            <h3 class="text-center">{{ $data->title }}</h3>
            <div>
                {!! $data->description !!}
            </div>
        </div>
    </div>
</div>
    

@endsection 