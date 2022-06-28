<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel='stylesheet' href="{{asset('css/style.css')}}">
    <link rel='stylesheet' href="{{asset('css/reset.css')}}">
    <link rel='stylesheet' href="{{asset('css/main.css')}}">
</head>
<body>

        @include('layouts.header')
        @yield('content')
        @include('layouts.footer')

</body>
</html>