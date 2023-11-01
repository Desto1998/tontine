<div class="text-center d-flex">
{{--    <a href="{{ route('meeting.show',$value->id) }}" title="Voir plus" class="btn btn-success ml-1 btn-xs"><i class="fa fa-eye"></i></a>--}}
    <a href="{{ route('meeting.edit',$value->id) }}" title="Modifier la reunion" class="btn btn-warning ml-1 btn-xs"><i class="fa fa-edit"></i></a>
    <a href="{{ route('meeting.print',$value->id) }}" target="_blank" title="Imprimer le rapport de la reunion" class="btn btn-light ml-1 btn-xs"><i class="fa fa-file-pdf"></i></a>

    <button class="btn btn-danger btn-xs ml-1 "
            title="Supprimer cette association" id="deletebtn{{ $value->id }}"
            onclick="deleteFun({{ $value->id }})"><i
            class="fa fa-trash"></i>
    </button>
</div>

