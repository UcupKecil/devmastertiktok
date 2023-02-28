<div>
    <button onClick="view({{ $id }})" class="btn btn-primary" data-toggle="tooltip" data-placement="top"
        title="Keterangan">
        @include('components.icons.view')
    </button>
    <a href="{{ url('/manage/course/edit-video/' . $id) }}" class="btn btn-warning" data-toggle="tooltip"
        data-placement="top" title="Sunting Data">
        @include('components.icons.edit')
    </a>
    <button type="button" class="btn btn-danger" onClick="deleteData({{ $id }})" data-toggle="tooltip"
        data-placement="top" title="Hapus Data">
        @include('components.icons.delete')
    </button>
</div>
