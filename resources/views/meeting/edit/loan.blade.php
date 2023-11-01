<div class="row col-sm-12">
    <div class="card col-md-12">
        <div class="card-header">
            <h3 class="card-title">Liste des prèts effectués lors de cette reunion</h3>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                    data-target="#modal-loan">
                Ajouter
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Raison</th>
                        <th>Montant</th>
                        <th>Membre</th>
                        <th>Cotisation</th>
                        <th>Date retour</th>
                        <th>Type</th>
                        <th>Interet</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($meetingLoans as $key=>$ms)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $ms->reason }}</td>
                            <td>{{ $ms->amount }}</td>
                            <td>{{ $ms->first_name }} {{ $ms->last_name }}</td>
                            <td>{{ $ms->name }}</td>
                            <td>{{ $ms->return_date }}</td>
                            <td>{{ $ms->type }}</td>
                            <td>{{ $ms->interest }}</td>
                            <td>
                                <button class="btn btn-danger btn-xs ml-1 "
                                        title="Supprimer ce prèt"
                                        onclick="deleteLoanFun({{ $ms->id }})"><i
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

