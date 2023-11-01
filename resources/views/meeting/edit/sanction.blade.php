<div class="row col-sm-12">
    <div class="card col-md-12">
        <div class="card-header">
            <h3 class="card-title">Liste des sanctions</h3>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                    data-target="#modal-sanction">
                Ajouter
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Sanction</th>
                        <th>Membre</th>
                        <th>Statut</th>
                        <th>Montant</th>
                        <th>Commentaire</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($meetingSanctions as $key=>$ms)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $ms->title }}</td>
                            <td>{{ $ms->first_name }} {{ $ms->last_name }}</td>
                            <td>{{ $ms->pay_status }}</td>
                            <td>{{ $ms->amount }}</td>
                            <td>{{ $ms->comment }}</td>
                            <td>
                                <button class="btn btn-danger btn-xs ml-1 "
                                        title="Supprimer ce fond"
                                        onclick="deleteSanctionFun({{ $ms->id }})"><i
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

