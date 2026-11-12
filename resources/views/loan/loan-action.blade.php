<div class="text-center d-flex">
    <a href="{{ route('loan.show',$value->id) }}" title="Voir plus" class="btn btn-success ml-1 btn-xs"><i
            class="fa fa-eye"></i></a>
    @if($value->status->code < 10 )
    <a href="{{ route('loan.edit', $value) }}" class="btn btn-warning btn-xs ml-1"
       title="Modifier plus">
        <i class="fa fa-edit"></i>
    </a>
    @endif
    <button class="btn btn-danger btn-xs ml-1 "
            title="Supprimer cette association" id="deletebtn{{ $value->id }}"
            onclick="deleteFun({{ $value->id }})"><i
            class="fa fa-trash"></i>
    </button>

</div>
<div class="text-center d-flex">
    @if($value->status->code < 10 && \App\Services\RoleService::canValidate())
        <form action="{{ route('loan.approve', $value) }}"
              method="POST">
            @csrf
            <button title="Valider la demande"
                    class="btn btn-success btn-xs mt-2">
                <i class="fa fa-check"></i>
            </button>
        </form>
    @endif

    @if($value->status->code < 50 && \App\Services\RoleService::canValidate())
        <button title="Rejeter la demande" onclick="rejectFun({{ $value->id }})"
                class="btn btn-danger btn-xs mt-2 ml-2">
            <i class="fa fa-times"></i>
        </button>
    @endif
</div>

