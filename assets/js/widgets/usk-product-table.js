/**
 * Start woocommerce widget script
 */

(function($, elementor) {
    'use strict';
    var widgetWCProductTable = function($scope, $) {

        var $productTable = $scope.find('.usk-wc-products-table'),
        $settings         = $productTable.data('settings'),
        $table            = $productTable.find('> table'),
        $quantity         = $productTable.find('.usk-wc-quantity .quantity input');

        if (!$productTable.length) {
            return;
        }

        //$settings.language = window.ElementPackConfig.data_table.language;

        if( $settings.hideHeader == 'yes'){

           $($table).DataTable({
            cache          : false,
            order          : [],
            paging         : $settings.paging,
            info           : $settings.info,
            bLengthChange  : $settings.bLengthChange,
            searching      : $settings.searching,
            ordering       : $settings.ordering,
            pageLength     : $settings.pageLength,
            drawCallback   : function( settings ) {
                $( $table).find("thead").remove(); } ,
            });
           return;
        }

        if( $settings.orderColumn != 'default' && $('.usk-wc-product').find('.usk-'+$settings.orderColumn).length > 0 && $settings.hideHeader != 'yes') {

        var orderColumn = $('.usk-wc-product .usk-'+$settings.orderColumn);
        orderColumn = $(orderColumn).index(this);

        $($table).DataTable({
            cache          : false,
            paging         : $settings.paging,
            info           : $settings.info,
            bLengthChange  : $settings.bLengthChange,
            searching      : $settings.searching,
            ordering       : $settings.ordering,
            pageLength     : $settings.pageLength,
            order          : [[ orderColumn, $settings.orderColumnQry ]],
        });

        } else {
            $($table).DataTable({
                cache         : false,
                order         : [],
                paging        : $settings.paging,
                info          : $settings.info,
                bLengthChange : $settings.bLengthChange,
                searching     : $settings.searching,
                ordering      : $settings.ordering,
                pageLength    : $settings.pageLength,

            });
        }

        jQuery($quantity).on('change',function(){
            var qtyNum = jQuery(this).val();
            jQuery(this).closest('tr').find('.usk-wc-add-to-cart a').attr('data-quantity', qtyNum);
        });
    };

    // Quickviews
      var widgetProductQuickView = {
        loadQuickViewHtml: function (_this, $scope) {
          var product_id = $(_this).data("id");
          $.ajax({
            type: "POST",
            dataType: "json",
            url: ultimate_store_kit_ajax_config.ajaxurl,
            data: {
              action: "ultimate_store_kit_wc_product_quick_view_content",
              product_id: product_id,
              security: $scope.find("#usk-product-table-modal-sc").val(),
            },
            success: function (response) {
              $("#usk-table-modal-response").html(response.data);
            },
          });
        },
      };
      var widgetWCQuickViewTrigger = function ($scope, $) {
        var $modalBody = '<div class="modal micromodal-slide" id="usk-table-modal" aria-hidden="false"><div class="modal__overlay" tabindex="-1" data-custom-close=""><div id="usk-table-modal-response" class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-btn-title"></div></div></div>';
        $("body").append($modalBody);
        MicroModal.init({
          openTrigger: "data-micromodal-trigger",
          closeTrigger: "data-micromodal-close",
          disableScroll: true,
          disableFocus: false,
          awaitOpenAnimation: false,
          awaitCloseAnimation: false,
          debugMode: true,
        });
        $scope.on("click", ".usk-shoping-icon-quickview", function (e) {
          e.preventDefault();
          widgetProductQuickView.loadQuickViewHtml(this, $scope);
        });
      };

    jQuery(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/usk-product-table.default', widgetWCProductTable);
        elementorFrontend.hooks.addAction("frontend/element_ready/usk-product-table.default", widgetWCQuickViewTrigger);
    });
}(jQuery, window.elementorFrontend));

/**
 * End woocommerce widget script
 */

