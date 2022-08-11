(function () {
  function r(e, n, t) {
    function o(i, f) {
      if (!n[i]) {
        if (!e[i]) {
          var c = "function" == typeof require && require;
          if (!f && c) return c(i, !0);
          if (u) return u(i, !0);
          var a = new Error("Cannot find module '" + i + "'");
          throw ((a.code = "MODULE_NOT_FOUND"), a);
        }
        var p = (n[i] = { exports: {} });
        e[i][0].call(
          p.exports,
          function (r) {
            var n = e[i][1][r];
            return o(n || r);
          },
          p,
          p.exports,
          r,
          e,
          n,
          t,
        );
      }
      return n[i].exports;
    }
    for (
      var u = "function" == typeof require && require, i = 0;
      i < t.length;
      i++
    )
      o(t[i]);
    return o;
  }
  return r;
})()(
  {
    1: [
      function (require, module, exports) {
        "use strict";

        Object.defineProperty(exports, "__esModule", {
          value: true,
        });
        exports["default"] = void 0;

        var CustomCSS = function CustomCSS() {
          function init() {
            elementor.on("preview:loaded", customCSS);
            elementor.settings.page.model.on("change", customCSS);
          }

          return {
            init: init,
          };
        };

        var _default = CustomCSS();

        exports["default"] = _default;
      },
      {},
    ],
    2: [
      function (require, module, exports) {
        "use strict";

        Object.defineProperty(exports, "__esModule", {
          value: true,
        });
        exports["default"] = void 0;

        var Templates = function Templates() {
          function onRequestInit() {
            jQuery(document).ajaxComplete(function (event, request, settings) {
              if (
                typeof settings.data !== "undefined" &&
                settings.data.indexOf("get_library_data") !== -1 &&
                settings.data.indexOf("action=elementor_ajax") !== -1
              ) {
                setTimeout(actuallyInit, 100);
              }
            });
          }

          function actuallyInit() {
            var layout = elementor.templates.layout;

            if (typeof layout === "undefined") {
              return;
            }

            var content = layout.modalContent; // Add Jupiter X filter button.

            function addFilter() {
              var filter = content.$el.find(
                "#elementor-template-library-filter-toolbar-remote",
              );

              if (
                !filter.length ||
                filter.find(".raven-template-library-filter").length
              ) {
                return;
              }

              filter.append(
                '\n        <div class="raven-template-library-filter">\n                 </div>\n      ',
              );
              var button = filter.find(".raven-template-library-filter-button"),
                input = content.$el.find(
                  "#elementor-template-library-filter-text",
                ),
                query = "Jupiter X";
              var isFiltered = false;
              button.on("click", function () {
                isFiltered = !isFiltered;
                button.toggleClass(
                  "raven-template-library-filter-active",
                  isFiltered,
                );
                input.trigger("input");
              });
              input.on("input", function (event) {
                if (isFiltered) {
                  event.stopPropagation();
                  elementor.templates.setFilter(
                    "text",
                    "".concat(query, " - ").concat(input.val()),
                  );
                }
              });
            } // Initially apply class on initial page display.

            addFilter();
            /**
             * Listen to whenever a library menu item is clicked.
             * Such as Blocks, Pages or My Templates.
             */

            content.listenTo(content, "show", function () {
              // Whenever modal content is changing.
              addFilter();
            });
          }

          function init() {
            elementor.on("document:loaded", function () {
              // eslint-disable-next-line no-undef
              if (
                $e.components
                  .get("library")
                  .hasTab("templates/webkima_elements")
              ) {
                return;
              } // eslint-disable-next-line no-undef

              $e.components.get("library").addTab(
                "templates/webkima_elements",
                {
                  title: "وبکیما المنت",
                  filter: {
                    source: function source() {
                      elementor.channels.templates.reply(
                        "filter:source",
                        "remote",
                      );
                      return "WebkimaAcademy";
                    },
                    type: "block",
                  },
                },
                10,
              );
            });
          }

          return {
            init: init,
          };
        };

        var _default = Templates();

        exports["default"] = _default;
      },
      {},
    ],

    8: [
      function (require, module, exports) {
        "use strict";

        (function ($, window) {
          var RavenEditor = function RavenEditor() {
            var self = this;

            function initComponents() {
              var components = {
                templates: require("./components/templates")["default"],
                customCSS: require("./components/custom-css")["default"],
              };

              for (var component in components) {
                components[component].init();
              }
            }

            function initControls() {
              self.controls = {
                media: require("./controls/media")["default"],
                checkbox: require("./controls/checkbox")["default"],
                file_uploader: require("./controls/file-uploader")["default"],
                presets: require("./controls/presets")["default"],
                query: require("./controls/query")["default"],
              };

              for (var control in self.controls) {
                elementor.addControlView(
                  "raven_".concat(control),
                  self.controls[control],
                );
              }
            }

            function initWidgets() {
              var widgets = {
                "raven-form": require("./widgets/form")["default"],
                "raven-categories": require("./widgets/categories")["default"],
                "raven-posts": require("./widgets/posts")["default"],
                "raven-post-carousel": require("./widgets/posts")["default"],
              };

              for (var widget in widgets) {
                elementor.hooks.addAction(
                  "panel/open_editor/widget/".concat(widget),
                  widgets[widget],
                );
              }
            }

            function initUtils() {
              self.utils = {
                Module: require("./utils/module")["default"],
                Form: require("./utils/form")["default"],
              };
            }

            function onElementorReady() {
              initComponents();
            }

            function onElementorInit() {
              onElementorReady();
              elementor.on("frontend:init", onFrontendInit);
              elementor.on("preview:loaded", onPreviewLoaded);
              elementor.channels.data.bind(
                "element:after:reset:style",
                onElementResetStyle,
              );

              if (typeof elementor.settings.editorPreferences !== "undefined") {
                elementor.settings.editorPreferences.model.on(
                  "change",
                  setWidgetsDarkIcon,
                );
              }
            }

            $(window).on("elementor:init", onElementorInit);
          };

          window.ravenEditor = new RavenEditor();
        })(jQuery, window);
      },
      {
        "./components/custom-css": 1,
        "./components/templates": 2,
        "./controls/checkbox": 3,
        "./controls/file-uploader": 4,
        "./controls/media": 5,
        "./controls/presets": 6,
        "./controls/query": 7,
        "./utils/form": 9,
        "./utils/module": 10,
        "./widgets/categories": 11,
        "./widgets/form": 12,
        "./widgets/posts": 17,
      },
    ],
    18: [
      function (require, module, exports) {
        function _interopRequireDefault(obj) {
          return obj && obj.__esModule
            ? obj
            : {
                default: obj,
              };
        }

        module.exports = _interopRequireDefault;
      },
      {},
    ],
  },
  {},
  [8],
);
