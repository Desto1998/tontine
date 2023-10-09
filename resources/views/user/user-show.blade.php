@extends('layouts.app')
@section('title','User-Edit')
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
                        <h1>Detail de l'utilisateur {{ $user->email }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="#">Utilisatuers</a></li>
                            <li class="breadcrumb-item active">Ajouter</li>
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
                    <h3 class="card-title">Entrez les informations</h3>
                </div>
                <div class="card-body">
                    @include('layouts.partials._flash-message')
                    <form method="post"  action="{{ route('admin.user.update') }}">

                        <input type="hidden" name="id" value="{{ $user->id }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="first_name">Nom <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" id="first_name"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           value="{{ $user->first_name }}" required autocomplete="first_name">
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="last_name">Prenom <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" id="last_name"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           value="{{ $user->last_name }}" required autocomplete="last_name">
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="text" name="email" id="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ $user->email }}" required autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone">Telephone<span class="text-danger">*</span></label>
                                    <input type="tel" maxlength="13" minlength="9" name="phone" id="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ $user->phone }}" required autocomplete="phone">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role_ids">Roles <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="role_ids[]" id="role_ids"
                                            style="width: 100%;">
                                        <option selected="selected" disabled="disabled">Seletionner un role</option>
                                        @foreach($roles as $rol)
                                            {{--                                            @isset($role) {{ $role != "" and $role->id == $rol->id ? 'selected' :'' }} @endisset--}}
                                            <option
                                                {{ $role == $rol->title ? 'selected' :'' }} value="{{ $rol->id }}">{{ $rol->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="permission_ids">Droit et permission <span class="text-dangert">*</span></label>
                                    <select class="select2" name="permission_ids[]" id="permission_ids" multiple="multiple"
                                            data-placeholder="Selectionner des permissions" style="width: 100%;">
                                        @foreach( $permissions as $permission )
                                            <option
                                                {{ in_array($permission->id, $PermissionIds) ? 'selected' : '' }} value="{{ $permission->id }}">{{ $permission->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="input-group my-4">
                            <label for="password">Modifier le mot de passe <span class="text-danger">* </span></label>
                            <input type="password" name="password" id="password" class="form-control"
                                   @error('password') is-invalid @enderror autocomplete="password">
                            <div class="input-group-append">
                                <button class="input-group-text bg-success btn" type="button" id="save-password">
                                    <span class="fas fa-edit"> Mettre à jour</span>
                                </button>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <div class="text-danger" id="password-error"></div>
                        </div>



                        <div class="col-12">
                            <a class="btn btn-light" href="{{ route('admin.user.all') }}">Retour</a>
                            <button type="submit" class="btn btn-primary float-right">Enregistrer</button>
                        </div>
                    </form>
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
        })


    </script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js')}}"></script>


@endsection
