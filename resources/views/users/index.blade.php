@extends('layouts.app')

@section('content')

<h1>Users</h1>
<hr>

<!-- show messages like: Book sucessfully deleted -->
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@foreach($users as $user)

	<div class="col-md-10">
	    <h3>
	        <a href="{{action('UserController@show',[$user->id])}}">
	            {{$user->email}}
	        </a>
	    </h3>
	</div>
	<hr>
@endforeach

@stop 