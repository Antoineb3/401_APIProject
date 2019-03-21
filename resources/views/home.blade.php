@extends('layouts.app')

<head>

    <!-- TODO: make a global stylesheet?  -->
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Styles -->
    <style>
        .content{
            /* background-color: #fff; */
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            color: #636b6f;

            margin-bottom: 30px;
        }
    </style>
</head>


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in.<br>
                    Welcome, {{Auth::user()->email}}!<br>
                    Your ID on this system is {{Auth()->user()->id}}.<br>
                    Your role is <span style="color:blue"> {{Auth()->user()->role}}</span>

                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="title m-b-md">
            Group 11 Library
        </div>

        <div class="links">
            @if(Auth()->user()->isAdmin())
                <a href="/books">Books</a>
                <a href="/authors">Authors</a>
                <a href="/users">Users</a>
            @elseif(Auth()->user()->isSubscriber())
                <a href="/books">Books</a>
                <a href="/authors">Authors</a>
            @endif    
        </div>
    </div>

</div>
@endsection
