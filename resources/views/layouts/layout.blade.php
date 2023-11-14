<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ config('app.name', 'COZUCOOP') }} </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
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
                <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark">
                    <a href="/"
                        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <svg class="bi pe-none me-2" width="40" height="32">
                            <use xlink:href="#bootstrap" />
                        </svg>
                        <span class="fs-4">Cozucoop</span>
                    </a>
                    <hr>
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
                                class="nav-link text-white @if (request()->routeIs('usuarios.index', 'usuarios.create', 'usuarios.edit'
                                )) active @endif">
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
                            <img src="https://github.com/mdo.png" alt="" width="32" height="32"
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

            </main>
            @include('layouts.color-select.select-theme')
        </section>

        <div class="lds-spinner2" id="loading" style="display: none">
            <div class="lds-spinner">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

        <div class="lds-roller" id="loader" style="display: none">
            <div class="lds-roller2">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
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
