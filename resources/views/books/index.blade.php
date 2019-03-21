@extends('layouts.app')

@section('content')

<header>
    <h1 style="display: inline-block;">Books</h1>
    @if(Auth::check())

        @if(Auth::user()->isAdmin())
            <a href="{{action('BookController@create')}}">
                <button type="button" class="btn btn-primary" style="float:right"> Create a Book </button>
            </a>
        @endif
    @endif        
</header>
<hr>

<!-- show messages like: Book sucessfully deleted -->
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif




@foreach($books as $book)


<div class="row">
    <!-- bootstrap class="row" divides the page in 12 columns. we decide how wide each of the following elements should be with class="col-md-X"-->
    <div class="col-md-1">
        <img src="{{$book->image}}" alt="book img" class="img-fluid">
    </div>
    <div class="col-md-10">
        <h2>
            <a href="{{action('BookController@show',[$book->id])}}">
                {{$book->name}}
            </a>
        </h2>
        {{$book->publisher}}, {{$book->publication_year}}
    </div>
</div>


<hr>
@endforeach

@stop
