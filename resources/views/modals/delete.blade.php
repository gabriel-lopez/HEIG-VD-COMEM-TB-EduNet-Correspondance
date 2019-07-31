<div class="modal fade" tabindex="-1" role="dialog" id="confirm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('modals.delete-title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('buttons.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ trans('modals.delete-body') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('buttons.cancel') }}</button>
                <button type="button" class="btn btn-danger" id="delete-btn">{{ trans('buttons.delete') }}</button>
            </div>
        </div>
    </div>
</div>
