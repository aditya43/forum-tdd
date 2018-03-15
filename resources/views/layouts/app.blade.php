<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('app.css') }}" rel="stylesheet">

    <style type="text/css">
        .level {
            display: flex;
            align-items: center;
        }

        .flex {
            flex: 1;
        }

        [v-cloak] {
            display: none;
        }
    </style>

    <script>
        window.App = {!! json_encode([
            'user' => Auth::user(),
            'signedIn' => Auth::check()
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        @include('partials._nav')

        <main class="py-4">
            @yield('content')
        </main>

        <flash message="{{ session('flash') }}"></flash>
    </div>


    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
