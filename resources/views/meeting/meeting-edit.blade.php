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

            <!-- Default box for details form-->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Information de la séance de réunion</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <a href="{{ route('meeting.print',['id'=>$meeting->id]) }}" class="btn btn-light float-right">
                        <i class="fa fa-file-pdf"></i> Imprimer
                    </a>
                    <form action="#" id="save-form" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="id" value="{{ $meeting->id }}">
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
                                   class="form-control"
                                      autocomplete="">{{ $meeting->comment }}</textarea>
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
            </div>
            <!-- /.card -->

            <ul class="nav nav-pills mb-4">
                <li class=" nav-item">
                    <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">
                        Cotisations</a>
                </li>

                <li class="nav-item">
                    <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">
                       Gérer Sanctions</a>
                </li>
                <li class="nav-item">
                    <a href="#navpills-3" class="nav-link" data-toggle="tab" aria-expanded="true">Gérer les
                        prets</a>
                </li>
                <li class="nav-item">
                    <a href="#navpills-4" class="nav-link" data-toggle="tab" aria-expanded="true">Gérer
                        Fonds</a>
                </li>
            </ul>
            @include('layouts.partials._flash-message')
            <div class="tab-content">
                <div id="navpills-1" class="tab-pane active">
                    @include('meeting.edit.contribution')
                </div>
                <div id="navpills-2" class="tab-pane">
                    @include('meeting.edit.sanction')
                </div>
                <div id="navpills-3" class="tab-pane">
                    @include('meeting.edit.loan')
                </div>
                <div id="navpills-4" class="tab-pane">
                    @include('meeting.edit.fund')
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@include('meeting.edit.modals')

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

        //region save data
        function saveContribution($id){
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
                url: "{{ route('meeting.update') }}",
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

                        window.location.reload();
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
        }

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
                url: "{{ route('meeting.update') }}",
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

                        window.location.reload();
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

        // Save loan Modal Data
        $("#save-form-loan").submit(function (event) {
            event.preventDefault();
            $('#save-form-loan .loading').fadeToggle();
            $('#save-form-loan .sent-message').hide();
            $('#save-btn-loan').attr("disabled", true);
            $('#save-form-loan .error-message').hide();
            $('.error-display').text('');
            // let table = $('#infosTable').DataTable();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const data = $('#save-form-loan').serialize();

            $.ajax({
                type: "POST",
                url: "{{ route('loan.store') }}",
                data: data,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if ($.isEmptyObject(response.error)) {
                        $('#save-btn-loan').attr("disabled", false);
                        $('#save-form-loan .loading').toggle();
                        $('#save-form-loan .sent-message').slideToggle();
                        $('#save-form-loan')[0].reset();
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        window.location.reload();
                    } else {
                        $('#save-btn-loan').attr("disabled", false);
                        $('#save-form-loan .loading').toggle();
                        let errBloc = '';
                        $.each(response.error, function (key, value) {
                            console.log(key);
                            errBloc += '<span>' + value + '</span><br>';
                            $('#' + key).addClass('is-invalid');
                            $('#' + key + '-error').text(value);
                            console.log('#' + key + '-error');
                        });
                        $('#save-form-loan .error-message').show().html('').append(errBloc)
                        errBloc = '';
                        Toast.fire({
                            icon: 'error',
                            title: 'Vérifiez le formulaire et reéssayez'
                        })
                    }
                },
                error: function (response) {
                    console.log(response);
                    $('#save-btn-loan').attr("disabled", false)
                    $('#save-form-loan .loading').toggle();
                }
            });
            $('.error-display').text('');
        });

        // Save fund Modal Data
        $("#save-form-fund").submit(function (event) {
            event.preventDefault();
            $('#save-form-fund .loading').fadeToggle();
            $('#save-form-fund .sent-message').hide();
            $('#save-btn-fund').attr("disabled", true);
            $('#save-form-fund .error-message').hide();
            $('.error-display').text('');
            // let table = $('#infosTable').DataTable();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const data = $('#save-form-fund').serialize();

            $.ajax({
                type: "POST",
                url: "{{ route('fund.store') }}",
                data: data,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if ($.isEmptyObject(response.error)) {
                        $('#save-btn-fund').attr("disabled", false);
                        $('#save-form-fund .loading').toggle();
                        $('#save-form-fund .sent-message').slideToggle();
                        $('#save-form-fund')[0].reset();
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        window.location.reload();
                    } else {
                        $('#save-btn-fund').attr("disabled", false);
                        $('#save-form-fund .loading').toggle();
                        let errBloc = '';
                        $.each(response.error, function (key, value) {
                            console.log(key);
                            errBloc += '<span>' + value + '</span><br>';
                            $('#' + key).addClass('is-invalid');
                            $('#' + key + '-error').text(value);
                            console.log('#' + key + '-error');
                        });
                        $('#save-form-fund .error-message').show().html('').append(errBloc)
                        errBloc = '';
                        Toast.fire({
                            icon: 'error',
                            title: 'Vérifiez le formulaire et reéssayez'
                        })
                    }
                },
                error: function (response) {
                    console.log(response);
                    $('#save-btn-fund').attr("disabled", false)
                    $('#save-form-fund .loading').toggle();
                }
            });
            $('.error-display').text('');
        });

        // Save sanction Modal Data
        $("#save-form-sanction").submit(function (event) {
            event.preventDefault();
            $('#save-form-sanction .loading').fadeToggle();
            $('#save-form-sanction .sent-message').hide();
            $('#save-btn-sanction').attr("disabled", true);
            $('#save-form-sanction .error-message').hide();
            $('.error-display').text('');
            // let table = $('#infosTable').DataTable();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const data = $('#save-form-sanction').serialize();

            $.ajax({
                type: "POST",
                url: "{{ route('meeting.member.sanction.store') }}",
                data: data,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if ($.isEmptyObject(response.error)) {
                        $('#save-btn-sanction').attr("disabled", false);
                        $('#save-form-sanction .loading').toggle();
                        $('#save-form-sanction .sent-message').slideToggle();
                        $('#save-form-sanction')[0].reset();
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        window.location.reload();
                    } else {
                        $('#save-btn-sanction').attr("disabled", false);
                        $('#save-btn-sanction .loading').toggle();
                        let errBloc = '';
                        $.each(response.error, function (key, value) {
                            console.log(key);
                            errBloc += '<span>' + value + '</span><br>';
                            $('#' + key).addClass('is-invalid');
                            $('#' + key + '-error').text(value);
                            console.log('#' + key + '-error');
                        });
                        $('#save-form-sanction .error-message').show().html('').append(errBloc)
                        errBloc = '';
                        Toast.fire({
                            icon: 'error',
                            title: 'Vérifiez le formulaire et reéssayez'
                        })
                    }
                },
                error: function (response) {
                    console.log(response);
                    $('#save-btn-sanction').attr("disabled", false);
                    $('#save-form-sanction').attr("disabled", false)
                    $('#save-form-sanction .loading').toggle();
                }
            });
            $('.error-display').text('');
        });
    //endregion

        //region delete methods
        function deleteSanctionFun(id) {
            // alert(id)

            swal.fire({
                title: "Supprimer ce sanction?",
                icon: 'question',
                text: "Cette sanction serra supprimée, cette action est irreversible.",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, supprimer!",
                cancelButtonText: "Non, annuler !",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('meeting.sanction.delete') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                Toast.fire({
                                    icon: 'success',
                                    title: res.message
                                })
                                window.location.reload();
                            } else {
                                sweetAlert("Désolé!", "Erreur lors de la suppression!", "error")
                            }

                        },
                        error: function (resp) {
                            sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                console.log(dismiss)
                return false;
            })
            // }
        }

        function deleteFundFun(id) {
            // alert(id)

            swal.fire({
                title: "Supprimer ce fond?",
                icon: 'question',
                text: "Ce fond serra supprimé, cette action est irreversible.",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, supprimer!",
                cancelButtonText: "Non, annuler !",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('fund.delete') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                Toast.fire({
                                    icon: 'success',
                                    title: res.message
                                })
                                window.location.reload();
                            } else {
                                sweetAlert("Désolé!", "Erreur lors de la suppression!", "error")
                            }

                        },
                        error: function (resp) {
                            sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                console.log(dismiss)
                return false;
            })
            // }
        }

        function deleteLoanFun(id) {
            // alert(id)

            swal.fire({
                title: "Supprimer ce prèt?",
                icon: 'question',
                text: "Ce prèt serra supprimé, cette action est irreversible.",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, supprimer!",
                cancelButtonText: "Non, annuler !",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('loan.delete') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                Toast.fire({
                                    icon: 'success',
                                    title: res.message
                                })
                                window.location.reload();
                            } else {
                                sweetAlert("Désolé!", "Erreur lors de la suppression!", "error")
                            }

                        },
                        error: function (resp) {
                            sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                console.log(dismiss)
                return false;
            })
            // }
        }
        //endregion
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
