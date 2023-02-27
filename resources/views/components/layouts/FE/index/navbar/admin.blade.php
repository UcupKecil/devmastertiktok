<li>
    <a href="javascript:void(0)" class="{{ $segment1 == 'master-data' ? ' active' : '' }}">
        Master Data
    </a>
    <ul class="sub-menu">
        <li>
            <a href="{{ url('/master-data/bank') }}"
                class="{{ $segment1 == 'master-data' && $segment2 == 'bank' ? ' active' : '' }}">
                Bank
            </a>
        </li>
    </ul>
</li>
<li>
    <a href="javascript:void(0)" class="{{ $segment1 == 'manage' ? ' active' : '' }}">
        kelola
    </a>
    <ul class="sub-menu">
        <li>
            <a href="{{ url('/manage/course') }}"
                class="{{ $segment1 == 'manage' && $segment2 == 'course' ? ' active' : '' }}">
                Course
            </a>
        </li>
        <li>
            <a href="{{ url('/manage/refferal') }}"
                class="{{ $segment1 == 'manage' && $segment2 == 'refferal' ? ' active' : '' }}">
                Refferal
            </a>
        </li>
    </ul>
</li>
