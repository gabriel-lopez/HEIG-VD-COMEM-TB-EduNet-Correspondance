@extends('app')

@section('title', $student->name . ' ' . $student->surname)

@section('content')
    <div class="inbox-body">

        @include('partials.picture')

        <div class="row">
            <div class="col-md-6">
                {{ $student->name }}
            </div>
            <div class="col-md-6">
                <div class="float-right">
                    @auth('student')
                    <div class="btn-group">

                        @auth('student')
                            <a class="btn mini btn-primary" href="{{ route('students.contact', $student->id) }}">
                                <i class="fas fa-paper-plane"></i>
                                {{ trans('buttons.contact') }}
                            </a>
                        @endauth

                    </div>
                    @endauth
                    @auth('admin')
                        <div class="btn-group">
                            <a class="btn mini btn-success" href="{{ route('students.edit', $student->id) }}">
                                <i class="fas fa-edit"></i>
                                {{ trans('buttons.edit') }}
                            </a>
                        </div>
                        <div class="btn-group">
                            <a class="btn mini btn-danger" href="{{ route('students.destroy', $student->id) }}">
                                <i class="fas fa-trash"></i>
                                {{ trans('buttons.delete') }}
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
