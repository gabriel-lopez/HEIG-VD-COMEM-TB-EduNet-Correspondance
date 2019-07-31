<ul class="unstyled inbox-pagination">
    <li>
        <span>{{ ($pagination->firstItem() == null ? 0 : $pagination->firstItem()) }}-{{ ($pagination->lastItem() == null ? 0 : $pagination->lastItem()) }} {{ trans('others.of') }} {{ $pagination->total() }}</span>
    </li>
    <li>
        <a href="{{ $pagination->previousPageUrl() }}" class="btn btn-primary btn-lg fa fa-angle-left pagination-left mr-1 @if($pagination->onFirstPage()) disabled @endif" role="button"></a>
    </li>
    <li>
        <a href="{{ $pagination->nextPageUrl() }}" class="btn btn-primary btn-lg fa fa-angle-right pagination-right @if(!$pagination->hasMorePages()) disabled @endif" role="button"></a>
    </li>
</ul>
