<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="container-login">

    <main class="form-signin">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <img class="mb-4" src="images/logo.png" alt="" width="270" height="80">

            <div class="form-floating">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <label for="email">Email</label>
            </div>
            <div class="form-floating">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">
                <label for="floatingPassword">Contraseña</label>
            </div>

            @if ($errors->has('email') || $errors->has('password'))
                <div class="alert alert-danger">
                    <strong>{{ $errors->first('email') ?: $errors->first('password') }}</strong>
                </div>
            @endif

            {{-- <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div> --}}
            <button class="w-100 btn btn-lg btn-base-dv" type="submit">Iniciar Sesion</button>
            <p class="mt-5 mb-3 text-muted">© 2024</p>
        </form>
    </main>
</body>

</html>