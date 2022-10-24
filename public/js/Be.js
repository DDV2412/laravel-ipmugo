/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************!*\
  !*** ./resources/js/Be.js ***!
  \****************************/
//
var showNavbar = function showNavbar(toggleId, navId, bodyId, headerId) {
  var toggle = document.getElementById(toggleId),
      nav = document.getElementById(navId),
      bodypd = document.getElementById(bodyId),
      headerpd = document.getElementById(headerId); // Validate that all variables exist

  if (toggle && nav && bodypd && headerpd) {
    toggle.addEventListener("click", function () {
      // show navbar
      nav.classList.toggle("Expander"); // change icon
      // add padding to body

      bodypd.classList.toggle("body-pd"); // add padding to header

      headerpd.classList.toggle("body-pd");
    });
  }
};

showNavbar("sideToggle", "sidebar", "body-pd", "Header"); // SideBarLink

var currentLocation = location.href;
var menuItem = document.querySelectorAll(".navList");
var menuLenght = menuItem.length;

for (var i = 0; i < menuLenght; i++) {
  if (menuItem[i].href === currentLocation) {
    menuItem[i].className = "navActive";
  }
}
/******/ })()
;