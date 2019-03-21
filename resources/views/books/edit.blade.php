@extends('layouts.app')

@section('content')


    <h1>Edit Book: {!! $book->first()->title !!}</h1>
    <hr>


    {!! Form::model($book, ['method'=>'PATCH', 'action'=>['BookController@update',$book->id]]) !!}
    @include ('books.form', ['submitButtonText'=>'Update Book', 'editFlag' =>'true'])
    {!! Form::close() !!}

    @include ('errors.list')



@stop
