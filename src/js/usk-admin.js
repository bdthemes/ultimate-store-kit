jQuery(document).ready(function ($) {

    jQuery('.ultimate-store-kit-notice.is-dismissible .notice-dismiss').on('click', function () {
        $this = jQuery(this).parents('.ultimate-store-kit-notice');
        var $id = $this.attr('id') || '';
        var $time = $this.attr('dismissible-time') || '';
        var $meta = $this.attr('dismissible-meta') || '';

        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'ultimate-store-kit-notices',
                id: $id,
                meta: $meta,
                time: $time,
            },
        });

    });

});