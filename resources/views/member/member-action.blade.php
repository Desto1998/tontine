<div class="text-center d-flex">
    <a href="{{ route('members.show',$value->id) }}" title="Voir plus" class="btn btn-success ml-1 btn-xs"><i
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
                <h4 class="modal-title">Editer le membre: {{ $value->id }}</h4>
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
                            <label for="first_name_{{ $value->id }}">Nom d'un membre<span
                                    class="text-danger">*</span></label>
                            <input type="text" name="first_name" value="{{ $value->first_name }}"
                                   id="first_name_{{ $value->id }}" class="form-control" required
                                   autocomplete="first_name">
                            <div id="first_name-error_{{ $value->id }}" class="text-danger error-display"
                                 role="alert"></div>
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label for="last_name_{{ $value->id }}">Prenom du membre<span
                                    class="text-danger">*</span></label>
                            <input type="text" name="last_name" value="{{ $value->last_name }}"
                                   id="last_name_{{ $value->id }}" class="form-control" required
                                   autocomplete="last_name">
                            <div id="last_name-error_{{ $value->id }}" class="text-danger error-display"
                                 role="alert"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="phone_{{ $value->id }}">Téléphone <span class="text-danger">*</span></label>
                                <input type="tel" maxlength="14" minlength="9" value="{{ $value->phone }}" name="phone"
                                       id="phone_{{ $value->id }}"
                                       class="form-control" required autocomplete="phone">
                                <div id="phone-error_{{ $value->id }}" class="text-danger error-display"
                                     role="alert"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="fund_amount_{{ $value->id }}">Fond a verser <span
                                        class="text-danger"></span></label>
                                <input type="number" name="fund_amount" value="{{ $value->fund_amount }}"
                                       id="fund_amount_{{ $value->id }}" class="form-control"
                                       autocomplete="fund_amount" step="any">
                                <div id="fund_amount-error_{{ $value->id }}" class="text-danger error-display"
                                     role="alert"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="city_{{ $value->id }}">Ville<span class="text-danger">*</span></label>
                                <input type="text" name="city" id="city_{{ $value->id }}" value="{{ $value->city }}"
                                       class="form-control" required autocomplete="city">
                                <div id="city-error_{{ $value->id }}" class="text-danger error-display"
                                     role="alert"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="address_{{ $value->id }}">Adresse <span class="text-danger">*</span></label>
                                <input type="text" name="address" value="{{ $value->address }}"
                                       id="address_{{ $value->id }}"
                                       class="form-control" required
                                       autocomplete="address">
                                <div id="address-error_{{ $value->id }}" class="text-danger error-display"
                                     role="alert"></div>
                            </div>
                        </div>

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
