<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ config('app.name', 'COZUCOOP') }} </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/color.css') }}">

    <link rel="stylesheet" href="{{ asset('css/Botonesnuevos.css') }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/style.default.css') }}" rel="stylesheet">

    @yield('extra-css')
    <!-- Theme CSS -->
    <script src="{{ asset('js/color-modes.js') }}"></script>

    {{-- Sweetalert --}}
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>


    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <!-- Fontawesome icons -->
    <script src="{{ asset('js/fontawesome/js/all.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/reuleaux.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/infinity.js"></script>
    <link rel="icon" href="{{ asset('images/logo.png') }}">

</head>

<body>
    @if (!auth()->user())
        <div class="login-container">
            <main class="py-4 ">
                @yield('content')
            </main>
        </div>
    @else
        @include('layouts.sidebar.sidebar')
        
        <section>
            <main class="d-flex flex-nowrap">
                <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="height: 100vh">
                    <a href="/"
                        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <svg class="bi pe-none me-2" width="40" height="32">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-c-circle" viewBox="0 0 16 16">
                              <path d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.146 4.992c-1.212 0-1.927.92-1.927 2.502v1.06c0 1.571.703 2.462 1.927 2.462.979 0 1.641-.586 1.729-1.418h1.295v.093c-.1 1.448-1.354 2.467-3.03 2.467-2.091 0-3.269-1.336-3.269-3.603V7.482c0-2.261 1.201-3.638 3.27-3.638 1.681 0 2.935 1.054 3.029 2.572v.088H9.875c-.088-.879-.768-1.512-1.729-1.512Z"/>
                            </svg>
                        </svg>
                        <span class="fs-4">Cozucoop</span>
                    </a>
                    <hr>
                    <div>
                    </div>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li>
                            <a href="{{ route('dashboard.index') }}"
                                class="nav-link text-white @if (request()->routeIs('dashboard.index')) active @endif">
                                <svg class="bi pe-none me-2" width="16" height="16">
                                    <use xlink:href="#speedometer2" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('usuarios.index') }}"
                                class="nav-link text-white @if (request()->routeIs('usuarios.index', 'usuarios.create', 'usuarios.edit')) active @endif">
                                <svg class="bi pe-none me-2" width="16" height="16">
                                    <use xlink:href="#people-circle" />
                                </svg>
                                Usuarios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('socios.index') }}"
                                class="nav-link text-white
                                @if (request()->routeIs('socios.index', 'socios.create', 'socios.edit')) active @endif"
                                aria-current="page">
                                <svg class="bi pe-none me-2" width="16" height="16">
                                    <use xlink:href="#partners" />
                                </svg>
                                Socios
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('conductores.index') }}"
                            class="nav-link text-white @if (request()->routeIs('conductores.index', 'conductores.create', 'conductores.edit')) active @endif"">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#drivers" />
                            </svg>
                            Conductores
                        </a>
                        </li>
                        <li>
                            <a href="{{ route('mototaxis.index') }}"
                                class="nav-link text-white @if (request()->routeIs('mototaxis.index', 'mototaxis.create', 'mototaxis.edit')) active @endif"">
                                <svg class="bi pe-none me-2" width="16" height="16">
                                    <use xlink:href="#flow" />
                                </svg>
                                Mototaxis
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('reportes.index') }}"
                            class="nav-link text-white @if (request()->routeIs('reportes.index', 'reportes.show')) active @endif">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#file" />
                            </svg>
                                Reportes
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown">
                        <a href="#"
                        class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('images/logo.png') }}" alt="" width="32" height="32"
                                class="rounded-circle me-2">
                                <strong>{{ auth()->user()->displayName }}</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item"href="{{ route('perfil.index') }}">Perfil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">Salir</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                    
                    
                </div>


                
                <div class="b-example-divider b-example-vr"></div>
                
                @yield('content') {{-- renderizamos la vista seleccionada por el usuario --}}
                @include('layouts.color-select.select-theme')
                
            </main>
        </section>

        <div class="lds-spinner2" id="loading" style="display: none">
            <l-infinity
              size="100"
              stroke="4"
              stroke-length="0.15"
              bg-opacity="0.1"
              speed="1.3"
              color="white" 
            ></l-infinity>
        </div>


        <div class="lds-roller" id="loader" style="display: none">
            <l-infinity
              size="100"
              stroke="4"
              stroke-length="0.15"
              bg-opacity="0.1"
              speed="1.3"
              color="white" 
            ></l-infinity>
        </div>

        <script src="{{ asset('js/sidebar.js') }}"></script>
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> --}}
        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
        <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>

        @stack('script')
    @endif
</body>

</html>
