@extends('layouts.app')
@section('title','User-Add')
@section('css_before')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@stop

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Creer un utilisateur</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Users</a></li>
                            <li class="breadcrumb-item active">Add</li>
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
                    <form method="post" action="{{ route('admin.user.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="first_name">Nom <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required autocomplete="first_name" >
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
                                    <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required autocomplete="last_name" >
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
                                    <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" >
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
                                    <input type="tel" maxlength="13" minlength="9" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required autocomplete="phone" >
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
                                    <select class="form-control select2" name="role_ids[]" id="role_ids" style="width: 100%;">
                                        <option selected="selected" disabled="disabled">Seletionner un role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="permission_ids">Droit et permission <span class="text-dangert">*</span></label>
                                    <select class="select2" name="permission_ids[]" id="permission_ids" multiple="multiple" data-placeholder="Selectionner des permissions" style="width: 100%;">
                                        @foreach($permissions as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password">Mot de passe <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control" @error('password') is-invalid @enderror required autocomplete="password" minlength="8">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password-confirm">Confirmer le mot de passe <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" id="password-confirm" class="form-control" @error('password_confirmation') is-invalid @enderror required>
                                    <small class="text-danger" id="confirm-error"></small>
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
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


        // endregion
    </script>
    <script>
        var confirmText = 'Le mot de passe confirmé doit etre égal au mot de passe entré';
        let errorDisplay = $('#confirm-error');
        $('#register-form').submit(function (e){

            // $('#confirm-error').hide(200);
            if ($('#password-confirm').val() !== $('#password').val() ){
                errorDisplay.text(confirmText);
                e.preventDefault();
                // return false;
            }
            // return true;
        });
        $('#password-confirm').blur(function (e){
            $('#password-confirm').val() !== $('#password').val()? errorDisplay.text(confirmText) : errorDisplay.text('');
        });
        $('#password').blur(function (e){
            if ($('#password-confirm').val() !==''){
                $('#password-confirm').val() !== $('#password').val()? errorDisplay.text(confirmText) : errorDisplay.text('');
            }
        });

        // subscribe to news letter
        {{--$("#subscribe-form").submit(function (event) {--}}
        {{--    event.preventDefault();--}}
        {{--    $('#subscribe-section .loading').fadeToggle();--}}
        {{--    $('#subscribe-section .sent-message').hide();--}}
        {{--    $('#subscribe-btn').attr("disabled", true);--}}
        {{--    $('#subscribe-section .error-message').hide()--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}
        {{--    const data = $('#subscribe-form').serialize();--}}

        {{--    $.ajax({--}}
        {{--        type: "POST",--}}
        {{--        url: "{{ route('subscribe') }}",--}}
        {{--        data: data,--}}
        {{--        dataType: 'json',--}}
        {{--        success: function (response) {--}}
        {{--            console.log(response);--}}
        {{--            if ($.isEmptyObject(response.error)) {--}}
        {{--                $('#subscribe-btn').attr("disabled", false);--}}
        {{--                $('#subscribe-section .loading').toggle();--}}
        {{--                $('#subscribe-section .sent-message').slideToggle();--}}
        {{--                $('#subscribe-form')[0].reset();--}}
        {{--            } else {--}}
        {{--                $('#subscribe-btn').attr("disabled", false);--}}
        {{--                $('#subscribe-section .loading').toggle();--}}
        {{--                let errBloc = '';--}}
        {{--                $.each(response.error, function (key, value) {--}}
        {{--                    console.log(key);--}}
        {{--                    errBloc += '<span>' + value + '</span><br>';--}}
        {{--                    $('.subscribe-email').addClass('is-invalid');--}}
        {{--                    console.log('#' + key + 'ErrorMsg');--}}
        {{--                });--}}
        {{--                $('.subscribe-section .error-message').show().html('').append(errBloc)--}}
        {{--                errBloc = '';--}}
        {{--            }--}}
        {{--        },--}}
        {{--        error: function (response) {--}}
        {{--            console.log(response);--}}
        {{--            $('#subscribe-btn').attr("disabled", false)--}}
        {{--            $('#subscribe-section .loading').toggle();--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}
    </script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js')}}"></script>


@endsection
