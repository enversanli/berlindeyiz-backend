<!DOCTYPE html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
          integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay"
          crossorigin="anonymous">
    <title>{{ config('app.name', 'Netsek') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Yanone+Kaffeesatz:wght@300&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">--}}
{{--    <script src="{{ asset('js/jquery-3.6.0.min.js') }}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>--}}
{{--    <script src="{{ asset('js/jquery.fancybox.js') }}" integrity="sha512-j7/1CJweOskkQiS5RD9W8zhEG9D9vpgByNGxPIqkO5KrXrwyDAroM9aQ9w8J7oRqwxGyz429hPVk/zR6IOMtSA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>--}}
{{--    <link--}}
{{--        rel="stylesheet"--}}
{{--        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">--}}
</head>
<body class="font-sans antialiased">
<div id="app">
    <div>
        <div class="min-h-screen  animate__animated animate__fadeIn">
            <header-component></header-component>
            @include('web.layouts.navigation')

            <div class="container max-w">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script type="module" src="{{mix('js/app.js')}}"></script>
</body>
</html>

