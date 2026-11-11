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
                        <h1>REGLAGE DES SESSIONS</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"><a href="#">Associations</a></li>
                            <li class="breadcrumb-item active"><a href="#">Sessions</a></li>
                            <li class="breadcrumb-item active"><a href="#">Settings</a></li>
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
                    <a href="{{ route('sessions.index') }}" class="btn btn-primary float-right" >
                        Retour à la liste
                    </a>
                </div>
                <div class="card-body">
                    <form action="#" id="save-form" method="post">
                        @csrf
                        <input type="hidden" name="session_id" value="{{ $sessionData['session']->id }}">
                        <table class="table-bordered w-100">
                            <tr class="bg-dark">
                                <th class="p-2">Membre</th>
                                <th class="p-2">Cotisation à Participer et montant pour la session</th>
                            </tr>
                            @foreach($sessionData['sessionMembers'] as $member)
                                <tr>
                                    <td class="text-center">{{ $member->member->first_name }} {{ $member->member->last_name }}</td>

                                    <td>
                                        @foreach($sessionData['sessionContributions'] as $contribution)
                                            @php
                                            $check = "";
                                            $amount = 0;
//                                            foreach ()
                                            @endphp
                                            <div class="member_contribution-block m-2">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label>
                                                            <input type="checkbox" name="session_contribution_id">
                                                            {{ $contribution->contribution->name }}
                                                        </label>
                                                    </div>
                                                    <div class="form-group col-md-4 mb-3">
                                                        <label for="amount">Montant à cotiser<span class="text-danger">*</span></label>
                                                        <input type="number" min="0" name="amount" id="amount" class="form-control" required>
                                                        <div id="amount-error" class="text-danger error-display" role="alert"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </td>

{{--                                    <td>--}}
{{--                                        <select name="contribution_ids[{{ $member->id }}][]" class="select2" multiple="multiple" data-placeholder="Selectionner des cotisations">--}}
{{--                                            <option></option>--}}
{{--                                            @foreach($sessionData['sessionContributions'] as $contribution)--}}
{{--                                                <option value="{{ $contribution->id }}" {{ in_array($contribution->id, $member->contributions->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $contribution->name }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </td>--}}
                                </tr>
                            @endforeach

                        </table>




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
