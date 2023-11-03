@extends('layouts.guest')

    @section('content')
        <div class="register-box">
            <div class="register-logo">
                <a href="{{ url('/home') }}"><b>{{ config('app.name') }}</b></a>
            </div>

            <div class="card">
                <div class="card-body register-card-body">
                    <p class="login-box-msg">Créer une association</p>

                    <form method="post" action="{{ route('register') }}">
                        @include('layouts.partials._flash-message')
                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                   placeholder="Nom de l'association" required>
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-user"></span></div>
                            </div>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required
                                   autocomplete="first_name" placeholder="Nom d'un membre">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-user"></span></div>
                            </div>
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}"
                                   autocomplete="last_name" placeholder="Prenom du membre" required>
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-user"></span></div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                            </div>
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="tel" maxlength="14" minlength="9" name="phone" id="phone"
                                   class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required autocomplete="phone" placeholder="Téléphone">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-phone"></span></div>
                            </div>
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="country" id="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country') }}" required
                                   autocomplete="country" placeholder="Pays">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-location-arrow"></span></div>
                            </div>
                            @error('country')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="town" id="" class="form-control @error('town') is-invalid @enderror" value="{{ old('town') }}" required
                                   autocomplete="town" placeholder="Ville">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-store"></span></div>
                            </div>
                            @error('town')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" required
                                   autocomplete="address" placeholder="Adresse">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-map-marker"></span></div>
                            </div>
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <textarea name="description" placeholder="Description" id="description" class="form-control">{{ old('description') }}</textarea>
                            <div id="description-error" class="text-danger error-display" role="alert"></div>
                            <div class="input-group-append">
{{--                                <div class="input-group-text"><span class="fas fa-comment"></span></div>--}}
                            </div>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror" placeholder="Mot de passe">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-lock"></span></div>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password_confirmation" class="form-control"
                                   placeholder="Confirmer le mot de passe">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-lock"></span></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                    <label for="agreeTerms">
                                        J'accepte les <a href="#">termes</a>
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Valider</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <a href="{{ route('login') }}" class="text-center">J'ai déja un compte</a>
                </div>
                <!-- /.form-box -->
            </div><!-- /.card -->

            <!-- /.form-box -->
        </div>
        <!-- /.register-box -->
    @endsection

