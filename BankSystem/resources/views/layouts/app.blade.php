<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CyberBank</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app">
    <nav class="navbar navbar-light bg-white shadow-sm">
        <div class="container">
            <a href="{{ url('/accounts') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="100" height="100">
            </a>

            <div class="text-center font-medium text-xl">
                <span class="text-gray-600 animate-text">SECURE.</span>
                <span class="text-gray-600 animate-text">CONVENIENT.</span>
                <span class="text-gray-600 animate-text">ACCESSIBLE.</span>
            </div>

            <div class="text-center">

                @guest
                    @if (Route::has('login'))
                        <a href="/login">
                            <button
                                class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4">
                                Login
                            </button>
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <a href="/register">
                            <button
                                class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4">
                                Register
                            </button>
                        </a>
                    @endif

                    <a href="/crypto">
                        <button
                            class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4">
                            Crypto
                        </button>
                    </a>
                @else

                    <a href="/accounts">
                        <button
                            class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4 ">
                            Accounts
                        </button>
                    </a>

                    <a href="/balance-transfer">
                        <button
                            class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4 ">
                            Transfer
                        </button>
                    </a>

                    <a href="/crypto-wallet">
                        <button
                            class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4 ">
                            Crypto Wallet
                        </button>
                    </a>

                    <a href="/crypto">
                        <button
                            class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4">
                            Cryptocurrency
                        </button>
                    </a>

                    <a href="/code-cards">
                        <button
                            class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4">
                            Code Cards
                        </button>
                    </a>

                    <button
                        class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    >
                        Logout
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endguest
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

            </div>
        </div>
    </nav>
    <main>
        @yield('content')
    </main>
</div>
</body>
</html>
