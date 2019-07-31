@extends('app')

@if(isset($keyword))
@section('title', trans('titles.modify-keyword'))
@else
@section('title', trans('titles.add-keyword'))
@endif

@section('content')
    <div class="inbox-body">
        <div class="row">
            <div class="col-md-6">

                @if(isset($keyword))
                    {{ Form::model($keyword, ['route' => ['keywords.update', $keyword->id], 'method' => 'patch']) }}
                @else
                    {{ Form::open(['route' => 'keywords.store', 'method' => 'post']) }}
                @endif

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="text">{{ trans('inputs.text') }}</label>
                        {{ Form::text('text', null, ['class' => 'form-control', 'placeholder' => trans('inputs.text')]) }}
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="text_normalized">{{ trans('inputs.text-normalized') }}</label>
                        {{ Form::text('text_normalized', null, ['class' => 'form-control', 'placeholder' => trans('inputs.text-normalized')]) }}
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        {{ Form::button('<i class="fas fa-save"></i>' . ' ' . trans('buttons.save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
