<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', config('app.name'))</title>
    @include('layouts.auth._layout.style')
</head>

<body class="">
    <!--wrapper-->
    @yield('content')
    <!--end wrapper-->
    @include('layouts.auth._layout.script')
</body>

</html>
