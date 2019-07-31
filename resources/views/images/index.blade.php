@extends('app')

@section('title', trans('titles.list-images'))

@section('content')
    <div class="inbox-body">
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="float-right">
                    <div class="btn-group">
                        @include('partials.pagination', ['pagination' => $images])
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('indexes.images-index')
@endsection
