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
                time: $time
            }
        });

    });

    if (jQuery('.wrap').hasClass('ultimate-store-kit-dashboard')) {
        // total activate
        function total_widget_status() {
            var total_widget_active_status = [];

            var totalActivatedWidgets = [];
            jQuery('#ultimate_store_kit_active_modules_page input:checked').each(function () {
                totalActivatedWidgets.push(jQuery(this).attr('name'));
            });

            total_widget_active_status.push(totalActivatedWidgets.length);

            var totalActivated3rdparty = [];
            jQuery('#ultimate_store_kit_edd_modules_page input:checked').each(function () {
                totalActivated3rdparty.push(jQuery(this).attr('name'));
            });

            total_widget_active_status.push(totalActivated3rdparty.length);

            var totalActivatedExtensions = [];
            jQuery('#ultimate_store_kit_elementor_extend_page input:checked').each(function () {
                totalActivatedExtensions.push(jQuery(this).attr('name'));
            });

            total_widget_active_status.push(totalActivatedExtensions.length);


            jQuery('#bdt-total-widgets-status').attr('data-value', total_widget_active_status);
            jQuery('#bdt-total-widgets-status-core').text(total_widget_active_status[0]);
            jQuery('#bdt-total-widgets-status-3rd').text(total_widget_active_status[1]);

            jQuery('#bdt-total-widgets-status-heading').text(total_widget_active_status[0] + total_widget_active_status[1] + total_widget_active_status[2]);

        }

        total_widget_status();

        jQuery('.ultimate-store-kit-settings-save-btn').on('click', function () {
            setTimeout(function () {
                total_widget_status();
            }, 2000);
        });

        // end total active

        // modules
        var moduleUsedWidget = jQuery('#ultimate_store_kit_active_modules_page').find('.usk-used-widget');
        var moduleUsedWidgetCount = jQuery('#ultimate_store_kit_active_modules_page').find('.bdt-options .usk-used').length;


        moduleUsedWidget.text(moduleUsedWidgetCount);
        var moduleUnusedWidget = jQuery('#ultimate_store_kit_active_modules_page').find('.usk-unused-widget');
        var moduleUnusedWidgetCount = jQuery('#ultimate_store_kit_active_modules_page').find('.bdt-options .usk-unused').length;
        moduleUnusedWidget.text(moduleUnusedWidgetCount);

        // 3rd party
        var thirdPartyUsedWidget = jQuery('#ultimate_store_kit_edd_modules_page').find('.usk-used-widget');
        var thirdPartyUsedWidgetCount = jQuery('#ultimate_store_kit_edd_modules_page').find('.bdt-options .usk-used').length;
        thirdPartyUsedWidget.text(thirdPartyUsedWidgetCount);

        var thirdPartyUnusedWidget = jQuery('#ultimate_store_kit_edd_modules_page').find('.usk-unused-widget');
        var thirdPartyUnusedWidgetCount = jQuery('#ultimate_store_kit_edd_modules_page').find('.bdt-options .usk-unused').length;
        thirdPartyUnusedWidget.text(thirdPartyUnusedWidgetCount);

        // others
        var othersUsedWidget = jQuery('#ultimate_store_kit_general_modules_page').find('.usk-used-widget');
        var othersUsedWidgetCount = jQuery('#ultimate_store_kit_general_modules_page').find('.bdt-options .usk-used').length;
        othersUsedWidget.text(othersUsedWidgetCount);

        var othersUnusedWidget = jQuery('#ultimate_store_kit_general_modules_page').find('.usk-unused-widget');
        var othersUnusedWidgetCount = jQuery('#ultimate_store_kit_general_modules_page').find('.bdt-options .usk-unused').length;
        othersUnusedWidget.text(othersUnusedWidgetCount);


        // total widgets

        var dashboardChatItems = ['#bdt-db-total-status', '#bdt-db-only-widget-status', '#bdt-db-only-edd_widgets-status', '#bdt-total-widgets-status'];

        dashboardChatItems.forEach(function ($el) {

            const ctx = jQuery($el);

            var $value = ctx.data('value');
            $value = $value.split(',');

            var $labels = ctx.data('labels');
            $labels = $labels.split(',');

            var $bg = ctx.data('bg');
            $bg = $bg.split(',');

            // var $bgHover = ctx.data('bg-hover');
            // $bgHover = $bgHover.split(',');


            const data = {
                labels: $labels,
                datasets: [{
                    data: $value,
                    backgroundColor: $bg,
                    // hoverBackgroundColor: false, //$bgHover,
                    borderWidth: 0,
                }],

            };

            const config = {
                type: 'doughnut',
                data: data,
                options: {
                    animation: {
                        duration: 3000,
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                    },
                    title: {
                        display: false,
                        text: ctx.data('label'),
                        fontSize: 16,
                        fontColor: '#333',
                    },
                    hover: {
                        mode: null
                    },

                }
            };

            if (window.myChart instanceof Chart) {
                window.myChart.destroy();
            }

            var myChart = new Chart(ctx, config);

        });

    }

    jQuery('.ultimate-store-kit-notice.notice-error img').css({
        'margin-right': '8px',
        'vertical-align': 'middle'
    });

});