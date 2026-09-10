@extends('layouts.guest')

@section('content')

<div class="register-wrapper">

    <div class="register-header">
    <img src="{{ asset('images/logo/logo-tontine-reduit-sans-fond.png') }}" alt="GSC" class="logo-tontine-reduit-sans-fond">

    <p>Créez votre association et commencez à gérer votre tontine simplement.</p>
    </div>

    <div class="register-card">

        <div class="register-card-header">
            <h2>Créer une association</h2>
            <p>Renseignez les informations nécessaires pour commencer.</p>
        </div>

        <div class="register-card-body">

            @include('layouts.partials._flash-message')

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- ASSOCIATION --}}
                <div class="section-title">
                    <i class="fas fa-users"></i>
                    Informations de l'association
                </div>

                <div class="form-group">
                    <label>
                        Nom de l'association <span class="required">*</span>
                    </label>

                    <div class="input-group">
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Ex : Association Espoir"
                            required
                        >

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>

                    @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pays <span class="required">*</span></label>

                            <div class="input-group">
                                <input
                                    type="text"
                                    name="country"
                                    value="{{ old('country') }}"
                                    class="form-control @error('country') is-invalid @enderror"
                                    placeholder="Ex : Cameroun"
                                    required
                                >

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                </div>
                            </div>

                            @error('country')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ville <span class="required">*</span></label>

                            <div class="input-group">
                                <input
                                    type="text"
                                    name="town"
                                    value="{{ old('town') }}"
                                    class="form-control @error('town') is-invalid @enderror"
                                    placeholder="Ex : Douala"
                                    required
                                >

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-city"></i>
                                    </div>
                                </div>
                            </div>

                            @error('town')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label>Adresse <span class="required">*</span></label>

                    <div class="input-group">
                        <input
                            type="text"
                            name="address"
                            value="{{ old('address') }}"
                            class="form-control @error('address') is-invalid @enderror"
                            placeholder="Adresse de l'association"
                            required
                        >

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </div>
                    </div>

                    @error('address')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Description</label>

                    <textarea
                        name="description"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Décrivez brièvement votre association..."
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>


                <hr class="section-divider">


                {{-- ADMINISTRATEUR --}}
                <div class="section-title">
                    <i class="fas fa-user-shield"></i>
                    Administrateur de l'association
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Prénom <span class="required">*</span></label>

                            <div class="input-group">
                                <input
                                    type="text"
                                    name="first_name"
                                    value="{{ old('first_name') }}"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    placeholder="Ex : Jean"
                                    autocomplete="given-name"
                                    required
                                >

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                            </div>

                            @error('first_name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nom <span class="required">*</span></label>

                            <div class="input-group">
                                <input
                                    type="text"
                                    name="last_name"
                                    value="{{ old('last_name') }}"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    placeholder="Ex : Dupont"
                                    autocomplete="family-name"
                                    required
                                >

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                            </div>

                            @error('last_name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>


                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email <span class="required">*</span></label>

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
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Téléphone <span class="required">*</span></label>

                            <div class="input-group">
                                <input
                                    type="tel"
                                    maxlength="14"
                                    minlength="9"
                                    name="phone"
                                    id="phone"
                                    value="{{ old('phone') }}"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="+237 6XX XXX XXX"
                                    autocomplete="tel"
                                    required
                                >

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                </div>
                            </div>

                            @error('phone')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>


                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mot de passe <span class="required">*</span></label>

                            <div class="input-group">
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Votre mot de passe"
                                    autocomplete="new-password"
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
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Confirmer le mot de passe <span class="required">*</span></label>

                            <div class="input-group">
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Confirmez votre mot de passe"
                                    autocomplete="new-password"
                                    required
                                >

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                {{-- CONDITIONS --}}
                <div class="terms">
                    <div class="icheck-primary">
                        <input
                            type="checkbox"
                            id="agreeTerms"
                            name="terms"
                            value="agree"
                            {{ old('terms') ? 'checked' : '' }}
                        >

                        <label for="agreeTerms">
                            J'accepte les
                            <a href="#">conditions d'utilisation</a>.
                        </label>
                    </div>
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
                            Créer l'association
                        </button>
                    </div>

                </div>

            </form>

            <div class="login-link">
                Vous avez déjà un compte ?
                <a href="{{ route('login') }}">
                    Se connecter
                </a>
            </div>

        </div>
    </div>

</div>

@endsection