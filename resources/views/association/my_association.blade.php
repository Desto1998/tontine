@extends('layouts.app')
@section('title','My-Associations')
@section('css_before')
    <!-- DataTables -->
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
                        <h1>MON ASSOCIATION</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Associations</a></li>
                            <li class="breadcrumb-item active"><a href="#">Profile</a></li>
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
                    <h3 class="card-title">Informations de l'association</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <form action="{{ route('association.my.update.logo') }}" method="post"
                                  enctype="multipart/form-data">
                                <div class="row mt-2 mb-3">
                                </div>
                                <input type="hidden" name="id" value="{{ $association->id }}">
                                @csrf
                                <div class="text-center align-content-xxl-center">
                                    <div class="row mb-3 ml-2" title="Cliquer pour selectioner une image">
                                        <img id="logo-zone"
                                             style="width: 300px; height: 300px; min-height: 200px; min-width: 200px"
                                             src="{{ !empty($association->logo) ? asset('images/profil/' . $association->logo) : asset('images/profil/user_img.jpg') }}"
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
                        <div class="col-md-7">
                            <form action="{{ route('association.my.update') }}" id="save-form" method="post">
                                @csrf
                                @include('layouts.partials._flash-message')
                                <input type="hidden" name="id" value="{{ $association->id }}">
                                <div class="form-group mb-3">
                                    <label for="name">Nom de l'association<span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ $association->name }}" class="form-control" required autocomplete="name">
                                    <div id="name-error" class="text-danger error-display" role="alert"></div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="country">Pays<span class="text-danger">*</span></label>
                                        <input type="text" name="country" id="country" class="form-control" required value="{{ $association->country }}"
                                               autocomplete="country">
                                        <div id="country-error" class="text-danger error-display" role="alert"></div>
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="town">Ville<span class="text-danger">*</span></label>
                                        <input type="text" name="town" id="town" class="form-control" required
                                               value="{{ $association->town }}"  autocomplete="town">
                                        <div id="town-error" class="text-danger error-display" role="alert"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="phone">Téléphone <span class="text-danger">*</span></label>
                                            <input type="tel" maxlength="14" minlength="9" name="phone" id="phone"
                                                   class="form-control" value="{{ $association->phone }}" required autocomplete="phone">
                                            <div id="phone-error" class="text-danger error-display" role="alert"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Email <span class="text-danger"></span></label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                   value="{{ $association->email }}" autocomplete="email">
                                            <div id="email-error" class="text-danger error-display" role="alert"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address">Adresse <span class="text-danger">*</span></label>
                                    <input type="text" name="address" id="address" class="form-control" required
                                           value="{{ $association->address }}" autocomplete="">
                                    <div id="address-error" class="text-danger error-display" role="alert"></div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description">Description <span class="text-danger"></span></label>
                                    <textarea name="description" id="description" class="form-control">{{ $association->description }}</textarea>
                                    <div id="description-error" class="text-danger error-display" role="alert"></div>
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="save-btn">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>

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
    </script>

    <script src="{{ asset('AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js')}}"></script>
    @include('layouts.partials._toastr-message')
@endsection
