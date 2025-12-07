<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Blog') }}</title>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header class="container">
        <nav>
            <ul>
                <li><strong><a href="{{ route('home') }}">📝 Mi Blog</a></strong></li>
            </ul>
            <ul>
                @auth
                    @if(auth()->user()->isAdmin())
                        <li><a href="{{ route('admin.users.index') }}">Usuarios</a></li>
                    @endif

                    <li><a href="{{ route('posts.create') }}">Nuevo Post</a></li>

                    <li>
                        <details role="list">
                            <summary aria-haspopup="listbox">{{ auth()->user()->name }}</summary>
                            <ul role="listbox">
                                <li><a href="{{ route('profile.edit') }}">Perfil</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="contrast">Salir</button>
                                    </form>
                                </li>
                            </ul>
                        </details>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Ingresar</a></li>
                    <li><a href="{{ route('register') }}">Registrarse</a></li>
                @endauth
            </ul>
        </nav>
    </header>

    <main class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="container">
        <hr>
        <p style="text-align: center; color: var(--pico-muted-color);">
            © {{ date('Y') }} Mi Blog Laravel - Desarrollado con Laravel y PicoCSS
        </p>
    </footer>
</body>

</html>