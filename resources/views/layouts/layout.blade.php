<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cozucoop</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Theme CSS -->
    <script src="{{ asset('js/color-modes.js') }}"></script>


    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

</head>
<body>
    @include('layouts.sidebar.sidebar')

    <section>
        <main class="d-flex flex-nowrap">
          <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
              <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
              <span class="fs-4">Cozucoop</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
              <li class="nav-item">
                <a href="#" class="nav-link active" aria-current="page">
                  <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                  Home
                </a>
              </li>
              <li>
                <a href="#" class="nav-link text-white">
                  <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg>
                  Dashboard
                </a>
              </li>
              <li>
                <a href="#" class="nav-link text-white">
                  <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"/></svg>
                  Orders
                </a>
              </li>
              <li>
                <a href="#" class="nav-link text-white">
                  <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#grid"/></svg>
                  Products
                </a>
              </li>
              <li>
                <a href="#" class="nav-link text-white">
                  <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"/></svg>
                  Clientes
                </a>
              </li>
            </ul>
            <hr>
            <div class="dropdown">
              <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>mdo</strong>
              </a>
              <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="#">Ajustes</a></li>
                <li><a class="dropdown-item" href="#">Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Salir</a></li>
              </ul>
            </div>
          </div>



          <div class="b-example-divider b-example-vr"></div>

            @yield('content') {{-- renderizamos la vista seleccionada por el usuario --}}

        </main>
        @include('layouts.color-select.select-theme')
    </section>


    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>
