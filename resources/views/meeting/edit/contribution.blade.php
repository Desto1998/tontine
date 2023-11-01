<div class="row">
    {{--    <h3>SECTION COTISATION</h3>--}}
    @foreach($sessionContributions as $contribution)
        <div class="col-md-6">
            <!-- Contribution boxes -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cotisation: {{ $contribution->contribution->name }}</h3>
                    {{--                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"--}}
                    {{--                            data-target="#modal-default">--}}
                    {{--                        Ajouter--}}
                    {{--                    </button>--}}
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('meeting.member.session.store') }}" id="save-form-cont_{{ $contribution->id }}" method="post">
                        @csrf
                        <input type="hidden" name="contribution_id" value="{{ $contribution->contribution_id }}">
                        <input type="hidden" name="session_contribution_id" value="{{ $contribution->id }}">
                        <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
                        <input type="hidden" name="session_id" value="{{ $meeting->session_id }}">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Membres</th>
                                <th>Montant(<span class="text-danger">*</span>)</th>
{{--                                @if ($contribution->contribution->type=="Tontine")--}}
{{--                                    <th>Bénéficiare</th>--}}
{{--                                @endif--}}
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($sessionMembers as $key=>$sm)

                                @php
                                    $amount = $sm->amount;
                                    $took= 0;
                                @endphp
                                @foreach($meetingSessionMembers as $msm)
                                    @if ($msm->session_member_id==$sm->id && $msm->session_contribution_id==$contribution->id)
                                        <input type="hidden" name="id[{{ $sm->id }}]" value="{{ $msm->id }}">
                                        @php
                                            $amount = $msm->amount;
                                            $took = $msm->took;
                                        @endphp
                                    @endif
                                @endforeach
                                <tr>
                                    <td>{{ $key +1 }}</td>
                                    <td>
                                        <input type="hidden" name="session_member_id[]" value="{{ $sm->id }}">
                                        <label for="amount_{{ $contribution->id }}_{{ $sm->id }}">{{ $sm->member->first_name }} {{ $sm->member->last_name }}</label>
                                    </td>
                                    <td><input type="number" name="amount[{{ $sm->id }}]" min="0"
                                               id="amount_{{ $contribution->id }}_{{ $sm->id }}"
                                               value="{{ $amount }}" class="form-control">
                                    </td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>

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
        </div>

    @endforeach

</div>

