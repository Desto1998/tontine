@extends('layouts.app')
@section('title','Associations')
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
                        <h1>GESTION DES ASSOCIATIONS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"><a href="#">Associations</a></li>
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
                    <h3 class="card-title">Liste des associations</h3>
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
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th>Pays</th>
                            <th>Ville</th>
                            <th>Adresse</th>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter une association</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" id="save-form" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">Nom de l'association<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" required autocomplete="name">
                            <div id="name-error" class="text-danger error-display" role="alert"></div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="country">Pays<span class="text-danger">*</span></label>
                                <input type="text" name="country" id="country" class="form-control" required
                                       autocomplete="country">
                                <div id="country-error" class="text-danger error-display" role="alert"></div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="town">Ville<span class="text-danger">*</span></label>
                                <input type="text" name="town" id="town" class="form-control" required
                                       autocomplete="town">
                                <div id="town-error" class="text-danger error-display" role="alert"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="first_name">Nom d'un membre<span class="text-danger">*</span></label>
                                <input type="text" name="first_name" id="first_name" class="form-control" required
                                       autocomplete="first_name">
                                <div id="first_name-error" class="text-danger error-display" role="alert"></div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="last_name">Prenom du membre<span class="text-danger">*</span></label>
                                <input type="text" name="last_name" id="last_name" class="form-control" required
                                       autocomplete="last_name">
                                <div id="last_name-error" class="text-danger error-display" role="alert"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone">Téléphone <span class="text-danger">*</span></label>
                                    <input type="tel" maxlength="14" minlength="9" name="phone" id="phone"
                                           class="form-control" required autocomplete="phone">
                                    <div id="phone-error" class="text-danger error-display" role="alert"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email">Email <span class="text-danger"></span></label>
                                    <input type="email" name="email" id="email" class="form-control"
                                           autocomplete="email">
                                    <div id="email-error" class="text-danger error-display" role="alert"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="address">Adresse <span class="text-danger">*</span></label>
                                    <input type="text" name="address" id="address" class="form-control" required
                                           autocomplete="address">
                                    <div id="address-error" class="text-danger error-display" role="alert"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password">Mot de passe <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control" required
                                           autocomplete="password" minlength="8" maxlength="255">
                                    <div id="password-error" class="text-danger error-display" role="alert"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description <span class="text-danger"></span></label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                            <div id="description-error" class="text-danger error-display" role="alert"></div>
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
                    url: "{{ route('admin.associations.load') }}",
                },
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'DT_RowIndex', name: 'id', orderable: true, searchable: true},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'country', name: 'country'},
                    {data: 'town', name: 'town',},
                    {data: 'address', name: 'address'},
                    // {data: 'user', name: 'users.email',},
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
                text: "Cette association serra supprimée, cette action est irreversible.",
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
                        url: "{{ route('admin.associations.delete') }}",
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
                url: "{{ route('admin.associations.store') }}",
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
                url: "{{ route('admin.associations.update') }}",
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
