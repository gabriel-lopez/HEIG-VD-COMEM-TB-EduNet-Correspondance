@extends('app')

@section('title', trans('titles.list-students'))

@section('content')
    <div class="inbox-body">
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="float-right">
                    <div class="btn-group">
                        @include('partials.pagination', ['pagination' => $students])
                    </div>
                    @if(Auth::guard('admin')->check())
                        <div class="btn-group">
                            <a class="btn mini btn-primary" href="{{ route('students.create', []) }}">
                                <i class="fas fa-user-plus"></i> {{ trans('buttons.add') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('indexes.student-index')
@endsection
