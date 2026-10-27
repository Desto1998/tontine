<div class="text-center d-flex">
    <a href="{{ route('project.show',$value->id) }}" title="Voir plus" class="btn btn-success ml-1 btn-xs"><i
            class="fa fa-eye"></i></a>
    <a href="{{ route('project.edit', $value->id) }}" class="btn btn-warning btn-xs ml-1" title="Modifier">
        <i class="fa fa-edit"></i>
    </a>
    <button class="btn btn-danger btn-xs ml-1 "
            title="Supprimer cette association" id="deletebtn{{ $value->id }}"
            onclick="deleteFun({{ $value->id }})"><i
            class="fa fa-trash"></i>
    </button>
</div>
