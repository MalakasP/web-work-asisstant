(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_projects_ProjectsComponent_vue"],{

/***/ "./node_modules/@babel/runtime/regenerator/index.js":
/*!**********************************************************!*\
  !*** ./node_modules/@babel/runtime/regenerator/index.js ***!
  \**********************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

module.exports = __webpack_require__(/*! regenerator-runtime */ "./node_modules/regenerator-runtime/runtime.js");


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/projects/ProjectsComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/projects/ProjectsComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_1__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { if (typeof Symbol === "undefined" || !(Symbol.iterator in Object(arr))) return; var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



function Team(_ref) {
  var id = _ref.id,
      name = _ref.name,
      description = _ref.description,
      created_at = _ref.created_at,
      updated_at = _ref.updated_at,
      pivot = _ref.pivot;
  this.id = id;
  this.name = name;
  this.description = description;
  this.created_at = created_at;
  this.updated_at = updated_at;
  this.pivot = pivot;
}

function User(_ref2) {
  var id = _ref2.id,
      name = _ref2.name,
      email = _ref2.email,
      created_at = _ref2.created_at,
      updated_at = _ref2.updated_at;
  this.id = id;
  this.name = name;
  this.email = email;
  this.created_at = created_at;
  this.updated_at = updated_at;
}

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      loaded: false,
      modal: false,
      edit: null,
      createForm: false,
      dynamicTitle: null,
      createdProjects: [],
      teamProjects: [],
      projectsUsers: {},
      teams: {},
      form: {
        title: null,
        description: null,
        author_id: null,
        team_id: null
      }
    };
  },
  computed: _objectSpread(_objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_2__.mapGetters)(["errors"])), (0,vuex__WEBPACK_IMPORTED_MODULE_2__.mapGetters)("auth", ["user"])), {}, {
    /**
     * Filter admin of the teams
     */
    teamsAdmin: function teamsAdmin() {
      var adminTeams = Object.entries(this.teams).filter(function (_ref3) {
        var _ref4 = _slicedToArray(_ref3, 2),
            key = _ref4[0],
            team = _ref4[1];

        if (team.pivot.is_admin) {
          return team.pivot.is_admin;
        } else {
          return false;
        }
      });
      return Object.fromEntries(adminTeams);
    }
  }),
  mounted: function mounted() {
    this.$store.commit("setErrors", {});
  },
  created: function created() {
    this.read();
  },
  methods: {
    /**
     * Get context data for projects component
     */
    read: function read() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return axios.get("api/" + "users").then(function (response) {
                  if (response.data != null) {
                    _this.projectsUsers = {};
                    response.data.users.forEach(function (user) {
                      if (user != null) {
                        _this.projectsUsers[user.id] = new User(user);
                      }
                    });
                  }
                })["catch"](function (error) {
                  console.log(error);
                });

              case 2:
                _context.next = 4;
                return axios.get("api/" + "teams").then(function (response) {
                  if (response.data != null) {
                    _this.teams = {};
                    response.data.teams.forEach(function (team) {
                      if (team != null) {
                        _this.teams[team.id] = new Team(team);
                      }
                    });
                    _this.teams[0] = new Team({
                      id: 0,
                      name: "No Team",
                      description: "",
                      created_at: moment__WEBPACK_IMPORTED_MODULE_1___default()(),
                      updated_at: moment__WEBPACK_IMPORTED_MODULE_1___default()(),
                      pivot: {
                        is_admin: true
                      }
                    });
                  }
                })["catch"](function (error) {
                  console.log(error);
                });

              case 4:
                _context.next = 6;
                return axios.get("api/" + "users/" + _this.user.id + "/teamProjects").then(function (response) {
                  if (response.data != null) {
                    _this.createdProjects = [];
                    _this.teamProjects = [];

                    if (response.data.createdProjects != null) {
                      response.data.createdProjects.forEach(function (project) {
                        _this.createdProjects.push(project);
                      });
                    }

                    if (response.data.teamProjects != null) {
                      response.data.teamProjects.forEach(function (project) {
                        if (project != null) {
                          _this.teamProjects.push(project);
                        }
                      });
                    }

                    console.log(_this.teamProjects);
                    _this.loaded = true;
                  }
                })["catch"](function (error) {
                  _this.loaded = true;
                  console.log(error);
                });

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },

    /**
     * Update the selected project
     */
    update: function update() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (_this2.form.team_id == 0) {
                  _this2.form.team_id = null;
                }

                _context2.next = 3;
                return axios.put("api/" + "projects/" + _this2.edit.id, _this2.form).then(function (response) {
                  if (response.data != null) {
                    _this2.modal = false;

                    var projectIndex = _this2.createdProjects.findIndex(function (project) {
                      return project.id == _this2.edit.id;
                    });

                    _this2.createdProjects.splice(projectIndex, 1, response.data.project);

                    _this2.edit = null;

                    _this2.$notify({
                      group: "app",
                      title: "Success!",
                      type: "success",
                      text: response.data.message
                    });

                    _this2.$store.commit("setErrors", {});
                  }
                })["catch"](function (error) {
                  console.log(error);

                  if (error.response) {
                    if (error.response.status != 422) {
                      _this2.modal = false;
                      _this2.edit = null;

                      _this2.$alert(error.response.data.status, "Warning", "error");
                    } else {
                      _this2.$store.commit("setErrors", error.response.data.errors);
                    }
                  }
                });

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },

    /**
     * Create new project
     */
    create: function create() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this3.form.author_id = _this3.user.id;

                if (_this3.form.team_id == 0) {
                  _this3.form.team_id = null;
                }

                _context3.next = 4;
                return axios.post("api/" + "projects", _this3.form).then(function (response) {
                  if (response.data != null) {
                    _this3.modal = false;
                    _this3.createForm = false;

                    _this3.createdProjects.push(response.data.project);

                    _this3.$notify({
                      group: "app",
                      title: "Success!",
                      type: "success",
                      text: response.data.message
                    });

                    _this3.$store.commit("setErrors", {});
                  }
                })["catch"](function (error) {
                  console.log(error);

                  if (error.response) {
                    if (error.response.status != 422) {
                      _this3.createForm = false;
                      _this3.modal = false;

                      _this3.$alert(error.response.data.status, "Warning", "error");
                    } else {
                      if (_this3.form.team_id == null) {
                        _this3.form.team_id = 0;
                      }

                      _this3.$store.commit("setErrors", error.response.data.errors);
                    }
                  }
                });

              case 4:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },

    /**
     * Delete the selected project
     */
    "delete": function _delete(id) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _context4.next = 2;
                return axios["delete"]("api/" + "projects/" + id).then(function (response) {
                  if (response.data.project.id != id) {
                    _this4.$alert("Something went wrong.", "Warning", "error");
                  } else {
                    var projectIndex = _this4.createdProjects.findIndex(function (project) {
                      return project.id == id;
                    });

                    _this4.createdProjects.splice(projectIndex, 1);

                    _this4.$notify({
                      group: "app",
                      title: "Success!",
                      type: "success",
                      text: response.data.message
                    });
                  }
                })["catch"](function (error) {
                  console.log(error);
                });

              case 2:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },

    /**
     * Start deletion of the selected project
     */
    startDelete: function startDelete(project) {
      var _this5 = this;

      this.$confirm("Are You sure?", "Confirm Delete", "error").then(function () {
        _this5["delete"](project.id);
      });
    },

    /**
     * Start editing of the selected project
     */
    startEdit: function startEdit(project) {
      this.$store.commit("setErrors", {});
      this.modal = true;
      this.edit = project;
      this.dynamicTitle = "Edit Project";

      if (project.team_id == null) {
        this.form.team_id = 0;
      } else {
        this.form.team_id = project.team_id;
      }

      this.form.title = project.title;
      this.form.description = project.description;
      this.form.author = project.author_id;
    },

    /**
     * Start new project creation
     */
    startCreate: function startCreate() {
      this.$store.commit("setErrors", {});
      this.createForm = true;
      this.form.title = null;
      this.form.description = null;
      this.form.team_id = 0;
    },

    /**
     * Start new project creation with modal form
     */
    startProject: function startProject() {
      this.$store.commit("setErrors", {});
      this.modal = true;
      this.dynamicTitle = "New Project";
      this.form.title = null;
      this.form.description = null;
      this.form.team_id = 0;
    },

    /**
     * Close project creation form
     */
    endCreate: function endCreate() {
      this.createForm = false;
      this.$store.commit("setErrors", {});
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/projects/ProjectsComponent.vue?vue&type=style&index=0&id=3ddcd2b9&scoped=true&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/projects/ProjectsComponent.vue?vue&type=style&index=0&id=3ddcd2b9&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n.card[data-v-3ddcd2b9] {\r\n  min-height: 200px;\r\n  border: 0;\r\n  box-shadow: 0 10px 20px 0 rgb(0 0 0 / 20%);\n}\n.full-width[data-v-3ddcd2b9] {\r\n  width: 100%;\n}\n.input-sm[data-v-3ddcd2b9] {\r\n  height: calc(2.15rem + 2px);\n}\n.modal-body[data-v-3ddcd2b9] {\r\n  height: 40vh;\r\n  overflow-y: auto;\n}\nthead tr[data-v-3ddcd2b9],\r\ntbody tr[data-v-3ddcd2b9] {\r\n  line-height: 40px;\n}\n.link[data-v-3ddcd2b9]:hover {\r\n  color: #007bff;\n}\r\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/regenerator-runtime/runtime.js":
/*!*****************************************************!*\
  !*** ./node_modules/regenerator-runtime/runtime.js ***!
  \*****************************************************/
/***/ ((module) => {

/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

var runtime = (function (exports) {
  "use strict";

  var Op = Object.prototype;
  var hasOwn = Op.hasOwnProperty;
  var undefined; // More compressible than void 0.
  var $Symbol = typeof Symbol === "function" ? Symbol : {};
  var iteratorSymbol = $Symbol.iterator || "@@iterator";
  var asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator";
  var toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function define(obj, key, value) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
    return obj[key];
  }
  try {
    // IE 8 has a broken Object.defineProperty that only works on DOM objects.
    define({}, "");
  } catch (err) {
    define = function(obj, key, value) {
      return obj[key] = value;
    };
  }

  function wrap(innerFn, outerFn, self, tryLocsList) {
    // If outerFn provided and outerFn.prototype is a Generator, then outerFn.prototype instanceof Generator.
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator;
    var generator = Object.create(protoGenerator.prototype);
    var context = new Context(tryLocsList || []);

    // The ._invoke method unifies the implementations of the .next,
    // .throw, and .return methods.
    generator._invoke = makeInvokeMethod(innerFn, self, context);

    return generator;
  }
  exports.wrap = wrap;

  // Try/catch helper to minimize deoptimizations. Returns a completion
  // record like context.tryEntries[i].completion. This interface could
  // have been (and was previously) designed to take a closure to be
  // invoked without arguments, but in all the cases we care about we
  // already have an existing method we want to call, so there's no need
  // to create a new function object. We can even get away with assuming
  // the method takes exactly one argument, since that happens to be true
  // in every case, so we don't have to touch the arguments object. The
  // only additional allocation required is the completion record, which
  // has a stable shape and so hopefully should be cheap to allocate.
  function tryCatch(fn, obj, arg) {
    try {
      return { type: "normal", arg: fn.call(obj, arg) };
    } catch (err) {
      return { type: "throw", arg: err };
    }
  }

  var GenStateSuspendedStart = "suspendedStart";
  var GenStateSuspendedYield = "suspendedYield";
  var GenStateExecuting = "executing";
  var GenStateCompleted = "completed";

  // Returning this object from the innerFn has the same effect as
  // breaking out of the dispatch switch statement.
  var ContinueSentinel = {};

  // Dummy constructor functions that we use as the .constructor and
  // .constructor.prototype properties for functions that return Generator
  // objects. For full spec compliance, you may wish to configure your
  // minifier not to mangle the names of these two functions.
  function Generator() {}
  function GeneratorFunction() {}
  function GeneratorFunctionPrototype() {}

  // This is a polyfill for %IteratorPrototype% for environments that
  // don't natively support it.
  var IteratorPrototype = {};
  IteratorPrototype[iteratorSymbol] = function () {
    return this;
  };

  var getProto = Object.getPrototypeOf;
  var NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  if (NativeIteratorPrototype &&
      NativeIteratorPrototype !== Op &&
      hasOwn.call(NativeIteratorPrototype, iteratorSymbol)) {
    // This environment has a native %IteratorPrototype%; use it instead
    // of the polyfill.
    IteratorPrototype = NativeIteratorPrototype;
  }

  var Gp = GeneratorFunctionPrototype.prototype =
    Generator.prototype = Object.create(IteratorPrototype);
  GeneratorFunction.prototype = Gp.constructor = GeneratorFunctionPrototype;
  GeneratorFunctionPrototype.constructor = GeneratorFunction;
  GeneratorFunction.displayName = define(
    GeneratorFunctionPrototype,
    toStringTagSymbol,
    "GeneratorFunction"
  );

  // Helper for defining the .next, .throw, and .return methods of the
  // Iterator interface in terms of a single ._invoke method.
  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function(method) {
      define(prototype, method, function(arg) {
        return this._invoke(method, arg);
      });
    });
  }

  exports.isGeneratorFunction = function(genFun) {
    var ctor = typeof genFun === "function" && genFun.constructor;
    return ctor
      ? ctor === GeneratorFunction ||
        // For the native GeneratorFunction constructor, the best we can
        // do is to check its .name property.
        (ctor.displayName || ctor.name) === "GeneratorFunction"
      : false;
  };

  exports.mark = function(genFun) {
    if (Object.setPrototypeOf) {
      Object.setPrototypeOf(genFun, GeneratorFunctionPrototype);
    } else {
      genFun.__proto__ = GeneratorFunctionPrototype;
      define(genFun, toStringTagSymbol, "GeneratorFunction");
    }
    genFun.prototype = Object.create(Gp);
    return genFun;
  };

  // Within the body of any async function, `await x` is transformed to
  // `yield regeneratorRuntime.awrap(x)`, so that the runtime can test
  // `hasOwn.call(value, "__await")` to determine if the yielded value is
  // meant to be awaited.
  exports.awrap = function(arg) {
    return { __await: arg };
  };

  function AsyncIterator(generator, PromiseImpl) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);
      if (record.type === "throw") {
        reject(record.arg);
      } else {
        var result = record.arg;
        var value = result.value;
        if (value &&
            typeof value === "object" &&
            hasOwn.call(value, "__await")) {
          return PromiseImpl.resolve(value.__await).then(function(value) {
            invoke("next", value, resolve, reject);
          }, function(err) {
            invoke("throw", err, resolve, reject);
          });
        }

        return PromiseImpl.resolve(value).then(function(unwrapped) {
          // When a yielded Promise is resolved, its final value becomes
          // the .value of the Promise<{value,done}> result for the
          // current iteration.
          result.value = unwrapped;
          resolve(result);
        }, function(error) {
          // If a rejected Promise was yielded, throw the rejection back
          // into the async generator function so it can be handled there.
          return invoke("throw", error, resolve, reject);
        });
      }
    }

    var previousPromise;

    function enqueue(method, arg) {
      function callInvokeWithMethodAndArg() {
        return new PromiseImpl(function(resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise =
        // If enqueue has been called before, then we want to wait until
        // all previous Promises have been resolved before calling invoke,
        // so that results are always delivered in the correct order. If
        // enqueue has not been called before, then it is important to
        // call invoke immediately, without waiting on a callback to fire,
        // so that the async generator function has the opportunity to do
        // any necessary setup in a predictable way. This predictability
        // is why the Promise constructor synchronously invokes its
        // executor callback, and why async functions synchronously
        // execute code before the first await. Since we implement simple
        // async functions in terms of async generators, it is especially
        // important to get this right, even though it requires care.
        previousPromise ? previousPromise.then(
          callInvokeWithMethodAndArg,
          // Avoid propagating failures to Promises returned by later
          // invocations of the iterator.
          callInvokeWithMethodAndArg
        ) : callInvokeWithMethodAndArg();
    }

    // Define the unified helper method that is used to implement .next,
    // .throw, and .return (see defineIteratorMethods).
    this._invoke = enqueue;
  }

  defineIteratorMethods(AsyncIterator.prototype);
  AsyncIterator.prototype[asyncIteratorSymbol] = function () {
    return this;
  };
  exports.AsyncIterator = AsyncIterator;

  // Note that simple async functions are implemented on top of
  // AsyncIterator objects; they just return a Promise for the value of
  // the final result produced by the iterator.
  exports.async = function(innerFn, outerFn, self, tryLocsList, PromiseImpl) {
    if (PromiseImpl === void 0) PromiseImpl = Promise;

    var iter = new AsyncIterator(
      wrap(innerFn, outerFn, self, tryLocsList),
      PromiseImpl
    );

    return exports.isGeneratorFunction(outerFn)
      ? iter // If outerFn is a generator, return the full iterator.
      : iter.next().then(function(result) {
          return result.done ? result.value : iter.next();
        });
  };

  function makeInvokeMethod(innerFn, self, context) {
    var state = GenStateSuspendedStart;

    return function invoke(method, arg) {
      if (state === GenStateExecuting) {
        throw new Error("Generator is already running");
      }

      if (state === GenStateCompleted) {
        if (method === "throw") {
          throw arg;
        }

        // Be forgiving, per 25.3.3.3.3 of the spec:
        // https://people.mozilla.org/~jorendorff/es6-draft.html#sec-generatorresume
        return doneResult();
      }

      context.method = method;
      context.arg = arg;

      while (true) {
        var delegate = context.delegate;
        if (delegate) {
          var delegateResult = maybeInvokeDelegate(delegate, context);
          if (delegateResult) {
            if (delegateResult === ContinueSentinel) continue;
            return delegateResult;
          }
        }

        if (context.method === "next") {
          // Setting context._sent for legacy support of Babel's
          // function.sent implementation.
          context.sent = context._sent = context.arg;

        } else if (context.method === "throw") {
          if (state === GenStateSuspendedStart) {
            state = GenStateCompleted;
            throw context.arg;
          }

          context.dispatchException(context.arg);

        } else if (context.method === "return") {
          context.abrupt("return", context.arg);
        }

        state = GenStateExecuting;

        var record = tryCatch(innerFn, self, context);
        if (record.type === "normal") {
          // If an exception is thrown from innerFn, we leave state ===
          // GenStateExecuting and loop back for another invocation.
          state = context.done
            ? GenStateCompleted
            : GenStateSuspendedYield;

          if (record.arg === ContinueSentinel) {
            continue;
          }

          return {
            value: record.arg,
            done: context.done
          };

        } else if (record.type === "throw") {
          state = GenStateCompleted;
          // Dispatch the exception by looping back around to the
          // context.dispatchException(context.arg) call above.
          context.method = "throw";
          context.arg = record.arg;
        }
      }
    };
  }

  // Call delegate.iterator[context.method](context.arg) and handle the
  // result, either by returning a { value, done } result from the
  // delegate iterator, or by modifying context.method and context.arg,
  // setting context.delegate to null, and returning the ContinueSentinel.
  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];
    if (method === undefined) {
      // A .throw or .return when the delegate iterator has no .throw
      // method always terminates the yield* loop.
      context.delegate = null;

      if (context.method === "throw") {
        // Note: ["return"] must be used for ES3 parsing compatibility.
        if (delegate.iterator["return"]) {
          // If the delegate iterator has a return method, give it a
          // chance to clean up.
          context.method = "return";
          context.arg = undefined;
          maybeInvokeDelegate(delegate, context);

          if (context.method === "throw") {
            // If maybeInvokeDelegate(context) changed context.method from
            // "return" to "throw", let that override the TypeError below.
            return ContinueSentinel;
          }
        }

        context.method = "throw";
        context.arg = new TypeError(
          "The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);

    if (record.type === "throw") {
      context.method = "throw";
      context.arg = record.arg;
      context.delegate = null;
      return ContinueSentinel;
    }

    var info = record.arg;

    if (! info) {
      context.method = "throw";
      context.arg = new TypeError("iterator result is not an object");
      context.delegate = null;
      return ContinueSentinel;
    }

    if (info.done) {
      // Assign the result of the finished delegate to the temporary
      // variable specified by delegate.resultName (see delegateYield).
      context[delegate.resultName] = info.value;

      // Resume execution at the desired location (see delegateYield).
      context.next = delegate.nextLoc;

      // If context.method was "throw" but the delegate handled the
      // exception, let the outer generator proceed normally. If
      // context.method was "next", forget context.arg since it has been
      // "consumed" by the delegate iterator. If context.method was
      // "return", allow the original .return call to continue in the
      // outer generator.
      if (context.method !== "return") {
        context.method = "next";
        context.arg = undefined;
      }

    } else {
      // Re-yield the result returned by the delegate method.
      return info;
    }

    // The delegate iterator is finished, so forget it and continue with
    // the outer generator.
    context.delegate = null;
    return ContinueSentinel;
  }

  // Define Generator.prototype.{next,throw,return} in terms of the
  // unified ._invoke helper method.
  defineIteratorMethods(Gp);

  define(Gp, toStringTagSymbol, "Generator");

  // A Generator should always return itself as the iterator object when the
  // @@iterator function is called on it. Some browsers' implementations of the
  // iterator prototype chain incorrectly implement this, causing the Generator
  // object to not be returned from this call. This ensures that doesn't happen.
  // See https://github.com/facebook/regenerator/issues/274 for more details.
  Gp[iteratorSymbol] = function() {
    return this;
  };

  Gp.toString = function() {
    return "[object Generator]";
  };

  function pushTryEntry(locs) {
    var entry = { tryLoc: locs[0] };

    if (1 in locs) {
      entry.catchLoc = locs[1];
    }

    if (2 in locs) {
      entry.finallyLoc = locs[2];
      entry.afterLoc = locs[3];
    }

    this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal";
    delete record.arg;
    entry.completion = record;
  }

  function Context(tryLocsList) {
    // The root entry object (effectively a try statement without a catch
    // or a finally block) gives us a place to store values thrown from
    // locations where there is no enclosing try statement.
    this.tryEntries = [{ tryLoc: "root" }];
    tryLocsList.forEach(pushTryEntry, this);
    this.reset(true);
  }

  exports.keys = function(object) {
    var keys = [];
    for (var key in object) {
      keys.push(key);
    }
    keys.reverse();

    // Rather than returning an object with a next method, we keep
    // things simple and return the next function itself.
    return function next() {
      while (keys.length) {
        var key = keys.pop();
        if (key in object) {
          next.value = key;
          next.done = false;
          return next;
        }
      }

      // To avoid creating an additional object, we just hang the .value
      // and .done properties off the next function object itself. This
      // also ensures that the minifier will not anonymize the function.
      next.done = true;
      return next;
    };
  };

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) {
        return iteratorMethod.call(iterable);
      }

      if (typeof iterable.next === "function") {
        return iterable;
      }

      if (!isNaN(iterable.length)) {
        var i = -1, next = function next() {
          while (++i < iterable.length) {
            if (hasOwn.call(iterable, i)) {
              next.value = iterable[i];
              next.done = false;
              return next;
            }
          }

          next.value = undefined;
          next.done = true;

          return next;
        };

        return next.next = next;
      }
    }

    // Return an iterator with no values.
    return { next: doneResult };
  }
  exports.values = values;

  function doneResult() {
    return { value: undefined, done: true };
  }

  Context.prototype = {
    constructor: Context,

    reset: function(skipTempReset) {
      this.prev = 0;
      this.next = 0;
      // Resetting context._sent for legacy support of Babel's
      // function.sent implementation.
      this.sent = this._sent = undefined;
      this.done = false;
      this.delegate = null;

      this.method = "next";
      this.arg = undefined;

      this.tryEntries.forEach(resetTryEntry);

      if (!skipTempReset) {
        for (var name in this) {
          // Not sure about the optimal order of these conditions:
          if (name.charAt(0) === "t" &&
              hasOwn.call(this, name) &&
              !isNaN(+name.slice(1))) {
            this[name] = undefined;
          }
        }
      }
    },

    stop: function() {
      this.done = true;

      var rootEntry = this.tryEntries[0];
      var rootRecord = rootEntry.completion;
      if (rootRecord.type === "throw") {
        throw rootRecord.arg;
      }

      return this.rval;
    },

    dispatchException: function(exception) {
      if (this.done) {
        throw exception;
      }

      var context = this;
      function handle(loc, caught) {
        record.type = "throw";
        record.arg = exception;
        context.next = loc;

        if (caught) {
          // If the dispatched exception was caught by a catch block,
          // then let that catch block handle the exception normally.
          context.method = "next";
          context.arg = undefined;
        }

        return !! caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        var record = entry.completion;

        if (entry.tryLoc === "root") {
          // Exception thrown outside of any try block that could handle
          // it, so set the completion value of the entire function to
          // throw the exception.
          return handle("end");
        }

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc");
          var hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            } else if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            }

          } else if (hasFinally) {
            if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else {
            throw new Error("try statement without catch or finally");
          }
        }
      }
    },

    abrupt: function(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc <= this.prev &&
            hasOwn.call(entry, "finallyLoc") &&
            this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      if (finallyEntry &&
          (type === "break" ||
           type === "continue") &&
          finallyEntry.tryLoc <= arg &&
          arg <= finallyEntry.finallyLoc) {
        // Ignore the finally entry if control is not jumping to a
        // location outside the try/catch block.
        finallyEntry = null;
      }

      var record = finallyEntry ? finallyEntry.completion : {};
      record.type = type;
      record.arg = arg;

      if (finallyEntry) {
        this.method = "next";
        this.next = finallyEntry.finallyLoc;
        return ContinueSentinel;
      }

      return this.complete(record);
    },

    complete: function(record, afterLoc) {
      if (record.type === "throw") {
        throw record.arg;
      }

      if (record.type === "break" ||
          record.type === "continue") {
        this.next = record.arg;
      } else if (record.type === "return") {
        this.rval = this.arg = record.arg;
        this.method = "return";
        this.next = "end";
      } else if (record.type === "normal" && afterLoc) {
        this.next = afterLoc;
      }

      return ContinueSentinel;
    },

    finish: function(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) {
          this.complete(entry.completion, entry.afterLoc);
          resetTryEntry(entry);
          return ContinueSentinel;
        }
      }
    },

    "catch": function(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;
          if (record.type === "throw") {
            var thrown = record.arg;
            resetTryEntry(entry);
          }
          return thrown;
        }
      }

      // The context.catch method must only be called with a location
      // argument that corresponds to a known catch block.
      throw new Error("illegal catch attempt");
    },

    delegateYield: function(iterable, resultName, nextLoc) {
      this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      };

      if (this.method === "next") {
        // Deliberately forget the last sent value so that we don't
        // accidentally pass it on to the delegate.
        this.arg = undefined;
      }

      return ContinueSentinel;
    }
  };

  // Regardless of whether this script is executing as a CommonJS module
  // or not, return the runtime object so that we can declare the variable
  // regeneratorRuntime in the outer scope, which allows this module to be
  // injected easily by `bin/regenerator --include-runtime script.js`.
  return exports;

}(
  // If this script is executing as a CommonJS module, use module.exports
  // as the regeneratorRuntime namespace. Otherwise create a new empty
  // object. Either way, the resulting object will be used to initialize
  // the regeneratorRuntime variable at the top of this file.
   true ? module.exports : 0
));

try {
  regeneratorRuntime = runtime;
} catch (accidentalStrictMode) {
  // This module should not be running in strict mode, so the above
  // assignment should always work unless something is misconfigured. Just
  // in case runtime.js accidentally runs in strict mode, we can escape
  // strict mode using a global Function call. This could conceivably fail
  // if a Content Security Policy forbids using Function, but in that case
  // the proper solution is to fix the accidental strict mode problem. If
  // you've misconfigured your bundler to force strict mode and applied a
  // CSP to forbid Function, and you're not willing to fix either of those
  // problems, please detail your unique predicament in a GitHub issue.
  Function("r", "regeneratorRuntime = r")(runtime);
}


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/projects/ProjectsComponent.vue?vue&type=style&index=0&id=3ddcd2b9&scoped=true&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/projects/ProjectsComponent.vue?vue&type=style&index=0&id=3ddcd2b9&scoped=true&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectsComponent_vue_vue_type_style_index_0_id_3ddcd2b9_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProjectsComponent.vue?vue&type=style&index=0&id=3ddcd2b9&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/projects/ProjectsComponent.vue?vue&type=style&index=0&id=3ddcd2b9&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectsComponent_vue_vue_type_style_index_0_id_3ddcd2b9_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectsComponent_vue_vue_type_style_index_0_id_3ddcd2b9_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/projects/ProjectsComponent.vue":
/*!****************************************************************!*\
  !*** ./resources/js/components/projects/ProjectsComponent.vue ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ProjectsComponent_vue_vue_type_template_id_3ddcd2b9_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProjectsComponent.vue?vue&type=template&id=3ddcd2b9&scoped=true& */ "./resources/js/components/projects/ProjectsComponent.vue?vue&type=template&id=3ddcd2b9&scoped=true&");
/* harmony import */ var _ProjectsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ProjectsComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/projects/ProjectsComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _ProjectsComponent_vue_vue_type_style_index_0_id_3ddcd2b9_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ProjectsComponent.vue?vue&type=style&index=0&id=3ddcd2b9&scoped=true&lang=css& */ "./resources/js/components/projects/ProjectsComponent.vue?vue&type=style&index=0&id=3ddcd2b9&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _ProjectsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ProjectsComponent_vue_vue_type_template_id_3ddcd2b9_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _ProjectsComponent_vue_vue_type_template_id_3ddcd2b9_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "3ddcd2b9",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/projects/ProjectsComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/projects/ProjectsComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/projects/ProjectsComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProjectsComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/projects/ProjectsComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/projects/ProjectsComponent.vue?vue&type=style&index=0&id=3ddcd2b9&scoped=true&lang=css&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/projects/ProjectsComponent.vue?vue&type=style&index=0&id=3ddcd2b9&scoped=true&lang=css& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectsComponent_vue_vue_type_style_index_0_id_3ddcd2b9_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProjectsComponent.vue?vue&type=style&index=0&id=3ddcd2b9&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/projects/ProjectsComponent.vue?vue&type=style&index=0&id=3ddcd2b9&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/projects/ProjectsComponent.vue?vue&type=template&id=3ddcd2b9&scoped=true&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/projects/ProjectsComponent.vue?vue&type=template&id=3ddcd2b9&scoped=true& ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectsComponent_vue_vue_type_template_id_3ddcd2b9_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectsComponent_vue_vue_type_template_id_3ddcd2b9_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProjectsComponent_vue_vue_type_template_id_3ddcd2b9_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProjectsComponent.vue?vue&type=template&id=3ddcd2b9&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/projects/ProjectsComponent.vue?vue&type=template&id=3ddcd2b9&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/projects/ProjectsComponent.vue?vue&type=template&id=3ddcd2b9&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/projects/ProjectsComponent.vue?vue&type=template&id=3ddcd2b9&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "container" }, [
    _vm.modal
      ? _c(
          "div",
          [
            _c("transition", { attrs: { name: "model" } }, [
              _c("div", { staticClass: "modal-mask" }, [
                _c("div", { staticClass: "modal-wrapper" }, [
                  _c("div", { staticClass: "modal-dialog" }, [
                    _c("div", { staticClass: "modal-content" }, [
                      _c("div", { staticClass: "modal-header" }, [
                        _c("h4", { staticClass: "modal-title" }, [
                          _vm._v(_vm._s(_vm.dynamicTitle))
                        ]),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "close",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                _vm.edit = null
                                _vm.modal = false
                              }
                            }
                          },
                          [
                            _c("span", { attrs: { "aria-hidden": "true" } }, [
                              _vm._v("× ")
                            ])
                          ]
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "modal-body" }, [
                        _c("div", { staticClass: "form-group" }, [
                          _c("label", [_vm._v("Enter Title")]),
                          _vm._v(" "),
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.form.title,
                                expression: "form.title"
                              }
                            ],
                            staticClass: "form-control",
                            class: { "is-invalid": _vm.errors.title },
                            attrs: { type: "text" },
                            domProps: { value: _vm.form.title },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(_vm.form, "title", $event.target.value)
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.errors.title
                            ? _c("div", { staticClass: "invalid-feedback" }, [
                                _vm._v(
                                  "\n                    " +
                                    _vm._s(_vm.errors.title) +
                                    "\n                  "
                                )
                              ])
                            : _vm._e()
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "form-group" }, [
                          _c("label", [_vm._v("Enter Description")]),
                          _vm._v(" "),
                          _c("textarea", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.form.description,
                                expression: "form.description"
                              }
                            ],
                            staticClass: "form-control",
                            class: { "is-invalid": _vm.errors.description },
                            attrs: { rows: "3" },
                            domProps: { value: _vm.form.description },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.form,
                                  "description",
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.errors.description
                            ? _c("div", { staticClass: "invalid-feedback" }, [
                                _vm._v(
                                  "\n                    " +
                                    _vm._s(_vm.errors.description) +
                                    "\n                  "
                                )
                              ])
                            : _vm._e()
                        ]),
                        _vm._v(" "),
                        Object.keys(this.teamsAdmin).lenght > 1
                          ? _c("div", { staticClass: "form-group" }, [
                              _c("label", [_vm._v("Choose Team")]),
                              _vm._v(" "),
                              _c(
                                "select",
                                {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: _vm.form.team_id,
                                      expression: "form.team_id"
                                    }
                                  ],
                                  staticClass: "form-control",
                                  class: { "is-invalid": _vm.errors.team_id },
                                  on: {
                                    change: function($event) {
                                      var $$selectedVal = Array.prototype.filter
                                        .call($event.target.options, function(
                                          o
                                        ) {
                                          return o.selected
                                        })
                                        .map(function(o) {
                                          var val =
                                            "_value" in o ? o._value : o.value
                                          return val
                                        })
                                      _vm.$set(
                                        _vm.form,
                                        "team_id",
                                        $event.target.multiple
                                          ? $$selectedVal
                                          : $$selectedVal[0]
                                      )
                                    }
                                  }
                                },
                                _vm._l(this.teamsAdmin, function(team) {
                                  return _c(
                                    "option",
                                    {
                                      key: team.id,
                                      domProps: { value: team.id }
                                    },
                                    [
                                      _vm._v(
                                        "\n                      " +
                                          _vm._s(team.name) +
                                          "\n                    "
                                      )
                                    ]
                                  )
                                }),
                                0
                              ),
                              _vm._v(" "),
                              _vm.errors.team_id
                                ? _c(
                                    "div",
                                    { staticClass: "invalid-feedback" },
                                    [
                                      _vm._v(
                                        "\n                    " +
                                          _vm._s(_vm.errors.team_id) +
                                          "\n                  "
                                      )
                                    ]
                                  )
                                : _vm._e()
                            ])
                          : _vm._e(),
                        _vm._v(" "),
                        _c("div", { attrs: { align: "center" } }, [
                          _vm.edit == null
                            ? _c("input", {
                                staticClass: "btn btn-primary",
                                attrs: { type: "button", value: "Submit" },
                                on: { click: _vm.create }
                              })
                            : _c("input", {
                                staticClass: "btn btn-primary",
                                attrs: { type: "button", value: "Submit" },
                                on: { click: _vm.update }
                              })
                        ])
                      ])
                    ])
                  ])
                ])
              ])
            ])
          ],
          1
        )
      : _vm._e(),
    _vm._v(" "),
    this.createdProjects.length > 0
      ? _c("div", { staticClass: "row justify-content-center" }, [
          _c("div", { staticClass: "col-12 card mt-3" }, [
            _c("div", { staticClass: "card-body text-center" }, [
              _c("h3", { staticClass: "card-title" }, [
                _vm._v("Created Projects")
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "table-responsive" }, [
                _c(
                  "table",
                  { staticClass: "table-striped w-100 d-block d-md-table" },
                  [
                    _vm._m(0),
                    _vm._v(" "),
                    _c(
                      "tbody",
                      [
                        _vm._l(_vm.createdProjects, function(project) {
                          return _c("tr", { key: project.id }, [
                            project.id > 0
                              ? _c(
                                  "td",
                                  {
                                    staticClass: "link",
                                    staticStyle: { width: "25%" },
                                    on: {
                                      click: function($event) {
                                        return _vm.$router.push({
                                          name: "Project",
                                          params: { projectId: project.id }
                                        })
                                      }
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(project.title) +
                                        "\n                "
                                    )
                                  ]
                                )
                              : _vm._e(),
                            _vm._v(" "),
                            project.description != null
                              ? _c("td", { staticStyle: { width: "40%" } }, [
                                  _vm._v(
                                    "\n                  " +
                                      _vm._s(project.description) +
                                      "\n                "
                                  )
                                ])
                              : _c("td", { staticStyle: { width: "40%" } }, [
                                  _vm._v("-")
                                ]),
                            _vm._v(" "),
                            project.team_id != null && project.team_id > 0
                              ? _c(
                                  "td",
                                  {
                                    staticClass: "link",
                                    staticStyle: { width: "25%" },
                                    on: {
                                      click: function($event) {
                                        return _vm.$router.push({
                                          name: "Team",
                                          params: { teamId: project.team_id }
                                        })
                                      }
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(
                                          _vm.teams[project.team_id].name
                                        ) +
                                        "\n                "
                                    )
                                  ]
                                )
                              : _c("td", { staticStyle: { width: "25%" } }, [
                                  _vm._v("No Team")
                                ]),
                            _vm._v(" "),
                            _c("td", { staticStyle: { width: "5%" } }, [
                              _c(
                                "button",
                                {
                                  staticClass: "btn btn-primary",
                                  staticStyle: { margin: "1px" },
                                  attrs: { type: "button" },
                                  on: {
                                    click: function($event) {
                                      return _vm.startEdit(project)
                                    }
                                  }
                                },
                                [
                                  _c("span", { staticClass: "icon is-small" }, [
                                    _c(
                                      "svg",
                                      {
                                        staticClass: "bi bi-three-dots",
                                        attrs: {
                                          xmlns: "http://www.w3.org/2000/svg",
                                          width: "16",
                                          height: "16",
                                          fill: "currentColor",
                                          viewBox: "0 0 16 16"
                                        }
                                      },
                                      [
                                        _c("path", {
                                          attrs: {
                                            d:
                                              "M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"
                                          }
                                        })
                                      ]
                                    )
                                  ])
                                ]
                              )
                            ]),
                            _vm._v(" "),
                            _c("td", { staticStyle: { width: "5%" } }, [
                              _c(
                                "button",
                                {
                                  staticClass: "btn btn-danger",
                                  attrs: { type: "button" },
                                  on: {
                                    click: function($event) {
                                      return _vm.startDelete(project)
                                    }
                                  }
                                },
                                [
                                  _c("span", { staticClass: "icon is-small" }, [
                                    _c(
                                      "svg",
                                      {
                                        staticClass: "bi bi-trash",
                                        attrs: {
                                          xmlns: "http://www.w3.org/2000/svg",
                                          width: "16",
                                          height: "16",
                                          fill: "currentColor",
                                          viewBox: "0 0 16 16"
                                        }
                                      },
                                      [
                                        _c("path", {
                                          attrs: {
                                            d:
                                              "M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"
                                          }
                                        }),
                                        _vm._v(" "),
                                        _c("path", {
                                          attrs: {
                                            "fill-rule": "evenodd",
                                            d:
                                              "M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"
                                          }
                                        })
                                      ]
                                    )
                                  ])
                                ]
                              )
                            ])
                          ])
                        }),
                        _vm._v(" "),
                        !_vm.createForm
                          ? _c("tr", { staticClass: "bg-white" }, [
                              _c("td"),
                              _vm._v(" "),
                              _c("td", [
                                _c(
                                  "button",
                                  {
                                    staticClass: "btn btn-secondary",
                                    staticStyle: { margin: "3px" },
                                    attrs: { type: "button" },
                                    on: {
                                      click: function($event) {
                                        return _vm.startCreate()
                                      }
                                    }
                                  },
                                  [
                                    _c(
                                      "span",
                                      { staticClass: "icon full-size" },
                                      [
                                        _c(
                                          "svg",
                                          {
                                            staticClass: "bi bi-plus-square",
                                            attrs: {
                                              xmlns:
                                                "http://www.w3.org/2000/svg",
                                              width: "16",
                                              height: "16",
                                              fill: "currentColor",
                                              viewBox: "0 0 16 16"
                                            }
                                          },
                                          [
                                            _c("path", {
                                              attrs: {
                                                d:
                                                  "M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"
                                              }
                                            }),
                                            _vm._v(" "),
                                            _c("path", {
                                              attrs: {
                                                d:
                                                  "M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"
                                              }
                                            })
                                          ]
                                        ),
                                        _vm._v(
                                          "\n                      Create Project\n                    "
                                        )
                                      ]
                                    )
                                  ]
                                )
                              ])
                            ])
                          : _c("tr", { staticClass: "bg-white" }, [
                              _c("td", [
                                _c("input", {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: _vm.form.title,
                                      expression: "form.title"
                                    }
                                  ],
                                  staticClass: "form-control input-sm",
                                  class: { "is-invalid": _vm.errors.title },
                                  attrs: {
                                    type: "text",
                                    placeholder: "Enter title"
                                  },
                                  domProps: { value: _vm.form.title },
                                  on: {
                                    input: function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        _vm.form,
                                        "title",
                                        $event.target.value
                                      )
                                    }
                                  }
                                }),
                                _vm._v(" "),
                                _vm.errors.title
                                  ? _c(
                                      "div",
                                      {
                                        staticClass:
                                          "tooltip bs-tooltip-top show invalid-feedback"
                                      },
                                      [
                                        _vm._v(
                                          "\n                    " +
                                            _vm._s(_vm.errors.title) +
                                            "\n                  "
                                        )
                                      ]
                                    )
                                  : _vm._e()
                              ]),
                              _vm._v(" "),
                              _c("td", [
                                _c("input", {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: _vm.form.description,
                                      expression: "form.description"
                                    }
                                  ],
                                  staticClass: "form-control input-sm",
                                  class: {
                                    "is-invalid": _vm.errors.description
                                  },
                                  attrs: {
                                    type: "text",
                                    rows: "1",
                                    placeholder: "Enter description"
                                  },
                                  domProps: { value: _vm.form.description },
                                  on: {
                                    input: function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        _vm.form,
                                        "description",
                                        $event.target.value
                                      )
                                    }
                                  }
                                }),
                                _vm._v(" "),
                                _vm.errors.description
                                  ? _c(
                                      "div",
                                      {
                                        staticClass:
                                          "tooltip bs-tooltip-top show invalid-feedback"
                                      },
                                      [
                                        _vm._v(
                                          "\n                    " +
                                            _vm._s(_vm.errors.description) +
                                            "\n                  "
                                        )
                                      ]
                                    )
                                  : _vm._e()
                              ]),
                              _vm._v(" "),
                              _c("td", [
                                _c(
                                  "select",
                                  {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: _vm.form.team_id,
                                        expression: "form.team_id"
                                      }
                                    ],
                                    staticClass: "form-control input-sm",
                                    class: { "is-invalid": _vm.errors.team_id },
                                    on: {
                                      change: function($event) {
                                        var $$selectedVal = Array.prototype.filter
                                          .call($event.target.options, function(
                                            o
                                          ) {
                                            return o.selected
                                          })
                                          .map(function(o) {
                                            var val =
                                              "_value" in o ? o._value : o.value
                                            return val
                                          })
                                        _vm.$set(
                                          _vm.form,
                                          "team_id",
                                          $event.target.multiple
                                            ? $$selectedVal
                                            : $$selectedVal[0]
                                        )
                                      }
                                    }
                                  },
                                  _vm._l(this.teamsAdmin, function(team) {
                                    return _c(
                                      "option",
                                      {
                                        key: team.id,
                                        domProps: { value: team.id }
                                      },
                                      [
                                        _vm._v(
                                          "\n                      " +
                                            _vm._s(team.name) +
                                            "\n                    "
                                        )
                                      ]
                                    )
                                  }),
                                  0
                                ),
                                _vm._v(" "),
                                _vm.errors.team_id
                                  ? _c(
                                      "div",
                                      {
                                        staticClass:
                                          "tooltip bs-tooltip-top show invalid-feedback"
                                      },
                                      [
                                        _vm._v(
                                          "\n                    " +
                                            _vm._s(_vm.errors.team_id) +
                                            "\n                  "
                                        )
                                      ]
                                    )
                                  : _vm._e()
                              ]),
                              _vm._v(" "),
                              _c("td", [
                                _c(
                                  "button",
                                  {
                                    staticClass: "btn btn-success",
                                    staticStyle: { margin: "1px" },
                                    attrs: { type: "button" },
                                    on: {
                                      click: function($event) {
                                        return _vm.create()
                                      }
                                    }
                                  },
                                  [
                                    _c(
                                      "span",
                                      { staticClass: "icon is-small" },
                                      [
                                        _c(
                                          "svg",
                                          {
                                            staticClass: "bi bi-check-circle",
                                            attrs: {
                                              xmlns:
                                                "http://www.w3.org/2000/svg",
                                              width: "16",
                                              height: "16",
                                              fill: "currentColor",
                                              viewBox: "0 0 16 16"
                                            }
                                          },
                                          [
                                            _c("path", {
                                              attrs: {
                                                d:
                                                  "M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"
                                              }
                                            }),
                                            _vm._v(" "),
                                            _c("path", {
                                              attrs: {
                                                d:
                                                  "M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"
                                              }
                                            })
                                          ]
                                        )
                                      ]
                                    )
                                  ]
                                )
                              ]),
                              _vm._v(" "),
                              _c("td", [
                                _c(
                                  "button",
                                  {
                                    staticClass: "btn btn-danger",
                                    staticStyle: { margin: "1px" },
                                    attrs: { type: "button" },
                                    on: {
                                      click: function($event) {
                                        return _vm.endCreate()
                                      }
                                    }
                                  },
                                  [
                                    _c(
                                      "span",
                                      { staticClass: "icon is-small" },
                                      [
                                        _c(
                                          "svg",
                                          {
                                            staticClass: "bi bi-x-circle",
                                            attrs: {
                                              xmlns:
                                                "http://www.w3.org/2000/svg",
                                              width: "16",
                                              height: "16",
                                              fill: "currentColor",
                                              viewBox: "0 0 16 16"
                                            }
                                          },
                                          [
                                            _c("path", {
                                              attrs: {
                                                d:
                                                  "M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"
                                              }
                                            }),
                                            _vm._v(" "),
                                            _c("path", {
                                              attrs: {
                                                d:
                                                  "M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                                              }
                                            })
                                          ]
                                        )
                                      ]
                                    )
                                  ]
                                )
                              ])
                            ])
                      ],
                      2
                    )
                  ]
                )
              ])
            ])
          ])
        ])
      : this.loaded
      ? _c("div", { staticClass: "row justify-content-center" }, [
          _c("div", { staticClass: "col-12 card mt-3" }, [
            _c("div", { staticClass: "card-body text-center" }, [
              _c("h3", { staticClass: "card-title" }, [
                _vm._v("Created Projects")
              ]),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-secondary w-25 mt-3",
                  attrs: { type: "button" },
                  on: {
                    click: function($event) {
                      return _vm.startProject()
                    }
                  }
                },
                [
                  _c("span", { staticClass: "icon full-size" }, [
                    _c(
                      "svg",
                      {
                        staticClass: "bi bi-plus-square",
                        attrs: {
                          xmlns: "http://www.w3.org/2000/svg",
                          width: "16",
                          height: "16",
                          fill: "currentColor",
                          viewBox: "0 0 16 16"
                        }
                      },
                      [
                        _c("path", {
                          attrs: {
                            d:
                              "M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"
                          }
                        }),
                        _vm._v(" "),
                        _c("path", {
                          attrs: {
                            d:
                              "M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"
                          }
                        })
                      ]
                    ),
                    _vm._v("\n            Start Project\n          ")
                  ])
                ]
              )
            ])
          ])
        ])
      : _c("div", { staticClass: "row justify-content-center" }, [
          _c("div", { staticClass: "loader mt-3" })
        ]),
    _vm._v(" "),
    this.teamProjects.length > 0
      ? _c("div", { staticClass: "row justify-content-center" }, [
          _c("div", { staticClass: "col-12 card mt-3" }, [
            _c("div", { staticClass: "card-body text-center" }, [
              _c("h3", { staticClass: "card-title" }, [
                _vm._v("Team Projects")
              ]),
              _vm._v(" "),
              _c("table", { staticClass: "table-striped full-width" }, [
                _vm._m(1),
                _vm._v(" "),
                _c(
                  "tbody",
                  _vm._l(_vm.teamProjects, function(project) {
                    return _c("tr", { key: project.id }, [
                      _c("td", { staticStyle: { width: "35%" } }, [
                        _vm._v(_vm._s(project.title))
                      ]),
                      _vm._v(" "),
                      _c("td", { staticStyle: { width: "30%" } }, [
                        _vm._v(
                          "\n                " +
                            _vm._s(_vm.projectsUsers[project.author_id].name) +
                            "\n              "
                        )
                      ]),
                      _vm._v(" "),
                      project.team_id != null
                        ? _c("td", { staticStyle: { width: "35%" } }, [
                            _vm._v(
                              "\n                " +
                                _vm._s(_vm.teams[project.team_id].name) +
                                "\n              "
                            )
                          ])
                        : _c("td", { staticStyle: { width: "35%" } }, [
                            _vm._v("No Team")
                          ])
                    ])
                  }),
                  0
                )
              ])
            ])
          ])
        ])
      : _vm._e()
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticStyle: { width: "25%" } }, [_vm._v("Title")]),
        _vm._v(" "),
        _c("th", { staticStyle: { width: "40%" } }, [_vm._v("Description")]),
        _vm._v(" "),
        _c("th", { staticStyle: { width: "25%" } }, [_vm._v("Team")]),
        _vm._v(" "),
        _c("th", { staticStyle: { width: "5%" } }),
        _vm._v(" "),
        _c("th", { staticStyle: { width: "5%" } })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticStyle: { width: "35%" } }, [_vm._v("Title")]),
        _vm._v(" "),
        _c("th", { staticStyle: { width: "30%" } }, [_vm._v("Author")]),
        _vm._v(" "),
        _c("th", { staticStyle: { width: "35%" } }, [_vm._v("Team")])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);