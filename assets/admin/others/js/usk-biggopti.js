/******/ (() => { // webpackBootstrap
/*!*********************************************!*\
  !*** ./src/admin/others/js/usk-biggopti.js ***!
  \*********************************************/
jQuery(document).ready(function ($) {
  // Delegate to capture dynamically injected biggopties as well
  $(document).on('click', '.ultimate-store-kit-biggopti.is-dismissible .bdt-biggopti-dismiss', function () {
    $this = $(this).parents('.ultimate-store-kit-biggopti');
    var $id = $this.attr('id') || '';
    var $time = $this.attr('dismissible-time') || '';
    var $meta = $this.attr('dismissible-meta') || '';
    $.ajax({
      url: window.UltimateStoreKitBiggoptiConfig && UltimateStoreKitBiggoptiConfig.ajaxurl ? UltimateStoreKitBiggoptiConfig.ajaxurl : typeof ajaxurl !== 'undefined' ? ajaxurl : '',
      type: 'POST',
      data: {
        action: 'ultimate-store-kit-biggopties',
        id: $id,
        meta: $meta,
        time: $time,
        _wpnonce: UltimateStoreKitBiggoptiConfig.nonce
      }
    });
  });
});
/******/ })()
;