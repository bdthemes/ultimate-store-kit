/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/adminx/App.js"
/*!***************************!*\
  !*** ./src/adminx/App.js ***!
  \***************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _components_Header__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/Header */ "./src/adminx/components/Header.js");
/* harmony import */ var _components_Sidebar__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/Sidebar */ "./src/adminx/components/Sidebar.js");
/* harmony import */ var _pages_Welcome__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./pages/Welcome */ "./src/adminx/pages/Welcome.js");
/* harmony import */ var _pages_WidgetsPage__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./pages/WidgetsPage */ "./src/adminx/pages/WidgetsPage.js");
/* harmony import */ var _pages_OtherSettings__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./pages/OtherSettings */ "./src/adminx/pages/OtherSettings.js");
/* harmony import */ var _pages_GetPro__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./pages/GetPro */ "./src/adminx/pages/GetPro.js");
/* harmony import */ var _pages_License__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./pages/License */ "./src/adminx/pages/License.js");
/* harmony import */ var _pages_AboutInfo__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./pages/AboutInfo */ "./src/adminx/pages/AboutInfo.js");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__);











const adminData = window.ultimateStoreKitAdminData || {};
const getPageFromHash = () => {
  const hash = window.location.hash.replace('#', '');
  const pageName = hash.split('?')[0];
  const validPages = ['welcome', 'widgets', 'other-settings', 'get-pro', 'license', 'about'];
  return validPages.includes(pageName) ? pageName : 'welcome';
};
const App = () => {
  const [activePage, setActivePage] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(getPageFromHash());
  const [settings, setSettings] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(adminData.savedSettings || {});
  const [saving, setSaving] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [notification, setNotification] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (notification) {
      const timer = setTimeout(() => setNotification(null), 3000);
      return () => clearTimeout(timer);
    }
  }, [notification]);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    const handleHashChange = () => {
      setActivePage(getPageFromHash());
    };
    window.addEventListener('hashchange', handleHashChange);
    return () => window.removeEventListener('hashchange', handleHashChange);
  }, []);
  const saveSettings = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useCallback)((section, sectionSettings) => {
    setSaving(true);
    const formData = new FormData();
    formData.append('action', 'ultimate_store_kit_save_settings');
    formData.append('nonce', adminData.nonce);
    formData.append('section', section);
    Object.keys(sectionSettings).forEach(key => {
      formData.append(`settings[${key}]`, sectionSettings[key]);
    });
    fetch(adminData.ajaxUrl, {
      method: 'POST',
      body: formData
    }).then(res => res.json()).then(response => {
      if (response.success) {
        setSettings(prev => ({
          ...prev,
          [section]: sectionSettings
        }));
        setNotification({
          type: 'success',
          message: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Settings saved successfully.', 'ultimate-store-kit')
        });
      } else {
        setNotification({
          type: 'error',
          message: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Failed to save settings.', 'ultimate-store-kit')
        });
      }
    }).catch(() => {
      setNotification({
        type: 'error',
        message: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('An error occurred while saving.', 'ultimate-store-kit')
      });
    }).finally(() => {
      setSaving(false);
    });
  }, [adminData.ajaxUrl, adminData.nonce]);
  const renderPage = () => {
    const widgets = adminData.widgets || {};
    switch (activePage) {
      case 'welcome':
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__.jsx)(_pages_Welcome__WEBPACK_IMPORTED_MODULE_4__["default"], {
          widgets: widgets,
          settings: settings,
          isPro: adminData.isPro
        });
      case 'widgets':
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__.jsx)(_pages_WidgetsPage__WEBPACK_IMPORTED_MODULE_5__["default"], {
          allWidgets: widgets,
          allSettings: settings,
          onSave: saveSettings,
          saving: saving,
          isPro: adminData.isPro
        });
      case 'other-settings':
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__.jsx)(_pages_OtherSettings__WEBPACK_IMPORTED_MODULE_6__["default"], {
          widgets: widgets.ultimate_store_kit_other_settings || [],
          section: "ultimate_store_kit_other_settings",
          settings: settings.ultimate_store_kit_other_settings || {},
          onSave: saveSettings,
          saving: saving,
          isPro: adminData.isPro
        });
      case 'get-pro':
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__.jsx)(_pages_GetPro__WEBPACK_IMPORTED_MODULE_7__["default"], {
          isPro: adminData.isPro
        });
      case 'license':
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__.jsx)(_pages_License__WEBPACK_IMPORTED_MODULE_8__["default"], {
          isPro: adminData.isPro
        });
      case 'about':
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__.jsx)(_pages_AboutInfo__WEBPACK_IMPORTED_MODULE_9__["default"], {});
      default:
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__.jsx)(_pages_Welcome__WEBPACK_IMPORTED_MODULE_4__["default"], {
          widgets: widgets,
          settings: settings
        });
    }
  };
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__.jsxs)("div", {
    className: "usk-admin-app",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__.jsx)(_components_Header__WEBPACK_IMPORTED_MODULE_2__["default"], {
      version: adminData.version
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__.jsxs)("div", {
      className: "usk-admin-body",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__.jsx)(_components_Sidebar__WEBPACK_IMPORTED_MODULE_3__["default"], {
        activePage: activePage,
        onNavigate: setActivePage,
        isPro: adminData.isPro
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__.jsxs)("div", {
        className: "usk-admin-content",
        children: [notification && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__.jsxs)("div", {
          className: `usk-notification usk-notification--${notification.type}`,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__.jsx)("span", {
            children: notification.message
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_10__.jsx)("button", {
            onClick: () => setNotification(null),
            className: "usk-notification__close",
            children: "\xD7"
          })]
        }), renderPage()]
      })]
    })]
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (App);

/***/ },

/***/ "./src/adminx/components/Header.js"
/*!*****************************************!*\
  !*** ./src/adminx/components/Header.js ***!
  \*****************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__);


const Header = ({
  version
}) => {
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
    className: "usk-admin-header",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "usk-admin-header__left",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
        className: "usk-admin-header__logo",
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("svg", {
          width: "32",
          height: "32",
          viewBox: "0 0 1010 1024",
          fill: "none",
          xmlns: "http://www.w3.org/2000/svg",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
            fill: "#ffffff",
            d: "M911.638 879.878l-51.416-503.357c-5.935-56.843-53.595-100.775-111.514-100.775-0.111 0-0.222 0-0.332 0h-472.748c-0.161 0-0.352-0.002-0.545-0.002-58.369 0-106.292 44.717-111.382 101.761l-0.031 0.429-46.017 503.357c-0.293 3.043-0.46 6.58-0.46 10.154 0 62.098 50.324 112.441 112.413 112.472h570.201c62.106-0.108 112.411-50.478 112.411-112.6 0-4.029-0.212-8.008-0.625-11.928l0.042 0.49z"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
            fill: "#1e293b",
            d: "M229.611 905.585c-0.014 0-0.033 0-0.050 0-7.454 0-13.496-6.043-13.496-13.496 0-0.408 0.017-0.811 0.054-1.208l-0.003 0.052 46.017-503.357c0-7.099 5.755-12.854 12.854-12.854v0h472.894c6.965 0.021 12.697 5.265 13.491 12.019l0.007 0.064 21.594 209.389c-73.984 3.594-140.814 31.559-193.28 75.97l0.472-0.391c-80.208 68.639-113.114 167.101-126.482 233.298z"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
            fill: "#1e293b",
            d: "M799.808 905.585h-231.369c12.854-48.973 37.661-112.343 88.435-155.532 36.734-30.62 83.98-49.763 135.643-51.407l0.351-0.009 19.666 191.393c0.106 0.618 0.165 1.33 0.165 2.057 0 7.099-5.755 12.854-12.854 12.854-0.014 0-0.026 0-0.040 0h0.002z"
          })]
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "usk-admin-header__info",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h1", {
          className: "usk-admin-header__title",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Ultimate Store Kit', 'ultimate-store-kit')
        }), version && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("span", {
          className: "usk-admin-header__version",
          children: ["v", version]
        })]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "usk-admin-header__right",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
        href: "https://storekit.pro/pricing/",
        target: "_blank",
        rel: "noopener noreferrer",
        className: "usk-admin-header__btn",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Get Pro', 'ultimate-store-kit')
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
        href: "https://bdthemes.com/support/",
        target: "_blank",
        rel: "noopener noreferrer",
        className: "usk-admin-header__btn usk-admin-header__btn--outline",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Support', 'ultimate-store-kit')
      })]
    })]
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Header);

/***/ },

/***/ "./src/adminx/components/Sidebar.js"
/*!******************************************!*\
  !*** ./src/adminx/components/Sidebar.js ***!
  \******************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__);


const navItems = [{
  group: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('DASHBOARD', 'ultimate-store-kit'),
  items: [{
    id: 'welcome',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Welcome', 'ultimate-store-kit'),
    icon: 'dashicons-admin-home'
  }]
}, {
  group: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Widgets', 'ultimate-store-kit'),
  items: [{
    id: 'widgets',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Widgets', 'ultimate-store-kit'),
    icon: 'dashicons-screenoptions'
  }]
}, {
  group: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('SETTINGS', 'ultimate-store-kit'),
  items: [{
    id: 'other-settings',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Other Settings', 'ultimate-store-kit'),
    icon: 'dashicons-admin-generic'
  }]
}, {
  group: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('SUPPORT', 'ultimate-store-kit'),
  items: [{
    id: 'get-pro',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Get Pro', 'ultimate-store-kit'),
    icon: 'dashicons-star-filled'
  }, {
    id: 'license',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('License', 'ultimate-store-kit'),
    icon: 'dashicons-admin-network'
  }, {
    id: 'about',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('About & Info', 'ultimate-store-kit'),
    icon: 'dashicons-info'
  }]
}];
const Sidebar = ({
  activePage,
  onNavigate,
  isPro
}) => {
  const handleNavigate = pageId => {
    window.location.hash = pageId;
  };
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
    className: "usk-admin-sidebar",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("nav", {
      className: "usk-admin-sidebar__nav",
      children: navItems.map(group => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
        className: "usk-admin-sidebar__group",
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("ul", {
          className: "usk-admin-sidebar__list",
          children: group.items.map(item => {
            if (item.id === 'get-pro' && isPro) {
              return null;
            }
            return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("li", {
              children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("a", {
                href: `#${item.id}`,
                className: `usk-admin-sidebar__item ${activePage === item.id ? 'usk-admin-sidebar__item--active' : ''}`,
                onClick: e => {
                  e.preventDefault();
                  handleNavigate(item.id);
                },
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
                  className: `dashicons ${item.icon}`
                }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
                  children: item.label
                })]
              })
            }, item.id);
          })
        })
      }, group.group))
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "usk-admin-sidebar__promo",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
        className: "usk-admin-sidebar__promo-badge",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Coming Soon', 'ultimate-store-kit')
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("ul", {
        className: "usk-admin-sidebar__promo-list",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("li", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Advanced Search & Filters', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("li", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Analytics Dashboard', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("li", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('User Reviews & Ratings', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("li", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('WooCommerce Integration', 'ultimate-store-kit')
        })]
      })]
    })]
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Sidebar);

/***/ },

/***/ "./src/adminx/index.js"
/*!*****************************!*\
  !*** ./src/adminx/index.js ***!
  \*****************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _App__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./App */ "./src/adminx/App.js");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./style.scss */ "./src/adminx/style.scss");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__);




document.addEventListener('DOMContentLoaded', () => {
  const root = document.querySelector('.ultimate-store-kit-admin-root');
  if (root) {
    (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createRoot)(root).render(/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(_App__WEBPACK_IMPORTED_MODULE_1__["default"], {}));
  }
});

/***/ },

/***/ "./src/adminx/pages/AboutInfo.js"
/*!***************************************!*\
  !*** ./src/adminx/pages/AboutInfo.js ***!
  \***************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__);


const adminData = window.ultimateStoreKitAdminData || {};
const AboutInfo = () => {
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
    className: "usk-about",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "usk-about__card",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
        className: "usk-about__logo",
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("svg", {
          width: "48",
          height: "48",
          viewBox: "0 0 1010 1024",
          fill: "none",
          xmlns: "http://www.w3.org/2000/svg",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
            fill: "#10b981",
            d: "M911.638 879.878l-51.416-503.357c-5.935-56.843-53.595-100.775-111.514-100.775-0.111 0-0.222 0-0.332 0h-472.748c-0.161 0-0.352-0.002-0.545-0.002-58.369 0-106.292 44.717-111.382 101.761l-0.031 0.429-46.017 503.357c-0.293 3.043-0.46 6.58-0.46 10.154 0 62.098 50.324 112.441 112.413 112.472h570.201c62.106-0.108 112.411-50.478 112.411-112.6 0-4.029-0.212-8.008-0.625-11.928l0.042 0.49z"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
            fill: "#ffffff",
            d: "M229.611 905.585c-0.014 0-0.033 0-0.050 0-7.454 0-13.496-6.043-13.496-13.496 0-0.408 0.017-0.811 0.054-1.208l-0.003 0.052 46.017-503.357c0-7.099 5.755-12.854 12.854-12.854v0h472.894c6.965 0.021 12.697 5.265 13.491 12.019l0.007 0.064 21.594 209.389c-73.984 3.594-140.814 31.559-193.28 75.97l0.472-0.391c-80.208 68.639-113.114 167.101-126.482 233.298z"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
            fill: "#ffffff",
            d: "M799.808 905.585h-231.369c12.854-48.973 37.661-112.343 88.435-155.532 36.734-30.62 83.98-49.763 135.643-51.407l0.351-0.009 19.666 191.393c0.106 0.618 0.165 1.33 0.165 2.057 0 7.099-5.755 12.854-12.854 12.854-0.014 0-0.026 0-0.040 0h0.002z"
          })]
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h2", {
        className: "usk-about__title",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Ultimate Store Kit', 'ultimate-store-kit')
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("span", {
        className: "usk-about__version",
        children: ["v", adminData.version || '']
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
        className: "usk-about__desc",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Build online stores in WordPress with the powerful store builder addon for Elementor. Enjoy a wide range of customizations and easily build product grids, carousels, single product/page elements, checkouts and more.', 'ultimate-store-kit')
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "usk-about__grid",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "usk-about__info-card",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h3", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Author', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://bdthemes.com/",
            target: "_blank",
            rel: "noopener noreferrer",
            children: "BdThemes"
          })
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "usk-about__info-card",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h3", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Website', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://storekit.pro/",
            target: "_blank",
            rel: "noopener noreferrer",
            children: "storekit.pro"
          })
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "usk-about__info-card",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h3", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Documentation', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://bdthemes.com/all-knowledge-base-of-ultimate-store-kit/",
            target: "_blank",
            rel: "noopener noreferrer",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Knowledge Base', 'ultimate-store-kit')
          })
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "usk-about__info-card",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h3", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Support', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://bdthemes.com/support/",
            target: "_blank",
            rel: "noopener noreferrer",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Get Support', 'ultimate-store-kit')
          })
        })]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "usk-about__links",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h3", {
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Useful Links', 'ultimate-store-kit')
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("ul", {
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("li", {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://www.youtube.com/c/bdthemes",
            target: "_blank",
            rel: "noopener noreferrer",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Video Tutorials', 'ultimate-store-kit')
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("li", {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://feedback.bdthemes.com/b/6vr2250l/feature-requests/",
            target: "_blank",
            rel: "noopener noreferrer",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Request a Feature', 'ultimate-store-kit')
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("li", {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://wordpress.org/plugins/ultimate-store-kit/",
            target: "_blank",
            rel: "noopener noreferrer",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Rate Us on WordPress.org', 'ultimate-store-kit')
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("li", {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://www.facebook.com/groups/developer.developer/",
            target: "_blank",
            rel: "noopener noreferrer",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Join Our Facebook Community', 'ultimate-store-kit')
          })
        })]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
      className: "usk-about__footer",
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("p", {
        children: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Ultimate Store Kit Addon made with love by', 'ultimate-store-kit'), ' ', /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
          target: "_blank",
          rel: "noopener noreferrer",
          href: "https://bdthemes.com",
          children: "BdThemes"
        }), ' ', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Team. All rights reserved.', 'ultimate-store-kit')]
      })
    })]
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (AboutInfo);

/***/ },

/***/ "./src/adminx/pages/GetPro.js"
/*!************************************!*\
  !*** ./src/adminx/pages/GetPro.js ***!
  \************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__);


const features = [{
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Core Widgets', 'ultimate-store-kit'),
  free: true,
  pro: true,
  note: 'Lite: 35+ / Pro: 100+'
}, {
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Theme Compatibility', 'ultimate-store-kit'),
  free: true,
  pro: true
}, {
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Dynamic Content & Custom Fields', 'ultimate-store-kit'),
  free: true,
  pro: true
}, {
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Proper Documentation', 'ultimate-store-kit'),
  free: true,
  pro: true
}, {
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Updates & Support', 'ultimate-store-kit'),
  free: true,
  pro: true
}, {
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Ready Made Blocks', 'ultimate-store-kit'),
  free: true,
  pro: true
}, {
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Ready Made Pages', 'ultimate-store-kit'),
  free: true,
  pro: true
}, {
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Rooten Theme Pro Features', 'ultimate-store-kit'),
  free: false,
  pro: true
}, {
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Priority Support', 'ultimate-store-kit'),
  free: false,
  pro: true
}];
const highlights = [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Incredibly Advanced', 'ultimate-store-kit'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Refund or Cancel Anytime', 'ultimate-store-kit'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Dynamic Content', 'ultimate-store-kit'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Super-Flexible Widgets', 'ultimate-store-kit'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('24/7 Premium Support', 'ultimate-store-kit'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Third Party Plugins', 'ultimate-store-kit'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Special Discount!', 'ultimate-store-kit'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Custom Field Integration', 'ultimate-store-kit'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('With Live Chat Support', 'ultimate-store-kit'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Trusted Payment Methods', 'ultimate-store-kit'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Interactive Effects', 'ultimate-store-kit'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Video Tutorial', 'ultimate-store-kit')];
const GetPro = ({
  isPro
}) => {
  if (isPro) {
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
      className: "usk-getpro",
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "usk-getpro__card",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h2", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('You already have Pro!', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Thank you for being a Pro user. You have access to all features.', 'ultimate-store-kit')
        })]
      })
    });
  }
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
    className: "usk-getpro",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "usk-getpro__header",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h2", {
          className: "usk-getpro__title",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('WHY GO WITH PRO?', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
          className: "usk-getpro__subtitle",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Just Compare With Ultimate Store Kit Free Vs Pro', 'ultimate-store-kit')
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
        href: "https://storekit.pro/pricing",
        target: "_blank",
        rel: "noopener noreferrer",
        className: "usk-btn usk-btn--primary usk-btn--lg",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Purchase Now', 'ultimate-store-kit')
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "usk-getpro__table",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "usk-getpro__table-head",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Features', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Free', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Pro', 'ultimate-store-kit')
        })]
      }), features.map((f, i) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "usk-getpro__table-row",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
          className: "usk-getpro__feature-name",
          children: f.label
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
          children: f.free ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
            className: "dashicons dashicons-yes-alt usk-getpro__icon--yes"
          }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
            className: "dashicons dashicons-dismiss usk-getpro__icon--no"
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
          children: f.pro ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
            className: "dashicons dashicons-yes-alt usk-getpro__icon--yes"
          }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
            className: "dashicons dashicons-dismiss usk-getpro__icon--no"
          })
        })]
      }, i))]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "usk-getpro__highlights",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
        className: "usk-getpro__highlights-grid",
        children: highlights.map((h, i) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
          className: "usk-getpro__highlight-item",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
            className: "dashicons dashicons-heart"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
            children: h
          })]
        }, i))
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
        className: "usk-getpro__cta",
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
          href: "https://storekit.pro/pricing",
          target: "_blank",
          rel: "noopener noreferrer",
          className: "usk-btn usk-btn--primary usk-btn--lg",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Purchase Now', 'ultimate-store-kit')
        })
      })]
    })]
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (GetPro);

/***/ },

/***/ "./src/adminx/pages/License.js"
/*!*************************************!*\
  !*** ./src/adminx/pages/License.js ***!
  \*************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__);


const License = ({
  isPro
}) => {
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
    className: "usk-license",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "usk-license__card",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h2", {
        className: "usk-license__title",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('License', 'ultimate-store-kit')
      }), isPro ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "usk-license__active",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
          className: "usk-license__status",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
            className: "dashicons dashicons-yes-alt"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Your license is active.', 'ultimate-store-kit')
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Thank you for activating the Pro version. You have access to all premium features and priority support.', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
          href: "https://account.bdthemes.com/",
          target: "_blank",
          rel: "noopener noreferrer",
          className: "usk-btn usk-btn--secondary",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Manage License', 'ultimate-store-kit')
        })]
      }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "usk-license__inactive",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
          className: "usk-license__status usk-license__status--inactive",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
            className: "dashicons dashicons-warning"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('No active license found.', 'ultimate-store-kit')
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('To unlock all premium features and get priority support, please purchase and activate a Pro license.', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
          className: "usk-license__actions",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://storekit.pro/pricing/",
            target: "_blank",
            rel: "noopener noreferrer",
            className: "usk-btn usk-btn--primary",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Get Pro License', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://account.bdthemes.com/",
            target: "_blank",
            rel: "noopener noreferrer",
            className: "usk-btn usk-btn--secondary",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Already have a license?', 'ultimate-store-kit')
          })]
        })]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "usk-license__footer-info",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("p", {
        children: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Ultimate Store Kit Addon made with love by', 'ultimate-store-kit'), ' ', /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
          target: "_blank",
          rel: "noopener noreferrer",
          href: "https://bdthemes.com",
          children: "BdThemes"
        }), ' ', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Team.', 'ultimate-store-kit')]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('All rights reserved by BdThemes.', 'ultimate-store-kit')
      })]
    })]
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (License);

/***/ },

/***/ "./src/adminx/pages/OtherSettings.js"
/*!*******************************************!*\
  !*** ./src/adminx/pages/OtherSettings.js ***!
  \*******************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__);



const OtherSettings = ({
  widgets,
  section,
  settings,
  onSave,
  saving,
  isPro
}) => {
  const [localSettings, setLocalSettings] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(() => {
    const initial = {};
    widgets.forEach(w => {
      if (w.type === 'start_group' || w.type === 'end_group') return;
      if (w.type === 'checkbox') {
        initial[w.name] = settings[w.name] !== undefined ? settings[w.name] : w.default || 'off';
      } else if (w.type === 'select' || w.type === 'number' || w.type === 'text') {
        initial[w.name] = settings[w.name] !== undefined ? settings[w.name] : w.default || '';
      }
    });
    return initial;
  });
  const handleChange = (name, value) => {
    setLocalSettings(prev => ({
      ...prev,
      [name]: value
    }));
  };
  const handleSave = () => {
    onSave(section, localSettings);
  };
  const renderGroups = () => {
    const groups = [];
    let currentGroup = null;
    widgets.forEach(w => {
      if (w.type === 'start_group') {
        currentGroup = {
          label: w.label,
          items: []
        };
        return;
      }
      if (w.type === 'end_group') {
        if (currentGroup) {
          groups.push(currentGroup);
          currentGroup = null;
        }
        return;
      }
      if (currentGroup) {
        currentGroup.items.push(w);
      } else {
        if (!groups.length || groups[groups.length - 1].items === undefined) {
          groups.push({
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('General', 'ultimate-store-kit'),
            items: []
          });
        }
        groups[groups.length - 1].items.push(w);
      }
    });
    return groups;
  };
  const groups = renderGroups();
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
    className: "usk-other-settings",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
      className: "usk-other-settings__header",
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("h2", {
        className: "usk-other-settings__title",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Other Settings', 'ultimate-store-kit')
      })
    }), groups.map((group, gi) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "usk-settings-group",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("h3", {
        className: "usk-settings-group__title",
        children: group.label
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
        className: "usk-settings-group__body",
        children: group.items.map(item => {
          const isProItem = item.widget_type === 'pro';
          const isDisabled = isProItem && !isPro;
          if (item.type === 'checkbox') {
            const isOn = !isDisabled && localSettings[item.name] === 'on';
            return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
              className: "usk-settings-field",
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
                className: "usk-settings-field__label",
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
                  children: item.label
                }), isProItem && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
                  className: "usk-widget-card__badge",
                  children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Pro', 'ultimate-store-kit')
                })]
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("label", {
                className: "usk-toggle",
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("input", {
                  type: "checkbox",
                  checked: isOn,
                  disabled: isDisabled,
                  onChange: () => handleChange(item.name, isOn ? 'off' : 'on')
                }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
                  className: "usk-toggle__slider"
                })]
              })]
            }, item.name);
          }
          if (item.type === 'select') {
            return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
              className: "usk-settings-field",
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("label", {
                className: "usk-settings-field__label",
                children: item.label
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("select", {
                className: "usk-settings-field__select",
                value: localSettings[item.name] || '',
                onChange: e => handleChange(item.name, e.target.value),
                disabled: isDisabled,
                children: item.options && Object.entries(item.options).map(([val, lbl]) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("option", {
                  value: val,
                  children: lbl
                }, val))
              })]
            }, item.name);
          }
          if (item.type === 'number' || item.type === 'text') {
            return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
              className: "usk-settings-field",
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("label", {
                className: "usk-settings-field__label",
                children: item.label
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("input", {
                type: item.type,
                className: "usk-settings-field__input",
                value: localSettings[item.name] || '',
                onChange: e => handleChange(item.name, e.target.value),
                disabled: isDisabled
              })]
            }, item.name);
          }
          return null;
        })
      })]
    }, gi)), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
      className: "usk-widgets-page__footer",
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("button", {
        className: "usk-btn usk-btn--primary usk-btn--lg",
        onClick: handleSave,
        disabled: saving,
        children: saving ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Saving...', 'ultimate-store-kit') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Save Changes', 'ultimate-store-kit')
      })
    })]
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (OtherSettings);

/***/ },

/***/ "./src/adminx/pages/Welcome.js"
/*!*************************************!*\
  !*** ./src/adminx/pages/Welcome.js ***!
  \*************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__);



const Welcome = ({
  widgets,
  settings,
  isPro
}) => {
  const stats = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => {
    const wcWidgets = widgets.ultimate_store_kit_active_modules || [];
    const eddWidgets = widgets.ultimate_store_kit_edd_modules || [];
    const otherWidgets = widgets.ultimate_store_kit_general_modules || [];
    const wcSettings = settings.ultimate_store_kit_active_modules || {};
    const eddSettings = settings.ultimate_store_kit_edd_modules || {};
    const otherSettings = settings.ultimate_store_kit_general_modules || {};
    const countActive = (widgetList, savedSettings) => {
      let active = 0;
      let inactive = 0;
      widgetList.forEach(w => {
        if (w.type !== 'checkbox') return;
        const val = savedSettings[w.name];
        const isOn = val !== undefined ? val === 'on' : w.default === 'on';
        if (isOn) active++;else inactive++;
      });
      return {
        active,
        inactive,
        total: active + inactive
      };
    };
    const wc = countActive(wcWidgets, wcSettings);
    const edd = countActive(eddWidgets, eddSettings);
    const other = countActive(otherWidgets, otherSettings);
    const all = {
      active: wc.active + edd.active + other.active,
      inactive: wc.inactive + edd.inactive + other.inactive,
      total: wc.total + edd.total + other.total
    };
    return {
      all,
      wc,
      edd,
      other
    };
  }, [widgets, settings]);
  const StatCard = ({
    title,
    data,
    color
  }) => {
    const percentage = data.total > 0 ? Math.round(data.active / data.total * 100) : 0;
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "usk-stat-card",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("h3", {
        className: "usk-stat-card__title",
        children: title
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "usk-stat-card__body",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
          className: "usk-stat-card__counts",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
            className: "usk-stat-card__count",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              className: "usk-stat-card__label",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Active:', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("strong", {
              children: data.active
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
            className: "usk-stat-card__count",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              className: "usk-stat-card__label",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Inactive:', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("strong", {
              children: data.inactive
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
            className: "usk-stat-card__count",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              className: "usk-stat-card__label",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Total:', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("strong", {
              children: data.total
            })]
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
          className: "usk-stat-card__chart",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
            viewBox: "0 0 36 36",
            className: "usk-donut",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              className: "usk-donut__ring",
              d: "M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831",
              fill: "none",
              stroke: "#e2e8f0",
              strokeWidth: "3"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              className: "usk-donut__segment",
              d: "M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831",
              fill: "none",
              stroke: color,
              strokeWidth: "3",
              strokeDasharray: `${percentage}, 100`
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("text", {
              x: "18",
              y: "20.5",
              className: "usk-donut__text",
              textAnchor: "middle",
              fontSize: "8",
              fill: "#334155",
              children: [percentage, "%"]
            })]
          })
        })]
      })]
    });
  };
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
    className: "usk-welcome",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "usk-welcome__stats",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(StatCard, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('All Widgets', 'ultimate-store-kit'),
        data: stats.all,
        color: "#f59e0b"
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(StatCard, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('WooCommerce', 'ultimate-store-kit'),
        data: stats.wc,
        color: "#ef4444"
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(StatCard, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('EDD', 'ultimate-store-kit'),
        data: stats.edd,
        color: "#10b981"
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(StatCard, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Other', 'ultimate-store-kit'),
        data: stats.other,
        color: "#3b82f6"
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "usk-welcome__grid",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "usk-welcome__card",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("h3", {
          className: "usk-welcome__card-title",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Support And Feedback', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("p", {
          children: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Feeling like to consult with an expert? Take live Chat support immediately from', 'ultimate-store-kit'), ' ', /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("a", {
            href: "https://storekit.pro/",
            target: "_blank",
            rel: "noopener noreferrer",
            children: "UltimateStoreKit"
          }), ".", ' ', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('We are always ready to help you 24/7.', 'ultimate-store-kit')]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("strong", {
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Or if you're facing technical issues with our plugin, then please create a support ticket", 'ultimate-store-kit')
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
          className: "usk-welcome__card-actions",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("a", {
            className: "usk-btn usk-btn--primary",
            target: "_blank",
            rel: "noopener noreferrer",
            href: "https://bdthemes.com/all-knowledge-base-of-ultimate-store-kit/",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Knowledge Base', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("a", {
            className: "usk-btn usk-btn--secondary",
            target: "_blank",
            rel: "noopener noreferrer",
            href: "https://bdthemes.com/support/",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Get Support', 'ultimate-store-kit')
          })]
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "usk-welcome__card",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("h3", {
          className: "usk-welcome__card-title",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('System Requirement', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
          className: "usk-welcome__card-desc",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Make sure your server meets the minimum requirements for optimal performance.', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
          className: "usk-system-info",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
            className: "usk-system-info__item",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('PHP Version', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              className: "usk-system-info__badge usk-system-info__badge--ok",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('OK', 'ultimate-store-kit')
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
            className: "usk-system-info__item",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Memory Limit', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              className: "usk-system-info__badge usk-system-info__badge--ok",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('OK', 'ultimate-store-kit')
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
            className: "usk-system-info__item",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Max Execution Time', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              className: "usk-system-info__badge usk-system-info__badge--ok",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('OK', 'ultimate-store-kit')
            })]
          })]
        })]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "usk-welcome__grid",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "usk-welcome__card",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("h3", {
          className: "usk-welcome__card-title",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Feedback', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('We are always looking for feedback from our users. If you have any suggestions or feedback, please let us know.', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
          className: "usk-welcome__card-actions",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("a", {
            className: "usk-btn usk-btn--secondary",
            target: "_blank",
            rel: "noopener noreferrer",
            href: "https://feedback.bdthemes.com/b/6vr2250l/feature-requests/",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Request Feature', 'ultimate-store-kit')
          })
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "usk-welcome__card",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("h3", {
          className: "usk-welcome__card-title",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Try Our Other Plugins', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Element Pack, Prime Slider, Ultimate Post Kit, Pixel Gallery & Live Copy Paste addons for Elementor.', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
          className: "usk-welcome__card-actions usk-welcome__card-actions--wrap",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("a", {
            className: "usk-btn usk-btn--small usk-btn--ep",
            target: "_blank",
            rel: "noopener noreferrer",
            href: "https://wordpress.org/plugins/bdthemes-element-pack-lite/",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Element Pack', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("a", {
            className: "usk-btn usk-btn--small usk-btn--ps",
            target: "_blank",
            rel: "noopener noreferrer",
            href: "https://wordpress.org/plugins/bdthemes-prime-slider-lite/",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Prime Slider', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("a", {
            className: "usk-btn usk-btn--small usk-btn--upk",
            target: "_blank",
            rel: "noopener noreferrer",
            href: "https://wordpress.org/plugins/ultimate-post-kit/",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Ultimate Post Kit', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("a", {
            className: "usk-btn usk-btn--small usk-btn--pg",
            target: "_blank",
            rel: "noopener noreferrer",
            href: "https://wordpress.org/plugins/pixel-gallery/",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Pixel Gallery', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("a", {
            className: "usk-btn usk-btn--small usk-btn--zb",
            target: "_blank",
            rel: "noopener noreferrer",
            href: "https://wordpress.org/plugins/zoloblocks/",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('ZoloBlocks', 'ultimate-store-kit')
          })]
        })]
      })]
    })]
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Welcome);

/***/ },

/***/ "./src/adminx/pages/WidgetsPage.js"
/*!*****************************************!*\
  !*** ./src/adminx/pages/WidgetsPage.js ***!
  \*****************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__);



const getFiltersFromHash = () => {
  const hash = window.location.hash;
  const params = new URLSearchParams(hash.includes('?') ? hash.split('?')[1] : '');
  return {
    widgetType: params.get('type') || 'wc',
    search: params.get('search') || '',
    filter: params.get('status') || 'all',
    contentTypeFilter: params.get('template') || 'all'
  };
};
const WidgetsPage = ({
  allWidgets,
  allSettings,
  onSave,
  saving,
  isPro
}) => {
  const initialFilters = getFiltersFromHash();
  const [widgetType, setWidgetType] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(initialFilters.widgetType);
  const [search, setSearch] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(initialFilters.search);
  const [filter, setFilter] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(initialFilters.filter);
  const [contentTypeFilter, setContentTypeFilter] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(initialFilters.contentTypeFilter);
  const widgetTypeConfig = {
    wc: {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('WooCommerce Widgets', 'ultimate-store-kit'),
      key: 'ultimate_store_kit_active_modules'
    },
    edd: {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('EDD Widgets', 'ultimate-store-kit'),
      key: 'ultimate_store_kit_edd_modules'
    },
    other: {
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Other Widgets', 'ultimate-store-kit'),
      key: 'ultimate_store_kit_general_modules'
    }
  };
  const currentConfig = widgetTypeConfig[widgetType];
  const widgets = allWidgets[currentConfig.key] || [];
  const settings = allSettings[currentConfig.key] || {};
  const [localSettings, setLocalSettings] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(() => {
    const initial = {};
    Object.keys(allSettings).forEach(sectionKey => {
      const sectionSettings = allSettings[sectionKey] || {};
      const sectionWidgets = allWidgets[sectionKey] || [];
      sectionWidgets.forEach(w => {
        if (w.type !== 'checkbox') return;
        initial[w.name] = sectionSettings[w.name] !== undefined ? sectionSettings[w.name] : w.default || 'off';
      });
    });
    return initial;
  });
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    const params = new URLSearchParams();
    if (widgetType !== 'wc') params.set('type', widgetType);
    if (search) params.set('search', search);
    if (filter !== 'all') params.set('status', filter);
    if (contentTypeFilter !== 'all') params.set('template', contentTypeFilter);
    const queryString = params.toString();
    const newHash = queryString ? `#widgets?${queryString}` : '#widgets';
    if (window.location.hash !== newHash) {
      window.history.replaceState(null, '', newHash);
    }
  }, [widgetType, search, filter, contentTypeFilter]);
  const contentTypes = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => {
    const types = new Set();
    widgets.forEach(w => {
      if (w.content_type) {
        w.content_type.split(' ').forEach(t => {
          if (t && t !== 'woocommerce' && t !== 'edd' && t !== 'new') {
            types.add(t);
          }
        });
      }
    });
    return Array.from(types);
  }, [widgets]);
  const filteredWidgets = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => {
    return widgets.filter(w => {
      if (w.type !== 'checkbox') return false;
      if (search && !w.label.toLowerCase().includes(search.toLowerCase())) return false;
      if (filter === 'free' && w.widget_type !== 'free') return false;
      if (filter === 'pro' && w.widget_type !== 'pro') return false;
      if (contentTypeFilter !== 'all' && (!w.content_type || !w.content_type.includes(contentTypeFilter))) return false;
      return true;
    });
  }, [widgets, search, filter, contentTypeFilter]);
  const handleToggle = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useCallback)(name => {
    setLocalSettings(prev => ({
      ...prev,
      [name]: prev[name] === 'on' ? 'off' : 'on'
    }));
  }, []);
  const handleActivateAll = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useCallback)(() => {
    setLocalSettings(prev => {
      const updated = {
        ...prev
      };
      filteredWidgets.forEach(w => {
        if (w.widget_type === 'pro' && !isPro) return;
        updated[w.name] = 'on';
      });
      return updated;
    });
  }, [filteredWidgets, isPro]);
  const handleDeactivateAll = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useCallback)(() => {
    setLocalSettings(prev => {
      const updated = {
        ...prev
      };
      filteredWidgets.forEach(w => {
        if (w.widget_type === 'pro' && !isPro) return;
        updated[w.name] = 'off';
      });
      return updated;
    });
  }, [filteredWidgets, isPro]);
  const handleSave = () => {
    const currentSettings = {};
    widgets.forEach(w => {
      if (w.type === 'checkbox' && localSettings[w.name] !== undefined) {
        currentSettings[w.name] = localSettings[w.name];
      }
    });
    onSave(currentConfig.key, currentSettings);
  };
  const activeCount = Object.values(localSettings).filter(v => v === 'on').length;
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
    className: "usk-widgets-page",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "usk-widgets-page__header",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("h2", {
        className: "usk-widgets-page__title",
        children: currentConfig.title
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
        className: "usk-widgets-page__meta",
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("span", {
          className: "usk-widgets-page__count",
          children: [activeCount, " / ", widgets.filter(w => w.type === 'checkbox').length, ' ', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Active', 'ultimate-store-kit')]
        })
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "usk-widgets-page__toolbar",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "usk-widgets-page__search",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
          className: "dashicons dashicons-search"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("input", {
          type: "text",
          placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Search widgets...', 'ultimate-store-kit'),
          value: search,
          onChange: e => setSearch(e.target.value)
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "usk-widgets-page__filter-group",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("label", {
          className: "usk-select-label",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Widget Type:', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("select", {
          className: "usk-select",
          value: widgetType,
          onChange: e => setWidgetType(e.target.value),
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("option", {
            value: "wc",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('WooCommerce', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("option", {
            value: "edd",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('EDD', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("option", {
            value: "other",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Other', 'ultimate-store-kit')
          })]
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "usk-widgets-page__filter-group",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("label", {
          className: "usk-select-label",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Status:', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("select", {
          className: "usk-select",
          value: filter,
          onChange: e => setFilter(e.target.value),
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("option", {
            value: "all",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('All', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("option", {
            value: "free",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Free', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("option", {
            value: "pro",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Pro', 'ultimate-store-kit')
          })]
        })]
      }), contentTypes.length > 0 && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "usk-widgets-page__filter-group",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("label", {
          className: "usk-select-label",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Template:', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("select", {
          className: "usk-select",
          value: contentTypeFilter,
          onChange: e => setContentTypeFilter(e.target.value),
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("option", {
            value: "all",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('All Templates', 'ultimate-store-kit')
          }), contentTypes.map(type => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("option", {
            value: type,
            children: type.charAt(0).toUpperCase() + type.slice(1)
          }, type))]
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "usk-widgets-page__bulk",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("button", {
          className: "usk-btn usk-btn--small usk-btn--outline-green",
          onClick: handleActivateAll,
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Activate All', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("button", {
          className: "usk-btn usk-btn--small usk-btn--outline-red",
          onClick: handleDeactivateAll,
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Deactivate All', 'ultimate-store-kit')
        })]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "usk-widgets-grid",
      children: [filteredWidgets.length === 0 && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
        className: "usk-widgets-grid__empty",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('No widgets found.', 'ultimate-store-kit')
      }), filteredWidgets.map(widget => {
        const isProWidget = widget.widget_type === 'pro';
        const isDisabled = isProWidget && !isPro;
        const isActive = !isDisabled && localSettings[widget.name] === 'on';
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
          className: `usk-widget-card ${isActive ? 'usk-widget-card--active' : ''} ${isDisabled ? 'usk-widget-card--disabled' : ''}`,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
            className: "usk-widget-card__header",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              className: "usk-widget-card__name",
              children: widget.label
            }), isProWidget && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              className: "usk-widget-card__badge",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Pro', 'ultimate-store-kit')
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
            className: "usk-widget-card__footer",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
              className: "usk-widget-card__links",
              children: [widget.demo_url && !widget.demo_url.startsWith('#') && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("a", {
                href: widget.demo_url,
                target: "_blank",
                rel: "noopener noreferrer",
                title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Demo', 'ultimate-store-kit'),
                children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
                  className: "dashicons dashicons-visibility"
                })
              }), widget.video_url && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("a", {
                href: widget.video_url,
                target: "_blank",
                rel: "noopener noreferrer",
                title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Video', 'ultimate-store-kit'),
                children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
                  className: "dashicons dashicons-video-alt3"
                })
              })]
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("label", {
              className: "usk-toggle",
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("input", {
                type: "checkbox",
                checked: isActive,
                disabled: isDisabled,
                onChange: () => handleToggle(widget.name)
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
                className: "usk-toggle__slider"
              })]
            })]
          })]
        }, widget.name);
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
      className: "usk-widgets-page__footer",
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("button", {
        className: "usk-btn usk-btn--primary usk-btn--lg",
        onClick: handleSave,
        disabled: saving,
        children: saving ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Saving...', 'ultimate-store-kit') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Save Changes', 'ultimate-store-kit')
      })
    })]
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (WidgetsPage);

/***/ },

/***/ "./src/adminx/style.scss"
/*!*******************************!*\
  !*** ./src/adminx/style.scss ***!
  \*******************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ },

/***/ "react/jsx-runtime"
/*!**********************************!*\
  !*** external "ReactJSXRuntime" ***!
  \**********************************/
(module) {

module.exports = window["ReactJSXRuntime"];

/***/ },

/***/ "@wordpress/element"
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
(module) {

module.exports = window["wp"]["element"];

/***/ },

/***/ "@wordpress/i18n"
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
(module) {

module.exports = window["wp"]["i18n"];

/***/ }

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		if (!(moduleId in __webpack_modules__)) {
/******/ 			delete __webpack_module_cache__[moduleId];
/******/ 			var e = new Error("Cannot find module '" + moduleId + "'");
/******/ 			e.code = 'MODULE_NOT_FOUND';
/******/ 			throw e;
/******/ 		}
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"admin": 0,
/******/ 			"./style-admin": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = globalThis["webpackChunkultimate_store_kit"] = globalThis["webpackChunkultimate_store_kit"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-admin"], () => (__webpack_require__("./src/adminx/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=admin.js.map