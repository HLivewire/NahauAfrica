(function () {
  var drawer = document.getElementById('nahauDrawer');
  var overlay = document.getElementById('nahauOverlay');
  if (!drawer || !overlay) return;
  var lastFocus = null;
  var panels = drawer.querySelectorAll('.nahau-panel');
  var busy = false;

  function current() { return drawer.querySelector('.nahau-panel.is-active'); }
  function byName(n) { return drawer.querySelector('.nahau-panel[data-panel="' + n + '"]'); }
  function focusFirst(panel) {
    var f = panel && panel.querySelector('input:not([type=hidden])');
    if (f) f.focus();
  }

  // Smooth switch: current panel fades/slides out, then the next one fades/slides in (items staggered).
  function show(name, instant) {
    var next = byName(name), cur = current();
    if (!next || next === cur || busy) return;
    if (instant || !cur) {
      if (cur) cur.classList.remove('is-active');
      next.classList.add('is-active');
      return;
    }
    busy = true;
    drawer.style.setProperty('--d', '.05s');
    cur.classList.add('is-leaving');
    setTimeout(function () {
      cur.classList.remove('is-active', 'is-leaving');
      next.classList.add('is-active');
      drawer.scrollTop = 0;
      setTimeout(function () { focusFirst(next); busy = false; }, 520);
    }, 280);
  }

  function open(name) {
    lastFocus = document.activeElement;
    if (name) show(name, true);
    drawer.style.setProperty('--d', '.4s');
    drawer.classList.add('is-open');
    overlay.classList.add('is-open');
    drawer.setAttribute('aria-hidden', 'false');
    document.body.classList.add('nahau-lock');
    setTimeout(function () { focusFirst(current()); }, 800);
  }
  function close() {
    drawer.classList.remove('is-open');
    overlay.classList.remove('is-open');
    drawer.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('nahau-lock');
    if (lastFocus && lastFocus.focus) lastFocus.focus();
  }

  document.addEventListener('click', function (e) {
    var sw = e.target.closest('[data-nahau-panel]');
    if (sw) { e.preventDefault(); show(sw.getAttribute('data-nahau-panel')); return; }
    if (e.target.closest('[data-nahau-open="drawer"]')) { e.preventDefault(); open('login'); }
    else if (e.target.closest('[data-nahau-close="drawer"]')) { close(); }
  });
  overlay.addEventListener('click', close);
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });

  // Re-open on the right panel after a server round trip (errors, "account created", "link sent").
  var start = drawer.getAttribute('data-nahau-start');
  if (start) setTimeout(function () { open(start); }, 150);
})();

/* password eye + submit spinner */
(function () {
  document.addEventListener('click', function (e) {
    var b = e.target.closest('[data-nahau-eye]');
    if (!b) return;
    var inp = b.parentNode.querySelector('input');
    var show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    b.setAttribute('aria-pressed', show ? 'true' : 'false');
    inp.focus();
  });
  document.addEventListener('submit', function (e) {
    var btn = e.target.querySelector && e.target.querySelector('.nahau-login-btn');
    if (!btn || !e.target.checkValidity()) return;
    btn.classList.add('is-loading');
    btn.setAttribute('aria-busy', 'true');
  });
  window.addEventListener('pageshow', function () {
    document.querySelectorAll('.nahau-login-btn.is-loading').forEach(function (b) { b.classList.remove('is-loading'); b.removeAttribute('aria-busy'); });
  });
})();
