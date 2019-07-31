@extends('app')

@section('title', 'Classe' . ' ' . $scheduledEducationalActivity->name)

@section('content')
    <div class="inbox-body">
        <div class="row">
            <div class="col-md-6">
                {{ $scheduledEducationalActivity->name }}
                <br>
                {{ $scheduledEducationalActivity->level->harmos_degree }}
                <br>
                {{ $scheduledEducationalActivity->canton->name }}
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    @if(($user == $scheduledEducationalActivity->teacher))
                        <div class="btn-group">
                            {{ Form::model($scheduledEducationalActivity, ['method' => 'post', 'route' => ['classes.activate', $scheduledEducationalActivity->id], 'class' =>'form-inline form-delete']) }}
                            {{ Form::hidden('id', $scheduledEducationalActivity->id) }}
                            {{ Form::button('<i class="fas fa-play"></i>' . ' ' . trans('buttons.activate-access'), ['class' => 'btn btn-xs btn-success delete', 'type' => 'submit', 'name' => 'delete_modal']) }}
                            {{ Form::close() }}
                        </div>
                        <div class="btn-group">
                            {{ Form::model($scheduledEducationalActivity, ['method' => 'post', 'route' => ['classes.deactivate', $scheduledEducationalActivity->id], 'class' =>'form-inline form-delete']) }}
                            {{ Form::hidden('id', $scheduledEducationalActivity->id) }}
                            {{ Form::button('<i class="fas fa-stop"></i>' . ' ' . trans('buttons.deactivate-access'), ['class' => 'btn btn-xs btn-danger delete', 'type' => 'submit', 'name' => 'delete_modal']) }}
                            {{ Form::close() }}
                        </div>
                    @endif
                    @if(($user == $scheduledEducationalActivity->teacher) || Auth::guard('admin')->check())
                        <div class="btn-group">
                            <a class="btn mini btn-primary" href="{{ route('students.create', ['scheduledEducationalActivity' => $scheduledEducationalActivity->id]) }}">
                                <i class="fas fa-user-plus"></i> {{ trans('buttons.add') }}
                            </a>
                        </div>
                        <div class="btn-group">
                            <a class="btn mini btn-success" href="{{ route('classes.edit', $scheduledEducationalActivity->id) }}">
                                <i class="fas fa-edit"></i> {{ trans('buttons.edit') }}
                            </a>
                        </div>
                        <div class="btn-group">
                            {{ Form::model($scheduledEducationalActivity, ['method' => 'delete', 'route' => ['classes.destroy', $scheduledEducationalActivity->id], 'class' =>'form-inline form-delete']) }}
                            {{ Form::hidden('id', $scheduledEducationalActivity->id) }}
                            {{ Form::button('<i class="fas fa-trash"></i>' . ' ' . trans('buttons.delete'), ['class' => 'btn btn-xs btn-danger delete', 'type' => 'submit', 'name' => 'delete_modal']) }}
                            {{ Form::close() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@include('indexes.student-index')
@endsection

