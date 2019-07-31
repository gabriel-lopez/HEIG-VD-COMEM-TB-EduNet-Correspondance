@extends('app')

@if(isset($student))
    @section('title', trans('titles.modify-student'))
@else
    @section('title', trans('titles.add-student'))
@endif

@section('content')
    <div class="inbox-body">

        @if(isset($student))
            {{ Form::model($student, ['route' => ['students.update', $student->id], 'method' => 'patch']) }}
        @else
            {{ Form::open(['route' => 'students.store', 'method' => 'post']) }}
        @endif

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="scheduledEducationalActivity_id">{{ trans('inputs.class') }}</label>
                {{ Form::select('scheduled_educational_activity_id', $scheduledEducationalActivities, (isset($scheduledEducationalActivity_id) ? $scheduledEducationalActivity_id : null), ['title' => trans('inputs.choose-class'), 'class' => 'selectpicker form-control']) }}
            </div>
            <div class="form-group col-md-6">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <div>
                    <label for="login">
                        {{ trans('inputs.login') }}
                        <div class="form-inline">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="loginAuto" value="loginAuto" class="custom-control-input" id="visto" checked>
                                <label class="custom-control-label" name="visto" for="visto">Système ajutomatique</label>
                            </div>
                            <div class="custom-control custom-checkbox"></div>
                            @if(Route::current()->getName() === 'students.edit')
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="loginNoUpdate" value="loginNoUpdate" class="custom-control-input" id="loginNoUpdate" checked>
                                <label class="custom-control-label" for="loginNoUpdate">Ne pas modifier</label>
                            </div>
                            @endif
                        </div>
                    </label>
                </div>
                {{ Form::text('login', null, ['id' => 'login', 'class' => 'form-control', 'placeholder' => trans('inputs.login'), 'disabled' => 'disabled']) }}
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <div class="">
                    <label for="password">
                        {{ trans('inputs.password') }}
                        <div class="form-inline">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="passwordAuto" value="passwordAuto" class="custom-control-input" id="passwordCheckBox" checked>
                                <label class="custom-control-label" for="passwordCheckBox">Système automatique</label>
                            </div>
                            <div class="custom-control custom-checkbox"></div>
                            @if(Route::current()->getName() === 'students.edit')
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="passwordNoUpdate" value="passwordNoUpdate" class="custom-control-input" id="passwordNoUpdate" checked>
                                <label class="custom-control-label" for="passwordNoUpdate">Ne pas modifier</label>
                            </div>
                            @endif
                        </div>
                    </label>
                </div>
                {{ Form::password('password', ['id' => 'password', 'class' => 'form-control', 'placeholder' => trans('inputs.password'), 'disabled' => 'disabled']) }}
            </div>
            <div class="form-group col-md-6">
                <label for="password_confirmation">
                    {{ trans('inputs.password-confirmation') }}
                    <div class="custom-control custom-checkbox">
                    </div>
                </label>
                {{ Form::password('password_confirmation', ['id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => trans('inputs.password-confirmation'), 'disabled' => 'disabled']) }}
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">{{ trans('inputs.first-name') }}</label>
                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('inputs.first-name')]) }}
            </div>
            <div class="form-group col-md-6">
                <label for="surname">{{ trans('inputs.last-name') }}</label>
                {{ Form::text('surname', null, ['class' => 'form-control', 'placeholder' => trans('inputs.last-name')]) }}
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="mRadio">{{ trans('inputs.sex') }}</label>
                <div id="mRadio" class="form-control">
                    <div class="form-check form-check-inline">
                        {{ Form::radio("sex", "male", false, ["class" => "form-check-input"]) }}
                        <label class="form-check-label">{{ trans('inputs.sex-male') }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        {{ Form::radio("sex", "female", false, ["class" => "form-check-input" ]) }}
                        <label class="form-check-label">{{ trans('inputs.sex-female') }}</label>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="birthdate">{{ trans('inputs.birthdate') }}</label>
                {{ Form::date('birthdate', null, ['class' => 'form-control', 'placeholder' => trans('inputs.birthdate')]) }}
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="description">{{ trans('inputs.keywords') }}</label>
                {{ Form::select('keywords[]', $keywords, null, ['title' => trans('inputs.choose-keywords'), 'class' => 'form-control selectpicker', 'multiple' => 'multiple', 'data-live-search' => '1', 'data-max-options' => '5']) }}
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="description">{{ trans('inputs.description') }}</label>
                {{ Form::textarea("description", null, ["class" => "form-control", "rows" => "15"]) }}
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                {{ Form::button('<i class="fas fa-save"></i>' . ' ' . trans('buttons.save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>
        </div>

        {{ Form::close() }}
    </div>
@endsection
