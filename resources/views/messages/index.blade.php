@extends('app')

@section('title', trans('titles.inbox'))

@section('content')
    <div class="inbox-body">
        @include('indexes.messages-index')
    </div>
@stop
