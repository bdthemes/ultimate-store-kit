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
/* harmony import */ var _tw__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./tw */ "./src/adminx/tw.js");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__);












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
  const [isProActive, setIsProActive] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(!!adminData.isPro);
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
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)(_pages_Welcome__WEBPACK_IMPORTED_MODULE_4__["default"], {
          widgets: widgets,
          settings: settings,
          isPro: isProActive
        });
      case 'widgets':
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)(_pages_WidgetsPage__WEBPACK_IMPORTED_MODULE_5__["default"], {
          allWidgets: widgets,
          allSettings: settings,
          onSave: saveSettings,
          saving: saving,
          isPro: isProActive
        });
      case 'other-settings':
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)(_pages_OtherSettings__WEBPACK_IMPORTED_MODULE_6__["default"], {
          widgets: widgets.ultimate_store_kit_other_settings || [],
          section: "ultimate_store_kit_other_settings",
          settings: settings.ultimate_store_kit_other_settings || {},
          onSave: saveSettings,
          saving: saving,
          isPro: isProActive
        });
      case 'get-pro':
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)(_pages_GetPro__WEBPACK_IMPORTED_MODULE_7__["default"], {
          isPro: isProActive
        });
      case 'license':
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)(_pages_License__WEBPACK_IMPORTED_MODULE_8__["default"], {
          isPro: isProActive,
          onLicenseStatusChange: setIsProActive
        });
      case 'about':
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)(_pages_AboutInfo__WEBPACK_IMPORTED_MODULE_9__["default"], {});
      default:
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)(_pages_Welcome__WEBPACK_IMPORTED_MODULE_4__["default"], {
          widgets: widgets,
          settings: settings
        });
    }
  };
  const notifBase = 'animate-usk-slide-in mb-4 flex items-center justify-between rounded-lg px-4 py-2.5 text-[13px] font-medium';
  const notifSuccess = 'border border-emerald-200 bg-emerald-100 text-emerald-800';
  const notifError = 'border border-red-200 bg-red-100 text-red-900';
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsxs)("div", {
    className: _tw__WEBPACK_IMPORTED_MODULE_10__.appShell,
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)(_components_Header__WEBPACK_IMPORTED_MODULE_2__["default"], {
      version: adminData.version,
      isPro: isProActive
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsxs)("div", {
      className: _tw__WEBPACK_IMPORTED_MODULE_10__.bodyRow,
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)(_components_Sidebar__WEBPACK_IMPORTED_MODULE_3__["default"], {
        activePage: activePage,
        onNavigate: setActivePage,
        isPro: isProActive
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsxs)("div", {
        className: _tw__WEBPACK_IMPORTED_MODULE_10__.mainContent,
        children: [notification && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsxs)("div", {
          className: `${notifBase} ${notification.type === 'success' ? notifSuccess : notifError}`,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)("span", {
            children: notification.message
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)("button", {
            type: "button",
            onClick: () => setNotification(null),
            className: "cursor-pointer border-0 bg-transparent px-1 text-lg leading-none text-inherit",
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
  version,
  isPro
}) => {
  const helpUrl = 'https://bdthemes.com/knowledge-base/ultimate-store-kit/';
  const proUrl = 'https://bdthemes.com/ultimate-store-kit/pricing/';
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
    className: "sticky top-8 z-[100] border-b border-gray-200 bg-white px-6 py-4",
    children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "flex min-w-0 gap-4",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
          className: "flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-blue-600",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("svg", {
            className: "h-6 w-6 text-white",
            viewBox: "0 0 24 24",
            fill: "none",
            xmlns: "http://www.w3.org/2000/svg",
            "aria-hidden": "true",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
              d: "M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h10v2H4v-2z",
              fill: "currentColor",
              opacity: "0.9"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
              d: "M17 14l3 3-3 3",
              stroke: "currentColor",
              strokeWidth: "2",
              strokeLinecap: "round",
              strokeLinejoin: "round"
            })]
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
          className: "flex min-w-0 flex-col gap-1",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
            className: "flex flex-wrap items-center gap-2",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h1", {
              className: "m-0 text-xl font-bold leading-tight text-slate-800",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Ultimate Store Kit', 'ultimate-store-kit')
            }), version ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("span", {
              className: "rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500",
              children: ["v", version]
            }) : null]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
            className: "m-0 max-w-xl text-sm leading-snug text-gray-500",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Build high-converting WooCommerce stores with Elementor widgets, presets, and store-focused tools.', 'ultimate-store-kit')
          })]
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "flex shrink-0 flex-wrap items-center gap-3 sm:pt-1",
        children: [!isPro ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("a", {
          href: proUrl,
          target: "_blank",
          rel: "noopener noreferrer",
          className: "inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 transition-colors hover:border-blue-300 hover:text-blue-600",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
            className: "dashicons dashicons-star-filled text-base text-amber-500",
            "aria-hidden": "true"
          }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Get Pro', 'ultimate-store-kit')]
        }) : null, /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("a", {
          href: helpUrl,
          target: "_blank",
          rel: "noopener noreferrer",
          className: "inline-flex items-center gap-1.5 text-sm text-gray-600 transition-colors hover:text-blue-600",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
            className: "flex h-5 w-5 items-center justify-center rounded-full border border-gray-300 text-[11px] font-bold leading-none text-gray-500",
            "aria-hidden": "true",
            children: "?"
          }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Help & Support', 'ultimate-store-kit')]
        })]
      })]
    })
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Header);

/***/ },

/***/ "./src/adminx/components/ProPromo.js"
/*!*******************************************!*\
  !*** ./src/adminx/components/ProPromo.js ***!
  \*******************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _tw__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../tw */ "./src/adminx/tw.js");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__);



const promoSettings = [{
  group: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Sales Controls', 'ultimate-store-kit'),
  description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Configure flash sale banners, countdown timers, and promotional badges for your store.', 'ultimate-store-kit'),
  fields: [{
    name: 'enable_flash_sale',
    type: 'checkbox',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Enable Flash Sale Banner', 'ultimate-store-kit'),
    description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Display a site-wide flash sale banner on product pages.', 'ultimate-store-kit')
  }, {
    name: 'flash_sale_text',
    type: 'text',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Flash Sale Text', 'ultimate-store-kit'),
    placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('🔥 Flash Sale — Up to 50% OFF!', 'ultimate-store-kit')
  }, {
    name: 'sale_badge_style',
    type: 'select',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Sale Badge Style', 'ultimate-store-kit'),
    options: {
      default: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Default', 'ultimate-store-kit'),
      ribbon: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Ribbon', 'ultimate-store-kit'),
      circle: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Circle', 'ultimate-store-kit'),
      starburst: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Starburst', 'ultimate-store-kit')
    }
  }, {
    name: 'sale_badge_color',
    type: 'color',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Sale Badge Color', 'ultimate-store-kit'),
    value: '#ef4444'
  }, {
    name: 'enable_countdown_timer',
    type: 'checkbox',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Enable Sale Countdown Timer', 'ultimate-store-kit'),
    description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Show a countdown timer on products that have a sale end date.', 'ultimate-store-kit')
  }, {
    name: 'countdown_position',
    type: 'select',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Countdown Position', 'ultimate-store-kit'),
    options: {
      above_price: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Above Price', 'ultimate-store-kit'),
      below_price: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Below Price', 'ultimate-store-kit'),
      above_button: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Above Add to Cart', 'ultimate-store-kit')
    }
  }, {
    name: 'minimum_discount_percent',
    type: 'number',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Minimum Discount % to Show Badge', 'ultimate-store-kit'),
    value: '5',
    description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Only show the sale badge when the discount is at least this percentage.', 'ultimate-store-kit')
  }]
}];
const ProPromo = () => {
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
    className: "pointer-events-none relative mt-6 select-none opacity-70",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "pointer-events-auto mb-4 flex items-center justify-between rounded-usk border border-amber-400 bg-gradient-to-br from-amber-100 to-amber-200 px-5 py-3.5",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "flex items-center gap-2.5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
          className: "rounded-[10px] bg-gradient-to-br from-amber-500 to-orange-500 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Pro', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
          className: "text-sm font-semibold text-amber-900",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Unlock these premium settings with Ultimate Store Kit Pro', 'ultimate-store-kit')
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("a", {
        href: "https://bdthemes.com/ultimate-store-kit/",
        target: "_blank",
        rel: "noopener noreferrer",
        className: `${_tw__WEBPACK_IMPORTED_MODULE_1__.btnSm} ${_tw__WEBPACK_IMPORTED_MODULE_1__.btnPrimary}`,
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Get Pro', 'ultimate-store-kit')
      })]
    }), promoSettings.map((group, gi) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
      className: "relative mb-4 overflow-hidden rounded-usk border border-slate-200 bg-white",
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "border-l-[3px] border-amber-400",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("h3", {
          className: "m-0 flex flex-wrap items-center gap-2 border-b border-slate-200 bg-slate-100 px-5 py-3.5 text-sm font-bold text-slate-800",
          children: [group.group, /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
            className: _tw__WEBPACK_IMPORTED_MODULE_1__.proBadge,
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Pro', 'ultimate-store-kit')
          })]
        }), group.description && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
          className: "m-0 px-5 pt-1 text-[13px] leading-relaxed text-slate-400",
          children: group.description
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
          className: "px-5 py-2 opacity-60",
          children: group.fields.map(field => {
            if (field.type === 'checkbox') {
              return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
                className: `${_tw__WEBPACK_IMPORTED_MODULE_1__.fieldRow} flex-wrap`,
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
                  className: _tw__WEBPACK_IMPORTED_MODULE_1__.fieldLabel,
                  children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
                    children: field.label
                  })
                }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
                  className: "h-[22px] w-10 rounded-full bg-slate-200"
                }), field.description && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
                  className: "mt-1 w-full text-xs leading-snug text-slate-400",
                  children: field.description
                })]
              }, field.name);
            }
            if (field.type === 'select') {
              return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
                className: _tw__WEBPACK_IMPORTED_MODULE_1__.fieldRow,
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("label", {
                  className: _tw__WEBPACK_IMPORTED_MODULE_1__.fieldLabel,
                  children: field.label
                }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("select", {
                  className: `${_tw__WEBPACK_IMPORTED_MODULE_1__.fieldControl} cursor-not-allowed opacity-60`,
                  disabled: true,
                  defaultValue: Object.keys(field.options)[0],
                  children: Object.entries(field.options).map(([val, lbl]) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("option", {
                    value: val,
                    children: lbl
                  }, val))
                })]
              }, field.name);
            }
            if (field.type === 'color') {
              return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
                className: _tw__WEBPACK_IMPORTED_MODULE_1__.fieldRow,
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("label", {
                  className: _tw__WEBPACK_IMPORTED_MODULE_1__.fieldLabel,
                  children: field.label
                }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("input", {
                  type: "color",
                  disabled: true,
                  value: field.value || '#000000',
                  readOnly: true,
                  className: "h-8 w-12 cursor-not-allowed rounded-md border border-slate-200 p-0.5 opacity-60"
                })]
              }, field.name);
            }
            if (field.type === 'number' || field.type === 'text') {
              return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
                className: _tw__WEBPACK_IMPORTED_MODULE_1__.fieldRow,
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("label", {
                  className: _tw__WEBPACK_IMPORTED_MODULE_1__.fieldLabel,
                  children: field.label
                }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("input", {
                  type: field.type,
                  className: `${_tw__WEBPACK_IMPORTED_MODULE_1__.fieldControl} cursor-not-allowed opacity-60`,
                  disabled: true,
                  placeholder: field.placeholder || '',
                  defaultValue: field.value || '',
                  readOnly: true
                }), field.description && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
                  className: "mt-1 w-full text-xs leading-snug text-slate-400",
                  children: field.description
                })]
              }, field.name);
            }
            return null;
          })
        })]
      })
    }, gi))]
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ProPromo);

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
  group: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Dashboard', 'ultimate-store-kit'),
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
    icon: 'dashicons-admin-widgets'
  }]
}, {
  group: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Settings', 'ultimate-store-kit'),
  items: [{
    id: 'other',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Other Settings', 'ultimate-store-kit'),
    icon: 'dashicons-admin-settings'
  }, {
    id: 'license',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('License', 'ultimate-store-kit'),
    icon: 'dashicons-admin-network'
  }]
}, {
  group: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Support', 'ultimate-store-kit'),
  items: [{
    id: 'getpro',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Get Pro', 'ultimate-store-kit'),
    icon: 'dashicons-star-filled'
  }, {
    id: 'about',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('About & Info', 'ultimate-store-kit'),
    icon: 'dashicons-info'
  }]
}];
const groupHeadingClass = 'mb-3 px-2 text-[11px] font-semibold uppercase tracking-widest text-gray-500';
const Sidebar = ({
  activePage,
  onNavigate,
  isPro
}) => {
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
    className: "sticky top-[7.5rem] z-[90] flex w-64 shrink-0 flex-col self-stretch justify-between border border-solid border-gray-100 bg-white px-4 py-6 rounded-lg",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("nav", {
      className: "flex flex-col gap-6",
      "aria-label": "Main",
      children: navItems.map(section => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
          className: `m-0 ${groupHeadingClass}`,
          children: section.group
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("ul", {
          className: "m-0 list-none space-y-1 p-0",
          children: section.items.map(item => {
            const isActive = activePage === item.id;
            return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("li", {
              children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("button", {
                type: "button",
                onClick: () => onNavigate(item.id),
                className: `flex w-full cursor-pointer items-center gap-3 rounded-lg border-0 px-3 py-2.5 text-left text-[13px] font-medium transition-colors ${isActive ? 'bg-blue-500 text-white shadow-sm' : 'bg-transparent text-slate-700 hover:bg-gray-100'}`,
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
                  className: `dashicons ${item.icon} shrink-0 text-lg ${isActive ? 'text-white' : 'text-gray-400'}`,
                  "aria-hidden": "true"
                }), item.label]
              })
            }, item.id);
          })
        })]
      }, section.group))
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
      className: "mt-8 px-2",
      children: isPro ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
        className: "rounded-lg bg-emerald-500 px-3 py-2.5 text-center text-xs font-bold uppercase tracking-wide text-white shadow-sm",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Pro activated!', 'ultimate-store-kit')
      }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "rounded-lg border border-dashed border-gray-200 bg-gray-50 px-3 py-3 text-center",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
          className: "m-0 text-[11px] font-semibold uppercase tracking-wide text-gray-400",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Coming soon', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
          className: "mt-1.5 m-0 text-xs leading-snug text-gray-500",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('More store widgets & presets in future updates.', 'ultimate-store-kit')
        })]
      })
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
const linkCard = 'font-semibold text-uks-brand no-underline hover:underline';
const AboutInfo = () => {
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "mb-4 rounded-usk border border-slate-200 bg-white p-8 text-center",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
        className: "mb-3",
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
        className: "mb-2 text-[22px] font-extrabold text-slate-800",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Ultimate Store Kit', 'ultimate-store-kit')
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("span", {
        className: "mb-3 inline-block rounded-xl bg-uks-brand px-3 py-0.5 text-xs font-semibold text-white",
        children: ["v", adminData.version || '']
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
        className: "mx-auto mb-0 max-w-[540px] text-[13px] leading-relaxed text-slate-500",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Build online stores in WordPress with the powerful store builder addon for Elementor. Enjoy a wide range of customizations and easily build product grids, carousels, single product/page elements, checkouts and more.', 'ultimate-store-kit')
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "mb-4 grid grid-cols-2 gap-3",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "rounded-usk border border-slate-200 bg-white px-5 py-4",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h3", {
          className: "mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Author', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
          className: "m-0 text-sm",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://bdthemes.com/",
            target: "_blank",
            rel: "noopener noreferrer",
            className: linkCard,
            children: "BdThemes"
          })
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "rounded-usk border border-slate-200 bg-white px-5 py-4",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h3", {
          className: "mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Website', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
          className: "m-0 text-sm",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://storekit.pro/",
            target: "_blank",
            rel: "noopener noreferrer",
            className: linkCard,
            children: "storekit.pro"
          })
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "rounded-usk border border-slate-200 bg-white px-5 py-4",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h3", {
          className: "mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Documentation', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
          className: "m-0 text-sm",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://bdthemes.com/all-knowledge-base-of-ultimate-store-kit/",
            target: "_blank",
            rel: "noopener noreferrer",
            className: linkCard,
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Knowledge Base', 'ultimate-store-kit')
          })
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "rounded-usk border border-slate-200 bg-white px-5 py-4",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h3", {
          className: "mb-1 text-xs font-semibold uppercase tracking-wide text-slate-400",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Support', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
          className: "m-0 text-sm",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://bdthemes.com/support/",
            target: "_blank",
            rel: "noopener noreferrer",
            className: linkCard,
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Get Support', 'ultimate-store-kit')
          })
        })]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "mb-4 rounded-usk border border-slate-200 bg-white p-5",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h3", {
        className: "mb-3 text-sm font-bold text-slate-800",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Useful Links', 'ultimate-store-kit')
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("ul", {
        className: "m-0 list-none p-0",
        children: [['https://www.youtube.com/c/bdthemes', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Video Tutorials', 'ultimate-store-kit')], ['https://feedback.bdthemes.com/b/6vr2250l/feature-requests/', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Request a Feature', 'ultimate-store-kit')], ['https://wordpress.org/plugins/ultimate-store-kit/', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Rate Us on WordPress.org', 'ultimate-store-kit')], ['https://www.facebook.com/groups/developer.developer/', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Join Our Facebook Community', 'ultimate-store-kit')]].map(([href, label]) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("li", {
          className: "border-b border-slate-100 py-1.5 last:border-b-0",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: href,
            target: "_blank",
            rel: "noopener noreferrer",
            className: "text-[13px] text-slate-700 no-underline hover:text-uks-brand",
            children: label
          })
        }, href))
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
      className: "p-4 text-center",
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("p", {
        className: "m-0 text-xs text-slate-400",
        children: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Ultimate Store Kit Addon made with love by', 'ultimate-store-kit'), ' ', /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
          target: "_blank",
          rel: "noopener noreferrer",
          href: "https://bdthemes.com",
          className: "text-uks-brand no-underline",
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
/* harmony import */ var _tw__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../tw */ "./src/adminx/tw.js");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__);



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
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "rounded-usk border border-slate-200 bg-white p-10 text-center",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("h2", {
          className: "mb-2 text-uks-brand",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('You already have Pro!', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
          className: "m-0 text-slate-500",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Thank you for being a Pro user. You have access to all features.', 'ultimate-store-kit')
        })]
      })
    });
  }
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "mb-6 flex items-center justify-between rounded-usk border border-slate-200 bg-white p-6",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("h2", {
          className: "mb-1 text-xl font-extrabold text-slate-800",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('WHY GO WITH PRO?', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
          className: "m-0 text-[13px] text-slate-500",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Just Compare With Ultimate Store Kit Free Vs Pro', 'ultimate-store-kit')
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("a", {
        href: "https://storekit.pro/pricing",
        target: "_blank",
        rel: "noopener noreferrer",
        className: `${_tw__WEBPACK_IMPORTED_MODULE_1__.btnLg} ${_tw__WEBPACK_IMPORTED_MODULE_1__.btnPrimary}`,
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Purchase Now', 'ultimate-store-kit')
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "mb-6 overflow-hidden rounded-usk border border-slate-200 bg-white",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "grid grid-cols-[2fr_1fr_1fr] bg-slate-800 px-5 py-3.5 text-center text-[13px] font-bold text-white",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
          className: "text-left",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Features', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Free', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Pro', 'ultimate-store-kit')
        })]
      }), features.map((f, i) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "grid grid-cols-[2fr_1fr_1fr] items-center border-b border-slate-100 px-5 py-3 text-center text-[13px] last:border-b-0 even:bg-slate-100",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
          className: "text-left font-medium text-slate-700",
          children: f.label
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
          children: f.free ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
            className: "dashicons dashicons-yes-alt text-uks-brand"
          }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
            className: "dashicons dashicons-dismiss text-red-500"
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
          children: f.pro ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
            className: "dashicons dashicons-yes-alt text-uks-brand"
          }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
            className: "dashicons dashicons-dismiss text-red-500"
          })
        })]
      }, i))]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "rounded-usk border border-slate-200 bg-white p-6",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
        className: "mb-5 grid grid-cols-[repeat(auto-fill,minmax(220px,1fr))] gap-3",
        children: highlights.map((h, i) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
          className: "flex items-center gap-2 text-[13px] text-slate-700",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
            className: "dashicons dashicons-heart text-sm text-red-500"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
            children: h
          })]
        }, i))
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
        className: "border-t border-slate-200 pt-3 text-center",
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("a", {
          href: "https://storekit.pro/pricing",
          target: "_blank",
          rel: "noopener noreferrer",
          className: `${_tw__WEBPACK_IMPORTED_MODULE_1__.btnLg} ${_tw__WEBPACK_IMPORTED_MODULE_1__.btnPrimary}`,
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
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _tw__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../tw */ "./src/adminx/tw.js");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__);




const adminData = window.ultimateStoreKitAdminData || {};
const getRestHeaders = () => ({
  'Content-Type': 'application/json',
  'X-WP-Nonce': adminData.restNonce
});
const msgBar = 'animate-usk-slide-in mb-5 flex items-center justify-between rounded-lg px-4 py-2.5 text-[13px] font-medium';
const License = ({
  isPro,
  onLicenseStatusChange
}) => {
  const initialLicenseData = adminData.licenseData || {};
  const [licenseData, setLicenseData] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(initialLicenseData);
  const [licenseKey, setLicenseKey] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)('');
  const [licenseEmail, setLicenseEmail] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(initialLicenseData.license_email || '');
  const [loading, setLoading] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [message, setMessage] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(initialLicenseData.show_message ? {
    type: 'error',
    text: initialLicenseData.license_message || ''
  } : null);
  const isActivated = licenseData.is_activated || false;
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (!adminData.restUrl) {
      return;
    }
    fetch(`${adminData.restUrl}status`, {
      method: 'GET',
      headers: getRestHeaders()
    }).then(res => res.json()).then(response => {
      if (response.success && response.license_data) {
        setLicenseData(response.license_data);
        setLicenseEmail(response.license_data.license_email || '');
        if (onLicenseStatusChange) {
          onLicenseStatusChange(true);
        }
      } else if (response.error_message) {
        if (onLicenseStatusChange) {
          onLicenseStatusChange(false);
        }
        setMessage({
          type: 'error',
          text: response.error_message
        });
      }
    }).catch(() => {});
  }, []);
  const handleActivate = e => {
    e.preventDefault();
    if (!licenseKey || !licenseEmail) {
      setMessage({
        type: 'error',
        text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Please provide both license key and email address.', 'ultimate-store-kit')
      });
      return;
    }
    setLoading(true);
    setMessage(null);
    fetch(`${adminData.restUrl}activate`, {
      method: 'POST',
      headers: getRestHeaders(),
      body: JSON.stringify({
        license_key: licenseKey,
        email: licenseEmail
      })
    }).then(res => res.json()).then(response => {
      if (response.success) {
        setLicenseData(response.license_data);
        if (onLicenseStatusChange) {
          onLicenseStatusChange(true);
        }
        setMessage({
          type: 'success',
          text: response.message || (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('License activated successfully!', 'ultimate-store-kit')
        });
        setLicenseKey('');
      } else {
        if (onLicenseStatusChange) {
          onLicenseStatusChange(false);
        }
        setMessage({
          type: 'error',
          text: response.message || (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('License activation failed.', 'ultimate-store-kit')
        });
      }
    }).catch(() => {
      setMessage({
        type: 'error',
        text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('An error occurred. Please try again.', 'ultimate-store-kit')
      });
    }).finally(() => {
      setLoading(false);
    });
  };
  const handleDeactivate = () => {
    if (!window.confirm((0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Are you sure you want to deactivate the license?', 'ultimate-store-kit'))) {
      return;
    }
    setLoading(true);
    setMessage(null);
    fetch(`${adminData.restUrl}deactivate`, {
      method: 'DELETE',
      headers: getRestHeaders()
    }).then(res => res.json()).then(response => {
      if (response.success) {
        setLicenseData({});
        if (onLicenseStatusChange) {
          onLicenseStatusChange(false);
        }
        setLicenseEmail('');
        setLicenseKey('');
        setMessage({
          type: 'success',
          text: response.message || (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('License deactivated successfully.', 'ultimate-store-kit')
        });
      } else {
        setMessage({
          type: 'error',
          text: response.message || (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Failed to deactivate license.', 'ultimate-store-kit')
        });
      }
    }).catch(() => {
      setMessage({
        type: 'error',
        text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('An error occurred. Please try again.', 'ultimate-store-kit')
      });
    }).finally(() => {
      setLoading(false);
    });
  };
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
    className: "max-w-[640px]",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
      className: "mb-4 rounded-usk border border-slate-200 bg-white p-8",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("h2", {
        className: "mb-5 text-xl font-bold text-slate-800",
        children: isActivated ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Ultimate Store Kit License Info', 'ultimate-store-kit') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Activate Your License', 'ultimate-store-kit')
      }), message && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: `${msgBar} ${message.type === 'success' ? 'border border-emerald-200 bg-emerald-100 text-emerald-800' : 'border border-red-200 bg-red-100 text-red-900'}`,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
          children: message.text
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("button", {
          type: "button",
          onClick: () => setMessage(null),
          className: "cursor-pointer border-0 bg-transparent px-1 text-lg leading-none text-inherit",
          children: "\xD7"
        })]
      }), isActivated ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "block",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("ul", {
          className: "m-0 mb-6 list-none p-0",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("li", {
            className: "flex items-center justify-between border-b border-slate-100 py-3 text-[13px] last:border-b-0",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "font-semibold text-slate-600",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Status', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: `rounded-[10px] px-3 py-0.5 text-xs font-semibold ${licenseData.is_valid ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-900'}`,
              children: licenseData.is_valid ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Valid', 'ultimate-store-kit') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Invalid', 'ultimate-store-kit')
            })]
          }), licenseData.license_title && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("li", {
            className: "flex items-center justify-between border-b border-slate-100 py-3 text-[13px] last:border-b-0",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "font-semibold text-slate-600",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('License Type', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "text-slate-700",
              children: licenseData.license_title
            })]
          }), licenseData.expire_date && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("li", {
            className: "flex items-center justify-between border-b border-slate-100 py-3 text-[13px] last:border-b-0",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "font-semibold text-slate-600",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('License Expires', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("span", {
              className: "flex items-center gap-2 text-slate-700",
              children: [licenseData.expire_date, licenseData.expire_renew_link && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
                href: licenseData.expire_renew_link,
                target: "_blank",
                rel: "noopener noreferrer",
                className: "rounded border border-uks-brand px-2.5 py-0.5 text-xs font-semibold text-uks-brand no-underline transition-all hover:bg-uks-brand hover:text-white",
                children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Renew', 'ultimate-store-kit')
              })]
            })]
          }), licenseData.support_end && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("li", {
            className: "flex items-center justify-between border-b border-slate-100 py-3 text-[13px] last:border-b-0",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "font-semibold text-slate-600",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Support Expires', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("span", {
              className: "flex items-center gap-2 text-slate-700",
              children: [licenseData.support_end, licenseData.support_renew_link && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
                href: licenseData.support_renew_link,
                target: "_blank",
                rel: "noopener noreferrer",
                className: "rounded border border-uks-brand px-2.5 py-0.5 text-xs font-semibold text-uks-brand no-underline transition-all hover:bg-uks-brand hover:text-white",
                children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Renew', 'ultimate-store-kit')
              })]
            })]
          }), licenseData.masked_key && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("li", {
            className: "flex items-center justify-between border-b border-slate-100 py-3 text-[13px] last:border-b-0",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "font-semibold text-slate-600",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('License Key', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "font-mono text-xs tracking-wide text-slate-500",
              children: licenseData.masked_key
            })]
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("div", {
          className: "mt-1 flex gap-2",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("button", {
            type: "button",
            onClick: handleDeactivate,
            disabled: loading,
            className: _tw__WEBPACK_IMPORTED_MODULE_2__.btnOutlineRed,
            children: loading ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Deactivating...', 'ultimate-store-kit') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Deactivate License', 'ultimate-store-kit')
          })
        })]
      }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "mt-0",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("p", {
          className: "mb-4 text-[13px] leading-relaxed text-slate-500",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Enter your license key and registered email to unlock Pro features and receive automatic updates.', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("ol", {
          className: "mb-6 list-decimal pl-5 text-[13px] leading-loose text-slate-600",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("li", {
            children: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Log in to your BdThemes account to get your license key.', 'ultimate-store-kit'), ' ', /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
              href: "https://bdthemes.onfastspring.com/account",
              target: "_blank",
              rel: "noopener noreferrer",
              className: "font-semibold text-uks-brand no-underline hover:underline",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Go to account', 'ultimate-store-kit')
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("li", {
            children: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("If you don't yet have a license key,", 'ultimate-store-kit'), ' ', /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
              href: "https://storekit.pro/pricing/",
              target: "_blank",
              rel: "noopener noreferrer",
              className: "font-semibold text-uks-brand no-underline hover:underline",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('get Ultimate Store Kit Pro now', 'ultimate-store-kit')
            }), "."]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("li", {
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Copy the license key from your account and paste it below.', 'ultimate-store-kit')
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("form", {
          onSubmit: handleActivate,
          className: "flex flex-col gap-4",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex flex-col gap-1.5",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("label", {
              htmlFor: "usk-license-key",
              className: "text-[13px] font-semibold text-slate-700",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('License Key', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("input", {
              type: "text",
              id: "usk-license-key",
              className: _tw__WEBPACK_IMPORTED_MODULE_2__.licenseInput,
              value: licenseKey,
              onChange: e => setLicenseKey(e.target.value),
              placeholder: "xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx",
              required: true
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex flex-col gap-1.5",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("label", {
              htmlFor: "usk-license-email",
              className: "text-[13px] font-semibold text-slate-700",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Email Address', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("input", {
              type: "email",
              id: "usk-license-email",
              className: _tw__WEBPACK_IMPORTED_MODULE_2__.licenseInput,
              value: licenseEmail,
              onChange: e => setLicenseEmail(e.target.value),
              placeholder: "example@email.com",
              required: true
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "mt-1 flex gap-2",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("button", {
              type: "submit",
              disabled: loading,
              className: _tw__WEBPACK_IMPORTED_MODULE_2__.btnPrimary,
              children: loading ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Activating...', 'ultimate-store-kit') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Activate License', 'ultimate-store-kit')
            }), !isPro && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
              href: "https://storekit.pro/pricing/",
              target: "_blank",
              rel: "noopener noreferrer",
              className: _tw__WEBPACK_IMPORTED_MODULE_2__.btnSecondary,
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Get Pro License', 'ultimate-store-kit')
            })]
          })]
        })]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
      className: "p-4 text-center",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("p", {
        className: "my-0.5 text-xs text-slate-400",
        children: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Ultimate Store Kit Addon made with love by', 'ultimate-store-kit'), ' ', /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
          target: "_blank",
          rel: "noopener noreferrer",
          href: "https://bdthemes.com",
          className: "text-uks-brand no-underline",
          children: "BdThemes"
        }), ' ', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Team.', 'ultimate-store-kit')]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("p", {
        className: "my-0.5 text-xs text-slate-400",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('All rights reserved by BdThemes.', 'ultimate-store-kit')
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
/* harmony import */ var _components_ProPromo__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/ProPromo */ "./src/adminx/components/ProPromo.js");
/* harmony import */ var _tw__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../tw */ "./src/adminx/tw.js");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__);





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
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
      className: "mb-5",
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("h2", {
        className: "m-0 text-xl font-bold text-slate-800",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Other Settings', 'ultimate-store-kit')
      })
    }), groups.map((group, gi) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
      className: "mb-4 overflow-hidden rounded-usk border border-slate-200 bg-white",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("h3", {
        className: "m-0 border-b border-slate-200 bg-slate-100 px-5 py-3.5 text-sm font-bold text-slate-800",
        children: group.label
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
        className: "px-5 py-2",
        children: group.items.map(item => {
          const isProItem = item.widget_type === 'pro';
          const dependency = item.dependency || null;
          const hasMissingDependency = dependency && (!dependency.isInstalled || !dependency.isActive);
          const isDisabled = isProItem && !isPro || hasMissingDependency;
          if (item.type === 'checkbox') {
            const isOn = !isDisabled && localSettings[item.name] === 'on';
            return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
              className: "border-b border-slate-100 py-2.5 last:border-b-0",
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
                className: "flex items-center justify-between gap-3",
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
                  className: `${_tw__WEBPACK_IMPORTED_MODULE_3__.fieldLabel} max-w-[70%] flex-wrap`,
                  children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("span", {
                    children: [item.label, hasMissingDependency && dependency?.actionUrl ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.Fragment, {
                      children: [' ', /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("a", {
                        href: dependency.actionUrl,
                        target: dependency.actionType === 'install' ? '_blank' : undefined,
                        rel: dependency.actionType === 'install' ? 'noopener noreferrer' : undefined,
                        className: "font-semibold text-uks-brand hover:underline",
                        children: dependency.actionLabel
                      })]
                    }) : null]
                  }), isProItem && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
                    className: _tw__WEBPACK_IMPORTED_MODULE_3__.proBadge,
                    children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Pro', 'ultimate-store-kit')
                  })]
                }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("label", {
                  className: _tw__WEBPACK_IMPORTED_MODULE_3__.toggleLabel,
                  children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("input", {
                    type: "checkbox",
                    className: _tw__WEBPACK_IMPORTED_MODULE_3__.toggleInput,
                    checked: isOn,
                    disabled: isDisabled,
                    onChange: () => handleChange(item.name, isOn ? 'off' : 'on')
                  }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
                    className: _tw__WEBPACK_IMPORTED_MODULE_3__.toggleTrack
                  }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
                    className: _tw__WEBPACK_IMPORTED_MODULE_3__.toggleKnob
                  })]
                })]
              }), hasMissingDependency && dependency?.message && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
                className: "mt-2 text-[13px] leading-relaxed text-slate-500",
                children: dependency.message
              })]
            }, item.name);
          }
          if (item.type === 'select') {
            return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
              className: _tw__WEBPACK_IMPORTED_MODULE_3__.fieldRow,
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("label", {
                className: _tw__WEBPACK_IMPORTED_MODULE_3__.fieldLabel,
                children: item.label
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("select", {
                className: _tw__WEBPACK_IMPORTED_MODULE_3__.fieldControl,
                value: localSettings[item.name] || '',
                onChange: e => handleChange(item.name, e.target.value),
                disabled: isDisabled,
                children: item.options && Object.entries(item.options).map(([val, lbl]) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("option", {
                  value: val,
                  children: lbl
                }, val))
              })]
            }, item.name);
          }
          if (item.type === 'number' || item.type === 'text') {
            return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
              className: _tw__WEBPACK_IMPORTED_MODULE_3__.fieldRow,
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("label", {
                className: _tw__WEBPACK_IMPORTED_MODULE_3__.fieldLabel,
                children: item.label
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("input", {
                type: item.type,
                className: _tw__WEBPACK_IMPORTED_MODULE_3__.fieldControl,
                value: localSettings[item.name] || '',
                onChange: e => handleChange(item.name, e.target.value),
                disabled: isDisabled
              })]
            }, item.name);
          }
          return null;
        })
      })]
    }, gi)), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
      className: "mt-6 flex justify-end pt-4",
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("button", {
        type: "button",
        className: `${_tw__WEBPACK_IMPORTED_MODULE_3__.btnLg} ${_tw__WEBPACK_IMPORTED_MODULE_3__.btnPrimary}`,
        onClick: handleSave,
        disabled: saving,
        children: saving ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Saving...', 'ultimate-store-kit') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Save Changes', 'ultimate-store-kit')
      })
    }), !isPro && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_components_ProPromo__WEBPACK_IMPORTED_MODULE_2__["default"], {})]
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
/* harmony import */ var _tw__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../tw */ "./src/adminx/tw.js");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__);




const linkInline = 'font-semibold text-uks-brand hover:underline';
const Welcome = ({
  widgets,
  settings
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
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
      className: "rounded-usk border border-slate-200 bg-white p-4",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("h3", {
        className: "mb-3 text-[13px] font-semibold uppercase tracking-wide text-slate-500",
        children: title
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "flex items-center justify-between gap-3",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
          className: "flex flex-col gap-1",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex gap-1.5 text-[13px] text-slate-700",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "text-slate-400",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Active:', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("strong", {
              children: data.active
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex gap-1.5 text-[13px] text-slate-700",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "text-slate-400",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Inactive:', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("strong", {
              children: data.inactive
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex gap-1.5 text-[13px] text-slate-700",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "text-slate-400",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Total:', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("strong", {
              children: data.total
            })]
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("div", {
          className: "h-[60px] w-[60px] shrink-0",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("svg", {
            viewBox: "0 0 36 36",
            className: "h-full w-full",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
              d: "M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831",
              fill: "none",
              stroke: "#e2e8f0",
              strokeWidth: "3"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
              d: "M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831",
              fill: "none",
              stroke: color,
              strokeWidth: "3",
              strokeDasharray: `${percentage}, 100`
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("text", {
              x: "18",
              y: "20.5",
              className: "font-bold",
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
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
      className: "mb-6 grid grid-cols-4 gap-4",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(StatCard, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('All Widgets', 'ultimate-store-kit'),
        data: stats.all,
        color: "#f59e0b"
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(StatCard, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('WooCommerce', 'ultimate-store-kit'),
        data: stats.wc,
        color: "#ef4444"
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(StatCard, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('EDD', 'ultimate-store-kit'),
        data: stats.edd,
        color: "#10b981"
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(StatCard, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Other', 'ultimate-store-kit'),
        data: stats.other,
        color: "#3b82f6"
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
      className: "mb-4 grid grid-cols-2 gap-4",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "rounded-usk border border-slate-200 bg-white p-5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("h3", {
          className: "mb-2 text-[15px] font-bold text-slate-800",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Support And Feedback', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("p", {
          className: "my-2 text-[13px] leading-relaxed text-slate-500",
          children: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Feeling like to consult with an expert? Take live Chat support immediately from', 'ultimate-store-kit'), ' ', /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
            href: "https://storekit.pro/",
            target: "_blank",
            rel: "noopener noreferrer",
            className: linkInline,
            children: "UltimateStoreKit"
          }), ".", ' ', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('We are always ready to help you 24/7.', 'ultimate-store-kit')]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("p", {
          className: "my-2 text-[13px] leading-relaxed text-slate-500",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("strong", {
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)("Or if you're facing technical issues with our plugin, then please create a support ticket", 'ultimate-store-kit')
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
          className: "mt-3 flex flex-wrap gap-2",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
            className: _tw__WEBPACK_IMPORTED_MODULE_2__.btnPrimary,
            target: "_blank",
            rel: "noopener noreferrer",
            href: "https://bdthemes.com/all-knowledge-base-of-ultimate-store-kit/",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Knowledge Base', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
            className: _tw__WEBPACK_IMPORTED_MODULE_2__.btnSecondary,
            target: "_blank",
            rel: "noopener noreferrer",
            href: "https://bdthemes.com/support/",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Get Support', 'ultimate-store-kit')
          })]
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "rounded-usk border border-slate-200 bg-white p-5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("h3", {
          className: "mb-2 text-[15px] font-bold text-slate-800",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('System Requirement', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("p", {
          className: "mb-3 text-[13px] leading-relaxed text-slate-500",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Make sure your server meets the minimum requirements for optimal performance.', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex items-center justify-between border-b border-slate-100 py-2 text-[13px] text-slate-700 last:border-b-0",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('PHP Version', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "rounded-[10px] bg-emerald-100 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-800",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('OK', 'ultimate-store-kit')
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex items-center justify-between border-b border-slate-100 py-2 text-[13px] text-slate-700 last:border-b-0",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Memory Limit', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "rounded-[10px] bg-emerald-100 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-800",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('OK', 'ultimate-store-kit')
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex items-center justify-between border-b border-slate-100 py-2 text-[13px] text-slate-700 last:border-b-0",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Max Execution Time', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "rounded-[10px] bg-emerald-100 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-800",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('OK', 'ultimate-store-kit')
            })]
          })]
        })]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
      className: "mb-4 grid grid-cols-2 gap-4",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "rounded-usk border border-slate-200 bg-white p-5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("h3", {
          className: "mb-2 text-[15px] font-bold text-slate-800",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Feedback', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("p", {
          className: "my-2 text-[13px] leading-relaxed text-slate-500",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('We are always looking for feedback from our users. If you have any suggestions or feedback, please let us know.', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("div", {
          className: "mt-3 flex flex-wrap gap-2",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
            className: _tw__WEBPACK_IMPORTED_MODULE_2__.btnSecondary,
            target: "_blank",
            rel: "noopener noreferrer",
            href: "https://feedback.bdthemes.com/b/6vr2250l/feature-requests/",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Request Feature', 'ultimate-store-kit')
          })
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "rounded-usk border border-slate-200 bg-white p-5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("h3", {
          className: "mb-2 text-[15px] font-bold text-slate-800",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Try Our Other Plugins', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("p", {
          className: "my-2 text-[13px] leading-relaxed text-slate-500",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Element Pack, Prime Slider, Ultimate Post Kit, Pixel Gallery & Live Copy Paste addons for Elementor.', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
          className: "mt-3 flex flex-wrap gap-2",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
            className: `${_tw__WEBPACK_IMPORTED_MODULE_2__.btnSm} ${_tw__WEBPACK_IMPORTED_MODULE_2__.btnEp}`,
            target: "_blank",
            rel: "noopener noreferrer",
            href: "https://wordpress.org/plugins/bdthemes-element-pack-lite/",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Element Pack', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
            className: `${_tw__WEBPACK_IMPORTED_MODULE_2__.btnSm} ${_tw__WEBPACK_IMPORTED_MODULE_2__.btnPs}`,
            target: "_blank",
            rel: "noopener noreferrer",
            href: "https://wordpress.org/plugins/bdthemes-prime-slider-lite/",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Prime Slider', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
            className: `${_tw__WEBPACK_IMPORTED_MODULE_2__.btnSm} ${_tw__WEBPACK_IMPORTED_MODULE_2__.btnUpk}`,
            target: "_blank",
            rel: "noopener noreferrer",
            href: "https://wordpress.org/plugins/ultimate-post-kit/",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Ultimate Post Kit', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
            className: `${_tw__WEBPACK_IMPORTED_MODULE_2__.btnSm} ${_tw__WEBPACK_IMPORTED_MODULE_2__.btnPg}`,
            target: "_blank",
            rel: "noopener noreferrer",
            href: "https://wordpress.org/plugins/pixel-gallery/",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Pixel Gallery', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
            className: `${_tw__WEBPACK_IMPORTED_MODULE_2__.btnSm} ${_tw__WEBPACK_IMPORTED_MODULE_2__.btnZb}`,
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
/* harmony import */ var _tw__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../tw */ "./src/adminx/tw.js");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__);




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
  const cardBase = 'flex flex-col justify-between gap-3 rounded-usk border border-slate-200 bg-white p-4 transition-all duration-200 hover:shadow-usk';
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
      className: "mb-5 flex items-center justify-between",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("h2", {
        className: "m-0 text-xl font-bold text-slate-800",
        children: currentConfig.title
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("div", {
        className: "flex items-center gap-2",
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("span", {
          className: "rounded-2xl border border-slate-200 bg-white px-3 py-1 text-[13px] text-slate-500",
          children: [activeCount, " / ", widgets.filter(w => w.type === 'checkbox').length, ' ', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Active', 'ultimate-store-kit')]
        })
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
      className: "mb-5 flex flex-wrap items-center gap-3 rounded-usk border border-slate-200 bg-white px-4 py-3",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "flex flex-[0_0_220px] items-center gap-1.5 rounded-md border border-slate-200 bg-slate-100 px-2.5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
          className: "dashicons dashicons-search h-4 w-4 text-base text-slate-400"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("input", {
          type: "text",
          className: "w-full border-0 bg-transparent py-1.5 text-[13px] text-slate-700 outline-none placeholder:text-slate-400",
          placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Search widgets...', 'ultimate-store-kit'),
          value: search,
          onChange: e => setSearch(e.target.value)
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "flex items-center gap-1.5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("label", {
          className: _tw__WEBPACK_IMPORTED_MODULE_2__.selectLabel,
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Widget Type:', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("select", {
          className: _tw__WEBPACK_IMPORTED_MODULE_2__.selectInput,
          value: widgetType,
          onChange: e => setWidgetType(e.target.value),
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("option", {
            value: "wc",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('WooCommerce', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("option", {
            value: "edd",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('EDD', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("option", {
            value: "other",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Other', 'ultimate-store-kit')
          })]
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "flex items-center gap-1.5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("label", {
          className: _tw__WEBPACK_IMPORTED_MODULE_2__.selectLabel,
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Status:', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("select", {
          className: _tw__WEBPACK_IMPORTED_MODULE_2__.selectInput,
          value: filter,
          onChange: e => setFilter(e.target.value),
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("option", {
            value: "all",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('All', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("option", {
            value: "free",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Free', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("option", {
            value: "pro",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Pro', 'ultimate-store-kit')
          })]
        })]
      }), contentTypes.length > 0 && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "flex items-center gap-1.5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("label", {
          className: _tw__WEBPACK_IMPORTED_MODULE_2__.selectLabel,
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Template:', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("select", {
          className: _tw__WEBPACK_IMPORTED_MODULE_2__.selectInput,
          value: contentTypeFilter,
          onChange: e => setContentTypeFilter(e.target.value),
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("option", {
            value: "all",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('All Templates', 'ultimate-store-kit')
          }), contentTypes.map(type => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("option", {
            value: type,
            children: type.charAt(0).toUpperCase() + type.slice(1)
          }, type))]
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "ml-auto flex gap-1.5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("button", {
          type: "button",
          className: `${_tw__WEBPACK_IMPORTED_MODULE_2__.btnSm} ${_tw__WEBPACK_IMPORTED_MODULE_2__.btnOutlineGreen}`,
          onClick: handleActivateAll,
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Activate All', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("button", {
          type: "button",
          className: `${_tw__WEBPACK_IMPORTED_MODULE_2__.btnSm} ${_tw__WEBPACK_IMPORTED_MODULE_2__.btnOutlineRed}`,
          onClick: handleDeactivateAll,
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Deactivate All', 'ultimate-store-kit')
        })]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
      className: "grid grid-cols-4 gap-3",
      children: [filteredWidgets.length === 0 && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("div", {
        className: "col-span-full py-10 text-center text-sm text-slate-400",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('No widgets found.', 'ultimate-store-kit')
      }), filteredWidgets.map(widget => {
        const isProWidget = widget.widget_type === 'pro';
        const dependency = widget.dependency || null;
        const hasMissingDependency = dependency && (!dependency.isInstalled || !dependency.isActive);
        const isDisabled = isProWidget && !isPro || hasMissingDependency;
        const isActive = !isDisabled && localSettings[widget.name] === 'on';
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
          className: `${cardBase} ${isActive ? 'border-emerald-300 bg-emerald-50' : ''} ${isDisabled ? 'opacity-60' : ''}`,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex items-start justify-between gap-2",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "text-[13px] font-semibold leading-snug text-slate-800",
              children: widget.label
            }), isProWidget && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: _tw__WEBPACK_IMPORTED_MODULE_2__.proBadge,
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Pro', 'ultimate-store-kit')
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex items-center justify-between",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
              className: "flex gap-2",
              children: [dependency?.actionUrl && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
                href: dependency.actionUrl,
                target: dependency.actionType === 'install' ? '_blank' : undefined,
                rel: dependency.actionType === 'install' ? 'noopener noreferrer' : undefined,
                title: dependency.message || dependency.actionLabel,
                className: "text-slate-400 transition-colors hover:text-uks-brand",
                children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
                  className: "dashicons dashicons-admin-plugins text-base"
                })
              }), widget.demo_url && !widget.demo_url.startsWith('#') && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
                href: widget.demo_url,
                target: "_blank",
                rel: "noopener noreferrer",
                title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Demo', 'ultimate-store-kit'),
                className: "text-slate-400 transition-colors hover:text-uks-brand",
                children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
                  className: "dashicons dashicons-visibility text-base"
                })
              }), widget.video_url && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
                href: widget.video_url,
                target: "_blank",
                rel: "noopener noreferrer",
                title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Video', 'ultimate-store-kit'),
                className: "text-slate-400 transition-colors hover:text-uks-brand",
                children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
                  className: "dashicons dashicons-video-alt3 text-base"
                })
              })]
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("label", {
              className: _tw__WEBPACK_IMPORTED_MODULE_2__.toggleLabel,
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("input", {
                type: "checkbox",
                className: _tw__WEBPACK_IMPORTED_MODULE_2__.toggleInput,
                checked: isActive,
                disabled: isDisabled,
                onChange: () => handleToggle(widget.name)
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
                className: _tw__WEBPACK_IMPORTED_MODULE_2__.toggleTrack
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
                className: _tw__WEBPACK_IMPORTED_MODULE_2__.toggleKnob
              })]
            })]
          }), hasMissingDependency && dependency?.actionUrl && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "text-[13px] leading-relaxed text-slate-500",
            children: [dependency.message, ' ', /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
              href: dependency.actionUrl,
              className: "font-semibold text-uks-brand hover:underline",
              target: dependency.actionType === 'install' ? '_blank' : undefined,
              rel: dependency.actionType === 'install' ? 'noopener noreferrer' : undefined,
              children: dependency.actionLabel
            })]
          })]
        }, widget.name);
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("div", {
      className: "mt-6 flex justify-end pt-4",
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("button", {
        type: "button",
        className: `${_tw__WEBPACK_IMPORTED_MODULE_2__.btnLg} ${_tw__WEBPACK_IMPORTED_MODULE_2__.btnPrimary}`,
        onClick: handleSave,
        disabled: saving,
        children: saving ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Saving...', 'ultimate-store-kit') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Save Changes', 'ultimate-store-kit')
      })
    })]
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (WidgetsPage);

/***/ },

/***/ "./src/adminx/tw.js"
/*!**************************!*\
  !*** ./src/adminx/tw.js ***!
  \**************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   appShell: () => (/* binding */ appShell),
/* harmony export */   bodyRow: () => (/* binding */ bodyRow),
/* harmony export */   btnEp: () => (/* binding */ btnEp),
/* harmony export */   btnLg: () => (/* binding */ btnLg),
/* harmony export */   btnOutlineGreen: () => (/* binding */ btnOutlineGreen),
/* harmony export */   btnOutlineRed: () => (/* binding */ btnOutlineRed),
/* harmony export */   btnPg: () => (/* binding */ btnPg),
/* harmony export */   btnPrimary: () => (/* binding */ btnPrimary),
/* harmony export */   btnPs: () => (/* binding */ btnPs),
/* harmony export */   btnSecondary: () => (/* binding */ btnSecondary),
/* harmony export */   btnSm: () => (/* binding */ btnSm),
/* harmony export */   btnUpk: () => (/* binding */ btnUpk),
/* harmony export */   btnZb: () => (/* binding */ btnZb),
/* harmony export */   fieldControl: () => (/* binding */ fieldControl),
/* harmony export */   fieldLabel: () => (/* binding */ fieldLabel),
/* harmony export */   fieldRow: () => (/* binding */ fieldRow),
/* harmony export */   licenseInput: () => (/* binding */ licenseInput),
/* harmony export */   mainContent: () => (/* binding */ mainContent),
/* harmony export */   proBadge: () => (/* binding */ proBadge),
/* harmony export */   selectInput: () => (/* binding */ selectInput),
/* harmony export */   selectLabel: () => (/* binding */ selectLabel),
/* harmony export */   toggleInput: () => (/* binding */ toggleInput),
/* harmony export */   toggleKnob: () => (/* binding */ toggleKnob),
/* harmony export */   toggleLabel: () => (/* binding */ toggleLabel),
/* harmony export */   toggleTrack: () => (/* binding */ toggleTrack)
/* harmony export */ });
/**
 * Shared Tailwind class strings for adminx (no @apply in SCSS).
 * Specificity scope: tailwind.config.js `important` = `.ultimate-store-kit-admin-root` (PHP wrapper).
 */

const appShell = 'flex min-h-[calc(100vh-100px)] flex-col bg-slate-50 m-5 ml-0 font-sans';

/** Row under header: stretch columns to same height so sidebar bg fills to content bottom. */
const bodyRow = 'flex flex-1 items-stretch p-5 gap-5';

/** Main column grows with page; min-w-0 avoids flex overflow quirks. */
const mainContent = 'min-w-0 flex-1';

/* Buttons */
const btnBase = 'inline-flex cursor-pointer items-center gap-1.5 rounded-md border border-transparent px-[18px] py-2 text-[13px] font-semibold leading-snug no-underline transition-all duration-200 disabled:cursor-not-allowed disabled:opacity-60';
const btnPrimary = `${btnBase} border-uks-brand bg-uks-brand text-white hover:bg-uks-brand-dark`;
const btnSecondary = `${btnBase} border-slate-300 bg-white text-slate-700 hover:bg-slate-100 hover:text-slate-800`;
const btnLg = `${btnBase} px-6 py-2.5 text-sm`;
const btnSm = `${btnBase} px-3 py-1 text-xs`;
const btnOutlineGreen = `${btnBase} border-uks-brand bg-transparent text-uks-brand hover:bg-uks-brand hover:text-white`;
const btnOutlineRed = `${btnBase} border-red-500 bg-transparent text-red-500 hover:bg-red-500 hover:text-white`;
const btnEp = `${btnBase} border-indigo-500 bg-indigo-500 text-white hover:opacity-90`;
const btnPs = `${btnBase} border-pink-500 bg-pink-500 text-white hover:opacity-90`;
const btnUpk = `${btnBase} border-orange-500 bg-orange-500 text-white hover:opacity-90`;
const btnPg = `${btnBase} border-violet-500 bg-violet-500 text-white hover:opacity-90`;
const btnZb = `${btnBase} border-teal-500 bg-teal-500 text-white hover:opacity-90`;

/* Form */
const selectLabel = 'whitespace-nowrap text-xs font-semibold text-slate-600';
const selectInput = 'min-w-[140px] cursor-pointer rounded-md border border-slate-200 bg-white px-3 py-1.5 text-[13px] text-slate-700 transition-all duration-200 hover:border-slate-300 focus:border-uks-brand focus:outline-none focus:ring-2 focus:ring-emerald-500';
const fieldRow = 'flex items-center justify-between border-b border-slate-100 py-2.5 last:border-b-0';
const fieldLabel = 'flex items-center gap-2 text-[13px] font-medium text-slate-700';
const fieldControl = 'min-w-[120px] rounded-md border border-slate-200 bg-white px-3 py-1.5 text-[13px] text-slate-700 focus:border-uks-brand focus:outline-none focus:ring-2 focus:ring-emerald-500 disabled:cursor-not-allowed disabled:opacity-50';
const licenseInput = 'w-full rounded-md border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 transition-all duration-200 placeholder:text-slate-400 focus:border-uks-brand focus:outline-none focus:ring-2 focus:ring-emerald-500';

/* Toggle — input uses peer; track + knob are siblings after input */
const toggleLabel = 'relative inline-block h-[22px] w-10 cursor-pointer';
const toggleInput = 'peer sr-only';
const toggleTrack = 'pointer-events-none absolute inset-0 rounded-full bg-slate-300 transition-colors peer-checked:bg-uks-brand peer-disabled:opacity-50';
const toggleKnob = 'pointer-events-none absolute bottom-[3px] left-[3px] z-[1] h-4 w-4 rounded-full bg-white shadow-sm transition-transform peer-checked:translate-x-[18px]';

/* Pro badge on cards */
const proBadge = 'shrink-0 whitespace-nowrap rounded-[10px] bg-gradient-to-br from-amber-500 to-orange-500 px-2 py-0.5 text-[10px] font-bold text-white';

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