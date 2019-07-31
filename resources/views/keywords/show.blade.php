@extends('app')

@section('title', $keyword->text)

@section('content')
    <div class="inbox-body">
        <div class="row">
            <div class="col-md-6">
                {{ $keyword->text }}
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    @if(Auth::guard('admin')->check())
                        <div class="btn-group">
                            <a class="btn mini btn-success" href="{{ route('keywords.edit', $keyword->id) }}">
                                <i class="fas fa-edit"></i> {{ trans('buttons.edit') }}
                            </a>
                        </div>
                        <div class="btn-group">
                            {{ Form::model($keyword, ['method' => 'delete', 'route' => ['keywords.destroy', $keyword->id], 'class' =>'form-inline form-delete']) }}
                            {{ Form::hidden('id', $keyword->id) }}
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

