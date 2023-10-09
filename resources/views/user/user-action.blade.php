<div class="text-center">
    <a href="{{ route('admin.user.show',$value->id) }}" title="Voir plus" class="btn btn-success ml-1 btn-xs"><i class="fa fa-eye"></i></a>
    @if($value->is_active)
        <a href="{{ route('admin.user.block',$value->id) }}" title="Cliquer pour bloquer" class="btn btn-dark ml-1 btn-xs"><i class="fa fa-lock"></i></a>
    @else
        <a href="{{ route('admin.user.activate',$value->id) }}" title="Cliquer pour activer ce compte" class="btn btn-info ml-1 btn-xs"><i class="fa fa-check"></i></a>
    @endif
    <button class="btn btn-danger btn-xs ml-1 "
            title="Supprimer cet utilisateur" id="deletebtn{{ $value->id }}"
            onclick="deleteFun({{ $value->id }})"><i
            class="fa fa-trash"></i>
    </button>
</div>
