@extends('layouts.app')
@section('title','PROJECT||Create')
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
                        <h1>CREER UN PROJET</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"><a href="#">Project</a></li>
                            <li class="breadcrumb-item active"><a href="#">Create</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            @include('layouts.partials._flash-message')
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Créer un projet</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('project.store') }}" id="save-form" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="title">Titre du projet<span class="text-danger">*</span></label>
                            <input type="text" min="5" name="title" id="title" class="form-control" required>
                            <div id="name-error" class="text-danger error-display" role="alert"></div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5 mb-3">
                                <label for="type">Type Montant <span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-control" required>
                                    <option>Fixe</option>
                                    <option>Non Fixe</option>
                                </select>
                                <div id="type-error" class="text-danger error-display" role="alert"></div>
                            </div>
                            <div class="form-group col-md-7 mb-3">
                                <label for="amount">Budget<span class="text-danger">*</span></label>
                                <input type="number" min="0" name="amount" id="amount" class="form-control" required>
                                <div id="amount-error" class="text-danger error-display" role="alert"></div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="contribution_id">Cotisation associée <span class="text-danger">*</span></label>
                            <select name="contribution_id" id="contribution_id" class="form-control" required>
                                <option value="">Cotisation</option>
                                @foreach($contributions as $contribution)
                                    <option value="{{ $contribution->id }}">{{ $contribution->name }}</option>
                                @endforeach
                            </select>
                            <div id="type-error" class="text-danger error-display" role="alert"></div>
                        </div>
{{--                        <div class="form-group mb-3">--}}
{{--                            <label for="member_ids">Membres Participants<span class="text-danger">*</span></label>--}}
{{--                            <select name="member_ids[]" id="member_ids" class="select2" multiple="multiple" data-placeholder="Selectionner les membres qui vont participer">--}}
{{--                                <option value="">Membre</option>--}}
{{--                                @foreach($members as $member)--}}
{{--                                    <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            <div id="member_ids-error" class="text-danger error-display" role="alert"></div>--}}
{{--                        </div>--}}
                        <div class="form-group mb-3">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                            <div id="description-error" class="text-danger error-display" role="alert"></div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Sélectionnez Les Membres Du Projet</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">Membres</th>
                                        <th>Participe?
                                            <input type="checkbox" value="true" title="Tout sélectionner" name="select_all" id="select_all" checked>

                                        </th>
                                        <th>Montant à Contribuer</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($members as $key => $member)
                                        <tr>
                                            <td class="col-md-5">{{ $member->first_name }} {{ $member->last_name }}</td>
                                            <td>
                                                <input type="checkbox" class="members" value="{{ $member->id }}" name="members_id[{{ $member->id }}]">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" value="0" name="amounts[{{ $member->id }}]">
                                            </td>
                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>

                        <div class="my-3">
                            <div class="loading">En cours...</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Enregistré avec succès</div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="reset" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary" id="save-btn">Enregistrer</button>
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
            load()
            let contributions = getContributions();
            console.log(contributions);

            contributions.forEach(function(item) {
                $('#contribution_id').append('<option value="' + item.id + '">' + item.name +'</option>');
            });
        });


        // region send message
        $('#select_all').on('click', function (e) {
            if ($('#select_all').is(':checked')) {
                $('.members').prop('checked', true);
            } else {
                $('.members').prop('checked', false);
            }
        });
        endregion

        // Save Modal Data
        $("#save-form").submit(function (event) {
            event.preventDefault();
            $('#save-form .loading').fadeToggle();
            $('#save-form .sent-message').hide();
            $('#save-btn').attr("disabled", true);
            $('#save-form .error-message').hide();
            $('.error-display').text('');
            // let table = $('#infosTable').DataTable();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const data = $('#save-form').serialize();

            $.ajax({
                type: "POST",
                url: "{{ route('project.store') }}",
                data: data,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if ($.isEmptyObject(response.error)) {
                        $('#save-btn').attr("disabled", false);
                        $('#save-form .loading').toggle();
                        $('#save-form .sent-message').slideToggle();
                        $('#save-form')[0].reset();
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                    } else {
                        $('#save-btn').attr("disabled", false);
                        $('#save-form .loading').toggle();
                        let errBloc = '';
                        $.each(response.error, function (key, value) {
                            console.log(key);
                            errBloc += '<span>' + value + '</span><br>';
                            $('#' + key).addClass('is-invalid');
                            $('#' + key + '-error').text(value);
                            console.log('#' + key + '-error');
                        });
                        $('#save-form .error-message').show().html('').append(errBloc)
                        errBloc = '';
                        Toast.fire({
                            icon: 'error',
                            title: 'Vérifiez le formulaire et reéssayez'
                        })
                    }
                },
                error: function (response) {
                    console.log(response);
                    $('#save-btn').attr("disabled", false)
                    $('#save-form .loading').toggle();
                }
            });
            $('.error-display').text('');
        });

        function saveEditedData(id) {
            event.preventDefault();
            $('#save-form_' + id + ' .loading').fadeToggle();
            $('#save-form_' + id + ' .sent-message').hide();
            $('#save-btn_' + id).attr("disabled", true);
            $('#save-form_' + id + ' .error-message').hide();
            $('.error-display').text('');
            // let table = $('#infosTable').DataTable();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const data = $('#save-form_' + id).serialize();

            $.ajax({
                type: "POST",
                url: "{{ route('contribution.update') }}",
                data: data,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if ($.isEmptyObject(response.error)) {
                        $('#save-btn_' + id).attr("disabled", false);
                        $('#save-form_' + id + ' .loading').toggle();
                        $('#save-form_' + id + ' .sent-message').slideToggle();
                        // $('#save-form_' + id)[0].reset();
                        $('.edit-modal').modal('hide');

                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        load();
                    } else {
                        $('#save-btn_' + id).attr("disabled", false);
                        $('#save-form_' + id + ' .loading').toggle();
                        let errBloc = '';
                        $.each(response.error, function (key, value) {
                            console.log(key);
                            errBloc += '<span>' + value + '</span><br>';
                            $('#' + key + '_' + id).addClass('is-invalid');
                            $('#' + key + '-error_' + id).text(value);
                            console.log('#' + key + '-error_' + id);
                        });
                        $('#save-form_' + id + ' .error-message').show().html('').append(errBloc)
                        errBloc = '';
                        Toast.fire({
                            icon: 'error',
                            title: 'Vérifiez le formulaire et reéssayez'
                        })
                    }
                },
                error: function (response) {
                    console.log(response);
                    $('#save-btn_' + id).attr("disabled", false);
                    $('#save-form_' + id + ' .loading').toggle();
                }
            });
            $('.error-display').text('');
        }

    </script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js')}}"></script>
@endsection
