@extends('app')

@section('title', trans('titles.moderation-messages'))

@section('content')
    <div class="inbox-body">
        <div class="row">
            <div class="col-md-6">
                <h1>{{ trans('others.moderation-reception') }}</h1>
                @include('indexes.messages-index', ['messages' => $received])
            </div>
            <div class="col-md-6">
                <h1>{{ trans('others.moderation-emission') }}</h1>
                @include('indexes.messages-index', ['messages' => $sent])
            </div>
        </div>
    </div>
@endsection
