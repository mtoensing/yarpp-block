/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/server-side-render */ "@wordpress/server-side-render");
/* harmony import */ var _wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__);







Object(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_2__["registerBlockType"])('yarpp-block/list', {
  title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('List YARPP Block', 'yarpp_block'),
  description: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Will show 3 related posts or will not appear if no related posts are found.'),
  category: 'layout',
  icon: 'ellipsis',
  supports: {
    align: ['wide', 'full']
  },
  keywords: ['YARPP Block'],
  attributes: {
    use_cache: {
      type: 'boolean',
      default: false
    },
    updated: {
      type: 'number',
      default: 0
    },
    blocktype: {
      type: 'string',
      default: 'related'
    },
    align: {
      type: 'string'
    },
    headline: {
      type: 'string',
      default: "Related posts"
    },
    level: {
      type: 'string',
      default: "h3"
    }
  },
  edit: function edit(props) {
    function updateHeadline(newValue) {
      props.setAttributes({
        headline: newValue
      });
    }

    function updateLevel(newValue) {
      props.setAttributes({
        level: newValue
      });
    }

    return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["Fragment"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__["InspectorControls"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__["Panel"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__["PanelBody"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__["TextControl"], {
      onChange: updateHeadline,
      className: "headline",
      label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Headline'),
      value: props.attributes.headline,
      placeholder: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Write headline', 'yarpp_block')
    }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__["SelectControl"], {
      label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Heading level', 'yarpp_block'),
      help: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Select the heading level', 'yarpp_block'),
      value: props.attributes.level,
      options: [{
        value: 'h1',
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('H1', 'yarpp_block')
      }, {
        value: 'h2',
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('H2', 'yarpp_block')
      }, {
        value: 'h3',
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('H3', 'yarpp_block')
      }, {
        value: 'h4',
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('H4', 'yarpp_block')
      }, {
        value: 'h5',
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('H5', 'yarpp_block')
      }, {
        value: 'h6',
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('H6', 'yarpp_block')
      }],
      onChange: updateLevel
    }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__["SelectControl"], {
      label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('YARPP block type', 'yarpp_block'),
      help: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Displays 3 posts of the configured type. ', 'yarpp_block'),
      value: props.attributes.blocktype,
      options: [{
        value: 'related',
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Related posts (default)', 'yarpp_block')
      }, {
        value: 'latest',
        label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Latest posts excluding related posts', 'yarpp_block')
      }],
      onChange: function onChange(blocktype) {
        return props.setAttributes({
          blocktype: blocktype
        });
      }
    })))), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__["BlockControls"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__["ToolbarGroup"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__["ToolbarButton"], {
      className: "components-icon-button components-toolbar__control",
      label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Update table of contents', 'yarpp-block'),
      onClick: function onClick() {
        return props.setAttributes({
          updated: Date.now()
        });
      },
      icon: "update"
    }))), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_server_side_render__WEBPACK_IMPORTED_MODULE_4___default.a, {
      block: props.name,
      attributes: props.attributes
    }));
  },
  save: function save(props) {
    return null;
  }
});

/***/ }),

/***/ "@wordpress/block-editor":
/*!**********************************************!*\
  !*** external {"this":["wp","blockEditor"]} ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["blockEditor"]; }());

/***/ }),

/***/ "@wordpress/blocks":
/*!*****************************************!*\
  !*** external {"this":["wp","blocks"]} ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["blocks"]; }());

/***/ }),

/***/ "@wordpress/components":
/*!*********************************************!*\
  !*** external {"this":["wp","components"]} ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["components"]; }());

/***/ }),

/***/ "@wordpress/element":
/*!******************************************!*\
  !*** external {"this":["wp","element"]} ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["element"]; }());

/***/ }),

/***/ "@wordpress/i18n":
/*!***************************************!*\
  !*** external {"this":["wp","i18n"]} ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["i18n"]; }());

/***/ }),

/***/ "@wordpress/server-side-render":
/*!***************************************************!*\
  !*** external {"this":["wp","serverSideRender"]} ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["serverSideRender"]; }());

/***/ })

/******/ });
//# sourceMappingURL=index.js.map