@extends('app')

@if(isset($admin))
    @section('title', trans('titles.modify-admin'))
@else
    @section('title', trans('titles.add-admin'))
@endif

@section('content')
    <div class="inbox-body">
        @if(isset($admin))
            {{ Form::model($admin, ['route' => ['admins.update', $admin->id], 'method' => 'patch']) }}
        @else
            {{ Form::open(['route' => 'admins.store', 'method' => 'post']) }}
        @endif

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
                <label for="email">{{ trans('inputs.e-mail') }}</label>
                {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('inputs.e-mail'), 'disabled' => 'disabled']) }}
            </div>

            <div class="form-group col-md-6">
                <label for="password">{{ trans('inputs.password') }}</label>
                <div class="input-group">
                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => trans('inputs.password'), 'required' => 'required']) }}
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-eye"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                @if(Route::currentRouteName() == 'admins.edit')
                    <label for="oldPassword">{{ trans('inputs.old-password') }}</label>
                    <div class="input-group">
                        {{ Form::password('oldPassword', ['class' => 'form-control', 'placeholder' => trans('inputs.password'), 'required' => 'required']) }}
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label for="password">{{ trans('inputs.password-confirmation') }}</label>
                <div class="input-group">
                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => trans('inputs.password-confirmation')]) }}
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-eye-slash"></i></span>
                    </div>
                </div>
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
