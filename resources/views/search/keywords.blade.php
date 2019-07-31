@extends('app')

@section('title', trans('titles.search-keywords'))

@section('content')
    <div class="inbox-body">
        <div class="row">
            <div class="col-md-6">
                {{ Form::open(['route' => 'search', 'method' => 'post']) }}
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Un mot-clé</label>
                        {{ Form::select('keywords[]', $keywords, null, ['title' => trans('inputs.choose-keywords'), 'class' => 'form-control selectpicker', 'multiple' => 'multiple']) }}
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        {{ Form::submit(trans('buttons.search'), ['class' => 'btn btn-primary']) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
