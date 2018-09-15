<?php
// config
$link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
?>

@if ($paginator->lastPage() > 1)

<p id="{{ $pagination_id }}_stats">Displaying <span id="{{ $pagination_id }}_stats_count">{{ $paginator->count() }}</span> rows
    <span id="{{ $pagination_id }}_stats_from">{{ $paginator->currentPage()*$paginator->perPage() - $paginator->count() + 1 }}</span>-<span id="{{ $pagination_id }}_stats_to">{{ $paginator->currentPage()*$paginator->perPage() }}</span> of total
    <span id="{{ $pagination_id }}_stats_total">{{ $paginator->total() }}</span> records (Page <span id="{{ $pagination_id }}_stats_cur_page">{{ $paginator->currentPage() }}</span> of <span id="{{ $pagination_id }}_stats_last_page">{{ $paginator->lastPage() }}</span>)</p>

    <ul class="pagination" id="{{ $pagination_id }}_pagination">
        <li class="page-item{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
            <a href="{{ $paginator->url(1) }}" class="page-link">First</a>
        </li>
        <li class="page-item{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
            <a href="{{ $paginator->previousPageUrl() }}" class="page-link">< Previous</a>
        </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <?php
            $half_total_links = floor($link_limit / 2);
            $from = $paginator->currentPage() - $half_total_links;
            $to = $paginator->currentPage() + $half_total_links;
            if ($paginator->currentPage() < $half_total_links) {
                $to += $half_total_links - $paginator->currentPage();
            }
            if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
            }
            ?>
            @if ($from < $i && $i < $to)
                <li class="page-item{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a href="{{ $paginator->url($i) }}" class="page-link">{{ $i }}</a>
                </li>
            @endif
        @endfor
        <li class="page-item{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
            <a href="{{ $paginator->nextPageUrl() }}" class="page-link">Next ></a>
        </li>
        <li class="page-item{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
            <a href="{{ $paginator->url($paginator->lastPage()) }}" class="page-link">Last</a>
        </li>
    </ul>
@endif
