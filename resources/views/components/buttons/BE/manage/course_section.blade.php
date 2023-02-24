<div>
    <button type="button" class="btn btn-warning" onClick="edit({{ $id }})" data-toggle="tooltip"
        data-placement="top" title="Sunting Data">
        @include('components.icons.edit')
    </button>
    <button type="button" class="btn btn-danger" onClick="deleteData({{ $id }})" data-toggle="tooltip"
        data-placement="top" title="Hapus Data">
        @include('components.icons.delete')
    </button>
</div>
