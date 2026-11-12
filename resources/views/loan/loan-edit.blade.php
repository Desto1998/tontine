@extends('layouts.app')
@section('title','Refund-Create')
@section('css_before')
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
                        <h1>DEMANDE DE PRÊT</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Associations</a></li>
                            <li class="breadcrumb-item"><a href="#">Loand</a></li>
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
                <div class="card-header justify-content-between">
                    <h3 class="card-title">Editer un Prêt</h3>
                    <a href="{{ route('loan.index') }}" class="btn btn-primary float-right">Retour</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('loan.update', $loan) }}" id="save-form" method="post">
                        @csrf

                        <input type="hidden" name="id" value="{{ $loan->id }}">
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="reason">Raison<span class="text-danger">*</span></label>
                                <input type="text" name="reason" value="{{ $loan->reason }}" id="reason" class="form-control" required
                                       autocomplete="reason">
                                <div id="reason-error" class="text-danger error-display" role="alert"></div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="type">Type<span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-control">
                                    <option>Remboursable</option>
{{--                                    <option>Rembousser sans intérèt</option>--}}
{{--                                    <option>Non remboursable</option>--}}
                                </select>
                                <div id="type-error" class="text-danger error-display" role="alert"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="contribution_id">Cotisations <span class="text-danger">*</span></label>
                                <select name="contribution_id" id="contribution_id" class="form-control">
                                    <option></option>
                                    @foreach($contributions as $contribution)
                                        <option {{ $contribution->id == $loan->contribution_id ? 'selected' : '' }} value="{{ $contribution->id }}">{{ $contribution->name }}</option>
                                    @endforeach
                                </select>
                                <div id="contribution_id-error" class="text-danger error-display" role="alert"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="amount">Montant <span class="text-danger">*</span></label>
                                    <input type="number" min="0" name="amount" id="amount"
                                           class="form-control" value="{{ $loan->amount }}" required autocomplete="amount">
                                    <div id="amount-error" class="text-danger error-display" role="alert"></div>
                                </div>
                            </div>

                        </div>
                        @if(!\App\Models\UserRole::checkRole('Member'))
                            <div class="form-group mb-3">
                                <label for="member_id">Membres <span class="text-danger">*</span></label>
                                <select name="member_id" id="member_id" class="form-control select2">
                                    <option value="">Sélectionner un membre</option>
                                    @foreach($members as $member)
                                        <option {{ $member->id == $loan->member_id ? 'selected' : '' }} value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                                    @endforeach
                                </select>
                                <div id="member_id-error" class="text-danger error-display" role="alert"></div>
                            </div>
                        @else
                            <input type="hidden" name="member_id" value="{{ \Illuminate\Support\Facades\Auth::user()->member_id }}">
                        @endif

                        <div class="row">
                            <div class="form-group col-md-3 mb-3">
                                <label for="return_date">Date remboursement <span class="text-danger">*</span></label>
                                <input type="date" min="{{ date('Y-m-d') }}" name="return_date" id="return_date" class="form-control" required
                                       autocomplete="return_date" readonly value="{{ $loan->return_date }}">
                                <div id="return_date-error" class="text-danger error-display" role="alert"></div>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="interest">Intérêt(en %)<span class="text-danger">*</span></label>
                                <input type="number" name="interest" id="" class="form-control" required
                                       autocomplete="" readonly value="{{ $loan->interest }}">
                                <div id="interest-error" class="text-danger error-display" role="alert"></div>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="interest_amount">Montant Intérêt<span class="text-danger">*</span></label>
                                <input type="number" name="interest_amount" id="interest_amount" class="form-control" required
                                       autocomplete="" readonly value="{{ $loan->interest_amount }}">
                                <div id="interest_amount-error" class="text-danger error-display" role="alert"></div>
                            </div>
                            <div class="form-group col-md-3 mb-3">
                                <label for="total_amount">Total à rembousser<span class="text-danger">*</span></label>
                                <input type="number" name="total_amount" id="" class="form-control" required
                                       autocomplete="" readonly value="{{ $loan->total_amount }}">
                                <div id="total_amount-error" class="text-danger error-display" role="alert"></div>
                            </div>
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
        const loans = @json($contributions)
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
    <script src="{{ asset('AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js')}}"></script>
    @include('layouts.partials._toastr-message')
@endsection
