@extends('app')

@section('title', 'Ecrire un message')

@section('content')
    <div class="inbox-body">

        @if(isset($message))
            @if(Route::currentRouteName() == 'students.contact')
                {{ Form::model($message, ['route' => ['students.contact.store', request()->route()->parameters['student']->id], 'method' => 'post']) }}
            @else
                {{ Form::model($message, ['route' => ['messages.update', $message->id], 'method' => 'patch']) }}
            @endif
        @else
            @if(Route::currentRouteName() == 'messages.answer')
                {{ Form::open(['route' => ['messages.answer.store', $oldMessage->id], 'method' => 'post']) }}
            @else
                {{ Form::open(['route' => 'messages.store', 'method' => 'post']) }}
            @endif
        @endif

        <div class="form-row">
            <div class="form-group col-md-12">
                <label>{{ trans('inputs.recipient') }}</label>

                @if(isset($message) && isset($message->recipient))
                    <div>
                        {{ $message->recipient->name }} {{ $message->recipient->surname }}
                    </div>
                 @elseif(isset($oldMessage) && isset($oldMessage->sender))
                    <div>
                        {{ $oldMessage->sender->name }} {{ $oldMessage->sender->surname }}
                    </div>
                @else
                    @auth("student")
                        {{ Form::select('recipient', (isset($correspondents) ? $correspondents : []), (isset(Request()->recipient) ? Request()->recipient : null), ['title' => trans('inputs.recipient'), 'class' => 'selectpicker form-control']) }}
                    @endauth

                    @auth("teacher")
                        {{ Form::select('contact', $optgroups, (isset(Request()->recipient) ? Request()->recipient : null), ['title' => trans('inputs.recipient'), 'class' => 'selectpicker form-control']) }}
                    @endauth

                    @auth("admin")
                        {{ Form::select('teachers[]', $teachers, (isset(Request()->recipient) ? Request()->recipient : null), [
                            'title' => trans('inputs.recipient'),
                            'class' => 'selectpicker form-control',
                            'multiple' => 'true',
                            'data-actions-box' => 'true'
                        ]) }}
                    @endauth
                @endif
            </div>
            <div class="form-group col-md-12">
                <label for="subject">{{ trans('inputs.subject') }}</label>
                {{ Form::text('subject', (isset($oldMessage) ? 'Re: ' . $oldMessage->subject : null), ['class' => 'form-control', 'placeholder' => trans('inputs.subject')]) }}
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label>{{ trans('inputs.message') }}</label>
                {{ Form::textarea('content', (!empty($oldMessage) ? $oldMessage->formattedAnswer : (!empty($message) ? $message->content : ''))) }}
            </div>
        </div>

        @isset($oldMessage)
            @if($oldMessage->is_correspondence_request == true)
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="acceptRequest" value="acceptRequest" class="custom-control-input" id="acceptRequest">
                            <label class="custom-control-label" for="acceptRequest">Je souhaite</label>
                        </div>
                    </div>
                </div>
            @endif
        @endisset

        <div class="form-row">
            <div class="form-group col-md-12">
                {{ Form::button('<i class="fas fa-paper-plane"></i>' . ' ' . trans('buttons.send'), ['type'=> 'submit', 'class' => 'btn btn-primary']) }}
            </div>
        </div>

        {{ Form::close() }}

            @isset($message)
            @if(Route::currentRouteName() == 'messages.edit')
                {{ Form::model($message, ['method' => 'delete', 'route' => ['messages.destroy', $message->id], 'class' =>'form-inline form-delete']) }}
                {{ Form::hidden('id', $message->id) }}
                {{ Form::button('<i class="fas fa-trash"></i> ' . trans('buttons.delete'), ['class' => 'btn btn-xs btn-danger delete', 'type' => 'submit', 'name' => 'delete_modal']) }}
                {{ Form::close() }}
            @endif
                @endisset
    </div>
@stop
