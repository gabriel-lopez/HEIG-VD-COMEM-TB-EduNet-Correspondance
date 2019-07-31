@extends('app')

@section('title', trans('titles.search-standard'))

@section('content')
    <div class="inbox-body">
        <div class="row">
            <div class="col-md-6">

                {{ Form::open(['route' => 'search', 'method' => 'post']) }}

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="name">{{ trans('inputs.first-name') }}</label>
                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('inputs.first-name')]) }}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Les élèves d'un canton</label>
                        {{ Form::select('cantons[]', $cantons, null, ['title' => trans('inputs.choose-cantons'), 'class' => 'form-control selectpicker', 'multiple' => 'multiple']) }}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Degré de la classe</label>
                        {{ Form::select('levels[]', $levels, null, ['title' => trans('inputs.choose-levels'), 'class' => 'form-control selectpicker', 'multiple' => 'multiple']) }}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Élève(s)</label>
                        <br/>

                        <div class="form-group col-md-12">
                            {{ Form::radio('sex[]', '', true) }}
                            <label for="sex">Garçons & Filles</label>
                        </div>
                        <div class="form-group col-md-12">
                            {{ Form::radio('sex[]', 'male', false) }}
                            <label for="sex">Garçons uniquement</label>
                        </div>
                        <div class="form-group col-md-12">
                            {{ Form::radio('sex[]', 'female', false) }}
                            <label for="sex">Filles uniquement</label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Un mot-clé</label>
                        {{ Form::select('keywords[]', $keywords, null, ['title' => trans('inputs.choose-keywords'), 'class' => 'form-control selectpicker', 'multiple' => 'multiple']) }}
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="searching">Elèves recherchant un correspondant</label>
                        {{ Form::checkbox('searching', true, true) }}
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
