<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }} - @yield('title')</title>

        <link rel="stylesheet" href="/css/app.css">

        <script>
            window.App = {
                csrfToken: '{{ csrf_token() }}',
                stripePublicKey: '{{ config('services.stripe.key') }}',
            }
        </script>
    </head>
    <body class="bg-grey-lighter">
        <div id="app">
            @yield('body')
        </div>

        @stack('scripts')
        <script src="/js/app.js"></script>
    </body>
</html>
