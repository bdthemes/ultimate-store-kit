!function ($) {
    "use strict";

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
        var isActive = value == 1;
        $('#template_status').val(isActive ? '1' : '0');
        $('#template_status_switcher')
            .toggleClass('usk-active', isActive)
            .attr('aria-checked', isActive);
        $('.usk-switcher-status-text').text(isActive ? 'Active' : 'Inactive');
    }

    $(document).on('click', '#ultimate-builder-kit-builder-modal .usk-modal-close-button', function (e) {
        hideModal();
    })

    $(document).on('click', 'body.post-type-usk-template-builder a.page-title-action', function (e) {
        e.preventDefault();
        resetModalForm();
        setSubmitBtn('Create Template');
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
        setSubmitBtn('Update Template');

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
                    alert('Permission denied or invalid request');
                }
            }
        });

    });

    $(document).ready(function () {
        $('#template_status_switcher').on('click', function () {
            var $input = $('#template_status');
            var isActive = $input.val() == '1';
            setTemplateStatusSwitcher(isActive ? 0 : 1);
        }).on('keydown', function (e) {
            if (e.key === ' ' || e.key === 'Enter') {
                e.preventDefault();
                $(this).click();
            }
        });
    });

}(jQuery);