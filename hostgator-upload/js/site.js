(function () {
  var btn = document.querySelector("[data-menu]");
  var nav = document.querySelector(".mobile-nav");
  if (!btn || !nav) return;
  btn.addEventListener("click", function () {
    var open = nav.classList.toggle("open");
    btn.setAttribute("aria-expanded", open ? "true" : "false");
    btn.setAttribute("aria-label", open ? "Close menu" : "Open menu");
    btn.textContent = open ? "×" : "☰";
  });
  if (new URLSearchParams(location.search).get("sent") === "1") {
    var note = document.getElementById("thanks");
    if (note) {
      note.hidden = false;
      note.scrollIntoView();
    }
  }
})();
