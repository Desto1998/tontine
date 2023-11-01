<!-- Add new sanction modal -->
<div class="modal fade" id="modal-sanction">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Appliquer un sanction</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="save-form-sanction" method="post">
                    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <div class="form-group">
                        <label for="sanction_id">Sanctions <span class="text-danger">*</span></label>
                        <select name="sanction_id" id="sanction_id" class="select2 form-control">
                            <option></option>
                            @foreach($sanctions as $s)
                                <option value="{{ $s->id }}">{{ $s->title }}</option>
                            @endforeach
                        </select>
                        <div id="sanction_id-error" class="text-danger error-display" role="alert"></div>
                    </div>
                    <div class="form-group">
                        <label for="session_member_id">Membres <span class="text-danger">*</span></label>
                        <select name="session_member_id" id="session_member_id" required class="select2 form-control">
                            <option></option>
                            @foreach($sessionMembers as $sm)
                                <option value="{{ $sm->member->id }}">{{ $sm->member->first_name }} {{ $sm->member->last_name }}</option>
                            @endforeach
                        </select>
                        <div id="session_member_id-error" class="text-danger error-display" role="alert"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="amount">Montant<span class="text-danger">*</span></label>
                        <input type="number" min="0" name="amount" id="amount"
                               class="form-control" required>
                        <div id="amount-error" class="text-danger error-display" role="alert"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="pay_status">Statut de la sanction<span class="text-danger">*</span></label>
                        <select name="pay_status" id="pay_status" class="form-control">
                            <option></option>
                            <option>Non payé</option>
                            <option>Payé</option>
                        </select>
                        <div id="pay_status-error" class="text-danger error-display" role="alert"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="comment">Commentaire <span class="text-danger"></span></label>
                        <textarea name="comment" id="comment" class="form-control"></textarea>
                        <div id="comment-error" class="text-danger error-display" role="alert"></div>
                    </div>
                    <div class="my-3">
                        <div class="loading">En cours...</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Enregistré avec succès</div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="save-btn-sanction">Enregistrer</button>
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


<!-- Add new loan modal -->
<div class="modal fade" id="modal-loan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter un pret</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="save-form-loan" method="post">
                    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <div class="form-group mb-3">
                        <label for="reason">Raison<span class="text-danger">*</span></label>
                        <input type="text" name="reason" id="reason" class="form-control" required
                               autocomplete="reason">
                        <div id="reason-error" class="text-danger error-display" role="alert"></div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="interest">Interet<span class="text-danger">*</span></label>
                            <input type="number" min="0" name="interest" id="interest" class="form-control" required
                                   autocomplete="interest">
                            <div id="interest-error" class="text-danger error-display" role="alert"></div>
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
                   <div class="row">
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="loan_member_id">Membres <span class="text-danger">*</span></label>
                               <select name="member_id" id="loan_member_id" required class="select2 form-control">
                                   <option></option>
                                   @foreach($members as $sm)
                                       <option value="{{ $sm->id }}">{{ $sm->first_name }} {{ $sm->last_name }}</option>
                                   @endforeach
                               </select>
                               <div id="loan_member_id-error" class="text-danger error-display" role="alert"></div>
                           </div>

                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="contribution_id">Cotisation source <span class="text-danger">*</span></label>
                               <select name="contribution_id" id="contribution_id" class="select2 form-control">
                                   <option></option>
                                   @foreach($sessionContributions as $c)
                                       <option value="{{ $c->contribution->id }}">{{ $c->contribution->name }}</option>
                                   @endforeach
                               </select>
                               <div id="contribution_id-error" class="text-danger error-display" role="alert"></div>
                           </div>
                       </div>
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
                        <button type="submit" class="btn btn-primary" id="save-btn-loan">Enregistrer</button>
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

<!-- Add new fund modal -->
<div class="modal fade" id="modal-fund">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter un fond</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="save-form-fund" method="post">
                    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <div class="form-group mb-3">
                        <label for="amount">Montant <span class="text-danger">*</span></label>
                        <input type="number" min="0" name="amount"
                               class="form-control" required autocomplete="amount">
                        <div id="amount-error" class="text-danger error-display" role="alert"></div>
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
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control" required></textarea>
                        <div id="description-error" class="text-danger error-display" role="alert"></div>
                    </div>
                    <div class="my-3">
                        <div class="loading">En cours...</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Enregistré avec succès</div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="save-btn-fund">Enregistrer</button>
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

<!-- Add new winnner modal -->
<div class="modal fade" id="modal-winner">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter un gagnant de la séance</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="save-form-winner" method="post">
                    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                    <div class="form-group mb-3">
                        <label for="amount">Montant<span class="text-danger">*</span></label>
                        <input type="number" min="0" name="amount" id="amount"
                               class="form-control" required>
                        <div id="amount-error" class="text-danger error-display" role="alert"></div>
                    </div>
                    <div class="form-group">
                        <label for="session_member_id">Membres <span class="text-danger">*</span></label>
                        <select name="session_member_id" id="session_member_id" required class="select2 form-control">
                            <option></option>
                            @foreach($sessionMembers as $sm)
                                <option value="{{ $sm->id }}">{{ $sm->member->first_name }} {{ $sm->member->last_name }}</option>
                            @endforeach
                        </select>
                        <div id="session_member_id-error" class="text-danger error-display" role="alert"></div>
                    </div>
                    <div class="form-group">
                        <label for="session_contribution_id">Cotisation source <span class="text-danger">*</span></label>
                        <select name="session_contribution_id" id="session_contribution_id" class="select2 form-control">
                            <option></option>
                            @foreach($sessionContributions as $c)
                                <option value="{{ $c->id }}">{{ $c->contribution->name }}</option>
                            @endforeach
                        </select>
                        <div id="session_contribution_id-error" class="text-danger error-display" role="alert"></div>
                    </div>
                    <div class="my-3">
                        <div class="loading">En cours...</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Enregistré avec succès</div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="save-btn-winner">Enregistrer</button>
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
