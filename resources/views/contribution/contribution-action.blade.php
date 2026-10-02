<div class="text-center d-flex">
    <a href="{{ route('contribution.show',$value->id) }}" title="Voir plus" class="btn btn-success ml-1 btn-xs"><i class="fa fa-eye"></i></a>
    <button type="button" class="btn btn-warning btn-xs ml-1" title="Voir plus" data-toggle="modal" data-target="#modal-default_{{ $value->id }}">
        <i class="fa fa-edit"></i>
    </button>
    <button class="btn btn-danger btn-xs ml-1 "
            title="Supprimer cette association" id="deletebtn{{ $value->id }}"
            onclick="deleteFun({{ $value->id }})"><i
            class="fa fa-trash"></i>
    </button>
</div>
<!-- Add new modal -->
<div class="modal fade text-left edit-modal" id="modal-default_{{ $value->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editer la cotisation: {{ $value->id }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="save-form_{{ $value->id }}" method="post" onsubmit="saveEditedData({{ $value->id }})">
                    @csrf
                    <input type="hidden" name="id" value="{{ $value->id }}">
                    <div class="form-group mb-3">
                        <label for="name_{{ $value->id }}">Nom de la cotisation<span class="text-danger">*</span></label>
                        <input type="text" min="5" value="{{ $value->name }}" name="name" id="name_{{ $value->id }}" class="form-control" required autocomplete="name">
                        <div id="name-error_{{ $value->id }}" class="text-danger error-display" role="alert"></div>
                    </div>
{{--                    @if($value->type == "Mutuelle")--}}
{{--                        <div class="form-group mb-3">--}}
{{--                            <label for="fund_deadline">Delais de dépot de fond<span class="text-danger">*</span></label>--}}
{{--                            <input type="date" value="{{ $value->fund_deadline }}" name="fund_deadline" id="fund_deadline" class="form-control">--}}
{{--                            <div id="fund_deadline-error" class="text-danger error-display" role="alert"></div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                    <div class="row">
                        <div class="form-group col-md-5 mb-3">
                            <label for="type_{{ $value->id }}">Type <span class="text-danger">*</span></label>
                            <select name="type" id="type_{{ $value->id }}" onchange="showType({{ $value->id }})" class="form-control" required>
                                <option {{ $value->type == "Tontine"? 'selected' : '' }}>Tontine</option>
                                <option {{ $value->type == "Caisse"? 'selected' : '' }}>Caisse</option>
                                <option {{ $value->type == "Mutuelle"? 'selected' : '' }}>Mutuelle</option>
                            </select>
                            <div id="type-error_{{ $value->id }}" class="text-danger error-display" role="alert"></div>
                        </div>
                        <div class="form-group col-md-7 mb-3">
                            <label for="amount">Montant<span class="text-danger">*</span></label>
                            <input type="number" min="0" name="amount" value="{{ $value->amount }}" id="amount" class="form-control" required>
                            <div id="amount-error" class="text-danger error-display" role="alert"></div>
                        </div>
                    </div>


                    <div class="form-group mb-3">
                        <label for="description_{{ $value->id }}">Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="description_{{ $value->id }}" class="form-control" required>{{ $value->description }}</textarea>
                        <div id="description-error_{{ $value->id }}" class="text-danger error-display" role="alert"></div>
                    </div>

                    <hr>
                    <div class="form-group mb-3">
                        <label for="loan_duration_{{ $value->id }}">Intérêt des prêts<span class="text-danger">*</span></label>
                        <input type="number" step="any" min="5" name="loan_duration" value="{{ $value->loan_duration }}" id="loan_duration_{{ $value->id }}" class="form-control" required>
                        <div id="loan_duration-error_{{ $value->id }}" class="text-danger error-display" role="alert"></div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-7 mb-3">
                            <label for="fund_deadline_{{ $value->id }}">Durée des prêts<span class="text-danger">*</span></label>
                            <input type="number" min="0" name="loan_deadline" value="{{ $value->fund_deadline }}" id="fund_deadline_{{ $value->id }}" class="form-control" required>
                            <div id="fund_deadline-error" class="text-danger error-display" role="alert"></div>
                        </div>

                        <div class="form-group col-md-5 mb-3">
                            <label for="loan_period_{{ $value->id }}">Période <span class="text-danger">*</span></label>
                            <select name="loan_period" id="loan_period_{{ $value->id }}" class="form-control" required>
                                <option {{ $value->period == "Semaine"? 'selected' : '' }}>Semaine</option>
                                <option {{ $value->period == "Mois"? 'selected' : '' }}>Mois</option>
                                <option {{ $value->period == "Année"? 'selected' : '' }}>Année</option>

                            </select>
                            <div id="loan_period-error_{{ $value->id }}" class="text-danger error-display" role="alert"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-md-7 mb-3">
                            <label for="fail_interest_{{ $value->id }}">Intérêt si échec<span class="text-danger">*</span></label>
                            <input type="number" min="0" step="any" value="{{ $value->fail_interest }}" name="fail_interest" id="fail_interest_{{ $value->id }}" class="form-control" required>
                            <div id="fail_interest-error_{{ $value->id }}" class="text-danger error-display" role="alert"></div>
                        </div>

                        <div class="form-group col-md-5 mb-3">
                            <label for="fail_interest_type_{{ $value->id }}">Type d'intérêt <span class="text-danger">*</span></label>
                            <select name="fail_interest_type" id="fail_interest_type_{{ $value->id }}" class="form-control" required>
                                <option {{ $value->period == "Pourcentage"? 'selected' : '' }}>Pourcentage</option>
                                <option {{ $value->period == "Montant(CFA)"? 'selected' : '' }}>Montant(CFA)</option>
                                {{--                                    <option>Année</option>--}}
                            </select>
                            <div id="fail_interest_type-error_{{ $value->id }}" class="text-danger error-display" role="alert"></div>
                        </div>
                    </div>

                    <div class="my-3">
                        <div class="loading">En cours... </div>
                        <div class="error-message"></div>
                        <div class="sent-message">Enregistré avec succès</div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="save-btn_{{ $value->id }}">Enregistrer</button>
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
