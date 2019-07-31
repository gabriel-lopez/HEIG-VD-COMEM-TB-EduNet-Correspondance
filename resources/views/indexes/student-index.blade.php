@include('modals.delete')

<table class="table" data-form="deleteForm">
    <thead class="thead-dark">
    <tr>
        <th class="text-center" scope="col">{{ trans('tables.name') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.surname') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.sex') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.age') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.level') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.searching-correspondent') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.actions') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($students as $student)
        <tr>
            <th class="text-center" scope="row">{{ $student->name }}</th>
            <th class="text-center" scope="row">{{ $student->surname }}</th>
            <th class="text-center" scope="row">{{ trans('tables.' . $student->sex) }}</th>
            <th class="text-center" scope="row">{{ $student->age }} ans</th>
            <th class="text-center" scope="row">{{ $student->scheduledEducationalActivity->level->harmos_degree }}</th>
            <th class="text-center" scope="row">
                @if($student->available)
                    <i class="fas fa-check-circle text-success"></i>
                @else
                    <i class="fas fa-times-circle text-danger"></i>
                @endif
            </th>
            <th>
                <div class="text-center">
                    <div class="btn-group">
                        <a class="btn mini btn-primary" href="{{ route('students.show', $student->id) }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                    @if(($user == $student->scheduledEducationalActivity->teacher) || Auth::guard('admin')->check())
                    <div class="btn-group">
                        <a class="btn mini btn-success" href="{{ route('students.edit', $student->id) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                    <div class="btn-group">
                        {{ Form::model($student, ['method' => 'delete', 'route' => ['students.destroy', $student->id], 'class' =>'form-inline form-delete']) }}
                        {{ Form::hidden('id', $student->id) }}
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
