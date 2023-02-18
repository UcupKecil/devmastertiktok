<div class="btn-group btn-group-toggle" data-toggle="buttons">
    <button type="button" class="btn btn-warning" onClick="edit({{ $id }})" data-toggle="tooltip"
        data-placement="top" title="Sunting Data">
        @include('components.icons.edit')
    </button>
    @if ($canDelete == 0)
        <button type="button" class="btn btn-danger" onClick="deleteData({{ $id }})" data-toggle="tooltip"
            data-placement="top" title="Hapus Data">
            @include('components.icons.delete')
        </button>
    @endif
</div>
