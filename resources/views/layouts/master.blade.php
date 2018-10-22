<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">

        <title>App</title>

        <link rel="icon" type="image/ico" href="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Local -->
        <link rel="stylesheet" type="text/css" href="/css/raw.min.css">
        <link rel="stylesheet" type="text/css" href="/css/app.css">
        <link rel="stylesheet" type="text/css" href="/css/Login-Form-Dark.css">
        <link rel="stylesheet" type="text/css" href="/css/animatedText.css">

        <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js" ></script>
        <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC" rel="stylesheet">


        <!-- Required Stylesheets -->
        <link type="text/css" rel="stylesheet" href="https://unpkg.com/bootstrap/dist/css/bootstrap.min.css"/>
        <link type="text/css" rel="stylesheet" href="https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.css"/>

        @yield('stylesheets')
    </head>
    <body>
        @include("layouts.navigation")

        @include('partials.errors')
        @include('partials.status')
        @include('partials.message')

        <div class="container-fluid">
            <div  id='app' class="row">
                @yield("app-content")
            </div>
        </div>

        <footer class="footer bg-dark">
            <div class="container-fluid">
                <span class="text-muted">&copy; {!! date('Y'); !!} <a href="">You</a>
                    @if (Session::get('original_user'))
                        <a class="btn btn-link btn-sm" href="/users/switch-back">Return to your Login</a>
                    @endif
                </span>
            </div>
        </footer>

        <script type="text/javascript">
            var _token = '{!! Session::token() !!}';
            var _url = '{!! url("/") !!}';
        </script>
        @yield("pre-javascript")
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
        <script src="/js/app.js"></script>
        @yield("javascript")
    </body>
</html>
