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
  const validPages = ['welcome', 'widgets', 'woocommerce-widgets', 'edd-widgets', 'other-widgets', 'other-settings', 'get-pro', 'license', 'about'];
  return validPages.includes(pageName) ? pageName : 'welcome';
};
const App = () => {
  const [activePage, setActivePage] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(getPageFromHash());
  const [settings, setSettings] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(adminData.savedSettings || {});
  const [isProActive, setIsProActive] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(!!adminData.isPro);
  const [saving, setSaving] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [notification, setNotification] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
  const [isSidebarOpen, setIsSidebarOpen] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [isDesktop, setIsDesktop] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(() => window.innerWidth > 1024);
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
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    // Pro users don't need Get Pro page; redirect if opened directly.
    if (isProActive && activePage === 'get-pro') {
      setActivePage('welcome');
      window.location.hash = '#welcome';
    }
  }, [isProActive, activePage]);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    setIsSidebarOpen(false);
  }, [activePage]);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    document.body.style.overflow = isSidebarOpen ? 'hidden' : '';
    return () => {
      document.body.style.overflow = '';
    };
  }, [isSidebarOpen]);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    const handleResize = () => {
      const desktop = window.innerWidth > 1024;
      setIsDesktop(desktop);
      if (desktop) {
        setIsSidebarOpen(false);
      }
    };
    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, []);
  const handleToggleSidebar = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useCallback)(event => {
    if (event?.preventDefault) event.preventDefault();
    if (event?.stopPropagation) event.stopPropagation();
    setIsSidebarOpen(prev => !prev);
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
      case 'woocommerce-widgets':
      case 'edd-widgets':
      case 'other-widgets':
        const widgetTypeMap = {
          'woocommerce-widgets': 'wc',
          'edd-widgets': 'edd',
          'other-widgets': 'other',
          'widgets': 'wc'
        };
        return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)(_pages_WidgetsPage__WEBPACK_IMPORTED_MODULE_5__["default"], {
          allWidgets: widgets,
          allSettings: settings,
          onSave: saveSettings,
          saving: saving,
          isPro: isProActive,
          widgetType: widgetTypeMap[activePage]
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
        return isProActive ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)(_pages_Welcome__WEBPACK_IMPORTED_MODULE_4__["default"], {
          widgets: widgets,
          settings: settings,
          isPro: isProActive
        }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)(_pages_GetPro__WEBPACK_IMPORTED_MODULE_7__["default"], {
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
      isPro: isProActive,
      isSidebarOpen: isSidebarOpen,
      isDesktop: isDesktop,
      onToggleSidebar: handleToggleSidebar
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)("div", {
      className: "bg-slate-50",
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsxs)("div", {
        className: `${_tw__WEBPACK_IMPORTED_MODULE_10__.bodyRow} flex-col lg:flex-row`,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)(_components_Sidebar__WEBPACK_IMPORTED_MODULE_3__["default"], {
          activePage: activePage,
          onNavigate: setActivePage,
          isPro: isProActive,
          isOpen: isSidebarOpen,
          isDesktop: isDesktop,
          onClose: () => setIsSidebarOpen(false)
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsxs)("div", {
          className: `${_tw__WEBPACK_IMPORTED_MODULE_10__.mainContent} flex flex-col`,
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
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)("div", {
            className: "flex-1",
            children: renderPage()
          })]
        })]
      })
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsxs)("footer", {
      className: "p-5 bg-white py-4 text-center text-sm text-slate-500 rounded-bl-lg rounded-br-lg",
      children: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Ultimate Store Kit Addon made with love by', 'ultimate-store-kit'), ' ', /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_11__.jsx)("a", {
        target: "_blank",
        rel: "noopener noreferrer",
        href: "https://bdthemes.com",
        className: "text-uks-brand no-underline hover:underline",
        children: "BdThemes"
      }), ". ", (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('All rights reserved.', 'ultimate-store-kit')]
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
/* harmony import */ var _tw__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../tw */ "./src/adminx/tw.js");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__);



const Header = ({
  version,
  isPro,
  onToggleSidebar,
  isSidebarOpen,
  isDesktop
}) => {
  const helpUrl = 'https://bdthemes.com/knowledge-base/ultimate-store-kit/';
  const proUrl = 'https://bdthemes.com/ultimate-store-kit/pricing/';
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
    className: "rounded-tl-lg rounded-tr-lg border-0 border-b border-solid border-b-gray-100 bg-white px-4 py-3 sm:px-6 sm:py-4",
    children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "flex min-w-0 items-center gap-3 sm:gap-4",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
          className: "flex",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
            className: "block h-10 w-10 sm:h-12 sm:w-12",
            version: "1.1",
            id: "Layer_1",
            xmlns: "http://www.w3.org/2000/svg",
            xmlnsXlink: "http://www.w3.org/1999/xlink",
            x: "0px",
            y: "0px",
            viewBox: "0 0 500 500",
            style: {
              enableBackground: "new 0 0 500 500"
            },
            xmlSpace: "preserve",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("style", {
              type: "text/css",
              dangerouslySetInnerHTML: {
                __html: "\n\t.st0{fill:#E30C1D;enable-background:new    ;}\n\t.st1{fill:#FFFFFF;}\n"
              }
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              className: "st0",
              d: "M473.6,496.4h-447c-12.6,0-22.9-10.2-22.9-22.9v-447c0-12.4,10.2-22.9,22.9-22.9h446.8 c12.6,0,22.9,10.2,22.9,22.9v446.8C496.3,486.3,486.2,496.4,473.6,496.4z"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("g", {
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
                className: "st1",
                d: "M374.3,364l-21.1-157.6c-1.9-14.3-14.2-25-28.6-25c0,0-0.1,0-0.1,0l-143.7,0.7c-14.5,0.1-26.8,11-28.5,25.4 l-18.6,156.9c-1,8.2,1.6,16.4,7.1,22.5s13.3,9.7,21.5,9.7h183.5c8.3,0,16.2-3.6,21.7-9.8C372.9,380.6,375.4,372.3,374.3,364z M186.4,217.1l132.8-0.6l6.4,47.6c-34.1,4.4-61,23.4-78.4,55.7c-8.5,15.8-12.9,31.5-15,41.9h-63L186.4,217.1z M268.1,361.7 c1.9-7.3,5-16.3,9.9-25.3c12-22.3,29.2-34.7,52.2-37.6l8.4,62.9H268.1z"
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
                className: "st1",
                d: "M212.4,169.2c8.8,0,16-7.2,16-16c0-13.9,11.3-25.3,25.3-25.3c13.9,0,25.3,11.3,25.3,25.3c0,8.8,7.2,16,16,16 s16-7.2,16-16c0-31.6-25.7-57.3-57.3-57.3c-31.6,0-57.3,25.7-57.3,57.3C196.4,162.1,203.6,169.2,212.4,169.2z"
              })]
            })]
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
          className: "flex min-w-0 flex-col gap-1",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
            className: "flex flex-wrap items-center gap-2",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("h1", {
              className: "m-0 text-lg font-bold leading-tight text-slate-800 sm:text-xl",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Ultimate Store Kit', 'ultimate-store-kit')
            }), version ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("span", {
              className: "rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500",
              children: ["v", version]
            }) : null]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
            className: "m-0 max-w-xl text-[13px] leading-snug text-gray-500 sm:text-sm",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Build high-converting WooCommerce stores with Elementor widgets & presets.', 'ultimate-store-kit')
          })]
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "flex shrink-0 flex-wrap items-center gap-2",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("button", {
          type: "button",
          onClick: e => onToggleSidebar?.(e),
          className: "inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-md border border-slate-200 bg-white text-slate-700 transition-colors hover:border-uks-brand/40 hover:text-uks-brand",
          style: {
            display: isDesktop ? 'none' : 'inline-flex'
          },
          "aria-expanded": isSidebarOpen ? 'true' : 'false',
          "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Open menu', 'ultimate-store-kit'),
          children: isSidebarOpen ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
            xmlns: "http://www.w3.org/2000/svg",
            viewBox: "0 0 24 24",
            fill: "none",
            stroke: "currentColor",
            strokeWidth: 2,
            strokeLinecap: "round",
            strokeLinejoin: "round",
            className: "h-4 w-4",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "M18 6 6 18"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "m6 6 12 12"
            })]
          }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
            xmlns: "http://www.w3.org/2000/svg",
            viewBox: "0 0 24 24",
            fill: "none",
            stroke: "currentColor",
            strokeWidth: 2,
            strokeLinecap: "round",
            strokeLinejoin: "round",
            className: "h-4 w-4",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "M4 6h16"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "M4 12h16"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "M4 18h16"
            })]
          })
        }), !isPro ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("a", {
          href: proUrl,
          target: "_blank",
          rel: "noopener noreferrer",
          className: `${_tw__WEBPACK_IMPORTED_MODULE_1__.btnSm} ${_tw__WEBPACK_IMPORTED_MODULE_1__.btnPrimary}`,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("svg", {
            xmlns: "http://www.w3.org/2000/svg",
            width: 24,
            height: 24,
            viewBox: "0 0 24 24",
            fill: "none",
            stroke: "currentColor",
            strokeWidth: 2,
            strokeLinecap: "round",
            strokeLinejoin: "round",
            className: "w-4 h-4 block",
            children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"
            })
          }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Get Pro', 'ultimate-store-kit')]
        }) : null, /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("a", {
          href: helpUrl,
          target: "_blank",
          rel: "noopener noreferrer",
          className: `${_tw__WEBPACK_IMPORTED_MODULE_1__.btnSm} ${_tw__WEBPACK_IMPORTED_MODULE_1__.btnSecondary} flex items-center gap-2 hover:border-uks-brand/40 hover:bg-white hover:text-uks-brand`,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
            className: "flex h-4 w-4 items-center justify-center rounded-full border border-current text-inherit",
            "aria-hidden": "true",
            children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
              xmlns: "http://www.w3.org/2000/svg",
              width: 24,
              height: 24,
              viewBox: "0 0 24 24",
              fill: "none",
              stroke: "currentColor",
              strokeWidth: 2,
              strokeLinecap: "round",
              strokeLinejoin: "round",
              className: "w-4 h-4 block",
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
                d: "M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 1 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z"
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
                d: "M21 16v2a4 4 0 0 1-4 4h-5"
              })]
            })
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
    className: "pointer-events-none relative select-none opacity-70",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "pointer-events-auto mb-4 flex items-center justify-between rounded-usk border border-uks-brand bg-[linear-gradient(313deg,#E62A3F_0%,#00216A_100%)] px-5 py-3.5",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "flex items-center gap-2.5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
          className: "rounded-[10px] bg-[linear-gradient(313deg,#E62A3F_0%,#00216A_100%)] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Pro', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
          className: "text-sm font-semibold text-white/90",
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
        className: "border-l-[3px] border-uks-brand",
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
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__);



const navItems = [{
  group: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Dashboard', 'ultimate-store-kit'),
  items: [{
    id: 'welcome',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Welcome', 'ultimate-store-kit'),
    icon: 'home'
  }]
}, {
  group: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Widgets', 'ultimate-store-kit'),
  items: [{
    id: 'woocommerce-widgets',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('WooCommerce', 'ultimate-store-kit'),
    icon: 'woocommerce'
  }, {
    id: 'edd-widgets',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('EDD', 'ultimate-store-kit'),
    icon: 'edd'
  }, {
    id: 'other-widgets',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Others', 'ultimate-store-kit'),
    icon: 'other'
  }]
}, {
  group: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Settings', 'ultimate-store-kit'),
  items: [{
    id: 'other-settings',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Other Settings', 'ultimate-store-kit'),
    icon: 'settings'
  }, {
    id: 'license',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('License', 'ultimate-store-kit'),
    icon: 'badge'
  }]
}, {
  group: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Support', 'ultimate-store-kit'),
  items: [{
    id: 'get-pro',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Get Pro', 'ultimate-store-kit'),
    icon: 'star'
  }, {
    id: 'about',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('About & Info', 'ultimate-store-kit'),
    icon: 'info'
  }]
}];
const groupHeadingClass = 'mb-3 px-2 text-xs font-semibold uppercase tracking-widest text-gray-400';
const Icon = ({
  name
}) => {
  const common = 'h-5 w-5 block color-current';
  switch (name) {
    case 'home':
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: 24,
        height: 24,
        viewBox: "0 0 24 24",
        fill: "none",
        stroke: "currentColor",
        strokeWidth: 2,
        strokeLinecap: "round",
        strokeLinejoin: "round",
        className: common,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
          d: "M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
          d: "M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"
        })]
      });
    case 'grid':
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: 24,
        height: 24,
        viewBox: "0 0 24 24",
        fill: "none",
        stroke: "currentColor",
        strokeWidth: 2,
        strokeLinecap: "round",
        strokeLinejoin: "round",
        className: common,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("rect", {
          width: 7,
          height: 9,
          x: 3,
          y: 3,
          rx: 1
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("rect", {
          width: 7,
          height: 5,
          x: 14,
          y: 3,
          rx: 1
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("rect", {
          width: 7,
          height: 9,
          x: 14,
          y: 12,
          rx: 1
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("rect", {
          width: 7,
          height: 5,
          x: 3,
          y: 16,
          rx: 1
        })]
      });
    case 'settings':
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: 24,
        height: 24,
        viewBox: "0 0 24 24",
        fill: "none",
        stroke: "currentColor",
        strokeWidth: 2,
        strokeLinecap: "round",
        strokeLinejoin: "round",
        className: common,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
          d: "M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("circle", {
          cx: 12,
          cy: 12,
          r: 3
        })]
      });
    case 'badge':
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: 24,
        height: 24,
        viewBox: "0 0 24 24",
        fill: "none",
        stroke: "currentColor",
        strokeWidth: 2,
        strokeLinecap: "round",
        strokeLinejoin: "round",
        className: common,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
          d: "M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("circle", {
          cx: "16.5",
          cy: "7.5",
          r: ".5",
          fill: "currentColor"
        })]
      });
    case 'star':
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: 24,
        height: 24,
        viewBox: "0 0 24 24",
        fill: "none",
        stroke: "currentColor",
        strokeWidth: 2,
        strokeLinecap: "round",
        strokeLinejoin: "round",
        className: common,
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
          d: "M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"
        })
      });
    case 'woocommerce':
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: 24,
        height: 24,
        viewBox: "0 0 24 24",
        fill: "none",
        stroke: "currentColor",
        strokeWidth: 2,
        strokeLinecap: "round",
        strokeLinejoin: "round",
        className: common,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("circle", {
          cx: 9,
          cy: 9,
          r: 2
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
          d: "M20 11.5v-1a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h2"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
          d: "M4 15h12a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-2"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
          d: "M22 15h-4"
        })]
      });
    case 'edd':
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: 24,
        height: 24,
        viewBox: "0 0 24 24",
        fill: "none",
        stroke: "currentColor",
        strokeWidth: 2,
        strokeLinecap: "round",
        strokeLinejoin: "round",
        className: common,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
          d: "M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
          d: "m7.5 4.21 4.5 2.6 4.5-2.6"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
          d: "M12 17.5V12"
        })]
      });
    case 'other':
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: 24,
        height: 24,
        viewBox: "0 0 24 24",
        fill: "none",
        stroke: "currentColor",
        strokeWidth: 2,
        strokeLinecap: "round",
        strokeLinejoin: "round",
        className: common,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("rect", {
          width: 7,
          height: 9,
          x: 3,
          y: 3,
          rx: 1
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("rect", {
          width: 7,
          height: 5,
          x: 14,
          y: 3,
          rx: 1
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("rect", {
          width: 7,
          height: 9,
          x: 14,
          y: 12,
          rx: 1
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("rect", {
          width: 7,
          height: 5,
          x: 3,
          y: 16,
          rx: 1
        })]
      });
    case 'info':
    default:
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: 24,
        height: 24,
        viewBox: "0 0 24 24",
        fill: "none",
        stroke: "currentColor",
        strokeWidth: 2,
        strokeLinecap: "round",
        strokeLinejoin: "round",
        className: common,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("circle", {
          cx: 12,
          cy: 12,
          r: 10
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
          d: "M12 16v-4"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
          d: "M12 8h.01"
        })]
      });
  }
};
const getAdminBarHeight = () => document.getElementById('wpadminbar')?.offsetHeight || 0;
const Sidebar = ({
  activePage,
  onNavigate,
  isPro,
  isOpen,
  isDesktop,
  onClose
}) => {
  const [showComingSoon, setShowComingSoon] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(true);
  const content = /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.Fragment, {
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("nav", {
      className: "flex flex-col gap-6",
      "aria-label": "Main",
      children: navItems.map(section => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
          className: `m-0 ${groupHeadingClass}`,
          children: section.group
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("ul", {
          className: "m-0 list-none space-y-1 p-0",
          children: section.items.filter(item => !(isPro && item.id === 'get-pro')).map(item => {
            const isActive = window.location.hash.includes(item.id);
            return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("li", {
              children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("button", {
                type: "button",
                onClick: () => {
                  onNavigate(item.id.split('?')[0]);
                  window.location.hash = `#${item.id}`;
                  onClose();
                },
                className: `flex w-full cursor-pointer items-center gap-3 rounded-lg border-0 px-3 py-3 text-left text-sm font-medium transition-colors ${isActive ? 'bg-uks-brand text-white shadow-sm' : 'bg-transparent text-slate-700 hover:bg-gray-100 hover:text-slate-900'}`,
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(Icon, {
                  name: item.icon
                }), item.label]
              })
            }, item.id);
          })
        })]
      }, section.group))
    }), showComingSoon && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
      className: "mt-6 hidden rounded-xl bg-slate-100 p-4 lg:block lg:mt-8",
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "relative ",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("button", {
          type: "button",
          onClick: () => setShowComingSoon(false),
          className: "absolute right-1 top-1 inline-flex cursor-pointer items-center justify-center border-0 bg-transparent text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600",
          "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Close', 'ultimate-store-kit'),
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
            xmlns: "http://www.w3.org/2000/svg",
            width: 24,
            height: 24,
            viewBox: "0 0 24 24",
            fill: "none",
            stroke: "currentColor",
            strokeWidth: 2,
            strokeLinecap: "round",
            strokeLinejoin: "round",
            className: "w-4 h-4 block",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "M18 6 6 18"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "m6 6 12 12"
            })]
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("span", {
          className: "mb-2.5 text-base font-bold text-slate-800 flex items-center gap-2",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
            xmlns: "http://www.w3.org/2000/svg",
            width: 24,
            height: 24,
            viewBox: "0 0 24 24",
            fill: "none",
            stroke: "currentColor",
            strokeWidth: 2,
            strokeLinecap: "round",
            strokeLinejoin: "round",
            className: "w-5 h-5",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "M12 2v4"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "m16.2 7.8 2.9-2.9"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "M18 12h4"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "m16.2 16.2 2.9 2.9"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "M12 18v4"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "m4.9 19.1 2.9-2.9"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "M2 12h4"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "m4.9 4.9 2.9 2.9"
            })]
          }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Coming soon', 'ultimate-store-kit')]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
          className: "m-0 text-[12px] leading-relaxed text-slate-600",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('New items planned for upcoming updates:', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("ul", {
          className: "mt-2.5 m-0 space-y-1.5 p-0 text-[12px] text-slate-600",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("li", {
            className: "flex items-start gap-2",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              className: "mt-1 h-1.5 w-1.5 rounded-full bg-uks-brand"
            }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('7+ WooCommerce widgets', 'ultimate-store-kit')]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("li", {
            className: "flex items-start gap-2",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              className: "mt-1 h-1.5 w-1.5 rounded-full bg-uks-brand"
            }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Template-based presets', 'ultimate-store-kit')]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("li", {
            className: "flex items-start gap-2",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              className: "mt-1 h-1.5 w-1.5 rounded-full bg-uks-brand"
            }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Performance-focused improvements', 'ultimate-store-kit')]
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("button", {
          onClick: () => window.open('https://feedback.bdthemes.com/b/6vr2250l/feature-requests', '_blank'),
          type: "button",
          className: "mt-3 inline-flex cursor-pointer items-center rounded-lg border border-uks-brand bg-white px-3 py-1.5 text-[12px] font-semibold text-uks-brand transition-colors hover:bg-uks-brand hover:text-white",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('See roadmap', 'ultimate-store-kit')
        })]
      })
    })]
  });
  if (isDesktop) {
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
      style: {
        display: 'flex'
      },
      className: "w-64 shrink-0 flex-col justify-between self-stretch rounded-lg border border-solid border-gray-100 bg-white px-4 py-6 lg:sticky lg:top-[7.5rem]",
      children: content
    });
  }
  const adminBarH = getAdminBarHeight();
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.Fragment, {
    children: [isOpen && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
      style: {
        display: 'block',
        position: 'fixed',
        top: adminBarH,
        left: 0,
        right: 0,
        bottom: 0,
        zIndex: 99998,
        backgroundColor: 'rgba(0,0,0,0.3)'
      },
      onClick: onClose,
      "aria-hidden": "true"
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      style: {
        position: 'fixed',
        left: 0,
        top: adminBarH,
        zIndex: 99999,
        height: `calc(100vh - ${adminBarH}px)`,
        width: '86vw',
        maxWidth: '320px',
        display: 'flex',
        flexDirection: 'column',
        backgroundColor: '#fff',
        padding: '1rem',
        boxShadow: '4px 0 24px rgba(0,0,0,0.15)',
        transform: isOpen ? 'translateX(0)' : 'translateX(-100%)',
        transition: 'transform 300ms ease-out',
        pointerEvents: isOpen ? 'auto' : 'none',
        overflowY: 'auto'
      },
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "mb-3 flex items-center justify-between",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
          className: "m-0 text-sm font-bold text-slate-700",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Navigation', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("button", {
          type: "button",
          onClick: onClose,
          className: "inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-md border border-slate-200 bg-white text-slate-500 hover:text-slate-700",
          "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Close menu', 'ultimate-store-kit'),
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("svg", {
            xmlns: "http://www.w3.org/2000/svg",
            viewBox: "0 0 24 24",
            fill: "none",
            stroke: "currentColor",
            strokeWidth: 2,
            strokeLinecap: "round",
            strokeLinejoin: "round",
            className: "h-4 w-4",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "M18 6 6 18"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
              d: "m6 6 12 12"
            })]
          })
        })]
      }), content]
    })]
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Sidebar);

/***/ },

/***/ "./src/adminx/components/Toggle.js"
/*!*****************************************!*\
  !*** ./src/adminx/components/Toggle.js ***!
  \*****************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__);

/**
 * Smooth Toggle switch component.
 * Uses inline styles exclusively so WordPress admin CSS cannot
 * override transform/transition via stylesheet specificity.
 */
const BRAND = '#00216A';
const OFF_BG = '#cbd5e1';

// Spring-like easing: fast start, gentle settle
const EASE = 'cubic-bezier(0.34, 1.56, 0.64, 1)';
const EASE_BG = 'cubic-bezier(0.4, 0, 0.2, 1)';
const Toggle = ({
  checked,
  onChange,
  disabled
}) => {
  const trackStyle = {
    position: 'absolute',
    inset: 0,
    borderRadius: '9999px',
    background: checked ? BRAND : OFF_BG,
    transition: `background 0.25s ${EASE_BG}`,
    opacity: disabled ? 0.45 : 1,
    pointerEvents: 'none',
    willChange: 'background'
  };
  const knobStyle = {
    position: 'absolute',
    top: '50%',
    left: 3,
    width: 16,
    height: 16,
    borderRadius: '9999px',
    background: '#fff',
    boxShadow: '0 1px 4px rgba(0,0,0,0.25)',
    transform: checked ? 'translate(18px, -50%)' : 'translate(0px, -50%)',
    transition: `transform 0.3s ${EASE}, box-shadow 0.2s ease`,
    pointerEvents: 'none',
    zIndex: 1,
    willChange: 'transform'
  };
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsxs)("label", {
    style: {
      position: 'relative',
      display: 'inline-flex',
      alignItems: 'center',
      width: 40,
      height: 22,
      cursor: disabled ? 'not-allowed' : 'pointer',
      flexShrink: 0,
      userSelect: 'none'
    },
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("input", {
      type: "checkbox",
      checked: checked,
      disabled: disabled,
      onChange: onChange,
      style: {
        position: 'absolute',
        opacity: 0,
        width: 0,
        height: 0,
        margin: 0,
        padding: 0,
        pointerEvents: 'none'
      }
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("span", {
      style: trackStyle
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_0__.jsx)("span", {
      style: knobStyle
    })]
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Toggle);

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
const linkStrong = 'font-semibold text-uks-brand no-underline transition hover:underline';
const InfoCard = ({
  icon,
  label,
  children
}) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
  className: "group flex items-center gap-4 rounded-lg border border-solid border-gray-200 bg-white p-4",
  children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
    className: "flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-uks-brand/10 text-uks-brand transition group-hover:bg-uks-brand/15",
    "aria-hidden": "true",
    children: icon
  }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
    className: "min-w-0 flex-1",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h3", {
      className: "m-0 mb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400",
      children: label
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
      className: "text-sm font-semibold text-slate-800",
      children: children
    })]
  })]
});
const UsefulLinkCard = ({
  icon,
  title,
  desc,
  href
}) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("a", {
  href: href,
  target: "_blank",
  rel: "noopener noreferrer",
  className: "group flex items-center gap-4 rounded-lg border border-solid border-gray-200 bg-white p-4 text-inherit no-underline transition hover:border-uks-brand/25",
  children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
    className: "flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-uks-brand/10 text-uks-brand transition group-hover:bg-uks-brand/15",
    "aria-hidden": "true",
    children: icon
  }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
    className: "min-w-0 flex-1",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
      className: "text-sm font-semibold text-slate-800",
      children: title
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
      className: "m-0 mt-0.5 text-[12px] leading-snug text-slate-500",
      children: desc
    })]
  })]
});
const AboutInfo = () => {
  const isPro = Boolean(adminData.isPro);
  const version = adminData.version || '';
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
    className: "space-y-6",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "overflow-hidden rounded-usk border border-slate-200 bg-white",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
        className: "bg-white p-4 sm:p-5 border border-solid border-gray-100",
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
          className: "flex gap-4 max-w-3xl flex-col items-center text-center sm:flex-row sm:items-start sm:text-left",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
            className: "",
            children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("svg", {
              className: "w-12 h-12 block",
              version: "1.1",
              id: "Layer_1",
              xmlns: "http://www.w3.org/2000/svg",
              xmlnsXlink: "http://www.w3.org/1999/xlink",
              x: "0px",
              y: "0px",
              viewBox: "0 0 500 500",
              xmlSpace: "preserve",
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("style", {
                type: "text/css",
                dangerouslySetInnerHTML: {
                  __html: "\n\t.st0{fill:#E30C1D;enable-background:new    ;}\n\t.st1{fill:#FFFFFF;}\n"
                }
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
                className: "st0",
                d: "M473.6,496.4h-447c-12.6,0-22.9-10.2-22.9-22.9v-447c0-12.4,10.2-22.9,22.9-22.9h446.8 c12.6,0,22.9,10.2,22.9,22.9v446.8C496.3,486.3,486.2,496.4,473.6,496.4z"
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("g", {
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
                  className: "st1",
                  d: "M374.3,364l-21.1-157.6c-1.9-14.3-14.2-25-28.6-25c0,0-0.1,0-0.1,0l-143.7,0.7c-14.5,0.1-26.8,11-28.5,25.4 l-18.6,156.9c-1,8.2,1.6,16.4,7.1,22.5s13.3,9.7,21.5,9.7h183.5c8.3,0,16.2-3.6,21.7-9.8C372.9,380.6,375.4,372.3,374.3,364z M186.4,217.1l132.8-0.6l6.4,47.6c-34.1,4.4-61,23.4-78.4,55.7c-8.5,15.8-12.9,31.5-15,41.9h-63L186.4,217.1z M268.1,361.7 c1.9-7.3,5-16.3,9.9-25.3c12-22.3,29.2-34.7,52.2-37.6l8.4,62.9H268.1z"
                }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
                  className: "st1",
                  d: "M212.4,169.2c8.8,0,16-7.2,16-16c0-13.9,11.3-25.3,25.3-25.3c13.9,0,25.3,11.3,25.3,25.3c0,8.8,7.2,16,16,16 s16-7.2,16-16c0-31.6-25.7-57.3-57.3-57.3c-31.6,0-57.3,25.7-57.3,57.3C196.4,162.1,203.6,169.2,212.4,169.2z"
                })]
              })]
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
            className: "min-w-0 flex-1",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
              className: "mb-2 flex flex-wrap items-center justify-center gap-2 sm:justify-start",
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h3", {
                className: "m-0 text-[22px] font-extrabold leading-none text-slate-900",
                children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Ultimate Store Kit', 'ultimate-store-kit')
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("span", {
                className: "inline-flex items-center rounded-full bg-uks-brand px-2.5 py-0.5 text-xs font-semibold text-white",
                children: ["v", version]
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("span", {
                className: `inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ${isPro ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700'}`,
                children: isPro ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Pro', 'ultimate-store-kit') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Free', 'ultimate-store-kit')
              })]
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
              className: "mb-4 text-[13px] leading-relaxed text-slate-600",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Build online stores in WordPress with the powerful store builder addon for Elementor. Enjoy a wide range of customizations and easily build product grids, carousels, single product/page elements, checkouts and more.', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("ul", {
              className: "m-0 flex list-none flex-wrap justify-center gap-3 p-0 sm:justify-start",
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("li", {
                className: "rounded-full py-1 px-2 border border-solid border-slate-200 bg-white/80 text-xs font-medium text-slate-600",
                children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Elementor widgets', 'ultimate-store-kit')
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("li", {
                className: "rounded-full py-1 px-2 border border-solid border-slate-200 bg-white/80 text-xs font-medium text-slate-600",
                children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('WooCommerce ready', 'ultimate-store-kit')
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("li", {
                className: "rounded-full py-1 px-2 border border-solid border-slate-200 bg-white/80 text-xs font-medium text-slate-600",
                children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Store-focused UI', 'ultimate-store-kit')
              })]
            })]
          })]
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "grid grid-cols-1 gap-px border-t border-slate-200 sm:grid-cols-3",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
          className: "bg-gray-100 px-4 py-3 text-center sm:text-left",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
            className: "m-0 mb-0.5 text-[11px] font-semibold uppercase tracking-wide text-slate-400",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Current version', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("p", {
            className: "m-0 text-sm font-bold text-slate-800",
            children: ["v", version]
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
          className: "bg-gray-100 px-4 py-3 text-center sm:text-left",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
            className: "m-0 mb-0.5 text-[11px] font-semibold uppercase tracking-wide text-slate-400",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('License', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
            className: "m-0 text-sm font-bold text-slate-800",
            children: isPro ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Pro (active)', 'ultimate-store-kit') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Free', 'ultimate-store-kit')
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
          className: "bg-gray-100 px-4 py-3 text-center sm:text-left",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
            className: "m-0 mb-0.5 text-[11px] font-semibold uppercase tracking-wide text-slate-400",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Built for', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
            className: "m-0 text-sm font-bold text-slate-800",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('WordPress + WooCommerce', 'ultimate-store-kit')
          })]
        })]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "rounded-usk border border-solid border-gray-100 bg-white p-4 sm:p-5",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h3", {
        className: "m-0 mb-3 text-base font-bold text-slate-800",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Product & support', 'ultimate-store-kit')
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: "grid grid-cols-1 gap-3 sm:grid-cols-2 2xl:grid-cols-4",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(InfoCard, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Author', 'ultimate-store-kit'),
          icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("svg", {
            className: "h-5 w-5",
            fill: "none",
            stroke: "currentColor",
            strokeWidth: "2",
            viewBox: "0 0 24 24",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
              d: "M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("circle", {
              cx: "12",
              cy: "7",
              r: "4"
            })]
          }),
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://bdthemes.com/",
            target: "_blank",
            rel: "noopener noreferrer",
            className: linkStrong,
            children: "BdThemes"
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(InfoCard, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Website', 'ultimate-store-kit'),
          icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("svg", {
            className: "h-5 w-5",
            fill: "none",
            stroke: "currentColor",
            strokeWidth: "2",
            viewBox: "0 0 24 24",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("circle", {
              cx: "12",
              cy: "12",
              r: "10"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
              d: "M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"
            })]
          }),
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://storekit.pro/",
            target: "_blank",
            rel: "noopener noreferrer",
            className: linkStrong,
            children: "storekit.pro"
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(InfoCard, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Documentation', 'ultimate-store-kit'),
          icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("svg", {
            className: "h-5 w-5",
            fill: "none",
            stroke: "currentColor",
            strokeWidth: "2",
            viewBox: "0 0 24 24",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
              d: "M4 19.5A2.5 2.5 0 0 1 6.5 17H20"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
              d: "M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"
            })]
          }),
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://bdthemes.com/all-knowledge-base-of-ultimate-store-kit/",
            target: "_blank",
            rel: "noopener noreferrer",
            className: linkStrong,
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Knowledge Base', 'ultimate-store-kit')
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(InfoCard, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Support', 'ultimate-store-kit'),
          icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("svg", {
            className: "h-5 w-5",
            fill: "none",
            stroke: "currentColor",
            strokeWidth: "2",
            viewBox: "0 0 24 24",
            children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
              d: "M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"
            })
          }),
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
            href: "https://bdthemes.com/support/",
            target: "_blank",
            rel: "noopener noreferrer",
            className: linkStrong,
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Get Support', 'ultimate-store-kit')
          })
        })]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
      className: "rounded-usk border border-solid border-gray-100 bg-white p-4 sm:p-5",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h3", {
        className: "m-0 mb-3 text-base font-bold text-slate-800",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Useful links', 'ultimate-store-kit')
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("ul", {
        className: "m-0 grid list-none grid-cols-1 gap-3 p-0 sm:grid-cols-2 2xl:grid-cols-4",
        children: [['https://www.youtube.com/c/bdthemes', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Video tutorials', 'ultimate-store-kit'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Step-by-step YouTube tutorials for setup, widgets, and customization.', 'ultimate-store-kit'), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("svg", {
          className: "h-5 w-5",
          fill: "none",
          stroke: "currentColor",
          strokeWidth: "2",
          viewBox: "0 0 24 24",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("polygon", {
            points: "23 7 16 12 23 17 23 7"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("rect", {
            x: "1",
            y: "5",
            width: "15",
            height: "14",
            rx: "2",
            ry: "2"
          })]
        })], ['https://feedback.bdthemes.com/b/6vr2250l/feature-requests/', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Request a feature', 'ultimate-store-kit'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Share ideas and vote on what we build next.', 'ultimate-store-kit'), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("svg", {
          className: "h-5 w-5",
          fill: "none",
          stroke: "currentColor",
          strokeWidth: "2",
          viewBox: "0 0 24 24",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
            d: "M12 20h9"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
            d: "M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"
          })]
        })], ['https://wordpress.org/plugins/ultimate-store-kit/', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Rate us on WordPress.org', 'ultimate-store-kit'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Help others discover the plugin with a review.', 'ultimate-store-kit'), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("svg", {
          className: "h-5 w-5",
          fill: "none",
          stroke: "currentColor",
          strokeWidth: "2",
          viewBox: "0 0 24 24",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("polygon", {
            points: "12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"
          })
        })], ['https://www.facebook.com/groups/358290584725185', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Facebook community', 'ultimate-store-kit'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Join our Facebook community to connect with other users and the team.', 'ultimate-store-kit'), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("svg", {
          className: "h-5 w-5",
          fill: "none",
          stroke: "currentColor",
          strokeWidth: "2",
          viewBox: "0 0 24 24",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("path", {
            d: "M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"
          })
        })]].map(([href, title, desc, icon]) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("li", {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(UsefulLinkCard, {
            href: href,
            title: title,
            desc: desc,
            icon: icon
          })
        }, href))
      })]
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
  freeNote: '35+',
  proNote: '100+'
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
const HIcon = ({
  d,
  viewBox = '0 0 24 24',
  filled = false
}) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("svg", {
  className: "h-4 w-4 shrink-0 text-uks-brand",
  viewBox: viewBox,
  fill: filled ? 'currentColor' : 'none',
  stroke: filled ? 'none' : 'currentColor',
  strokeWidth: "2",
  strokeLinecap: "round",
  strokeLinejoin: "round",
  children: Array.isArray(d) ? d.map((p, i) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
    d: p
  }, i)) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
    d: d
  })
});
const highlights = [{
  text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Incredibly Advanced', 'ultimate-store-kit'),
  icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(HIcon, {
    d: "M13 2 3 14h9l-1 8 10-12h-9l1-8z"
  })
}, {
  text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Refund or Cancel Anytime', 'ultimate-store-kit'),
  icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(HIcon, {
    d: ['M9 14 4 9l5-5', 'M4 9h10.5a5.5 5.5 0 0 1 0 11H11']
  })
}, {
  text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Dynamic Content', 'ultimate-store-kit'),
  icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(HIcon, {
    d: ['M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z', 'M14 2v6h6', 'M8 13h8', 'M8 17h4']
  })
}, {
  text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Super-Flexible Widgets', 'ultimate-store-kit'),
  icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(HIcon, {
    d: ['M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z']
  })
}, {
  text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('24/7 Premium Support', 'ultimate-store-kit'),
  icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(HIcon, {
    d: ['M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z']
  })
}, {
  text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Third Party Plugins', 'ultimate-store-kit'),
  icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(HIcon, {
    d: ['M6.3 20.3a2.4 2.4 0 0 0 3.4 0L12 18l-6-6-2.3 2.3a2.4 2.4 0 0 0 0 3.4z', 'm2 22 3-3', 'M7.5 13.5 10 11', 'M10.5 16.5 13 14', 'm18 3-4 4h6l-4 4']
  })
}, {
  text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Special Discount!', 'ultimate-store-kit'),
  icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(HIcon, {
    d: ['M9 5H2v7l6.29 6.29c.94.94 2.48.94 3.42 0l3.58-3.58c.94-.94.94-2.48 0-3.42L9 5z', 'M6 9.01V9']
  })
}, {
  text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Custom Field Integration', 'ultimate-store-kit'),
  icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(HIcon, {
    d: ['M12 20h9', 'M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z']
  })
}, {
  text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('With Live Chat Support', 'ultimate-store-kit'),
  icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(HIcon, {
    d: ['M8 12h.01', 'M12 12h.01', 'M16 12h.01', 'M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z']
  })
}, {
  text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Trusted Payment Methods', 'ultimate-store-kit'),
  icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(HIcon, {
    d: ['M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z']
  })
}, {
  text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Interactive Effects', 'ultimate-store-kit'),
  icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(HIcon, {
    d: ['M12 2v4', 'm16.2 7.8 2.9-2.9', 'M18 12h4', 'm16.2 16.2 2.9 2.9', 'M12 18v4', 'm4.9 19.1 2.9-2.9', 'M2 12h4', 'm4.9 4.9 2.9 2.9']
  })
}, {
  text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Video Tutorial', 'ultimate-store-kit'),
  icon: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(HIcon, {
    d: ['M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z', 'M9.75 15.02 15.5 12l-5.75-3.02v6.04z']
  })
}];
const StarIcon = ({
  className = 'h-3.5 w-3.5'
}) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("svg", {
  className: className,
  viewBox: "0 0 24 24",
  fill: "currentColor",
  children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
    d: "M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"
  })
});
const CheckIcon = () => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("svg", {
  className: "mx-auto h-[18px] w-[18px] text-uks-brand",
  viewBox: "0 0 24 24",
  fill: "none",
  stroke: "currentColor",
  strokeWidth: "2.5",
  strokeLinecap: "round",
  strokeLinejoin: "round",
  children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
    d: "M20 6 9 17l-5-5"
  })
});
const CrossIcon = () => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("svg", {
  className: "mx-auto h-[18px] w-[18px] text-slate-300",
  viewBox: "0 0 24 24",
  fill: "none",
  stroke: "currentColor",
  strokeWidth: "2",
  strokeLinecap: "round",
  strokeLinejoin: "round",
  children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
    d: "M18 6 6 18M6 6l12 12"
  })
});
const GetPro = ({
  isPro
}) => {
  if (isPro) {
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "rounded-usk border border-slate-200 bg-white p-6 text-center sm:p-10",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
        className: "mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100",
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("svg", {
          className: "h-7 w-7 text-emerald-600",
          viewBox: "0 0 24 24",
          fill: "none",
          stroke: "currentColor",
          strokeWidth: "2.5",
          strokeLinecap: "round",
          strokeLinejoin: "round",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
            d: "M20 6 9 17l-5-5"
          })
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("h2", {
        className: "m-0 mb-2 text-xl font-bold text-slate-800",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('You already have Pro!', 'ultimate-store-kit')
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
        className: "m-0 text-sm text-slate-500",
        children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Thank you for being a Pro user. You have access to all features.', 'ultimate-store-kit')
      })]
    });
  }
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
    className: "space-y-5",
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "overflow-hidden rounded-usk border border-solid border-gray-100 bg-white",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "flex border-b border-gray-100",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
          className: "flex flex-[2] items-center px-3 py-3 sm:px-5 sm:py-3.5",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
            className: "text-[10px] font-semibold uppercase tracking-wider text-slate-400 sm:text-[11px]",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Features', 'ultimate-store-kit')
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
          className: "flex w-20 items-center justify-center border-l border-gray-100 bg-slate-50 py-3 sm:w-28 sm:py-3.5 lg:w-36",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
            className: "text-[11px] font-bold text-slate-500 sm:text-[12px]",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Free', 'ultimate-store-kit')
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
          className: "flex w-20 items-center justify-center border-l border-uks-brand/30 bg-uks-brand py-3 sm:w-28 sm:py-3.5 lg:w-36",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("span", {
            className: "inline-flex items-center gap-1 text-[11px] font-bold text-white sm:gap-1.5 sm:text-[12px]",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(StarIcon, {
              className: "h-3 w-3"
            }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Pro', 'ultimate-store-kit')]
          })
        })]
      }), features.map((f, i) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: `flex items-center border-b border-gray-50 last:border-b-0 ${i % 2 === 1 ? 'bg-slate-50/50' : 'bg-white'}`,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
          className: "flex min-w-0 flex-[2] items-center gap-2 px-3 py-3 sm:px-5 sm:py-3.5",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
            className: "text-[12px] font-medium text-slate-700 sm:text-[13px]",
            children: f.label
          }), f.freeNote && f.proNote && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("span", {
            className: "hidden shrink-0 rounded-full border border-slate-100 bg-white px-2 py-0.5 text-[10px] font-semibold text-slate-400 sm:inline-block",
            children: [f.freeNote, " \u2192 ", f.proNote]
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
          className: `flex w-20 shrink-0 items-center justify-center border-l py-3 sm:w-28 sm:py-3.5 lg:w-36 ${i % 2 === 1 ? 'border-gray-100 bg-slate-50/50' : 'border-gray-50 bg-white'}`,
          children: f.free ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(CheckIcon, {}) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(CrossIcon, {})
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
          className: "flex w-20 shrink-0 items-center justify-center border-l border-uks-brand/20 bg-uks-brand/[0.07] py-3 sm:w-28 sm:py-3.5 lg:w-36",
          children: f.pro ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(CheckIcon, {}) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(CrossIcon, {})
        })]
      }, i))]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
      className: "overflow-hidden rounded-usk border border-solid border-gray-100 bg-white",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "p-4 sm:p-5 lg:p-6",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
          className: "m-0 mb-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400 sm:mb-4",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)("What's included with Pro", 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
          className: "grid grid-cols-1 gap-2 xs:grid-cols-2 sm:grid-cols-3 lg:grid-cols-4",
          children: highlights.map((h, i) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
            className: "flex items-center gap-2 rounded-lg border border-slate-100 bg-slate-50/70 px-3 py-2.5 sm:gap-2.5",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              className: "shrink-0",
              "aria-hidden": "true",
              children: h.icon
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("span", {
              className: "text-[12px] font-medium leading-snug text-slate-600",
              children: h.text
            })]
          }, i))
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: "flex flex-col items-center gap-3 border-t border-uks-brand/15 bg-gradient-to-br from-uks-brand/[0.07] to-transparent px-4 py-5 text-center sm:px-6 sm:py-6",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("p", {
          className: "m-0 text-[13px] font-semibold text-slate-700",
          children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Ready to unlock all Pro features?', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("a", {
          href: "https://storekit.pro/pricing",
          target: "_blank",
          rel: "noopener noreferrer",
          className: `${_tw__WEBPACK_IMPORTED_MODULE_1__.btnLg} ${_tw__WEBPACK_IMPORTED_MODULE_1__.btnPrimary} gap-2`,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(StarIcon, {
            className: "h-4 w-4"
          }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Upgrade to Pro — View Pricing', 'ultimate-store-kit')]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
          className: "flex flex-wrap items-center justify-center gap-x-4 gap-y-1.5 text-[11px] text-slate-400",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("span", {
            className: "flex items-center gap-1",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("svg", {
              className: "h-3.5 w-3.5 text-emerald-500",
              viewBox: "0 0 24 24",
              fill: "none",
              stroke: "currentColor",
              strokeWidth: "2.5",
              strokeLinecap: "round",
              strokeLinejoin: "round",
              children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
                d: "M20 6 9 17l-5-5"
              })
            }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('30-day money-back', 'ultimate-store-kit')]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("span", {
            className: "flex items-center gap-1",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("svg", {
              className: "h-3.5 w-3.5 text-emerald-500",
              viewBox: "0 0 24 24",
              fill: "none",
              stroke: "currentColor",
              strokeWidth: "2.5",
              strokeLinecap: "round",
              strokeLinejoin: "round",
              children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
                d: "M20 6 9 17l-5-5"
              })
            }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Cancel anytime', 'ultimate-store-kit')]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("span", {
            className: "flex items-center gap-1",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("svg", {
              className: "h-3.5 w-3.5 text-emerald-500",
              viewBox: "0 0 24 24",
              fill: "none",
              stroke: "currentColor",
              strokeWidth: "2.5",
              strokeLinecap: "round",
              strokeLinejoin: "round",
              children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("path", {
                d: "M20 6 9 17l-5-5"
              })
            }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Instant access', 'ultimate-store-kit')]
          })]
        })]
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
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("div", {
    className: "",
    children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
      className: "mb-4 rounded-lg border border-solid border-gray-100 bg-white p-8",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "mb-6 border-0 border-b border-solid border-b-gray-100 pb-4",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("h2", {
          className: "m-0 mb-1 text-xl font-bold text-slate-800",
          children: isActivated ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Ultimate Store Kit License Info', 'ultimate-store-kit') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Activate Your License', 'ultimate-store-kit')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("p", {
          className: "m-0 text-[14px] leading-relaxed text-slate-500",
          children: isActivated ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Your license is active. View details and manage your subscription below.', 'ultimate-store-kit') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Enter your license key to activate and receive updates & premium support.', 'ultimate-store-kit')
        })]
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
      }), isActivated ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("div", {
        className: "block",
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
          className: "mb-5",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex flex-col gap-4",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
              className: "flex flex-col gap-2 border-0 border-b border-solid border-b-gray-100 pb-4",
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
                className: "text-[14px] font-semibold text-slate-600",
                children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Status', 'ultimate-store-kit')
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("span", {
                className: `inline-flex items-center gap-2 self-start rounded-[10px] px-3 py-1 text-xs font-bold ${licenseData.is_valid ? 'border border-emerald-200 bg-emerald-100 text-emerald-800' : 'border border-red-200 bg-red-100 text-red-900'}`,
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("svg", {
                  width: "14",
                  height: "14",
                  viewBox: "0 0 24 24",
                  fill: "none",
                  stroke: "currentColor",
                  strokeWidth: "2",
                  strokeLinecap: "round",
                  strokeLinejoin: "round",
                  "aria-hidden": "true",
                  children: licenseData.is_valid ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.Fragment, {
                    children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
                      d: "M20 6 9 17l-5-5"
                    })
                  }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.Fragment, {
                    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
                      d: "M18 6 6 18"
                    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
                      d: "M6 6l12 12"
                    })]
                  })
                }), licenseData.is_valid ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Valid', 'ultimate-store-kit') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Invalid', 'ultimate-store-kit')]
              })]
            }), licenseData.license_title && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
              className: "flex flex-col gap-1 border-0 border-b border-solid border-b-gray-100 pb-4",
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
                className: "text-[14px] font-semibold text-slate-600",
                children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('License Type', 'ultimate-store-kit')
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
                className: "text-[14px] text-slate-800",
                children: licenseData.license_title
              })]
            }), licenseData.expire_date && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
              className: "flex flex-col gap-1 border-0 border-b border-solid border-b-gray-100 pb-4",
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
                className: "text-[14px] font-semibold text-slate-600",
                children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('License Expired on', 'ultimate-store-kit')
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
                className: "text-[14px] text-slate-800",
                children: licenseData.expire_date
              })]
            }), licenseData.support_end && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
              className: "flex flex-col gap-1 border-0 border-b border-solid border-b-gray-100 pb-4",
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
                className: "text-[14px] font-semibold text-slate-600",
                children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Support Expired on', 'ultimate-store-kit')
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
                className: "text-[14px] text-slate-800",
                children: licenseData.support_end
              })]
            }), licenseData.masked_key && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
              className: "flex flex-col gap-2  pb-4",
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
                className: "text-[14px] font-semibold text-slate-600",
                children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Your License Key', 'ultimate-store-kit')
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
                className: "inline-flex w-fit max-w-full items-center rounded-md border border-slate-200 bg-slate-50 px-3 py-2 font-mono text-[12px] text-slate-700",
                children: licenseData.masked_key
              })]
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("button", {
            type: "button",
            onClick: handleDeactivate,
            disabled: loading,
            className: "mt-4 inline-flex items-center justify-center rounded-md border border-solid border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 cursor-pointer  transition-colors hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-60",
            children: loading ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Deactivating...', 'ultimate-store-kit') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Deactivate License', 'ultimate-store-kit')
          })]
        })
      }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("div", {
        className: "mt-0",
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("form", {
          onSubmit: handleActivate,
          className: "flex flex-col gap-5",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex flex-col gap-1.5",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("label", {
              htmlFor: "usk-license-key",
              className: "text-[13px] font-semibold text-slate-700",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('License Code', 'ultimate-store-kit')
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
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("p", {
            className: "m-0 text-[12px] leading-relaxed text-slate-500",
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('We will send update news of this product by this email address, don\'t worry, we hate spam.', 'ultimate-store-kit')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "mt-1 flex items-center gap-3",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("button", {
              type: "submit",
              disabled: loading,
              className: `${_tw__WEBPACK_IMPORTED_MODULE_2__.btnPrimary} rounded-md inline-flex items-center justify-center`,
              children: loading ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Activating...', 'ultimate-store-kit') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Activate License', 'ultimate-store-kit')
            }), !isPro && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
              href: "https://storekit.pro/pricing/",
              target: "_blank",
              rel: "noopener noreferrer",
              className: _tw__WEBPACK_IMPORTED_MODULE_2__.btnSecondary,
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Get Pro License', 'ultimate-store-kit')
            })]
          })]
        })
      })]
    })
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
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
      className: "grid grid-cols-[repeat(auto-fit,minmax(420px,1fr))] items-start gap-4",
      children: [groups.map((group, gi) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
        className: "w-full overflow-hidden rounded-usk border border-solid border-gray-100 bg-white",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("h3", {
          className: "m-0 border-0 border-b border-solid border-b-gray-200  px-5 py-3.5 text-sm font-bold uppercase tracking-wide text-slate-700",
          children: group.label
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
          className: "space-y-5 p-5",
          children: group.items.map(item => {
            const isProItem = item.widget_type === 'pro';
            const dependency = item.dependency || null;
            const hasMissingDependency = dependency && (!dependency.isInstalled || !dependency.isActive);
            const isDisabled = isProItem && !isPro || hasMissingDependency;
            if (item.type === 'checkbox') {
              const isOn = !isDisabled && localSettings[item.name] === 'on';
              return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
                className: "rounded-lg border border-slate-200 bg-white",
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
                  }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_tw__WEBPACK_IMPORTED_MODULE_3__.Toggle, {
                    checked: isOn,
                    disabled: isDisabled,
                    onChange: () => handleChange(item.name, isOn ? 'off' : 'on')
                  })]
                }), hasMissingDependency && dependency?.message && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
                  className: "mt-2 text-[13px] leading-relaxed text-slate-500",
                  children: dependency.message
                })]
              }, item.name);
            }
            if (item.type === 'select') {
              return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
                className: "rounded-lg border border-slate-200 bg-white",
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("label", {
                  className: _tw__WEBPACK_IMPORTED_MODULE_3__.fieldLabel,
                  children: [item.label, isProItem && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
                    className: `${_tw__WEBPACK_IMPORTED_MODULE_3__.proBadge} ml-2 align-middle`,
                    children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Pro', 'ultimate-store-kit')
                  })]
                }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("select", {
                  className: `${_tw__WEBPACK_IMPORTED_MODULE_3__.fieldControl} mt-2 block w-full`,
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
                className: "rounded-lg border border-slate-200 bg-white",
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("label", {
                  className: _tw__WEBPACK_IMPORTED_MODULE_3__.fieldLabel,
                  children: [item.label, isProItem && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("span", {
                    className: `${_tw__WEBPACK_IMPORTED_MODULE_3__.proBadge} ml-2 align-middle`,
                    children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Pro', 'ultimate-store-kit')
                  })]
                }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("input", {
                  type: item.type,
                  className: `${_tw__WEBPACK_IMPORTED_MODULE_3__.fieldControl} mt-2 block w-full`,
                  value: localSettings[item.name] || '',
                  onChange: e => handleChange(item.name, e.target.value),
                  disabled: isDisabled
                })]
              }, item.name);
            }
            return null;
          })
        })]
      }, gi)), !isPro && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_components_ProPromo__WEBPACK_IMPORTED_MODULE_2__["default"], {})]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
      className: "mt-6 flex justify-end pt-4",
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("button", {
        type: "button",
        className: `${_tw__WEBPACK_IMPORTED_MODULE_3__.btnLg} ${_tw__WEBPACK_IMPORTED_MODULE_3__.btnPrimary}`,
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
      className: "rounded-lg border border-solid border-gray-100 bg-white p-4",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("h3", {
        className: "m-0 mb-3 text-[13px] font-semibold uppercase tracking-wide text-slate-500",
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
      className: "mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4",
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
      className: "mb-4 grid grid-cols-1 gap-4 xl:grid-cols-2",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "rounded-lg border border-solid border-gray-100 bg-white p-5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("h3", {
          className: "m-0 mb-2 text-base font-bold text-slate-800",
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
        className: "rounded-lg border border-solid border-gray-100 bg-white p-5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("h3", {
          className: "m-0 mb-2 text-base font-bold text-slate-800",
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
              className: "rounded-lg bg-emerald-100 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-800",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('OK', 'ultimate-store-kit')
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex items-center justify-between border-b border-slate-100 py-2 text-[13px] text-slate-700 last:border-b-0",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Memory Limit', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "rounded-lg bg-emerald-100 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-800",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('OK', 'ultimate-store-kit')
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex items-center justify-between border-b border-slate-100 py-2 text-[13px] text-slate-700 last:border-b-0",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Max Execution Time', 'ultimate-store-kit')
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "rounded-lg bg-emerald-100 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-800",
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('OK', 'ultimate-store-kit')
            })]
          })]
        })]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
      className: "grid grid-cols-1 gap-4 xl:grid-cols-2",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "rounded-lg border border-solid border-gray-100 bg-white p-5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("h3", {
          className: "m-0 mb-2 text-base font-bold text-slate-800",
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
        className: "rounded-lg border border-solid border-gray-100 bg-white p-5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("h3", {
          className: "m-0 mb-2 text-base font-bold text-slate-800",
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




const WidgetsPage = ({
  allWidgets,
  allSettings,
  onSave,
  saving,
  isPro,
  widgetType = 'wc'
}) => {
  const [search, setSearch] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)('');
  const [filter, setFilter] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)('all');
  const [contentTypeFilter, setContentTypeFilter] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)('all');
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
    setSearch('');
    setFilter('all');
    setContentTypeFilter('all');
  }, [widgetType]);
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
  const cardBase = 'flex flex-col justify-between gap-3 rounded-lg border border-solid border-gray-200 p-4';
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
      className: "mb-5 flex flex-wrap items-center justify-between gap-2",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("h2", {
        className: "m-0 text-xl font-bold text-slate-800",
        children: currentConfig.title
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("span", {
        className: "rounded-2xl border border-slate-200 bg-white px-3 py-1 text-[13px] text-slate-500",
        children: [activeCount, " / ", widgets.filter(w => w.type === 'checkbox').length, ' ', (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Active', 'ultimate-store-kit')]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
      className: "mb-5 flex flex-wrap items-center justify-between gap-3 rounded-lg border border-solid border-gray-100 bg-white px-4 py-3",
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "flex flex-wrap items-center gap-3",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
          className: "relative",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("svg", {
            xmlns: "http://www.w3.org/2000/svg",
            width: 24,
            height: 24,
            viewBox: "0 0 24 24",
            fill: "none",
            stroke: "currentColor",
            strokeWidth: 2,
            strokeLinecap: "round",
            strokeLinejoin: "round",
            className: "absolute right-3 top-3 h-4 w-4 block text-gray-400",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
              d: "m21 21-4.34-4.34"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("circle", {
              cx: 11,
              cy: 11,
              r: 8
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("input", {
            type: "text",
            className: "block w-full rounded-md border border-solid border-gray-200 bg-transparent py-2.5 pr-10 pl-3 text-sm text-slate-700 placeholder:text-gray-500 focus:border-uks-brand focus:outline-none focus:ring-2 focus:ring-uks-brand/25 sm:w-48",
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Search widgets...', 'ultimate-store-kit'),
            value: search,
            onChange: e => setSearch(e.target.value)
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
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        className: "flex flex-wrap items-center gap-1.5",
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("button", {
          type: "button",
          className: `${_tw__WEBPACK_IMPORTED_MODULE_2__.btnSm} !rounded-lg !bg-uks-brand !text-white hover:!bg-uks-brand-dark focus:outline-none focus:ring-2 focus:ring-uks-brand focus:ring-offset-2 focus:ring-offset-white border-none`,
          onClick: handleActivateAll,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("svg", {
            className: "h-4 w-4",
            viewBox: "0 0 24 24",
            fill: "none",
            stroke: "currentColor",
            strokeWidth: "2",
            strokeLinecap: "round",
            strokeLinejoin: "round",
            "aria-hidden": "true",
            children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
              d: "M20 6 9 17l-5-5"
            })
          }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Activate All', 'ultimate-store-kit')]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("button", {
          type: "button",
          className: `${_tw__WEBPACK_IMPORTED_MODULE_2__.btnSm} !rounded-lg !border !border-uks-brand/25 bg-uks-brand/5 text-uks-brand hover:bg-uks-brand/10 hover:text-uks-brand-dark focus:outline-none focus:ring-2 focus:ring-uks-brand focus:ring-offset-2 focus:ring-offset-white`,
          onClick: handleDeactivateAll,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("svg", {
            className: "h-4 w-4",
            viewBox: "0 0 24 24",
            fill: "none",
            stroke: "currentColor",
            strokeWidth: "2",
            strokeLinecap: "round",
            strokeLinejoin: "round",
            "aria-hidden": "true",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
              d: "M18 6 6 18"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
              d: "M6 6l12 12"
            })]
          }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Deactivate All', 'ultimate-store-kit')]
        })]
      })]
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
      className: "grid grid-cols-1 gap-3 rounded-lg border border-solid border-gray-100 bg-white p-5 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4",
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
          className: `${cardBase} ${isActive ? 'border-emerald-300' : ''} ${isDisabled ? 'opacity-60 cursor-not-allowed bg-slate-100' : ''}`,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex items-start justify-between gap-2",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: "text-base font-semibold leading-snug text-slate-800",
              children: widget.label
            }), isProWidget && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
              className: _tw__WEBPACK_IMPORTED_MODULE_2__.proBadge,
              children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Pro', 'ultimate-store-kit')
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
            className: "flex items-center justify-between",
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
              className: "flex gap-2 items-center",
              children: [dependency?.actionUrl && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("a", {
                href: dependency.actionUrl,
                target: dependency.actionType === 'install' ? '_blank' : undefined,
                rel: dependency.actionType === 'install' ? 'noopener noreferrer' : undefined,
                title: dependency.message || dependency.actionLabel,
                className: "text-gray-400 transition-colors hover:text-uks-brand flex items-center gap-1 decoration-none",
                style: {
                  textDecoration: 'none'
                },
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("svg", {
                  xmlns: "http://www.w3.org/2000/svg",
                  width: 24,
                  height: 24,
                  viewBox: "0 0 24 24",
                  fill: "none",
                  stroke: "currentColor",
                  strokeWidth: 2,
                  strokeLinecap: "round",
                  strokeLinejoin: "round",
                  className: "w-4 h-4 block",
                  children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
                    d: "M6.3 20.3a2.4 2.4 0 0 0 3.4 0L12 18l-6-6-2.3 2.3a2.4 2.4 0 0 0 0 3.4Z"
                  }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
                    d: "m2 22 3-3"
                  }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
                    d: "M7.5 13.5 10 11"
                  }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
                    d: "M10.5 16.5 13 14"
                  }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
                    d: "m18 3-4 4h6l-4 4"
                  })]
                }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Install', 'ultimate-store-kit')]
              }), widget.demo_url && !widget.demo_url.startsWith('#') && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("a", {
                href: widget.demo_url,
                target: "_blank",
                rel: "noopener noreferrer",
                title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Demo', 'ultimate-store-kit'),
                className: "text-gray-400 transition-colors hover:text-uks-brand flex items-center gap-1 decoration-none",
                style: {
                  textDecoration: 'none'
                },
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("svg", {
                  xmlns: "http://www.w3.org/2000/svg",
                  width: 24,
                  height: 24,
                  viewBox: "0 0 24 24",
                  fill: "none",
                  stroke: "currentColor",
                  strokeWidth: 2,
                  strokeLinecap: "round",
                  strokeLinejoin: "round",
                  className: "w-4 h-4 block",
                  children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
                    d: "M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"
                  }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("circle", {
                    cx: 12,
                    cy: 12,
                    r: 3
                  })]
                }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Demo', 'ultimate-store-kit')]
              }), widget.video_url && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("a", {
                href: widget.video_url,
                target: "_blank",
                rel: "noopener noreferrer",
                title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Video', 'ultimate-store-kit'),
                className: "text-gray-400 transition-colors hover:text-uks-brand flex items-center gap-1 decoration-none",
                style: {
                  textDecoration: 'none'
                },
                children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("svg", {
                  xmlns: "http://www.w3.org/2000/svg",
                  width: 24,
                  height: 24,
                  viewBox: "0 0 24 24",
                  fill: "none",
                  stroke: "currentColor",
                  strokeWidth: 2,
                  strokeLinecap: "round",
                  strokeLinejoin: "round",
                  className: "w-4 h-4 block",
                  children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("path", {
                    d: "M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"
                  })
                }), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Video', 'ultimate-store-kit')]
              })]
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(_tw__WEBPACK_IMPORTED_MODULE_2__.Toggle, {
              checked: isActive,
              disabled: isDisabled,
              onChange: () => handleToggle(widget.name)
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
/* harmony export */   Toggle: () => (/* reexport safe */ _components_Toggle__WEBPACK_IMPORTED_MODULE_0__["default"]),
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
/* harmony import */ var _components_Toggle__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/Toggle */ "./src/adminx/components/Toggle.js");
/**
 * Shared Tailwind class strings for adminx (no @apply in SCSS).
 * Specificity scope: tailwind.config.js `important` = `.ultimate-store-kit-admin-root` (PHP wrapper).
 */

const appShell = 'flex min-h-[calc(100vh-100px)] flex-col m-5 ml-0 mb-0 font-sans';

/** Row under header: stretch columns to same height so sidebar bg fills to content bottom. */
const bodyRow = 'flex flex-1 items-stretch p-5 gap-5';

/** Main column grows with page; min-w-0 avoids flex overflow quirks. */
const mainContent = 'min-w-0 flex-1';

/* Buttons */
const btnBase = 'inline-flex cursor-pointer items-center gap-1.5 rounded-md border border-transparent px-[18px] py-2 text-[13px] font-semibold leading-snug no-underline transition-all duration-200 disabled:cursor-not-allowed disabled:opacity-60';
const btnPrimary = `${btnBase} border-uks-brand bg-uks-brand text-white hover:bg-uks-brand-dark`;
const btnSecondary = `${btnBase} bg-gray-100 border-gray-200 text-gray-700 hover:bg-gray-200 hover:text-gray-800`;
const btnLg = `${btnBase} px-6 py-2.5 text-sm`;
const btnSm = `${btnBase} px-3 py-2.5 text-xs`;
const btnOutlineGreen = `${btnBase} border-uks-brand bg-transparent text-uks-brand hover:bg-uks-brand hover:text-white`;
const btnOutlineRed = `${btnBase} border-red-500 bg-transparent text-red-500 hover:bg-red-500 hover:text-white`;
const btnEp = `${btnBase} border-indigo-500 bg-indigo-500 text-white hover:opacity-90`;
const btnPs = `${btnBase} border-pink-500 bg-pink-500 text-white hover:opacity-90`;
const btnUpk = `${btnBase} border-orange-500 bg-orange-500 text-white hover:opacity-90`;
const btnPg = `${btnBase} border-violet-500 bg-violet-500 text-white hover:opacity-90`;
const btnZb = `${btnBase} border-teal-500 bg-teal-500 text-white hover:opacity-90`;

/* Form */
const selectLabel = 'whitespace-nowrap text-xs font-semibold text-slate-600';
const selectInput = 'min-w-[140px] cursor-pointer rounded-md border border-slate-200 bg-white px-3 py-1.5 text-[13px] text-slate-700 transition-all duration-200 hover:border-slate-300 focus:border-uks-brand focus:outline-none focus:ring-2 focus:ring-uks-brand';
const fieldRow = 'flex items-center justify-between border-b border-slate-100 py-2.5 last:border-b-0';
const fieldLabel = 'flex items-center gap-2 text-[13px] font-medium text-slate-700';
const fieldControl = 'min-w-[120px] w-full block max-w-full rounded-md border border-slate-200 bg-white px-3 py-1.5 text-[13px] text-slate-700 focus:border-uks-brand focus:outline-none focus:ring-2 focus:ring-uks-brand disabled:cursor-not-allowed disabled:opacity-50';
const licenseInput = 'w-full rounded-md border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 transition-all duration-200 placeholder:text-slate-400 focus:border-uks-brand focus:outline-none focus:ring-2 focus:ring-uks-brand';

/* Toggle — self-contained React component; avoids WP admin CSS overrides on peer/transform */


// Keep these for any legacy usage; new code should use <Toggle /> component
const toggleLabel = 'relative inline-block h-[22px] w-10 cursor-pointer';
const toggleInput = 'peer sr-only';
const toggleTrack = 'pointer-events-none absolute inset-0 rounded-full bg-slate-300 transition-colors duration-200 peer-checked:bg-uks-brand peer-disabled:opacity-50';
const toggleKnob = 'pointer-events-none absolute bottom-[3px] left-[3px] z-[1] h-4 w-4 rounded-full bg-white shadow-sm transition-transform duration-200 ease-in-out peer-checked:translate-x-[18px]';

/* Pro badge on cards */
const proBadge = 'shrink-0 whitespace-nowrap rounded-md border border-solid border-gray-100 text-uks-brand px-2 py-0.5 text-[10px] font-bold shadow-sm bg-white';

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