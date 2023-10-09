@extends('layouts.app')
@section('title','Profile')
@section('css_before')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet"
          href="{{ asset('AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet"
          href="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet"
          href="{{ asset('AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@stop

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mon profil {{ $user->email }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="#">Profil</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Détail du compte:</h3>
                </div>
                <div class="card-body">
                    @include('layouts.partials._flash-message')

                    <ul class="nav nav-pills mb-4">
                        <li class=" nav-item">
                            <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">A
                                propos de moi</a>
                        </li>


                        <li class="nav-item">
                            <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">Photo de
                                profil</a>
                        </li>
                        <li class="nav-item">
                            <a href="#navpills-3" class="nav-link" data-toggle="tab" aria-expanded="true">Mettre à jour
                                mon mot de passe</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="navpills-1" class="tab-pane active">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="p-t-15">
                                        <label class="h4">Mes informations</label>
                                        <button type="button" style="float: right;" class="btn btn-light"
                                                id="edit-btn" title="Modifier mes informations">
                                            <i class="fa fa-edit"></i> Modifier
                                        </button>
                                    </div>

                                    <form method="POST" action="{{ route('user.profile.update') }}" id="registerForm">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <div class="row col-md-12">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="first_name" class="">{{ __('Nom') }}&nbsp;<span
                                                            class="text-danger">*</span></label>
                                                    <input id="first_name" type="text"
                                                           class="form-control edit-info @error('first_name') is-invalid @enderror"
                                                           name="first_name" disabled value="{{ $user->first_name }}" required
                                                           autocomplete="first_name" autofocus>

                                                    @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last_name" class="">{{ __('Prenom') }}</label>

                                                    <input id="last_name" type="text" disabled
                                                           class="form-control edit-info @error('last_name') is-invalid @enderror"
                                                           name="last_name" value="{{ $user->last_name }}" required
                                                           autocomplete="last_name" autofocus>

                                                    @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row col-12">
                                            <div class="form-group col-md-6">
                                                <label for="email" class="">{{ __('Email') }}
                                                    &nbsp;<span class="text-danger">*</span></label>
                                                <input id="email" type="email"
                                                       class="form-control edit-info @error('email') is-invalid @enderror"
                                                       name="email" disabled value="{{ $user->email }}" required
                                                       autocomplete="email">

                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="cf-phone">{{ __('Téléphone') }}
                                                    &nbsp;<span class="text-danger">*</span></label>

                                                <input id="cf-phone" name="phone" type="tel"
                                                       class="form-control edit-info @error('phone') is-invalid @enderror"
                                                       minlength="8" disabled maxlength="14" value="{{ $user->phone }}"
                                                       required>
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row col-12">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="role_ids">Roles <span class="text-danger">*</span></label>
                                                    <select class="form-control select2" disabled name="role_ids[]" id="role_ids"
                                                            style="width: 100%;">
                                                        @foreach($roles as $rol)
                                                            {{--                                            @isset($role) {{ $role != "" and $role->id == $rol->id ? 'selected' :'' }} @endisset--}}
                                                            <option
                                                                {{ $role == $rol->title ? 'selected' :'' }} value="{{ $rol->id }}">{{ $rol->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="permission_ids">Droit et permission <span class="text-dangert">*</span></label>
                                                <select class="select2" name="permission_ids[]" id="permission_ids" multiple="multiple"
                                                        data-placeholder="Selectionner des permissions" disabled style="width: 100%;">
                                                    {{--                                <option disabled selected>Liste des accès</option>--}}
                                                    @foreach( $permissions as $permission )
                                                        <option
                                                            {{ in_array($permission->id, $PermissionIds) ? 'selected' : '' }} value="{{ $permission->id }}">{{ $permission->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>



                                        <div class="form-group row mb-0 text-centers justify-content-center">
                                            <div class="col-md-6 ">
                                                <button type="submit" disabled
                                                        class="btn btn-primary btn-block edit-info">
                                                    {{ __('Enregistrer') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="navpills-2" class="tab-pane">
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <div class="col-md-5">
                                        <form action="{{ route('user.profile.update.image') }}" method="post"
                                              enctype="multipart/form-data">
                                            <div class="row mt-2 mb-3">
                                            </div>
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            @csrf
                                            <div class="text-center align-content-xxl-center">
                                                <div class="row mb-3 ml-2" title="Cliquer pour selectioner une image">
                                                    <img id="logo-zone"
                                                         style="width: 300px; height: 300px; min-height: 200px; min-width: 200px"
                                                         src="{{ !empty($user->profilePicturePath) ? asset('images/profil/' . $user->profilePicturePath) : asset('images/profil/user_img.jpg') }}"
                                                         alt="Ouopps! Auncune image disponible">
                                                </div>
                                                <div class="kv-avatar">
                                                    <div class="file-loading">
                                                        <input type="file" id="logo-upload" class="form-control"
                                                               name="logo" required>
                                                    </div>
                                                </div>
                                                <div class="kv-avatar-hint">
                                                    <small>Sélectionner un fichier< 1500 KB</small>
                                                </div>
                                            </div>
                                            <div class="form-group mt-2">
                                                <hr>
                                                <div class="text-right">
                                                    <button type="submit" name="saveImage"
                                                            class="btn btn-primary btn-block">Enregistrer</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="navpills-3" class="tab-pane">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="p-t-15">
                                        <label class="h4">Réinitialiser mon mot de passe</label>

                                    </div>
                                    <form method="POST" action="{{ route('user.profile.update.password') }}"
                                          id="registerForm">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">

                                        <div class="form-group">
                                            <label for="password" class="">{{ __('Ancien mot de passe') }}
                                                &nbsp;<span class="text-danger">*</span></label>
                                            <input id="oldpassword" type="password"
                                                   class="form-control reset-password @error('password') is-invalid @enderror"
                                                   name="oldpassword" required autocomplete="old-password">

                                            @error('oldpassword')
                                            <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            <label for="password"
                                                   class="">{{ __('Nouveau mot de passe') }}&nbsp;<span
                                                    class="text-danger">*</span></label>
                                            <input id="password" type="password"
                                                   class="form-control reset-password @error('password') is-invalid @enderror"
                                                   name="password" required autocomplete="new-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror

                                        </div>

                                        <div class="form-group">
                                            <label for="password-confirm"
                                                   class="">{{ __('Confirmer le mot de passe') }}
                                                &nbsp;<span class="text-danger">*</span></label>

                                            <input id="password-confirm" type="password"
                                                   class="form-control reset-password" onblur="checkConfirmPassword()"
                                                   name="password_confirmation" required autocomplete="new-password">
                                            <div id="invalid-passconf" hidden><span class="text-danger">Le mot de
                                                        passe confirmé est different !</span>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0 text-centers justify-content-center">
                                            <div class="col-md-6 ">
                                                <button type="submit"
                                                        class="btn btn-primary btn-block reset-password">
                                                    {{ __('Enregistrer') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">

                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@Endsection
@section('script')

    <script>
        $(document).ready(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });

        $('#save-password').on('click', function (e){
            let errbloc = $('#password-error');
            let passwordField = $('#password');
            let saveBtn = $('#save-password');
            errbloc.html('');
            let password = passwordField.val();
            if (password == ''){
                errbloc.html('<small> Veillez entrer un mot de passe SVP</small>');
                passwordField.addClass('is-invalid');
                return
            }
            if (password.length < 8){
                errbloc.html('Le mot de passe doit contenir au moins 8 caractères');
                passwordField.addClass('is-invalid');
                return;
            }
            const id = $('input[name="id"]').val();
            saveBtn.attr("disabled", true).html('En cours...');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('admin.user.update.password') }}",
                data:  {id: id, password: password},
                dataType: 'json',
                success: function (res) {
                    saveBtn.attr("disabled", false).html('<span class="fas fa-edit"> Mettre à jour</span>');
                    if (res.status==="success"){
                        errbloc.html('');
                        passwordField.removeClass('is-invalid');
                        Toast.fire({
                            icon: 'success',
                            title: res.message
                        })
                    }else {
                        sweetAlert("Désolé!", "Erreur lors de la mise à jour!", "error")
                    }

                },
                error: function (response) {
                    saveBtn.attr("disabled", false).html('<span class="fas fa-edit"> Mettre à jour</span>');
                    errbloc.html('');
                    passwordField.removeClass('is-invalid');
                    console.log(response);
                    sweetAlert("Désolé!", "Erreur lors de la mise à jour!", "error");
                }
            });
        });


    </script>
    <script>

        function checkForm() {
            var adress = $('#website').val();
            if (!/^(http(s)?\/\/:)?(www\.)?[a-zA-Z\-]{3,}(\.(com|net|org))?$/.test(adress)) {
                $('#invalid-website').removeAttr('hidden');
                $('#registerForm').preventDefault();
            }
            // else {
            //     $('#invalid-website').addAttr('hidden');
            // }
            var password = $('#password').val();
            var confirmpass = $('#password-confirm').val();
            if (password !== confirmpass) {
                $('#invalid-passconf').removeAttr('hidden');
                $('#registerForm').preventDefault();
            }
        }

        function checkConfirmPassword() {
            var password = $('#password').val();
            var confirmpass = $('#password-confirm').val();
            if (password != confirmpass) {
                $('#invalid-passconf').removeAttr('hidden');
                $('#invalid-passconf').show();

            } else {
                // $('#invalid-passconf').attr('hidden');
                $('#invalid-passconf').hide();
            }
        }
        $('#edit-btn').click(function (e){
            $('.edit-info').removeAttr('disabled');
            // $('.btn-primary').removeAttr('disabled');
        });
        $("#logo-zone").click(function(e) {
            $("#logo-upload").click();
        });
        function fasterPreview( uploader ) {
            if ( uploader.files && uploader.files[0] ){
                $('#logo-zone').attr('src',
                    window.URL.createObjectURL(uploader.files[0]) );
            }
        }
        $("#logo-upload").change(function(){
            fasterPreview( this );
        });
        $('#edit-btn').click(function (e){
            $('.form-control').removeAttr('disabled');
            $('.btn-primary').removeAttr('disabled');
        });
    </script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js')}}"></script>


@endsection
