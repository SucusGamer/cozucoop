@extends('layouts.layout')
@section('title', 'Iniciar Sesión')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-center align-items-center" style="min-height: 94vh;">
            <div class="col-md-8">
                <div class="card border-info mb-3" style="border-radius: 15px">
                    <div class="card-header" style="font-size: 30px;text-align: center">{{ __('Inicio de Sesión') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Correo Electrónico') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        @if(isset($_COOKIE['email'])) value="{{ $_COOKIE['email'] }}" @endif
                                        required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            @if(isset($_COOKIE['password'])) value="{{ $_COOKIE['password'] }}" @endif
                                            required autocomplete="current-password">
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                            <i id="eyeIcon" class="fas fa-eye"></i>
                                        </button>
                                    </div>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Recuérdame') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary2">
                                        {{ __('Acceder') }}
                                    </button>

                                    <a class="btn btn-link" href="/password/reset" style="text-decoration: none;">
                                      ¿Olvidaste tu contraseña?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-auth.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        var passwordInput = document.getElementById('password');
        var eyeIcon = document.getElementById('eyeIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });
</script>

@endsection

