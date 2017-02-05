webpackJsonp([0],{

/***/ 63:
/***/ (function(module, exports, __webpack_require__) {

var __vue_exports__, __vue_options__
var __vue_styles__ = {}

/* template */
var __vue_template__ = __webpack_require__(64)
__vue_options__ = __vue_exports__ = __vue_exports__ || {}
if (
  typeof __vue_exports__.default === "object" ||
  typeof __vue_exports__.default === "function"
) {
if (Object.keys(__vue_exports__).some(function (key) { return key !== "default" && key !== "__esModule" })) {console.error("named exports are not supported in *.vue files.")}
__vue_options__ = __vue_exports__ = __vue_exports__.default
}
if (typeof __vue_options__ === "function") {
  __vue_options__ = __vue_options__.options
}
__vue_options__.__file = "C:\\Portfolio\\goldfund\\resources\\assets\\js\\admin\\components\\Dash.vue"
__vue_options__.render = __vue_template__.render
__vue_options__.staticRenderFns = __vue_template__.staticRenderFns

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4555fdde", __vue_options__)
  } else {
    hotAPI.reload("data-v-4555fdde", __vue_options__)
  }
})()}
if (__vue_options__.functional) {console.error("[vue-loader] Dash.vue: functional components are not supported and should be defined in plain js files using render functions.")}

module.exports = __vue_exports__


/***/ }),

/***/ 64:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('md-card', {
    attrs: {
      "md-with-hover": ""
    }
  }, [_c('md-card-header', [_c('div', {
    staticClass: "md-title"
  }, [_vm._v("Title2 goes here")]), _vm._v(" "), _c('div', {
    staticClass: "md-subhead"
  }, [_vm._v("Subtitle here")])]), _vm._v(" "), _c('md-card-content', [_vm._v("\n    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio itaque ea, nostrum odio. Dolores, sed accusantium quasi non, voluptas eius illo quas, saepe voluptate pariatur in deleniti minus sint. Excepturi.\n  ")]), _vm._v(" "), _c('md-card-actions', [_c('md-button', [_vm._v("Action")]), _vm._v(" "), _c('md-button', [_vm._v("Action")])], 1)], 1)
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-4555fdde", module.exports)
  }
}

/***/ })

});