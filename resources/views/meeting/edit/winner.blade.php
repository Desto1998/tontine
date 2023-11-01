<div class="row col-sm-12">
    <div class="card col-md-12">
        <div class="card-header">
            <h3 class="card-title">Liste des gagnants du jour</h3>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                    data-target="#modal-winner">
                Ajouter
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Cotisation</th>
                        <th>Membre</th>
                        <th>Montant</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($meetingWinners as $key=>$ms)
                        @php
                            $contribution_name= '';
                        @endphp
                        @foreach($sessionContributions as $sc)
                            @if ($sc->id == $ms->session_contribution_id)
                                @php
                                    $contribution_name = $sc->contribution->name;
                                @endphp
                            @endif
                        @endforeach
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $contribution_name }}</td>
                            <td>{{ $ms->first_name }} {{ $ms->last_name }}</td>
                            <td>{{ $ms->take_amount }}</td>
                            <td>
                                <button class="btn btn-danger btn-xs ml-1 "
                                        title="Supprimer ce gagnant"
                                        onclick="deleteWinnerFun({{ $ms->id }})"><i
                                        class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

