<div>
    @if ($point > 0)
        <button type="button" class="btn btn-primary" onClick="transfer({{ $id }})" data-toggle="tooltip"
            data-placement="top" title="Transfer">
            @include('components.icons.exchange')
        </button>
    @else
    <a href="{{ url('/manage/referral/detail/' . $id) }}" class="btn btn-secondary" data-toggle="tooltip"
        data-placement="top" title="List Section">
        @include('components.icons.list')
    </a>
   <p>--</p>
    @endif
</div>
