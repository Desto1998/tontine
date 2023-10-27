<div class="text-center d-flex">
    <a href="{{ route('admin.associations.show',$value->id) }}" title="Voir plus" class="btn btn-success ml-1 btn-xs"><i class="fa fa-eye"></i></a>
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
                <h4 class="modal-title">Editer l'association: {{ $value->id }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="save-form_{{ $value->id }}" method="post" onsubmit="saveEditedData({{ $value->id }})">
                    @csrf
                    <input type="hidden" name="id" value="{{ $value->id }}">
                    <div class="form-group mb-3">
                        <label for="name_{{ $value->id }}">Nom de l'association<span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ $value->name }}" id="name_{{ $value->id }}" class="form-control" required autocomplete="name">
                        <div id="name-error_{{ $value->id }}" class="text-danger error-display" role="alert"></div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="country_{{ $value->id }}">Pays<span class="text-danger">*</span></label>
                            <input type="text" name="country" value="{{ $value->country }}" id="country_{{ $value->id }}" class="form-control" required autocomplete="country">
                            <div id="country-error_{{ $value->id }}" class="text-danger error-display" role="alert"></div>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="town_{{ $value->id }}">Ville<span class="text-danger">*</span></label>
                            <input type="text" name="town" id="town_{{ $value->id }}" class="form-control" value="{{ $value->town }}" required autocomplete="town">
                            <div id="town-error_{{ $value->id }}" class="text-danger error-display" role="alert"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="phone_{{ $value->id }}">Téléphone <span class="text-danger">*</span></label>
                                <input type="tel" maxlength="14" minlength="9" name="phone" id="phone_{{ $value->id }}"
                                       class="form-control" required autocomplete="phone" value="{{ $value->phone }}">
                                <div id="phone-error_{{ $value->id }}" class="text-danger error-display" role="alert"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="email_{{ $value->id }}">Email <span class="text-danger"></span></label>
                                <input type="email" name="email" id="email_{{ $value->id }}" class="form-control"
                                       autocomplete="email" value="{{ $value->email }}">
                                <div id="email-error_{{ $value->id }}" class="text-danger error-display" role="alert"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="address_{{ $value->id }}">Adresse <span class="text-danger">*</span></label>
                        <input type="text" name="address" id="address_{{ $value->id }}" class="form-control" required
                               autocomplete="address" value="{{ $value->address }}">
                        <div id="address-error_{{ $value->id }}" class="text-danger error-display" role="alert"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Description <span class="text-danger"></span></label>
                        <textarea  name="description" id="description" class="form-control">{{ $value->description }}</textarea>
                        <div id="description-error" class="text-danger error-display" role="alert"></div>
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
