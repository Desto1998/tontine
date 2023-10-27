@extends('layouts.app')
@section('title','Loans')
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
                        <h1>GESTION DES PRETS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"><a href="#">Associations</a></li>
                            <li class="breadcrumb-item active"><a href="#">Loans</a></li>
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
                    <h3 class="card-title">Liste des prèts</h3>
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#modal-default">
                        Ajouter
                    </button>
                </div>
                <div class="card-body">
                    <table id="infosTable" class="table table-bordered table-striped text-center">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="check_" name="contact_form_message_id"></th>
                            <th>#</th>
                            <th>Membre</th>
                            <th>Cotisation</th>
                            <th>Raison</th>
                            <th>Montant</th>
                            <th>Type</th>
                            <th>Total</th>
                            <th>Date retour</th>
                            <th>Statut</th>
                            <th>Créé le</th>
                            <th>Créé par</th>
                            <th data-priority="2">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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



    <!-- Add new modal -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter un prèt</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" id="save-form" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="name">Désignation<span class="text-danger">*</span></label>
                                <input type="text" name="name" id="reason" class="form-control" required
                                       autocomplete="name">
                                <div id="name-error" class="text-danger error-display" role="alert"></div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="type">Type<span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-control">
                                    <option>Remboursable</option>
                                    <option>Rembousser sans intérèt</option>
                                    <option>Non remboursable</option>
                                </select>
                                <div id="type-error" class="text-danger error-display" role="alert"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="amount">Montant <span class="text-danger">*</span></label>
                                    <input type="number" min="0" name="amount" id="amount"
                                           class="form-control" required autocomplete="amount">
                                    <div id="amount-error" class="text-danger error-display" role="alert"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="interest_type">Type d'intérèt <span class="text-danger">*</span></label>
                                    <select name="interest_type" id="interest_type" class="form-control">
                                        <option></option>
                                        <option>Pourcentage(%)</option>
                                        <option>Montant(FCFA)</option>
                                    </select>
                                    <div id="interest_type-error" class="text-danger error-display" role="alert"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="member_id">Membres <span class="text-danger">*</span></label>
                            <select name="member_id" id="member_id" class="form-control select2">
                                <option></option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                                @endforeach
                            </select>
                            <div id="member_id-error" class="text-danger error-display" role="alert"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="contribution_id">Cotisations <span class="text-danger">*</span></label>
                            <select name="contribution_id" id="contribution_id" class="form-control select2">
                                <option></option>
                                @foreach($contributions as $contribution)
                                    <option value="{{ $contribution->id }}">{{ $contribution->name }}</option>
                                @endforeach
                            </select>
                            <div id="contribution_id-error" class="text-danger error-display" role="alert"></div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="return_date">Date remboursement <span class="text-danger">*</span></label>
                                <input type="date" min="{{ date('Y-m-d') }}" name="return_date" id="return_date" class="form-control" required
                                       autocomplete="return_date">
                                <div id="return_date-error" class="text-danger error-display" role="alert"></div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="total_amount">Total à rembousser<span class="text-danger">*</span></label>
                                <input type="number" name="total_amount" id="total_amount" class="form-control" required
                                       autocomplete="" readonly value="0">
                                <div id="total_amount-error" class="text-danger error-display" role="alert"></div>
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
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- end new modal -->

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
        function load() {
            if ($.fn.dataTable.isDataTable('#infosTable')) {
                let table = $('#infosTable').DataTable();
                table.destroy();
                // $('#infosTable').DataTable()._fnClearTable()._fnInitialise();
            }
            $("#infosTable").DataTable({
                "iDisplayLength": 10, // Configure le nombre de resultats a afficher par page a 10
                // bRetrieve: false,
                // stateSave: false,
                "processing": true,
                "serverSide": true,
                "paging": true,
                // "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "dom": 'Bfrtip',
                "buttons": [
                    // "copy", "csv", "excel", "pdf", "print", "colvis", 'pageLength',
                    {
                        extend: 'copy',
                        text: 'Copier',
                        className: 'btn btn-dark',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        className: 'btn btn-dark',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        className: 'btn btn-dark',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        className: 'btn btn-dark',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Imprimer',
                        className: 'btn btn-dark',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend: 'pageLength',
                        className: 'btn btn-dark',
                    },
                    {
                        extend: 'colvis',
                        className: 'btn btn-dark',
                    },
                ],
                ajaxSetup: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                ajax: {
                    url: "{{ route('loan.load') }}",
                },
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'DT_RowIndex', name: 'id', orderable: true, searchable: true},
                    {data: 'member', name: 'members.first_name'},
                    {data: 'contribution', name: 'contributions.name'},
                    {data: 'reason', name: 'reason'},
                    {data: 'type', name: 'type',},
                    {data: 'amount', name: 'amount',},
                    {data: 'total_amount', name: 'total_amount',},
                    {data: 'return_date', name: 'return_date',},
                    {data: 'statute', name: 'loans.status'},
                    {data: 'created', name: 'loans.created_at'},
                    {data: 'user', name: 'users.first_name'},
                    {data: 'actionbtn', name: 'actionbtn', orderable: false, searchable: false},

                ],
                order: ['1', 'desc']
            });
            $('#infosTable_filter').addClass('col-md-4 float-right')
            $('#infosTable_info').addClass('col-md-6 float-left')
            $('#infosTable_paginate').addClass('col-md-6 float-right')

        }

        function deleteFun(id) {
            // alert(id)

            let table = $('#infosTable').DataTable();

            swal.fire({
                title: "Supprimer ce partenaire?",
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
                url: "{{ route('loan.store') }}",
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
                url: "{{ route('loan.update') }}",
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

        $('.modal button[data-dismiss="modal"]').click(function (e) {
            load();
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
