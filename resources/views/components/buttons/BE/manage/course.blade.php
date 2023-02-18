<div>
    <a href="{{ url('/manage/course/videos/' . $slug) }}" class="btn btn-primary" data-toggle="tooltip" data-placement="top"
        title="List Video">
        @include('components.icons.list')
    </a>
    <a href="{{ url('/manage/course/edit/' . $id) }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top"
        title="Sunting Data">
        @include('components.icons.edit')
    </a>
    <button type="button" class="btn btn-danger" onClick="deleteData({{ $id }})" data-toggle="tooltip"
        data-placement="top" title="Sunting Data">
        @include('components.icons.delete')
    </button>
</div>
