@extends('layouts.app')

@section('content')

<h1>Authors</h1>
<hr>

<!-- show messages like: Author sucessfully deleted -->
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif




@foreach($authors as $author)

<div>

        <h4>{{$author->name}}</h4>

        @if(Auth::check() && Auth::User()->isAdmin())
            <div class="btn-group-vertical">
                {{ Form::model($author, ['method' => 'DELETE', 'action' => ['AuthorController@destroy', $author->id]]) }}
                    {{ Form::submit('Delete',  ['class' => 'btn btn-outline-danger btn-sm']) }}
                {!! Form::close() !!}
            </div>
        @endif

</div>
<hr>
@endforeach

@stop 