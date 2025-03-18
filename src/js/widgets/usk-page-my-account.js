(function ($, elementor) {
    "use strict";
    var PageMyAccount = function ($scope) {
        var $wrapper = $scope.find(".usk-myaccount-edit-mode");
        var $navLink = $wrapper.find(".woocommerce-MyAccount-navigation-link");
        var $sections = {
            dashboard: $scope.find(".usk-myaccount-dashboard"),
            orders: $scope.find(".usk-myaccount-orders"),
            downloads: $scope.find(".usk-myaccount-downloads"),
            addresses: $scope.find(".usk-myaccount-address"),
            paymentMethods: $scope.find(".usk-myaccount-payment-methods"),
            accountDetails: $scope.find(".usk-myaccount-details"),
        };

        $navLink.on("click", function () {
            var target = $(this).attr("class").split("--")[1].replace("edit-", "");
            if (target === "account") target = "accountDetails";  // Fix edit-account mapping
            if (target === "address") target = "addresses"; // Fix edit-address mapping

            $navLink.removeClass("is-active");
            $(this).addClass("is-active");

            $.each($sections, (key, section) => section.toggle(key === target));
        });
    };

    jQuery(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/usk-page-my-account.default", PageMyAccount);
    });
})(jQuery, window.elementorFrontend);

