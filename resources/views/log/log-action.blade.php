<div class="text-center">
    <a href="{{ route('admin.logs.show', ['id' =>$value->id ]) }}" class="btn btn-success btn-xs"
       title="Visualiser les details"><i
            class="fa fa-eye"></i></a>
    <button class="btn btn-danger btn-xs ml-1 "
            title="Supprimer ce journal" id="deletebtn{{ $value->id }}"
            onclick="deleteFun({{ $value->id }})"><i
            class="fa fa-trash"></i></button>
</div>
