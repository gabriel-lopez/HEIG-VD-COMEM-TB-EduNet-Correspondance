@extends('app')

@section('title', $teacher->name . ' ' . $teacher->surname)

@section('content')
    <div class="inbox-body">
        <div class="row">
            <div class="col-md-6">
                {{ $teacher->name }}
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    <div class="btn-group">
                        @auth('teacher')
                            <a class="btn mini btn-success" href="{{ route('messages.create', ['teacher' => '2' . $teacher->id]) }}">
                        @endauth
                        @auth('admin')
                            <a class="btn mini btn-success" href="{{ route('messages.create', ['teacher' => $teacher->id]) }}">
                        @endauth
                            <i class="fas fa-pen"></i> {{ trans('buttons.contact') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('indexes.schedulededucationalactivities-index', ['showTeachers' => 'false'])
@endsection
