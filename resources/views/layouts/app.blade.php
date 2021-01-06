<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

  
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('lib/select2-bootstrap4/select2-bootstrap4.css') }}" rel="stylesheet" />

    <!-- Fontawesome -->
    <link href="{{ asset('lib/fontawesome/css/all.css') }}" rel="stylesheet">

    <!-- DatePicker -->
    <link href="{{ asset('lib/datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet">

    <!-- Summernote -->
    <link href="{{ asset('lib/summernote/summernote.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">     

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    @Auth

                    <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('Cadastro') }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('home') }}">
                                    <i class="fas fa-user-graduate"></i> &nbsp;
                                    {{ __('Tipo de Profissionais') }}
                                </a>
                               
                                <a class="dropdown-item" href="{{ route('home') }}">
                                    <i class="fas fa-chalkboard-teacher"></i> &nbsp;
                                    {{ __('Profissionais') }}
                                </a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('empresa') }}">
                                    <i class="fas fa-school"></i> &nbsp;
                                    {{ __('Empresa') }}
                                </a>
                            </div>
                        </li>

                        @endAuth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        

    
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('lib/jquery-mask/jquery.mask.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="{{ asset('lib/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('lib/datepicker/locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
    <script src="{{ asset('lib/summernote/summernote.min.js') }}"></script>
    <script src="{{ asset('lib/summernote/lang/summernote-pt-BR.min.js') }}"></script>
    
    @hasSection('javascript')
    @yield('javascript')
    @endif
</body>
</html>
