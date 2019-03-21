<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link href="/css/app.css" rel="stylesheet">
</head>

<body>
    <div class='container'>
        @yield('content')
    </div>

    <div class='container'>
        @yield('footer')
    </div></body>

</html>
