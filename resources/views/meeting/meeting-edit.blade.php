@extends('layouts.app')
@section('title','Meeting-edit')
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
                        <h1>EDITER UNE REUNION</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Associations</a></li>
                            <li class="breadcrumb-item"><a href="#">Meetings</a></li>
                            <li class="breadcrumb-item active"><a href="#">Edit</a></li>
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
                    <h3 class="card-title">Information de la séance de réunion</h3>
                    {{--                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"--}}
                    {{--                            data-target="#modal-default">--}}
                    {{--                        Ajouter--}}
                    {{--                    </button>--}}
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <form action="#" id="save-form" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="form-group mb-3">
                            <label for="agenda">Ordre du jour<span class="text-danger">*</span></label>
                            <input type="text" name="agenda" id="agenda"
                                   class="form-control" required value="{{ $meeting->agenda }}"
                                   autocomplete="agenda">
                            <div id="agenda-error" class="text-danger error-display" role="alert"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="date">Date<span class="text-danger">*</span></label>
                            <input type="date" name="date" id="date"
                                   class="form-control" required value="{{ $meeting->date }}"
                                   autocomplete="">
                            <div id="date-error" class="text-danger error-display" role="alert"></div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="start_time">Heure de début<span class="text-danger">*</span></label>
                                <input type="time" name="start_time" id="start_time"
                                       class="form-control" required value="{{ $meeting->start_time }}"
                                       autocomplete="">
                                <div id="start_time-error" class="text-danger error-display" role="alert"></div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="end_time">Heure de fin<span class="text-danger">*</span></label>
                                <input type="time" name="end_time" id="end_time"
                                       class="form-control" required value="{{ $meeting->end_time }}"
                                       autocomplete="">
                                <div id="end_time-error" class="text-danger error-display" role="alert"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="coordinator">Coordonateur de la séance <span class="text-danger">*</span></label>
                                <select name="coordinator" id="coordinator" class="select2 form-control">
                                    <option></option>
                                    @foreach($members as $member)
                                        <option {{ $member->id == $meeting->coordinator ? 'selected' : '' }}
                                            value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                                    @endforeach
                                </select>
                                <div id="coordinator-error" class="text-danger error-display" role="alert"></div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="session_id">Sessions <span class="text-danger">*</span></label>
                                <select name="session_id" id="session_id" class="select2 form-control">
                                    <option></option>
                                    @foreach($sessions as $session)
                                        <option {{ $session->id == $meeting->session_id ? 'selected' : '' }} value="{{ $session->id }}">{{ $session->name }}</option>
                                    @endforeach
                                </select>
                                <div id="session_id-error" class="text-danger error-display" role="alert"></div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="comment">Commentaire<span class="text-danger">*</span></label>
                            <textarea name="comment" id="comment"
                                   class="form-control" required value="{{ $meeting->comment }}"
                                      autocomplete=""></textarea>
                            <div id="comment-error" class="text-danger error-display" role="alert"></div>
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

        });

        // region send message
        // $('#selectAll').on('click', function (e) {
        //     if ($('#selectAll').is(':checked')) {
        //         $('input[name="productId"]').prop('checked', true);
        //     } else {
        //         $('input[name="productId"]').prop('checked', false);
        //     }
        // });
        // endregion



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
                url: "{{ route('meeting.store') }}",
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

                        window.location.href = '/dashboard/meeting/edit/'+response.data.id;
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
    @include('layouts.partials._toastr-message')
@endsection
