@extends('app')

@if(isset($scheduledEducationalActivity))
    @section('title', trans('titles.modify-class'))
@else
    @section('title', trans('titles.add-class'))
@endif

@section('content')
    <div class="inbox-body">

        @if(isset($scheduledEducationalActivity))
            {{ Form::model($scheduledEducationalActivity, ['route' => ['classes.update', $scheduledEducationalActivity->id], 'method' => 'patch']) }}
        @else
            {{ Form::open(['route' => 'classes.store', 'method' => 'post']) }}
        @endif

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">{{ trans('inputs.name') }}</label>
                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('inputs.name') ]) }}
            </div>
            <div class="form-group col-md-6">
                @auth('admin')
                    <label for="teacher_id">Professeur(-e)</label>
                    {{ Form::select('teacher_id', $teachers, null, ['title' => 'Pick a size...', 'class' => 'selectpicker form-control']) }}
                @endauth
            </div>
        </div>

         <div class="form-row">
             <div class="form-group col-md-6">
                 <label for="canton_id">Canton de la classe</label>
                 {{ Form::select('canton_id', $cantons, null, ['title' => trans('inputs.choose-canton'), 'class' => 'selectpicker form-control']) }}
             </div>
             <div class="form-group col-md-6">
                 <label for="level_id">Degré de la classe</label>
                 {{ Form::select('level_id', $levels, null, ['title' => 'Pick a size...', 'class' => 'selectpicker form-control']) }}
             </div>
         </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                {{ Form::submit(trans('buttons.save'), ['class' => 'btn btn-primary']) }}
            </div>
        </div>

        {{ Form::close() }}
    </div>
@endsection
