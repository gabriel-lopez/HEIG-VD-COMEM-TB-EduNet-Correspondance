@include('modals.delete')

<table class="table" data-form="deleteForm">
    <thead class="thead-dark">
    <tr>
        <th class="text-center" scope="col">{{ trans('tables.original_filename') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.filename') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.mime') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.owner') }}</th>
        <th class="text-center" scope="col">{{ trans('tables.actions') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($images as $image)
        <tr>
            <th class="text-center" scope="row">{{ $image->original_filename }}</th>
            <th class="text-center" scope="row">{{ $image->filename }}</th>
            <th class="text-center" scope="row">{{ $image->mime }}</th>
            <th class="text-center" scope="row">{{ $image->owner->name . ' ' . $image->owner->surname }}</th>
            <th>
                <div class="text-center">
                    <div class="btn-group">
                        <a class="btn mini btn-primary" href="{{ Storage::disk('edunet')->url($image->filename) }}" target="_blank">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                    @if(Auth::guard('admin')->check())
                        <div class="btn-group">
                            {{ Form::model($image, ['method' => 'delete', 'route' => ['images.destroy', $image->id], 'class' =>'form-inline form-delete']) }}
                            {{ Form::hidden('id', $image->id) }}
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
