<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Talk To God - Connect with divine wisdom through AI-powered conversations">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Talk To God') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/fav.png') }}">
    
    <!-- Styles -->
    <link rel="stylesheet preload" href="{{ asset('assets/css/plugins.css') }}" as="style">
    <link rel="stylesheet preload" href="{{ asset('assets/css/style.css') }}" as="style">
    
    @livewireStyles
</head>
<body class="shop-main-h">
    <!-- Header Area Start -->
    <div class="rts-header-one-area-one">
        <div class="header-mid-one-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="header-mid-wrapper-between">
                            <div class="nav-sm-left">
                                <ul class="nav-h_top">
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    @auth
                                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    @endauth
                                </ul>
                            </div>
                            <div class="nav-sm-right">
                                <ul class="nav-h_top">
                                    @auth
                                        <li><a href="{{ route('profile.edit') }}">My Account</a></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                                @csrf
                                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    Log Out
                                                </a>
                                            </form>
                                        </li>
                                    @else
                                        <li><a href="{{ route('login') }}">Log In</a></li>
                                        <li><a href="{{ route('register') }}">Register</a></li>
                                    @endauth
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="search-header-area-main">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="logo-search-category-wrapper">
                            <a href="{{ route('home') }}" class="logo-area">
                                <h2 class="logo">Talk To God</h2>
                            </a>
                            @auth
                            <div class="category-search-wrapper">
                                <form action="#" class="search-header">
                                    <input type="text" placeholder="Ask your spiritual question..." required>
                                    <button type="submit" class="rts-btn btn-primary radious-sm with-icon">
                                        <div class="btn-text">Ask</div>
                                        <div class="arrow-icon">
                                            <i class="fa-light fa-paper-plane"></i>
                                        </div>
                                    </button>
                                </form>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Area End -->

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Section Begin -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text">
                            <p>Copyright &copy; {{ date('Y') }} Talk To God. All rights reserved.</p>
                        </div>
                        <div class="footer__copyright__links">
                            <a href="{{ route('privacy') }}">Privacy Policy</a>
                            <a href="{{ route('terms') }}">Terms of Service</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Scripts -->
    <script src="{{ asset('assets/js/plugins/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @livewireScripts
</body>
</html> 