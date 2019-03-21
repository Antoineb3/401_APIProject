@extends('layouts.app')

@section('content')


    <h1>Edit User: {!! $user->email !!}</h1>
    <hr>

    {!! Form::model($user, ['method'=>'PATCH', 'action'=>['UserController@update',$user->id]]) !!}

	<div class="form-group">
    	{!! Form::label('role', 'Role:') !!}
    	{!! Form::select('role', array('Admin' => 'Admin', 'Subscriber' => 'Subscriber'), $user->role, ['class'=>'form-control']) !!}
	</div>

	<div class="form-group">
    	{!! Form::label('birthday', 'Birthday:') !!}
    	{!! Form::input('date', 'birthday', date('Y-m-d'), ['class'=>'form-control']) !!}
	</div>

	<div class="form-group">
    	{!! Form::label('education_field', 'Education Field:') !!}
    	{!! Form::text('education_field', null, ['class'=>'form-control']) !!}
	</div>

    <div class="form-group form-checkbox">
        @if(sizeof($available_books)>1)
          {!! Form::label('subscriptions[]', 'Subscriptions:') !!}
        @else
          {!! Form::label('subscriptions[]', 'Subscription:') !!}
        @endif
         <br/>
        <div class = "container" style = "margin-left: 50px">
            @foreach($available_books as $book)

                {!! Form::checkbox('subscriptions[]', $book->id, in_array($book->id, $current_subscribed_book_ids) ? true : false) !!}

                {{ $book->name }}
                <br/>
            @endforeach
        </div>
    </div>

	<div class="form-group">
    	{!! Form::submit('Update User', ['class'=>'btn btn-primary form-control']) !!}
	</div>

    {!! Form::close() !!}

    @include ('errors.list')



@stop
