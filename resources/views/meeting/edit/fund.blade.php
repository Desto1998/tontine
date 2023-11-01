<div class="row col-sm-12">
    <div class="card col-md-12">
        <div class="card-header">
            <h3 class="card-title">Liste des reçues lors de cette reunion</h3>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                    data-target="#modal-fund">
                Ajouter
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Montant</th>
                        <th>Membre</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($meetingFunds as $key=>$ms)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $ms->amount }}</td>
                            <td>{{ $ms->first_name }} {{ $ms->last_name }}</td>
                            <td>{{ $ms->description }}</td>
                            <td>
                                <button class="btn btn-danger btn-xs ml-1 "
                                        title="Supprimer ce fond"
                                        onclick="deleteFundFun({{ $ms->id }})"><i
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

