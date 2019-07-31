<div class="mail-option">
    @if(isset($pagination) && $pagination = true)
    <ul class="unstyled inbox-pagination">
        <li>
            <span>{{ ($messages->firstItem() == null ? 0 : $messages->firstItem()) }}-{{ ($messages->lastItem() == null ? 0 : $messages->lastItem()) }} {{ trans('others.of') }} {{ $messages->total() }}</span>
        </li>
        <li>
            <a href="{{ $messages->previousPageUrl() }}" class="btn btn-primary btn-lg fa fa-angle-left pagination-left mr-1 @if($messages->onFirstPage()) disabled @endif" role="button" aria-disabled="true"></a>
        </li>
        <li>
            <a href="{{ $messages->nextPageUrl() }}" class="btn btn-primary btn-lg fa fa-angle-right pagination-right @if(!$messages->hasMorePages()) disabled @endif" role="button" aria-disabled="true"></a>
        </li>
    </ul>
    @endif
</div>

<table class="table table-inbox table-hover">
    <tbody>
    @foreach ($messages as $message)
        <tr data-href="@if($message->status === 'draft') {{ route('messages.edit', $message->id ) }} @else {{ route('messages.show', $message->id ) }} @endif" class="{{ $message->status === 'new' ? 'unread' : '' }}">
            <td class="view-message  dont-show">{{ $message->sender->name }}</td>
            <td class="view-message ">{{ $message->subject }}</td>
            <!--<td class="view-message  inbox-small-cells"><i class="fa fa-paperclip"></i></td>-->
            <td class="view-message  text-right">{{ $message->updated_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
