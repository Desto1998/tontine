@extends('layouts.guest')

@section('content')

<div class="register-wrapper">

<!--
<div class="register-header">
    <img src="{{ asset('images/logo/logo-web.png') }}" alt="GSC" class="logo-web">

    <p>Connectez-vous pour accéder à votre espace de gestion.</p>
</div>
-->

<div class="register-card">

    <div class="register-card-header">
        <h2>Se connecter</h2>
        <p>Entrez vos identifiants pour accéder à votre compte.</p>
    </div>

    <div class="register-card-body">

        @include('layouts.partials._flash-message')

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            {{-- EMAIL --}}
            <div class="form-group">
                <label>
                    Email <span class="required">*</span>
                </label>

                <div class="input-group">
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="exemple@email.com"
                        autocomplete="email"
                        required
                    >

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                </div>

                @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>


            {{-- MOT DE PASSE --}}
            <div class="form-group">
                <label>
                    Mot de passe <span class="required">*</span>
                </label>

                <div class="input-group">
                    <input
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Votre mot de passe"
                        autocomplete="current-password"
                        required
                    >

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                </div>

                @error('password')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>


            {{-- OPTIONS --}}
            <div class="d-flex justify-content-between align-items-center mt-3">

                <div class="terms">
                    <div class="icheck-primary">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                        >

                        <label for="remember">
                            Se souvenir de moi
                        </label>
                    </div>
                </div>

                <a href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>

            </div>


            {{-- ACTION --}}
            <div class="row align-items-center mt-4">

                <div class="col-md-7">
                    <small class="text-muted">
                        <span class="required">*</span>
                        Champs obligatoires
                    </small>
                </div>

                <div class="col-md-5 text-md-right">
                    <button type="submit" class="btn btn-primary btn-register">
                        Se connecter
                    </button>
                </div>

            </div>

        </form>


        <div class="login-link">
            Vous n'avez pas encore de compte ?
            <a href="{{ route('register') }}">
                Créer l'association
            </a>
        </div>

    </div>
</div>

</div>

@endsection
