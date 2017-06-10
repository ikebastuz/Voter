<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Voter') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ URL::to('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::to('css/sweetalert2.min.css') }}">
    <script src="{{ URL::to('js/tether.min.js') }}"></script>
    <script src="{{ URL::to('js/jquery-3.2.0.min.js') }}"></script>
    <script src="{{ URL::to('js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::to('js/sweetalert2.min.js') }}"></script>


</head>
<body>
    <div id="app">
        @include('inc.navbar')

        @yield('content')
    </div>

</body>
@yield('js')
</html>
