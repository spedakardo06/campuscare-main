// Small helper: fade out flash alerts after a few seconds.
document.querySelectorAll('.alert').forEach(function (el) {
  setTimeout(function () { el.style.opacity = '0'; }, 6000);
});
