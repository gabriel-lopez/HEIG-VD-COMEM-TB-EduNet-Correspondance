@extends('app')

@section('title', $message->subject)

@section('content')
    <div class="inbox-body">
        @if($message->recipient->is(Auth::user()))
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    <div class="btn-group">
                        {{ Form::model($message, ['method' => 'get', 'route' => ['messages.answer', $message->id], 'class' =>'form-inline']) }}
                        {{ Form::button('<i class="fas fa-paper-plane"></i>' . ' ' . trans('buttons.answer'), ['class' => 'btn btn-xs btn-primary delete', 'type' => 'submit']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                {{ $message->sender->name }}
                <br/>
                {{ $message->subject }}
                <br/>
                {{ $message->created_at }}
                <br/>
                {!! $message->content !!}
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    @if(Auth::guard('teacher')->check() && ($message->status == 'moderation_sender' || $message->status == 'moderation_recipient'))
                        <div class="btn-group">
                            {{ Form::model($message, ['method' => 'post', 'route' => ['messages.release', $message->id], 'class' =>'form-inline form-delete']) }}
                            {{ Form::hidden('id', $message->id) }}
                            {{ Form::button('<i class="fas fa-paper-plane"></i>' . ' ' . trans('buttons.validate'), ['class' => 'btn btn-xs btn-primary delete', 'type' => 'submit', 'name' => 'delete_modal']) }}
                            {{ Form::close() }}
                        </div>
                        <div class="btn-group">
                            {{ Form::model($message, ['method' => 'post', 'route' => ['messages.repel', $message->id], 'class' =>'form-inline form-delete']) }}
                            {{ Form::hidden('id', $message->id) }}
                            {{ Form::button('<i class="fas fa-paper-plane"></i>' . ' ' . trans('buttons.not-accepted'), ['class' => 'btn btn-xs btn-primary delete', 'type' => 'submit', 'name' => 'delete_modal']) }}
                            {{ Form::close() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
