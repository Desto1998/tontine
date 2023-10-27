<div class="text-center d-flex">
    <a href="{{ route('loan.show',$value->id) }}" title="Voir plus" class="btn btn-success ml-1 btn-xs"><i
            class="fa fa-eye"></i></a>
    <button type="button" class="btn btn-warning btn-xs ml-1" title="Voir plus" data-toggle="modal"
            data-target="#modal-default_{{ $value->id }}">
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
                <h4 class="modal-title">Editer le pret: {{ $value->id }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="save-form_{{ $value->id }}" method="post"
                      onsubmit="saveEditedData({{ $value->id }})">
                    @csrf
                    <input type="hidden" name="id" value="{{ $value->id }}">
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="reason">Raison<span class="text-danger">*</span></label>
                            <input type="text" name="reason" value="{{ $value->reason }}" id="reason" class="form-control" required
                                   autocomplete="reason">
                            <div id="reason-error" class="text-danger error-display" role="alert"></div>
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
                                       class="form-control" value="{{ $value->amount }}" required autocomplete="amount">
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="interest">Intérèt<span class="text-danger">*</span></label>
                                <input type="number" name="interest" value="{{ $value->interest }}" id="interest" class="form-control" required
                                       autocomplete="">
                                <div id="interest-error" class="text-danger error-display" role="alert"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="member_id">Membres <span class="text-danger">*</span></label>
                                <select name="member_id" id="member_id" class="form-control">
                                    <option></option>
                                    @foreach($members as $member)
                                        <option {{ $member->id == $value->member_id ? 'selected' : '' }} value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                                    @endforeach
                                </select>
                                <div id="member_id-error" class="text-danger error-display" role="alert"></div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="contribution_id">Cotisations <span class="text-danger">*</span></label>
                            <select name="contribution_id" id="contribution_id" class="form-control">
                                <option></option>
                                @foreach($contributions as $contribution)
                                    <option {{ $contribution->id == $value->contribution_id ? 'selected' : '' }} value="{{ $contribution->id }}">{{ $contribution->name }}</option>
                                @endforeach
                            </select>
                            <div id="contribution_id-error" class="text-danger error-display" role="alert"></div>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="return_date">Date remboursement <span class="text-danger">*</span></label>
                            <input type="text" name="return_date" value="{{ $value->return_date }}" id="return_date" class="form-control" required
                                   autocomplete="return_date">
                            <div id="return_date-error" class="text-danger error-display" role="alert"></div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="total_amount">Total à rembousser<span class="text-danger">*</span></label>
                        <input type="number" name="total_amount" id="total_amount" class="form-control" required
                               autocomplete="" readonly value="{{ $value->total_amount }}">
                        <div id="total_amount-error" class="text-danger error-display" role="alert"></div>
                    </div>
                    <div class="my-3">
                        <div class="loading">En cours...</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Enregistré avec succès</div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="save-btn_{{ $value->id }}">Enregistrer
                        </button>
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
