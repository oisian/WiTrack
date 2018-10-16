@extends('layouts.master')

@section('app-content')

    <div id="particles-js" class="login-dark">
        <form method="POST" action="/login">
            <div class="letters"><span class="letter">W</span><span class="letter">i</span><span class="letter">-</span><span
                    class="letter">T</span><span class="letter">r</span><span
                    class="letter">a</span><span class="letter">c</span><span class="letter">k</span>
            </div>
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-12 raw-margin-top-24">
                    <input class="form-control" type="email" name="email" placeholder="Email"
                           value="{{ old('email') }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 raw-margin-top-24">
                    <input class="form-control" type="password" name="password" placeholder="Password" id="password">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 raw-margin-top-24">
                    <label>
                        Remember Me <input type="checkbox" name="remember">
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Log In</button>
            </div>

            <a href="/password/reset" class="forgot">Forgot your email or password?</a>


        </form>
    </div>

    <script>
        particlesJS.load('particles-js', '{{ asset('/js/particlesjs-config.json') }}', function () {
            console.log('callback - particles.js config loaded');
        });
    </script>

@stop

