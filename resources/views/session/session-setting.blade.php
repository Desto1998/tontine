@extends('layouts.app')
@section('title','Sessions')
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
                        <h1>GESTION DES SESSIONS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"><a href="#">Associations</a></li>
                            <li class="breadcrumb-item active"><a href="#">Sessions</a></li>
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
                    <h3 class="card-title">Liste des sessions</h3>
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#modal-default">
                        Ajouter
                    </button>
                </div>
                <div class="card-body">
                    <form action="#" id="save-form" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="row">
                            <div class="form-group col-md-8 mb-3">
                                <label for="name">Désignation<span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" required
                                       autocomplete="name">
                                <div id="name-error" class="text-danger error-display" role="alert"></div>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="type">Type<span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-control">
                                    <option>Tontine</option>
                                    <option>Caisse</option>
                                    {{--                                    <option>Non remboursable</option>--}}
                                </select>
                                <div id="type-error" class="text-danger error-display" role="alert"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="frequency">Fréquence <span class="text-danger">*</span></label>
                                    <select name="frequency" id="frequency" class="form-control" required>
                                        <option>Une fois par mois</option>
                                        <option>Aprés chaque deux semaines</option>
                                        <option>Chaque semaine</option>
                                        <option>Chaque jour</option>
                                    </select>
                                    <div id="frequency-error" class="text-danger error-display" role="alert"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="meeting_day">Jour de séance <span class="text-danger">*</span></label>
                                    <select name="meeting_day" id="meeting_day" class="form-control">
                                        <option></option>
                                        <option>Dimanche</option>
                                        <option>Lundi</option>
                                        <option>Mardi</option>
                                        <option>Mercredi</option>
                                        <option>Jeudi</option>
                                        <option>Vendredi</option>
                                        <option>Samedi</option>
                                    </select>
                                    <div id="meeting_day-error" class="text-danger error-display" role="alert"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="start_date">Date de début<span class="text-danger">*</span></label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required
                                       autocomplete="">
                                <div id="start_date-error" class="text-danger error-display" role="alert"></div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="end_date">Date de fin<span class="text-danger">*</span></label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required
                                       autocomplete="">
                                <div id="end_date-error" class="text-danger error-display" role="alert"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="member_ids">Membres <span class="text-danger">*</span></label>
                                    <select name="member_ids[]" id="member_ids" class="select2" multiple="multiple" data-placeholder="Selectionner les membres qui vont participer">
                                        <option></option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                                        @endforeach
                                    </select>
                                    <div id="member_ids-error" class="text-danger error-display" role="alert"></div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="contribution_ids">Cotisations <span class="text-danger">*</span></label>
                                <select name="contribution_ids[]" id="contribution_ids" class="select2" multiple="multiple" data-placeholder="Selectionner des cotisations">
                                    <option></option>
                                    @foreach($contributions as $contribution)
                                        <option value="{{ $contribution->id }}">{{ $contribution->name }}</option>
                                    @endforeach
                                </select>
                                <div id="contribution_ids-error" class="text-danger error-display" role="alert"></div>
                            </div>
                        </div>

                        <div class="my-3">
                            <div class="loading">En cours...</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Enregistré avec succès</div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="save-btn">Enregistrer</button>
                        </div>
                    </form>
                </div>

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
        });

        // fonction qui charge les informations : les elements du tableau
        function deleteFun(id) {
            // alert(id)

            let table = $('#infosTable').DataTable();

            swal.fire({
                title: "Supprimer cette session?",
                icon: 'question',
                text: "Cette session serra supprimée, cette action est irreversible.",
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
                        url: "{{ route('sessions.delete') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                Toast.fire({
                                    icon: 'success',
                                    title: res.message
                                })
                                table.row($('#deletebtn' + id).parents('tr'))
                                    .remove()
                                    .draw();
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
