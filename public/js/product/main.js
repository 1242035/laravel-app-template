"use strict";

function _slicedToArray(arr, i) {
    return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest();
}

function _nonIterableRest() {
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}

function _iterableToArrayLimit(arr, i) {
    if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === "[object Arguments]")) {
        return;
    }
    var _arr = [];
    var _n = true;
    var _d = false;
    var _e = undefined;
    try {
        for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
            _arr.push(_s.value);
            if (i && _arr.length === i) break;
        }
    } catch (err) {
        _d = true;
        _e = err;
    } finally {
        try {
            if (!_n && _i["return"] != null) _i["return"]();
        } finally {
            if (_d) throw _e;
        }
    }
    return _arr;
}

function _arrayWithHoles(arr) {
    if (Array.isArray(arr)) return arr;
}

function _typeof(obj) {
    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
        _typeof = function _typeof(obj) {
            return typeof obj;
        };
    } else {
        _typeof = function _typeof(obj) {
            return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
        };
    }
    return _typeof(obj);
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').val()
    }
});
$(function () {
    // init data for modal
    function initFieldNames(element, index) {
        var dataFields = element.find('.data-field');
        dataFields.each(function () {
            var field_name = $(this).attr('name');
            $(this).attr('name', "products[".concat(index, "][").concat(field_name, "]"));
        });

        var filterEmpty = function filterEmpty() {
            var emptyInputs = element.find('.data-field').filter(function () {
                return !this.value;
            });

            if (emptyInputs.length == dataFields.length) {
                dataFields.removeClass('data-field-active');
            } else {
                dataFields.addClass('data-field-active');
            }
        };

        dataFields.on('change', filterEmpty);
        element.find('.modal-errors').each(function () {
            var error_name = $(this).attr('data-error_for');
            $(this).attr('data-error_for', "products.".concat(index, ".").concat(error_name));
        });
        pushToValidateObj(index);
    }

    function initDatalist(element) {
        element.on('change', function () {
            let datalistEle = this;
            let productName = $(this).val().trim();
            let row = $(this).closest('tr');
            let category = row.find('select.sltCategory');
            let supplier = row.find('select.sltSupplier');
            let market = row.find('select.sltMarket');
            let priceElem = row.find('.txtPrice');
            $('.product-id', row).val('');
            $(this).siblings('#product_names').find("option").each(function () {
                if ($(this).text() == productName || $(this).val() == productName) {
                    $(datalistEle).val($(this).val());
                    let productId = $(this).data('id');
                    let category_id = productNameMap[productId].category_id;
                    let supplier_id = productNameMap[productId].supplier_id;
                    let market_id = productNameMap[productId].market_id;
                    let price = productNameMap[productId].price;
                    category.val(category_id);
                    supplier.val(supplier_id);
                    market.val(market_id);
                    priceElem.val(price);
                    $('.product-id', element.parent()).val($(this).data('id'));
                    return false;
                }

                category.attr('disabled', false).removeClass('disabled-fields');
                supplier.attr('disabled', false).removeClass('disabled-fields');
            });
        });
    }

    function initDateRangePicker(node) {
        var curYear = parseInt(moment().format('YYYY'), 10);
        $(node).daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: curYear,
            maxYear: curYear + 10,
            me: $(this),
            parentEl: '#product-modal'
        });
        $(node).on('apply.daterangepicker', function (ev, picker) {
            $(this).find('.arrival_date').val(picker.startDate.format('YYYY-MM-DD')).change();
        });
    }

    function initImagePreview(btn, label) {
        var inputImageBtn = label.siblings('.input-image-buttons');
        label.on('click', function () {
            inputImageBtn.trigger('click');
        });
        label.siblings('.image-preview').find('.image-preview__image').click(function () {
            inputImageBtn.trigger('click');
        });
        btn.on('change', function () {
            var _this = this;

            var file = this.files[0];

            if (file) {
                var reader = new FileReader();
                reader.addEventListener('load', function () {
                    $(_this).siblings('.image-preview').find('.image-preview__image').attr('src', reader.result);
                });
                reader.readAsDataURL(file);
            } else {
                $(this).attr('src', '/images/no-image.png');
            }
        });
    } // render data for modal


    function renderItems(item, count, node) {
        var type = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
        var origin = $(item);

        for (var i = 1; i <= count; i++) {
            var clone = origin.clone();
            clone.css('display', 'table-row');
            clone.addClass('clones');
            initDateRangePicker(clone.find('.date'));
            initImagePreview(clone.find('.input-image-buttons'), clone.find('.product-modal-label'));
            initDatalist(clone.find('.product-names'));
            clone.appendTo(node);

            if (type === null) {
                clone.attr('data-modal_row_id', i);
                initFieldNames(clone, i);
            } else if (type == "edit") {
                clone.attr('data-modal_row_id', "1");
                initFieldNames(clone, 1);
                $('#add-row-btn').css('display', 'none');
            } else if (type == "new") {
                var new_id = parseInt(clone.prev('.clones').attr('data-modal_row_id'), 10) + 1;
                clone.attr('data-modal_row_id', new_id);
                initFieldNames(clone, new_id);
                clone.find('.row-remove-btn').append(createRemoveBtn());
                $('.remove-row-btn').one('click', function () {
                    $(this).closest('.product-modal-row').remove();
                });
            }
        }

        return true;
    }

    function populateError(errorObj) {
        if (_typeof(errorObj) == 'object') {
            for (var _i = 0, _Object$entries = Object.entries(errorObj); _i < _Object$entries.length; _i++) {
                var _Object$entries$_i = _slicedToArray(_Object$entries[_i], 2),
                    key = _Object$entries$_i[0],
                    value = _Object$entries$_i[1];

                var output = "";
                var _iteratorNormalCompletion = true;
                var _didIteratorError = false;
                var _iteratorError = undefined;

                try {
                    for (var _iterator = value[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
                        var message = _step.value;
                        output += "<div>".concat(message, "</div>");
                    }
                } catch (err) {
                    _didIteratorError = true;
                    _iteratorError = err;
                } finally {
                    try {
                        if (!_iteratorNormalCompletion && _iterator.return != null) {
                            _iterator.return();
                        }
                    } finally {
                        if (_didIteratorError) {
                            throw _iteratorError;
                        }
                    }
                }

                $("[data-error_for=\"".concat(key, "\"]")).html(output).siblings('.data-field').addClass('error-focus');
            }
        }
    }

    function createRemoveBtn() {
        return "<button type = \"button\" class= \"remove-row-btn color-white\">X</button>";
    }

    function getDateJapenese(dateString) {
        var year, month, day;

        var _dateString$split = dateString.split("-");

        var _dateString$split2 = _slicedToArray(_dateString$split, 3);

        year = _dateString$split2[0];
        month = _dateString$split2[1];
        day = _dateString$split2[2];
        return "".concat(year, "\u5E74").concat(month, "\u6708").concat(day, "\u65E5");
    } //modal logic


    $('#product-modal-show').on('click', function (e) {
        e.preventDefault();
        renderItems('#origin-row', 2, '.product-modal-radius');
        $('#modal-submit-btn').css('display', 'inline-block').attr('data-method', 'store').html('登録');
        $('#product-modal').modal('show');
    });
    $('#product-modal').on('hidden.bs.modal', function () {
        validateObj = {
            rules: {},
            messages: {}
        };
        $('.clones').remove();
        $('.image-preview__image').attr('src', '/images/no-image.png');
        $('#product-modal-form').trigger("reset");
        $('.product-modal-label').off('click');
        var addBtn = $('#add-row-btn');

        if (addBtn.css('display') == 'none') {
            addBtn.css('display', 'block');
        }
    });
    $('.product_rows').on('click', function (e) {
        e.preventDefault();
        //var showEditBtn = $(this).find('.storage-status').val() == 2 ? 'none' : 'inline-block';
        var showEditBtn = 'inline-block';
        renderItems('#origin-row', 1, '.product-modal-radius', 'edit');
        var clone = $('.clones');
        clone.find('.storage-status').val($(this).find('.storage-status').val());
        clone.find('.product-names').val($(this).find('.product_name').text()).change();
        //clone.find('.category_name').val($(this).find('.category_name').text()).change();
        clone.find('.sltCategory').val(clone.find('option:contains(' + $(this).find('.category_name').text() + ')').val());
        clone.find('.arrival_date').val($(this).find('.arrival_date').attr('data-arrival_date'));
        clone.find('.plan_delivery_day').val($(this).find('.plan_delivery_day').text().slice(0, -1));
        clone.find('.modal-select-market').val(clone.find('option:contains(' + $(this).find('.market_name').text() + ')').val());
        clone.find('.modal-quantity').val($(this).find('.total_quantity').attr('data-quantity'));
        clone.find('.modal-price').val($(this).find('.total_price').attr('data-price'));
        clone.find('.modal-note').val($(this).find('.note').text());
        clone.find('.modal-tax').val(clone.find('option:contains(' + $(this).find('.tax').text() + ')').val());
        // clone.find('.modal-tax').val($(this).find('.tax').text());
        clone.find('.image-preview__image').attr('src', $(this).find('.storage_image').attr('src'));
        var rowId = $(this).attr('data-id');
        $('#modal-submit-btn').attr('data-method', 'edit').css('display', showEditBtn).html('保存');
        $('#product-modal-form').attr('data-row_id', rowId);
        $('#product-modal').modal('show');
    }); // $('#product-modal-form').submit(function (e) {

    var isLoading = false;
    $('#modal-submit-btn').click(function (e) {
        if (isLoading) return;
        e.preventDefault();
        var $form = $('#product-modal-form');
        var formData, validator; // edit and store logic

        $form.find('.modal-errors').html("");
        $form.find('.error-focus').removeClass('error-focus');

        switch ($("#modal-submit-btn").attr('data-method')) {
            case 'store':
                $form.find('.data-field').each(function () {
                    if ($(this).val() == '' && !$(this).hasClass('data-field-active')) {
                        $(this).attr("disabled", true).addClass('empty-disabled-fields');
                    } else {
                        $(this).attr("disabled", false);
                    }
                });
                validator = $form.validate(validateObj);
                validator.checkForm();
                validator.showErrors();

                if (validator.errorList.length == 0) {
                    isLoading = true;
                    formData = new FormData($form[0]);
                    $.ajax({
                        type: "POST",
                        url: storeUrl,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function success(data) {
                            $('#product-modal').modal('hide');
                            toastr.success(productAdminMessage.success_store, '成功しました');
                            setTimeout(function () {
                                location.reload();
                            }, 1500)
                        },
                        error: function error(_error) {
                            console.log(_error);
                            populateError(_error.responseJSON.errors);
                            toastr.error(productAdminMessage.fail_store, 'エラー');
                            isLoading = false;
                        }
                    });
                }

                $form.find('.empty-disabled-fields').removeClass('.empty-disabled-fields').attr("disabled", false);
                // $form.find('.disabled-fields').attr('disabled', true);
                break;

            case 'edit':
                var disabledFields = $form.find('.disabled-fields');
                disabledFields.prop('disabled', false);
                validator = $form.validate(validateObj);
                validator.checkForm();
                validator.showErrors();

                if (validator.errorList.length == 0) {
                    $('.loading').css('display', 'block');
                    isLoading = true;
                    formData = new FormData($form[0]);
                    $.ajax({
                        type: "POST",
                        url: editUrl + "/" + $form.attr('data-row_id'),
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function success(data) {
                            var storageRow = $("#storage-row-".concat(data.storage.id));
                            storageRow.find('.arrival_date').attr('data-arrival_date', data.storage.arrival_date).html(getDateJapenese(data.storage.arrival_date)); // storageRow.find('.supplier_name').html(data.storage.supplier_name);
                            //storageRow.find('.category_name').html(data.storage.category_name);
                            //storageRow.find('.product_name').html(data.storage.produt_name);

                            storageRow.find('.category_name').html(data.storage.category_name);
                            storageRow.find('.supplier_name').html(data.storage.supplier_name);
                            storageRow.find('.product-names').html(data.storage.product_name);
                            storageRow.find('.market_name').html(data.storage.market_name);
                            storageRow.find('.plan_delivery_day').html(data.storage.plan_delivery_day + '日');
                            storageRow.find('.total_quantity').attr('data-quantity', data.storage.total_quantity).html(data.storage.total_quantity+"kg");
                            storageRow.find('.total_price').attr('data-price', data.storage.total_price).html('¥'+data.storage.total_price);
                            storageRow.find('.note').html(data.storage.note);
                            storageRow.find('.tax').html(data.storage.tax + '%');
                            storageRow.find('.storage_image').attr('src', data.storage.image);
                            $('.loading').css('display', 'none');
                            toastr.success(productAdminMessage.success_edit, '成功しました');
                            $('#product-modal').modal('hide');
                            setTimeout(function () {
                                isLoading = false;
                            }, 600);
                        },
                        error: function error(_error2) {
                            //console.log(_error2);
                            populateError(_error2.responseJSON.errors);
                            toastr.error(productAdminMessage.fail_edit, 'エラー');
                            $('.loading').css('display', 'none');
                            isLoading = false;
                        }
                    });
                }

                // disabledFields.prop('disabled', true);
                break;
        }
    });
    $('#add-row-btn button').on('click', function () {
        renderItems('#origin-row', 1, '.product-modal-radius', "new");
    });
});
