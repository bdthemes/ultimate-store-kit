!function ($) {
    "use strict";
    var __ = wp.i18n.__;

    function showModal() {
        $('#ultimate-builder-kit-builder-modal').show();
    }

    function hideModal() {
        $('#ultimate-builder-kit-builder-modal').hide();
    }

    function resetModalForm(){
        $("#ultimate-builder-kit-builder-modal form")[0].reset();
        $("#ultimate-builder-kit-builder-modal form .template_id").val('');
        setTemplateStatusSwitcher(1);
    }

    function setSubmitBtn(string){
        $("#ultimate-builder-kit-builder-modal form .usk-modal-submit-btn").val(string)
    }

    function setError($this) {
        $this.addClass('input-error');
    }

    function removeError($this) {
        $('.input-error').removeClass('input-error');
    }

    function setTemplateStatusSwitcher(value) {
        var isActive = String(value) === '1';
        var $modal = $('#ultimate-builder-kit-builder-modal');
        var $switcher = $modal.find('#usk_template_status_switcher');
        var $statusInput = $modal.find('#usk_template_status');

        $statusInput.val(isActive ? '1' : '0');

        if (isActive) {
            $switcher.addClass('usk-active');
        } else {
            $switcher.removeClass('usk-active');
        }

        $switcher.attr('aria-checked', isActive ? 'true' : 'false');
        $modal.find('.usk-switcher-status-text').text(isActive ? __('Active', 'ultimate-store-kit') : __('Inactive', 'ultimate-store-kit'));
    }

    $(document).on('click', '#ultimate-builder-kit-builder-modal .usk-modal-close-button', function (e) {
        hideModal();
    })

    $(document).on('click', 'body.post-type-usk-template-builder a.page-title-action', function (e) {
        e.preventDefault();
        resetModalForm();
        setSubmitBtn(__('Create Template', 'ultimate-store-kit'));
        showModal();
    })


    $(document).on('submit', '#ultimate-builder-kit-builder-modal form', function (e) {
        e.preventDefault();
        var $serialized = $(this).serialize();
        removeError();

        $.ajax({
            url: ajaxurl,
            dataType: "json",
            method: 'post',
            cache: false,
            data: {
                'action': 'ultimate_store_kit_builder_create_template',
                'data': $serialized,
            },
            success: function (response) {
                window.location.href = response.data.redirect
            },
            error: function (errorThrown) {
                if (errorThrown.status == 422) {
                    $.each(errorThrown.responseJSON.data.errors_arr, function (index, value) {
                        setError($('#ultimate-builder-kit-builder-modal #' + index));
                    });
                }
            }
        });

    });

    $(document).on('click', 'body.post-type-usk-template-builder .row-actions .usk-edit-action a', function (e) {
        e.preventDefault();
        removeError();
        resetModalForm();
        setSubmitBtn(__('Update Template', 'ultimate-store-kit'));

        $.ajax({
            url: ajaxurl,
            dataType: "json",
            method: 'post',
            data: {
                'action': 'ultimate_store_kit_builder_get_edit_template',
                'template_id': $(this).data('id'),
                'nonce': UltimateStoreKitConfigBuilder.nonce
            },
            success: function (response) {
                if(response.success){
                    $("#ultimate-builder-kit-builder-modal form .template_id").val(response.data.id).change();
                    $("#ultimate-builder-kit-builder-modal form #template_name").val(response.data.name).change();
                    $("#ultimate-builder-kit-builder-modal form #template_type").val(response.data.type).change();
                    setTemplateStatusSwitcher(response.data.status);
                }
                showModal();
            },
            error: function (errorThrown) {
                console.log(errorThrown);
                if (errorThrown.status == 422 || errorThrown.status == 403) {
                    alert(__('Permission denied or invalid request', 'ultimate-store-kit'));
                }
            }
        });

    });

    $(document).ready(function () {
        $('#ultimate-builder-kit-builder-modal').on('click', '#usk_template_status_switcher', function () {
            var $input = $('#usk_template_status');
            var isActive = $input.val() === '1';
            setTemplateStatusSwitcher(isActive ? 0 : 1);
        }).on('keydown', '#usk_template_status_switcher', function (e) {
            if (e.key === ' ' || e.key === 'Enter') {
                e.preventDefault();
                var $input = $('#usk_template_status');
                var isActive = $input.val() === '1';
                setTemplateStatusSwitcher(isActive ? 0 : 1);
            }
        });
    });

}(jQuery);