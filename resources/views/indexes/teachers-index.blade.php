@include('modals.delete')

<table class="table" data-form="deleteForm">
    <thead class="thead-dark">
    <tr>
        <th class="text-center" scope="col">{{ trans('tables.name') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.surname') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.number-of-classes') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.number-of-students') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.actions') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($teachers as $teacher)
        <tr>
            <th class="text-center" scope="row">{{ $teacher->name }}</th>
            <th class="text-center" scope="row">{{ $teacher->surname }}</th>
            <th class="text-center" scope="row">{{ $teacher->scheduledEducationalActivities->count() }}</th>
            <th class="text-center" scope="row">{{ $teacher->students->count() }}</th>
            <th>
                <div class="text-center">
                    <div class="btn-group">
                        <a class="btn mini btn-primary" href="{{ route('teachers.show', $teacher->id) }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                    @if(($user == $teacher) || Auth::guard('admin')->check())
                        <div class="btn-group">
                            <a class="btn mini btn-success" href="{{ route('teachers.edit', $teacher->id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                        <div class="btn-group">
                            {{ Form::model($teacher, ['method' => 'delete', 'route' => ['teachers.destroy', $teacher->id], 'class' =>'form-inline form-delete']) }}
                            {{ Form::hidden('id', $teacher->id) }}
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
