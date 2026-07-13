/**
 * Markimatics Template — Minimal JS
 * Mobile nav toggle only. Safe to omit in WordPress if your theme handles menus.
 */
(function () {
  var toggle = document.getElementById("mk-nav-toggle");
  var nav = document.getElementById("mk-nav");

  if (!toggle || !nav) return;

  toggle.addEventListener("click", function () {
    var isOpen = nav.classList.toggle("mk-nav--open");
    toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
  });
})();
