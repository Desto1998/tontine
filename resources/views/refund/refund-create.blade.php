@extends('layouts.app')
@section('title','Refund-Create')
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
                        <h1>DEMANDE DE REMBOUSEMENT</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Associations</a></li>
                            <li class="breadcrumb-item"><a href="#">Refund</a></li>
                            <li class="breadcrumb-item active"><a href="#">Create</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header justify-content-between">
                    <h3 class="card-title">Créer une demande de remboursement</h3>
                    <a href="{{ route('refunds.index') }}" class="btn btn-primary float-right">Retour</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('refunds.store') }}" id="save-form" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="mb-3">
                            <label>Prêt</label>
                            <select name="loan_id" id="loan_id" class="form-control" required onchange="getLoan()">
                                <option value="">-- Sélectionner --</option>

                                @foreach($loans as $loan)
                                    <option value="{{ $loan->id }}"
                                        {{ old('loan_id', $refund->loan_id ?? '') == $loan->id ? 'selected' : '' }}>
                                        #{{ $loan->id }} {{ $loan->reason }} de ( {{ $loan->member->first_name }} {{ $loan->member->last_name }} du {{ $loan->created_at }})
                                    </option>
                                @endforeach
                            </select>
                            @error('loan_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" readonly
                                   value="{{ old('date', isset($refund) ? $refund->date->format('Y-m-d') : date('Y-m-d')) }}">
                        </div>

                        <div class="mb-3">
                            <label>Montant à remboursé</label>
                            <input type="number" step="any" name="amount" min="0" id="amount" class="form-control"
                                   value="{{ old('amount', $refund->amount ?? 0) }}" onchange="calculateRemain()">
                        </div>

                        <div class="mb-3">
                            <label>Intérêts</label>
                            <input type="number" step="any" name="interest" id="interest" readonly class="form-control"
                                   value="{{ old('interest', $refund->interest ?? 0) }}">
                        </div>

                        <div class="mb-3">
                            <label>Reste à payer</label>
                            <input type="number" step="any" name="remain" id="remain" class="form-control"
                                   value="{{ old('remain', $refund->remain ?? 0) }}"  readonly>
                        </div>

                        <div class="mb-3">
                            <label>Commentaire</label>
                            <textarea name="comment" class="form-control"
                                      rows="4">{{ old('comment', $refund->comment ?? '') }}</textarea>
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
        const loans = @json($loans)
        // region send message
        // $('#selectAll').on('click', function (e) {
        //     if ($('#selectAll').is(':checked')) {
        //         $('input[name="productId"]').prop('checked', true);
        //     } else {
        //         $('input[name="productId"]').prop('checked', false);
        //     }
        // });
        // endregion

        function getLoan() {
            let loan_id  = $('#loan_id').val()
            let loan = loans.find(item => item.id == loan_id);
            $('#montant').prop('max', loan.total_amount);
            $('#interest').val(loan.interest_amount);
            $('#amount').val(loan.total_amount);
        }
        function calculateRemain(){
            let loan_id  = $('#loan_id').val()
            let loan = loans.find(item => item.id == loan_id);
            let amount = $('#amount').val();
            $('#remain').val(loan.amount - amount);

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
