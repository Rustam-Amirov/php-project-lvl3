<!DOCTYPE html>
    <head>
         <title>@yield('title')</title>
         @include('shared.metategs')
    </head>
    <body class="min-vh-100 d-flex flex-column">
        @include('shared.header')

        @yield('main')

        @include('shared.footer')
    </body>
</html>
