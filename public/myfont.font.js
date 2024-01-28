/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./webfonts-loader/myfont.font.js":
/*!****************************************!*\
  !*** ./webfonts-loader/myfont.font.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./blocks/News/src/editor.scss":
/*!*************************************!*\
  !*** ./blocks/News/src/editor.scss ***!
  \*************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./blocks/Navigation/src/style.scss":
/*!******************************************!*\
  !*** ./blocks/Navigation/src/style.scss ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/src/styles/theme.scss":
/*!**************************************!*\
  !*** ./assets/src/styles/theme.scss ***!
  \**************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/src/styles/editor.scss":
/*!***************************************!*\
  !*** ./assets/src/styles/editor.scss ***!
  \***************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/src/styles/admin.scss":
/*!**************************************!*\
  !*** ./assets/src/styles/admin.scss ***!
  \**************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./blocks/Row/src/editor.scss":
/*!************************************!*\
  !*** ./blocks/Row/src/editor.scss ***!
  \************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./blocks/News/src/style.scss":
/*!************************************!*\
  !*** ./blocks/News/src/style.scss ***!
  \************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

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
/******/ 	!function() {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = function(result, chunkIds, fn, priority) {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var chunkIds = deferred[i][0];
/******/ 				var fn = deferred[i][1];
/******/ 				var priority = deferred[i][2];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every(function(key) { return __webpack_require__.O[key](chunkIds[j]); })) {
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
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	!function() {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/public/myfont.font": 0,
/******/ 			"blocks/News/build/style": 0,
/******/ 			"blocks/Row/build/editor": 0,
/******/ 			"assets/build/styles/admin": 0,
/******/ 			"assets/build/styles/editor": 0,
/******/ 			"assets/build/styles/theme": 0,
/******/ 			"blocks/Navigation/build/style": 0,
/******/ 			"blocks/News/build/editor": 0
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
/******/ 		__webpack_require__.O.j = function(chunkId) { return installedChunks[chunkId] === 0; };
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = function(parentChunkLoadingFunction, data) {
/******/ 			var chunkIds = data[0];
/******/ 			var moreModules = data[1];
/******/ 			var runtime = data[2];
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some(function(id) { return installedChunks[id] !== 0; })) {
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
/******/ 		var chunkLoadingGlobal = self["webpackChunkstarter_kit_theme"] = self["webpackChunkstarter_kit_theme"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["blocks/News/build/style","blocks/Row/build/editor","assets/build/styles/admin","assets/build/styles/editor","assets/build/styles/theme","blocks/Navigation/build/style","blocks/News/build/editor"], function() { return __webpack_require__("./webfonts-loader/myfont.font.js"); })
/******/ 	__webpack_require__.O(undefined, ["blocks/News/build/style","blocks/Row/build/editor","assets/build/styles/admin","assets/build/styles/editor","assets/build/styles/theme","blocks/Navigation/build/style","blocks/News/build/editor"], function() { return __webpack_require__("./assets/src/styles/theme.scss"); })
/******/ 	__webpack_require__.O(undefined, ["blocks/News/build/style","blocks/Row/build/editor","assets/build/styles/admin","assets/build/styles/editor","assets/build/styles/theme","blocks/Navigation/build/style","blocks/News/build/editor"], function() { return __webpack_require__("./assets/src/styles/editor.scss"); })
/******/ 	__webpack_require__.O(undefined, ["blocks/News/build/style","blocks/Row/build/editor","assets/build/styles/admin","assets/build/styles/editor","assets/build/styles/theme","blocks/Navigation/build/style","blocks/News/build/editor"], function() { return __webpack_require__("./assets/src/styles/admin.scss"); })
/******/ 	__webpack_require__.O(undefined, ["blocks/News/build/style","blocks/Row/build/editor","assets/build/styles/admin","assets/build/styles/editor","assets/build/styles/theme","blocks/Navigation/build/style","blocks/News/build/editor"], function() { return __webpack_require__("./blocks/Row/src/editor.scss"); })
/******/ 	__webpack_require__.O(undefined, ["blocks/News/build/style","blocks/Row/build/editor","assets/build/styles/admin","assets/build/styles/editor","assets/build/styles/theme","blocks/Navigation/build/style","blocks/News/build/editor"], function() { return __webpack_require__("./blocks/News/src/style.scss"); })
/******/ 	__webpack_require__.O(undefined, ["blocks/News/build/style","blocks/Row/build/editor","assets/build/styles/admin","assets/build/styles/editor","assets/build/styles/theme","blocks/Navigation/build/style","blocks/News/build/editor"], function() { return __webpack_require__("./blocks/News/src/editor.scss"); })
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["blocks/News/build/style","blocks/Row/build/editor","assets/build/styles/admin","assets/build/styles/editor","assets/build/styles/theme","blocks/Navigation/build/style","blocks/News/build/editor"], function() { return __webpack_require__("./blocks/Navigation/src/style.scss"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiL3B1YmxpYy9teWZvbnQuZm9udC5qcyIsIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7OztBQUFBOzs7Ozs7Ozs7Ozs7QUNBQTs7Ozs7Ozs7Ozs7O0FDQUE7Ozs7Ozs7Ozs7OztBQ0FBOzs7Ozs7Ozs7Ozs7QUNBQTs7Ozs7Ozs7Ozs7O0FDQUE7Ozs7Ozs7Ozs7OztBQ0FBOzs7Ozs7Ozs7Ozs7QUNBQTs7Ozs7OztVQ0FBO1VBQ0E7O1VBRUE7VUFDQTtVQUNBO1VBQ0E7VUFDQTtVQUNBO1VBQ0E7VUFDQTtVQUNBO1VBQ0E7VUFDQTtVQUNBO1VBQ0E7O1VBRUE7VUFDQTs7VUFFQTtVQUNBO1VBQ0E7O1VBRUE7VUFDQTs7Ozs7V0N6QkE7V0FDQTtXQUNBO1dBQ0E7V0FDQSwrQkFBK0Isd0NBQXdDO1dBQ3ZFO1dBQ0E7V0FDQTtXQUNBO1dBQ0EsaUJBQWlCLHFCQUFxQjtXQUN0QztXQUNBO1dBQ0E7V0FDQTtXQUNBLGtCQUFrQixxQkFBcUI7V0FDdkMsb0hBQW9ILGlEQUFpRDtXQUNySztXQUNBLEtBQUs7V0FDTDtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7Ozs7O1dDN0JBLDhDQUE4Qzs7Ozs7V0NBOUM7V0FDQTtXQUNBO1dBQ0EsdURBQXVELGlCQUFpQjtXQUN4RTtXQUNBLGdEQUFnRCxhQUFhO1dBQzdEOzs7OztXQ05BOztXQUVBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBOztXQUVBOztXQUVBOztXQUVBOztXQUVBOztXQUVBOztXQUVBLDhDQUE4Qzs7V0FFOUM7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBLGlDQUFpQyxtQ0FBbUM7V0FDcEU7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBLE1BQU0scUJBQXFCO1dBQzNCO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7O1dBRUE7V0FDQTtXQUNBOzs7OztVRXpEQTtVQUNBO1VBQ0E7VUFDQSxxUEFBcVAsaUVBQWlFO1VBQ3RULHFQQUFxUCwrREFBK0Q7VUFDcFQscVBBQXFQLGdFQUFnRTtVQUNyVCxxUEFBcVAsK0RBQStEO1VBQ3BULHFQQUFxUCw2REFBNkQ7VUFDbFQscVBBQXFQLDZEQUE2RDtVQUNsVCxxUEFBcVAsOERBQThEO1VBQ25ULCtRQUErUSxtRUFBbUU7VUFDbFYiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9zdGFydGVyLWtpdC10aGVtZS8uL3dlYmZvbnRzLWxvYWRlci9teWZvbnQuZm9udC5qcyIsIndlYnBhY2s6Ly9zdGFydGVyLWtpdC10aGVtZS8uL2Jsb2Nrcy9OZXdzL3NyYy9lZGl0b3Iuc2NzcyIsIndlYnBhY2s6Ly9zdGFydGVyLWtpdC10aGVtZS8uL2Jsb2Nrcy9OYXZpZ2F0aW9uL3NyYy9zdHlsZS5zY3NzPzZiMjUiLCJ3ZWJwYWNrOi8vc3RhcnRlci1raXQtdGhlbWUvLi9hc3NldHMvc3JjL3N0eWxlcy90aGVtZS5zY3NzPzU0M2YiLCJ3ZWJwYWNrOi8vc3RhcnRlci1raXQtdGhlbWUvLi9hc3NldHMvc3JjL3N0eWxlcy9lZGl0b3Iuc2Nzcz9mNWY2Iiwid2VicGFjazovL3N0YXJ0ZXIta2l0LXRoZW1lLy4vYXNzZXRzL3NyYy9zdHlsZXMvYWRtaW4uc2Nzcz8wNjFmIiwid2VicGFjazovL3N0YXJ0ZXIta2l0LXRoZW1lLy4vYmxvY2tzL1Jvdy9zcmMvZWRpdG9yLnNjc3M/Zjk0NSIsIndlYnBhY2s6Ly9zdGFydGVyLWtpdC10aGVtZS8uL2Jsb2Nrcy9OZXdzL3NyYy9zdHlsZS5zY3NzIiwid2VicGFjazovL3N0YXJ0ZXIta2l0LXRoZW1lL3dlYnBhY2svYm9vdHN0cmFwIiwid2VicGFjazovL3N0YXJ0ZXIta2l0LXRoZW1lL3dlYnBhY2svcnVudGltZS9jaHVuayBsb2FkZWQiLCJ3ZWJwYWNrOi8vc3RhcnRlci1raXQtdGhlbWUvd2VicGFjay9ydW50aW1lL2hhc093blByb3BlcnR5IHNob3J0aGFuZCIsIndlYnBhY2s6Ly9zdGFydGVyLWtpdC10aGVtZS93ZWJwYWNrL3J1bnRpbWUvbWFrZSBuYW1lc3BhY2Ugb2JqZWN0Iiwid2VicGFjazovL3N0YXJ0ZXIta2l0LXRoZW1lL3dlYnBhY2svcnVudGltZS9qc29ucCBjaHVuayBsb2FkaW5nIiwid2VicGFjazovL3N0YXJ0ZXIta2l0LXRoZW1lL3dlYnBhY2svYmVmb3JlLXN0YXJ0dXAiLCJ3ZWJwYWNrOi8vc3RhcnRlci1raXQtdGhlbWUvd2VicGFjay9zdGFydHVwIiwid2VicGFjazovL3N0YXJ0ZXIta2l0LXRoZW1lL3dlYnBhY2svYWZ0ZXItc3RhcnR1cCJdLCJzb3VyY2VzQ29udGVudCI6WyIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiLCIvLyBUaGUgbW9kdWxlIGNhY2hlXG52YXIgX193ZWJwYWNrX21vZHVsZV9jYWNoZV9fID0ge307XG5cbi8vIFRoZSByZXF1aXJlIGZ1bmN0aW9uXG5mdW5jdGlvbiBfX3dlYnBhY2tfcmVxdWlyZV9fKG1vZHVsZUlkKSB7XG5cdC8vIENoZWNrIGlmIG1vZHVsZSBpcyBpbiBjYWNoZVxuXHR2YXIgY2FjaGVkTW9kdWxlID0gX193ZWJwYWNrX21vZHVsZV9jYWNoZV9fW21vZHVsZUlkXTtcblx0aWYgKGNhY2hlZE1vZHVsZSAhPT0gdW5kZWZpbmVkKSB7XG5cdFx0cmV0dXJuIGNhY2hlZE1vZHVsZS5leHBvcnRzO1xuXHR9XG5cdC8vIENyZWF0ZSBhIG5ldyBtb2R1bGUgKGFuZCBwdXQgaXQgaW50byB0aGUgY2FjaGUpXG5cdHZhciBtb2R1bGUgPSBfX3dlYnBhY2tfbW9kdWxlX2NhY2hlX19bbW9kdWxlSWRdID0ge1xuXHRcdC8vIG5vIG1vZHVsZS5pZCBuZWVkZWRcblx0XHQvLyBubyBtb2R1bGUubG9hZGVkIG5lZWRlZFxuXHRcdGV4cG9ydHM6IHt9XG5cdH07XG5cblx0Ly8gRXhlY3V0ZSB0aGUgbW9kdWxlIGZ1bmN0aW9uXG5cdF9fd2VicGFja19tb2R1bGVzX19bbW9kdWxlSWRdKG1vZHVsZSwgbW9kdWxlLmV4cG9ydHMsIF9fd2VicGFja19yZXF1aXJlX18pO1xuXG5cdC8vIFJldHVybiB0aGUgZXhwb3J0cyBvZiB0aGUgbW9kdWxlXG5cdHJldHVybiBtb2R1bGUuZXhwb3J0cztcbn1cblxuLy8gZXhwb3NlIHRoZSBtb2R1bGVzIG9iamVjdCAoX193ZWJwYWNrX21vZHVsZXNfXylcbl9fd2VicGFja19yZXF1aXJlX18ubSA9IF9fd2VicGFja19tb2R1bGVzX187XG5cbiIsInZhciBkZWZlcnJlZCA9IFtdO1xuX193ZWJwYWNrX3JlcXVpcmVfXy5PID0gZnVuY3Rpb24ocmVzdWx0LCBjaHVua0lkcywgZm4sIHByaW9yaXR5KSB7XG5cdGlmKGNodW5rSWRzKSB7XG5cdFx0cHJpb3JpdHkgPSBwcmlvcml0eSB8fCAwO1xuXHRcdGZvcih2YXIgaSA9IGRlZmVycmVkLmxlbmd0aDsgaSA+IDAgJiYgZGVmZXJyZWRbaSAtIDFdWzJdID4gcHJpb3JpdHk7IGktLSkgZGVmZXJyZWRbaV0gPSBkZWZlcnJlZFtpIC0gMV07XG5cdFx0ZGVmZXJyZWRbaV0gPSBbY2h1bmtJZHMsIGZuLCBwcmlvcml0eV07XG5cdFx0cmV0dXJuO1xuXHR9XG5cdHZhciBub3RGdWxmaWxsZWQgPSBJbmZpbml0eTtcblx0Zm9yICh2YXIgaSA9IDA7IGkgPCBkZWZlcnJlZC5sZW5ndGg7IGkrKykge1xuXHRcdHZhciBjaHVua0lkcyA9IGRlZmVycmVkW2ldWzBdO1xuXHRcdHZhciBmbiA9IGRlZmVycmVkW2ldWzFdO1xuXHRcdHZhciBwcmlvcml0eSA9IGRlZmVycmVkW2ldWzJdO1xuXHRcdHZhciBmdWxmaWxsZWQgPSB0cnVlO1xuXHRcdGZvciAodmFyIGogPSAwOyBqIDwgY2h1bmtJZHMubGVuZ3RoOyBqKyspIHtcblx0XHRcdGlmICgocHJpb3JpdHkgJiAxID09PSAwIHx8IG5vdEZ1bGZpbGxlZCA+PSBwcmlvcml0eSkgJiYgT2JqZWN0LmtleXMoX193ZWJwYWNrX3JlcXVpcmVfXy5PKS5ldmVyeShmdW5jdGlvbihrZXkpIHsgcmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18uT1trZXldKGNodW5rSWRzW2pdKTsgfSkpIHtcblx0XHRcdFx0Y2h1bmtJZHMuc3BsaWNlKGotLSwgMSk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRmdWxmaWxsZWQgPSBmYWxzZTtcblx0XHRcdFx0aWYocHJpb3JpdHkgPCBub3RGdWxmaWxsZWQpIG5vdEZ1bGZpbGxlZCA9IHByaW9yaXR5O1xuXHRcdFx0fVxuXHRcdH1cblx0XHRpZihmdWxmaWxsZWQpIHtcblx0XHRcdGRlZmVycmVkLnNwbGljZShpLS0sIDEpXG5cdFx0XHR2YXIgciA9IGZuKCk7XG5cdFx0XHRpZiAociAhPT0gdW5kZWZpbmVkKSByZXN1bHQgPSByO1xuXHRcdH1cblx0fVxuXHRyZXR1cm4gcmVzdWx0O1xufTsiLCJfX3dlYnBhY2tfcmVxdWlyZV9fLm8gPSBmdW5jdGlvbihvYmosIHByb3ApIHsgcmV0dXJuIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmosIHByb3ApOyB9IiwiLy8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuX193ZWJwYWNrX3JlcXVpcmVfXy5yID0gZnVuY3Rpb24oZXhwb3J0cykge1xuXHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcblx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcblx0fVxuXHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xufTsiLCIvLyBubyBiYXNlVVJJXG5cbi8vIG9iamVjdCB0byBzdG9yZSBsb2FkZWQgYW5kIGxvYWRpbmcgY2h1bmtzXG4vLyB1bmRlZmluZWQgPSBjaHVuayBub3QgbG9hZGVkLCBudWxsID0gY2h1bmsgcHJlbG9hZGVkL3ByZWZldGNoZWRcbi8vIFtyZXNvbHZlLCByZWplY3QsIFByb21pc2VdID0gY2h1bmsgbG9hZGluZywgMCA9IGNodW5rIGxvYWRlZFxudmFyIGluc3RhbGxlZENodW5rcyA9IHtcblx0XCIvcHVibGljL215Zm9udC5mb250XCI6IDAsXG5cdFwiYmxvY2tzL05ld3MvYnVpbGQvc3R5bGVcIjogMCxcblx0XCJibG9ja3MvUm93L2J1aWxkL2VkaXRvclwiOiAwLFxuXHRcImFzc2V0cy9idWlsZC9zdHlsZXMvYWRtaW5cIjogMCxcblx0XCJhc3NldHMvYnVpbGQvc3R5bGVzL2VkaXRvclwiOiAwLFxuXHRcImFzc2V0cy9idWlsZC9zdHlsZXMvdGhlbWVcIjogMCxcblx0XCJibG9ja3MvTmF2aWdhdGlvbi9idWlsZC9zdHlsZVwiOiAwLFxuXHRcImJsb2Nrcy9OZXdzL2J1aWxkL2VkaXRvclwiOiAwXG59O1xuXG4vLyBubyBjaHVuayBvbiBkZW1hbmQgbG9hZGluZ1xuXG4vLyBubyBwcmVmZXRjaGluZ1xuXG4vLyBubyBwcmVsb2FkZWRcblxuLy8gbm8gSE1SXG5cbi8vIG5vIEhNUiBtYW5pZmVzdFxuXG5fX3dlYnBhY2tfcmVxdWlyZV9fLk8uaiA9IGZ1bmN0aW9uKGNodW5rSWQpIHsgcmV0dXJuIGluc3RhbGxlZENodW5rc1tjaHVua0lkXSA9PT0gMDsgfTtcblxuLy8gaW5zdGFsbCBhIEpTT05QIGNhbGxiYWNrIGZvciBjaHVuayBsb2FkaW5nXG52YXIgd2VicGFja0pzb25wQ2FsbGJhY2sgPSBmdW5jdGlvbihwYXJlbnRDaHVua0xvYWRpbmdGdW5jdGlvbiwgZGF0YSkge1xuXHR2YXIgY2h1bmtJZHMgPSBkYXRhWzBdO1xuXHR2YXIgbW9yZU1vZHVsZXMgPSBkYXRhWzFdO1xuXHR2YXIgcnVudGltZSA9IGRhdGFbMl07XG5cdC8vIGFkZCBcIm1vcmVNb2R1bGVzXCIgdG8gdGhlIG1vZHVsZXMgb2JqZWN0LFxuXHQvLyB0aGVuIGZsYWcgYWxsIFwiY2h1bmtJZHNcIiBhcyBsb2FkZWQgYW5kIGZpcmUgY2FsbGJhY2tcblx0dmFyIG1vZHVsZUlkLCBjaHVua0lkLCBpID0gMDtcblx0aWYoY2h1bmtJZHMuc29tZShmdW5jdGlvbihpZCkgeyByZXR1cm4gaW5zdGFsbGVkQ2h1bmtzW2lkXSAhPT0gMDsgfSkpIHtcblx0XHRmb3IobW9kdWxlSWQgaW4gbW9yZU1vZHVsZXMpIHtcblx0XHRcdGlmKF9fd2VicGFja19yZXF1aXJlX18ubyhtb3JlTW9kdWxlcywgbW9kdWxlSWQpKSB7XG5cdFx0XHRcdF9fd2VicGFja19yZXF1aXJlX18ubVttb2R1bGVJZF0gPSBtb3JlTW9kdWxlc1ttb2R1bGVJZF07XG5cdFx0XHR9XG5cdFx0fVxuXHRcdGlmKHJ1bnRpbWUpIHZhciByZXN1bHQgPSBydW50aW1lKF9fd2VicGFja19yZXF1aXJlX18pO1xuXHR9XG5cdGlmKHBhcmVudENodW5rTG9hZGluZ0Z1bmN0aW9uKSBwYXJlbnRDaHVua0xvYWRpbmdGdW5jdGlvbihkYXRhKTtcblx0Zm9yKDtpIDwgY2h1bmtJZHMubGVuZ3RoOyBpKyspIHtcblx0XHRjaHVua0lkID0gY2h1bmtJZHNbaV07XG5cdFx0aWYoX193ZWJwYWNrX3JlcXVpcmVfXy5vKGluc3RhbGxlZENodW5rcywgY2h1bmtJZCkgJiYgaW5zdGFsbGVkQ2h1bmtzW2NodW5rSWRdKSB7XG5cdFx0XHRpbnN0YWxsZWRDaHVua3NbY2h1bmtJZF1bMF0oKTtcblx0XHR9XG5cdFx0aW5zdGFsbGVkQ2h1bmtzW2NodW5rSWRdID0gMDtcblx0fVxuXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXy5PKHJlc3VsdCk7XG59XG5cbnZhciBjaHVua0xvYWRpbmdHbG9iYWwgPSBzZWxmW1wid2VicGFja0NodW5rc3RhcnRlcl9raXRfdGhlbWVcIl0gPSBzZWxmW1wid2VicGFja0NodW5rc3RhcnRlcl9raXRfdGhlbWVcIl0gfHwgW107XG5jaHVua0xvYWRpbmdHbG9iYWwuZm9yRWFjaCh3ZWJwYWNrSnNvbnBDYWxsYmFjay5iaW5kKG51bGwsIDApKTtcbmNodW5rTG9hZGluZ0dsb2JhbC5wdXNoID0gd2VicGFja0pzb25wQ2FsbGJhY2suYmluZChudWxsLCBjaHVua0xvYWRpbmdHbG9iYWwucHVzaC5iaW5kKGNodW5rTG9hZGluZ0dsb2JhbCkpOyIsIiIsIi8vIHN0YXJ0dXBcbi8vIExvYWQgZW50cnkgbW9kdWxlIGFuZCByZXR1cm4gZXhwb3J0c1xuLy8gVGhpcyBlbnRyeSBtb2R1bGUgZGVwZW5kcyBvbiBvdGhlciBsb2FkZWQgY2h1bmtzIGFuZCBleGVjdXRpb24gbmVlZCB0byBiZSBkZWxheWVkXG5fX3dlYnBhY2tfcmVxdWlyZV9fLk8odW5kZWZpbmVkLCBbXCJibG9ja3MvTmV3cy9idWlsZC9zdHlsZVwiLFwiYmxvY2tzL1Jvdy9idWlsZC9lZGl0b3JcIixcImFzc2V0cy9idWlsZC9zdHlsZXMvYWRtaW5cIixcImFzc2V0cy9idWlsZC9zdHlsZXMvZWRpdG9yXCIsXCJhc3NldHMvYnVpbGQvc3R5bGVzL3RoZW1lXCIsXCJibG9ja3MvTmF2aWdhdGlvbi9idWlsZC9zdHlsZVwiLFwiYmxvY2tzL05ld3MvYnVpbGQvZWRpdG9yXCJdLCBmdW5jdGlvbigpIHsgcmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oXCIuL3dlYmZvbnRzLWxvYWRlci9teWZvbnQuZm9udC5qc1wiKTsgfSlcbl9fd2VicGFja19yZXF1aXJlX18uTyh1bmRlZmluZWQsIFtcImJsb2Nrcy9OZXdzL2J1aWxkL3N0eWxlXCIsXCJibG9ja3MvUm93L2J1aWxkL2VkaXRvclwiLFwiYXNzZXRzL2J1aWxkL3N0eWxlcy9hZG1pblwiLFwiYXNzZXRzL2J1aWxkL3N0eWxlcy9lZGl0b3JcIixcImFzc2V0cy9idWlsZC9zdHlsZXMvdGhlbWVcIixcImJsb2Nrcy9OYXZpZ2F0aW9uL2J1aWxkL3N0eWxlXCIsXCJibG9ja3MvTmV3cy9idWlsZC9lZGl0b3JcIl0sIGZ1bmN0aW9uKCkgeyByZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhcIi4vYXNzZXRzL3NyYy9zdHlsZXMvdGhlbWUuc2Nzc1wiKTsgfSlcbl9fd2VicGFja19yZXF1aXJlX18uTyh1bmRlZmluZWQsIFtcImJsb2Nrcy9OZXdzL2J1aWxkL3N0eWxlXCIsXCJibG9ja3MvUm93L2J1aWxkL2VkaXRvclwiLFwiYXNzZXRzL2J1aWxkL3N0eWxlcy9hZG1pblwiLFwiYXNzZXRzL2J1aWxkL3N0eWxlcy9lZGl0b3JcIixcImFzc2V0cy9idWlsZC9zdHlsZXMvdGhlbWVcIixcImJsb2Nrcy9OYXZpZ2F0aW9uL2J1aWxkL3N0eWxlXCIsXCJibG9ja3MvTmV3cy9idWlsZC9lZGl0b3JcIl0sIGZ1bmN0aW9uKCkgeyByZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhcIi4vYXNzZXRzL3NyYy9zdHlsZXMvZWRpdG9yLnNjc3NcIik7IH0pXG5fX3dlYnBhY2tfcmVxdWlyZV9fLk8odW5kZWZpbmVkLCBbXCJibG9ja3MvTmV3cy9idWlsZC9zdHlsZVwiLFwiYmxvY2tzL1Jvdy9idWlsZC9lZGl0b3JcIixcImFzc2V0cy9idWlsZC9zdHlsZXMvYWRtaW5cIixcImFzc2V0cy9idWlsZC9zdHlsZXMvZWRpdG9yXCIsXCJhc3NldHMvYnVpbGQvc3R5bGVzL3RoZW1lXCIsXCJibG9ja3MvTmF2aWdhdGlvbi9idWlsZC9zdHlsZVwiLFwiYmxvY2tzL05ld3MvYnVpbGQvZWRpdG9yXCJdLCBmdW5jdGlvbigpIHsgcmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oXCIuL2Fzc2V0cy9zcmMvc3R5bGVzL2FkbWluLnNjc3NcIik7IH0pXG5fX3dlYnBhY2tfcmVxdWlyZV9fLk8odW5kZWZpbmVkLCBbXCJibG9ja3MvTmV3cy9idWlsZC9zdHlsZVwiLFwiYmxvY2tzL1Jvdy9idWlsZC9lZGl0b3JcIixcImFzc2V0cy9idWlsZC9zdHlsZXMvYWRtaW5cIixcImFzc2V0cy9idWlsZC9zdHlsZXMvZWRpdG9yXCIsXCJhc3NldHMvYnVpbGQvc3R5bGVzL3RoZW1lXCIsXCJibG9ja3MvTmF2aWdhdGlvbi9idWlsZC9zdHlsZVwiLFwiYmxvY2tzL05ld3MvYnVpbGQvZWRpdG9yXCJdLCBmdW5jdGlvbigpIHsgcmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oXCIuL2Jsb2Nrcy9Sb3cvc3JjL2VkaXRvci5zY3NzXCIpOyB9KVxuX193ZWJwYWNrX3JlcXVpcmVfXy5PKHVuZGVmaW5lZCwgW1wiYmxvY2tzL05ld3MvYnVpbGQvc3R5bGVcIixcImJsb2Nrcy9Sb3cvYnVpbGQvZWRpdG9yXCIsXCJhc3NldHMvYnVpbGQvc3R5bGVzL2FkbWluXCIsXCJhc3NldHMvYnVpbGQvc3R5bGVzL2VkaXRvclwiLFwiYXNzZXRzL2J1aWxkL3N0eWxlcy90aGVtZVwiLFwiYmxvY2tzL05hdmlnYXRpb24vYnVpbGQvc3R5bGVcIixcImJsb2Nrcy9OZXdzL2J1aWxkL2VkaXRvclwiXSwgZnVuY3Rpb24oKSB7IHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKFwiLi9ibG9ja3MvTmV3cy9zcmMvc3R5bGUuc2Nzc1wiKTsgfSlcbl9fd2VicGFja19yZXF1aXJlX18uTyh1bmRlZmluZWQsIFtcImJsb2Nrcy9OZXdzL2J1aWxkL3N0eWxlXCIsXCJibG9ja3MvUm93L2J1aWxkL2VkaXRvclwiLFwiYXNzZXRzL2J1aWxkL3N0eWxlcy9hZG1pblwiLFwiYXNzZXRzL2J1aWxkL3N0eWxlcy9lZGl0b3JcIixcImFzc2V0cy9idWlsZC9zdHlsZXMvdGhlbWVcIixcImJsb2Nrcy9OYXZpZ2F0aW9uL2J1aWxkL3N0eWxlXCIsXCJibG9ja3MvTmV3cy9idWlsZC9lZGl0b3JcIl0sIGZ1bmN0aW9uKCkgeyByZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhcIi4vYmxvY2tzL05ld3Mvc3JjL2VkaXRvci5zY3NzXCIpOyB9KVxudmFyIF9fd2VicGFja19leHBvcnRzX18gPSBfX3dlYnBhY2tfcmVxdWlyZV9fLk8odW5kZWZpbmVkLCBbXCJibG9ja3MvTmV3cy9idWlsZC9zdHlsZVwiLFwiYmxvY2tzL1Jvdy9idWlsZC9lZGl0b3JcIixcImFzc2V0cy9idWlsZC9zdHlsZXMvYWRtaW5cIixcImFzc2V0cy9idWlsZC9zdHlsZXMvZWRpdG9yXCIsXCJhc3NldHMvYnVpbGQvc3R5bGVzL3RoZW1lXCIsXCJibG9ja3MvTmF2aWdhdGlvbi9idWlsZC9zdHlsZVwiLFwiYmxvY2tzL05ld3MvYnVpbGQvZWRpdG9yXCJdLCBmdW5jdGlvbigpIHsgcmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oXCIuL2Jsb2Nrcy9OYXZpZ2F0aW9uL3NyYy9zdHlsZS5zY3NzXCIpOyB9KVxuX193ZWJwYWNrX2V4cG9ydHNfXyA9IF9fd2VicGFja19yZXF1aXJlX18uTyhfX3dlYnBhY2tfZXhwb3J0c19fKTtcbiIsIiJdLCJuYW1lcyI6W10sInNvdXJjZVJvb3QiOiIifQ==