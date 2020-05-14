<style>
  #import-modal .modal-errors .error {
    position: absolute;
    /*bottom:30%;*/
    /*transform: translateY(50%);*/
    /*left:0;*/
    /*width:100%;*/
    /*text-align: center;*/
    /* transform: translateX(-50%); */
    color: red;
    font-size: 13px;
    font-weight: 500;
  }

  #import-modal .error-focus {
    border-color: red;
  }

  #import-modal .error {
    position: relative;
    top: 12px;
  }

  #import-modal .custom-file-label::after {
    content: "{{ __('general.buttons.browse') }}" !important;
}
</style>
<div class="modal fade" id="import-modal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form class="was-validated">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input import-file" id="validatedCustomFile" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        <label class="custom-file-label" for="validatedCustomFile" data-label="{{ __('general.labels.choose_file') }}">{{ __('general.labels.choose_file') }}</label>
                        <div class="invalid-feedback">{{ __('validation.admin.import.csv_xls') }}</div>
                    </div>
                    <div class="form-group row mt-2 d-none form-alert"></div>
                    <div class="form-group d-none mt-2 form-progress">
                      <div class="col-12">
                        <div class="row h-100">
                          <div class="progress-start col-1 pl-0 pr-0 text-center" style="font-size:12px; padding-left: 5px;"></div>
                          <div class="progress col-10 my-auto align-self-center pl-0 pr-0">
                            <div class="progress-bar progress-bar-striped" style="width:0%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <div class="progress-end col-1 pl-0 pr-0 text-center" style="font-size:12px; padding-left: 5px;"></div>
                        </div>
                      </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center align-item-center">
                <button class="btn btn-default btn-import-close">{{ __('general.buttons.close') }}</button>
                <button class="btn btn-success btn-import-action">
                  <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                  {{ __('general.buttons.import') }}
                </button>
            </div>
        </div>
    </div>
</div>
<script defer src="{{ asset('js/import/main.js') }}"></script>

