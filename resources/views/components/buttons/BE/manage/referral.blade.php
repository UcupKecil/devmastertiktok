<div>
    @if ($point > 0)
        <button type="button" class="btn btn-primary" onClick="transfer({{ $id }})" data-toggle="tooltip"
            data-placement="top" title="Transfer">
            @include('components.icons.exchange')
        </button>
    @else
        <p>-</p>
    @endif
</div>
