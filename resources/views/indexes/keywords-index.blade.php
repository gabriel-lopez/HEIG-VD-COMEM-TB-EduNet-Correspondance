@include('modals.delete')

<table class="table" data-form="deleteForm">
    <thead class="thead-dark">
    <tr>
        <th class="text-center" scope="col">{{ trans('tables.surname') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.name-normalized') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.number-of-students') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.creator') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.creator-type') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.actions') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($keywords as $keyword)
        <tr>
            <th class="text-center" scope="row">{{ $keyword->text }}</th>
            <th class="text-center" scope="row">{{ $keyword->text_normalized }}</th>
            <th class="text-center" scope="row">{{ $keyword->students->count() }}</th>
            <th class="text-center" scope="row">{{ $keyword->creator->name }}</th>
            <th class="text-center" scope="row">{{ $keyword->creator_type }}</th>
            <th>
                <div class="text-center">
                    <div class="btn-group">
                        <a class="btn mini btn-primary" href="{{ route('keywords.show', $keyword->id) }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                    @if(Auth::guard('admin')->check())
                        <div class="btn-group">
                            <a class="btn mini btn-success" href="{{ route('keywords.edit', $keyword->id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                        <div class="btn-group">
                            {{ Form::model($keyword, ['method' => 'delete', 'route' => ['keywords.destroy', $keyword->id], 'class' =>'form-inline form-delete']) }}
                            {{ Form::hidden('id', $keyword->id) }}
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
