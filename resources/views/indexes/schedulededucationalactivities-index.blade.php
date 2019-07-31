@include('modals.delete')

<table class="table" data-form="deleteForm">
    <thead class="thead-dark">
    <tr>
        <th class="text-center" scope="col">{{ trans('tables.surname') }}</th>
        @if(!Auth::guard('student')->check() || isset($showTeachers))
            <th class="text-center" scope="col">{{ trans('tables.teacher') }}</th>
        @endif
        <th class="text-center" scope="col">{{ trans('tables.level') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.canton') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.number-of-students') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.actions') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($scheduledEducationalActivities as $scheduledEducationalActivity)
        <tr>
            <th class="text-center" scope="row">{{ $scheduledEducationalActivity->name }}</th>
            @if(!Auth::guard('student')->check())
                <th class="text-center" scope="row">
                    <a href="{{ route('teachers.show', $scheduledEducationalActivity->teacher->id) }}">
                        {{ $scheduledEducationalActivity->teacher->name }} {{ $scheduledEducationalActivity->teacher->surname }}
                    </a>
                </th>
            @endif
            <th class="text-center" scope="row">{{ $scheduledEducationalActivity->level->harmos_degree }}</th>
            <th class="text-center" scope="row">{{ $scheduledEducationalActivity->canton->name }}</th>
            <th class="text-center" scope="row">{{ $scheduledEducationalActivity->students->count() }}</th>
            <th>
                <div class="text-center">
                    <div class="btn-group">
                        <a class="btn mini btn-primary" href="{{ route('classes.show', $scheduledEducationalActivity->id) }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                    @if(($user == $scheduledEducationalActivity->teacher) || Auth::guard('admin')->check())
                        <div class="btn-group">
                            <a class="btn mini btn-success" href="{{ route('classes.edit', $scheduledEducationalActivity->id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                        <div class="btn-group">
                            {{ Form::model($scheduledEducationalActivity, ['method' => 'delete', 'route' => ['classes.destroy', $scheduledEducationalActivity->id], 'class' =>'form-inline form-delete']) }}
                            {{ Form::hidden('id', $scheduledEducationalActivity->id) }}
                            {{ Form::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-xs btn-danger delete', 'type' => 'submit', 'name' => 'delete_modal']) }}
                            {{ Form::close() }}
                        </div>
                    @endif
                </div>
            </th>
        </tr>
    @endforeach
    </tbody>
</table>
