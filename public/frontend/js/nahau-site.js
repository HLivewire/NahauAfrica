/* NahauAfrica public site behaviour (no third-party scripts). */
(function () {
  'use strict';
  var d = document;
  function $(s, c) { return (c || d).querySelector(s); }
  function $$(s, c) { return Array.prototype.slice.call((c || d).querySelectorAll(s)); }
  function store(k, v) { try { if (v === undefined) return localStorage.getItem(k); localStorage.setItem(k, v); } catch (e) { return null; } }

  /* Analytics: sends to Plausible / GA4 / dataLayer if present, otherwise does nothing. */
  window.nahauTrack = function (name, props) {
    try {
      if (window.plausible) window.plausible(name, { props: props || {} });
      if (window.gtag) window.gtag('event', name, props || {});
      (window.dataLayer = window.dataLayer || []).push(Object.assign({ event: name }, props || {}));
    } catch (e) {}
  };
  d.addEventListener('click', function (e) {
    var t = e.target.closest('[data-nx-track]');
    if (!t) return;
    var p = {};
    if (t.dataset.channel) p.channel = t.dataset.channel;
    if (t.dataset.id) p.listing = t.dataset.id;
    nahauTrack(t.dataset.nxTrack, p);
  });

  /* Text size (16–28px, remembered) */
  var body = $('[data-nx-body]');
  var size = parseInt(store('nx-size'), 10) || 20;
  function applySize() { d.documentElement.style.setProperty('--nx-fs', size + 'px'); }
  if (body) applySize();
  $$('[data-nx-size]').forEach(function (b) {
    b.addEventListener('click', function () {
      size = Math.max(16, Math.min(28, size + parseInt(b.dataset.nxSize, 10)));
      store('nx-size', String(size)); applySize(); nahauTrack('text_size_change', { size: size });
    });
  });

  /* Copy link */
  $$('[data-nx-copy]').forEach(function (b) {
    var label = b.innerHTML, check = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>';
    b.addEventListener('click', function () {
      var url = b.closest('[data-nx-share]').dataset.url;
      function done() { b.innerHTML = check; b.classList.add('is-copied'); b.setAttribute('title', b.dataset.copied); setTimeout(function () { b.innerHTML = label; b.classList.remove('is-copied'); b.setAttribute('title', b.getAttribute('aria-label')); }, 2500); nahauTrack('share_click', { channel: 'copy' }); }
      if (navigator.clipboard && navigator.clipboard.writeText) { navigator.clipboard.writeText(url).then(done, fallback); } else { fallback(); }
      function fallback() { var i = d.createElement('input'); i.value = url; d.body.appendChild(i); i.select(); try { d.execCommand('copy'); } catch (e) {} d.body.removeChild(i); done(); }
    });
  });

  /* Completed read: scrolled past 90% of the body */
  var story = $('[data-nx-story]');
  if (story && body) {
    nahauTrack('story_read_start', { section: story.dataset.section, lang: story.dataset.lang });
    var fired = false;
    window.addEventListener('scroll', function () {
      if (fired) return;
      var r = body.getBoundingClientRect();
      if (r.height && (window.innerHeight - r.top) / r.height >= 0.9) { fired = true; nahauTrack('story_read_complete', { section: story.dataset.section }); }
    }, { passive: true });
  }

  /* Toggle buttons (report form, opportunity form) */
  $$('[data-nx-toggle]').forEach(function (b) {
    b.addEventListener('click', function () {
      var t = $(b.dataset.nxToggle); if (!t) return;
      var open = t.hasAttribute('hidden');
      if (open) t.removeAttribute('hidden'); else t.setAttribute('hidden', '');
      b.setAttribute('aria-expanded', open ? 'true' : 'false');
      if (open) { var f = t.querySelector('input,select,textarea'); if (f) f.focus(); }
    });
  });
  $$('[data-nx-toggle]').forEach(function (b) { var t = $(b.dataset.nxToggle); if (t && !t.hasAttribute('hidden')) b.setAttribute('aria-expanded', 'true'); });

  /* Report this advert (AJAX, falls back to normal post) */
  $$('form[data-nx-report]').forEach(function (f) {
    f.addEventListener('submit', function (e) {
      e.preventDefault();
      fetch(f.action, { method: 'POST', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: new FormData(f) })
        .then(function (r) { if (!r.ok) throw 0; f.outerHTML = '<p role="status" style="font-weight:600">' + (d.documentElement.lang === 'sw' ? 'Asante — wahariri wetu watakagua tangazo hili.' : 'Thanks — our editors will review this advert.') + '</p>'; nahauTrack('opportunity_report'); })
        .catch(function () { f.submit(); });
    });
  });

  /* Newsletter (AJAX, falls back to normal post) */
  $$('form[data-nx-newsletter]').forEach(function (f) {
    f.addEventListener('submit', function (e) {
      var email = f.querySelector('input[type=email]');
      var err = f.querySelector('[role=alert]');
      if (!email.value || !/^\S+@\S+\.\S+$/.test(email.value)) {
        e.preventDefault(); err.textContent = d.documentElement.lang === 'sw' ? 'Tafadhali weka barua pepe kama name@example.com' : 'Please enter an email address like name@example.com'; email.focus(); return;
      }
      e.preventDefault();
      fetch(f.action, { method: 'POST', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: new FormData(f) })
        .then(function (r) { if (!r.ok) throw 0; var h = d.documentElement.lang === 'sw' ? 'Asante! Uko kwenye orodha — tazama hadithi yetu ijayo.' : "Asante! You're on the list — look out for our next story."; f.outerHTML = '<div role="status"><h2>' + h + '</h2></div>'; })
        .catch(function () { f.submit(); });
    });
  });

  /* Section filters + search without a full reload (URL updates, back button works) */
  var listing = $('[data-nx-listing]');
  function loadList(url, push) {
    var target = $('#nx-results');
    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-Nahau-Fragment': '1' } })
      .then(function (r) { return r.text(); })
      .then(function (html) { target.innerHTML = html; if (push) history.pushState({ nx: 1 }, '', url); })
      .catch(function () { location.href = url; });
  }
  if (listing) {
    var chips = $('.nx-toolbar .nx-chips');
    d.addEventListener('click', function (e) {
      var a = e.target.closest('.nx-toolbar .nx-chip, #nx-results .pagination a, #nx-results .maan-pagination a');
      if (!a || !a.href) return;
      e.preventDefault();
      loadList(a.href, true);
      if (a.classList.contains('nx-chip')) { $$('.nx-toolbar .nx-chip').forEach(function (c) { c.classList.remove('is-on'); c.setAttribute('aria-pressed', 'false'); }); a.classList.add('is-on'); a.setAttribute('aria-pressed', 'true'); }
    });
    var form = $('[data-nx-filter]');
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var params = new URLSearchParams(new FormData(form));
      var url = form.action + '?' + params.toString();
      loadList(url, true);
    });
    window.addEventListener('popstate', function () { loadList(location.href, false); });
  }
  var opps = $('[data-nx-opps]');
  if (opps) {
    d.addEventListener('click', function (e) {
      var a = e.target.closest('[data-nx-opps] .nx-chips .nx-chip');
      if (!a) return; e.preventDefault();
      fetch(a.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } }).then(function (r) { return r.text(); })
        .then(function (html) { $('#nx-opp-results').innerHTML = html; history.pushState({}, '', a.href); $$('[data-nx-opps] .nx-chips .nx-chip').forEach(function (c) { c.classList.remove('is-on'); c.setAttribute('aria-pressed', 'false'); }); a.classList.add('is-on'); a.setAttribute('aria-pressed', 'true'); })
        .catch(function () { location.href = a.href; });
    });
  }

  /* Heroes in focus: rotate every 6s; stops on reduced motion, hidden tab, hover/focus, or any manual control */
  var spot = $('[data-nx-spotlight]');
  if (spot) {
    var slides = $$('.nx-spot-slide', spot), jumps = $$('[data-nx-jump]', spot);
    var pauseBtn = $('[data-nx-pause]', spot), live = $('[data-nx-slides]', spot);
    var i = 0, timer = null, userStopped = false, inside = false;
    var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
    var ms = parseInt(spot.dataset.interval, 10) || 6000;
    function show(n) {
      i = (n + slides.length) % slides.length;
      slides.forEach(function (s, k) { if (k === i) s.removeAttribute('hidden'); else s.setAttribute('hidden', ''); });
      jumps.forEach(function (j, k) { j.classList.toggle('is-on', k === i); });
    }
    function running() { return !userStopped && !reduce && !inside && !d.hidden; }
    function tick() { stop(); if (running()) timer = setTimeout(function () { show(i + 1); tick(); }, ms); }
    function stop() { if (timer) { clearTimeout(timer); timer = null; } }
    function manual() { userStopped = true; stop(); pauseBtn.textContent = lang('Play'); pauseBtn.setAttribute('aria-pressed', 'true'); live.setAttribute('aria-live', 'polite'); }
    function lang(w) { var sw = d.documentElement.lang === 'sw'; return ({ Pause: sw ? 'Simamisha' : 'Pause', Play: sw ? 'Cheza' : 'Play' })[w]; }
    $('[data-nx-prev]', spot).addEventListener('click', function () { manual(); show(i - 1); });
    $('[data-nx-next]', spot).addEventListener('click', function () { manual(); show(i + 1); });
    jumps.forEach(function (j, k) { j.addEventListener('click', function () { manual(); show(k); }); });
    pauseBtn.addEventListener('click', function () {
      if (userStopped) { userStopped = false; pauseBtn.textContent = lang('Pause'); pauseBtn.setAttribute('aria-pressed', 'false'); live.removeAttribute('aria-live'); tick(); } else { manual(); }
    });
    spot.addEventListener('mouseenter', function () { inside = true; stop(); });
    spot.addEventListener('mouseleave', function () { inside = false; tick(); });
    spot.addEventListener('focusin', function () { inside = true; stop(); });
    spot.addEventListener('focusout', function () { inside = false; tick(); });
    d.addEventListener('visibilitychange', function () { if (d.hidden) stop(); else tick(); });
    if (reduce) { pauseBtn.textContent = lang('Play'); pauseBtn.setAttribute('aria-pressed', 'true'); }
    tick();
  }

  /* Search analytics */
  var sc = $('[data-nx-search-count]');
  if (sc) nahauTrack('search', { term: sc.dataset.term, results: sc.dataset.nxSearchCount });
  $$('form[data-nx-submit]').forEach(function (f) { f.addEventListener('submit', function () { nahauTrack(f.dataset.nxSubmit); }); });
})();

/* Language dropdown */
(function () {
    document.querySelectorAll('[data-nx-lang]').forEach(function (box) {
        var btn = box.querySelector('.nx-lang-btn'), list = box.querySelector('.nx-lang-list');
        if (!btn || !list) return;
        function set(open) { list.hidden = !open; btn.setAttribute('aria-expanded', open ? 'true' : 'false'); }
        btn.addEventListener('click', function (e) { e.stopPropagation(); set(list.hidden); });
        document.addEventListener('click', function (e) { if (!box.contains(e.target)) set(false); });
        box.addEventListener('keydown', function (e) { if (e.key === 'Escape') { set(false); btn.focus(); } });
    });
})();

/* Favourite heart on book covers (login required) */
(function () {
    var meta = function (n) { var m = document.querySelector('meta[name="' + n + '"]'); return m ? m.content : ''; };
    function openLogin() {
        var opener = Array.prototype.slice.call(document.querySelectorAll('[data-nahau-open="drawer"]')).filter(function (e) { return e.offsetParent !== null; })[0] || document.querySelector('[data-nahau-open="drawer"]');
        if (opener) opener.click();
    }
    document.addEventListener('click', function (e) {
        var b = e.target.closest('[data-nx-fav]');
        if (!b) return;
        e.preventDefault(); e.stopPropagation();
        if (meta('nahau-auth') !== '1') { openLogin(); return; }
        if (b.disabled) return;
        b.disabled = true;
        fetch(b.getAttribute('data-url'), { method: 'POST', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': meta('csrf-token') } })
            .then(function (r) { return r.json().then(function (j) { return { s: r.status, j: j }; }); })
            .then(function (x) {
                if (x.s === 401) { openLogin(); return; }
                var on = !!x.j.favorite;
                b.classList.toggle('is-on', on); b.setAttribute('aria-pressed', on ? 'true' : 'false');
                if (window.nahauTrack) window.nahauTrack(on ? 'favorite_add' : 'favorite_remove', { id: b.getAttribute('data-nx-fav') });
            })
            .catch(function () {})
            .then(function () { b.disabled = false; });
    });
})();

/* Add to cart */
(function () {
    var meta = function (n) { var m = document.querySelector('meta[name="' + n + '"]'); return m ? m.content : ''; };
    function toast(html) {
        var t = document.querySelector('.nx-toast');
        if (!t) { t = document.createElement('div'); t.className = 'nx-toast'; t.setAttribute('role', 'status'); document.body.appendChild(t); }
        t.innerHTML = html; requestAnimationFrame(function () { t.classList.add('is-on'); });
        clearTimeout(t._h); t._h = setTimeout(function () { t.classList.remove('is-on'); }, 4200);
    }
    document.addEventListener('click', function (e) {
        var b = e.target.closest('[data-nx-cart]'); if (!b) return;
        e.preventDefault(); if (b.disabled) return; b.disabled = true;
        fetch(b.getAttribute('data-url'), { method: 'POST', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': meta('csrf-token') } })
            .then(function (r) { return r.json().then(function (j) { return { ok: r.ok, j: j }; }); })
            .then(function (x) {
                if (!x.ok) return;
                var price = b.textContent.split('·')[1];
                b.textContent = b.getAttribute('data-added') + (price ? ' ·' + price : '');
                toast('<span>' + b.getAttribute('data-added') + '</span><a href="' + b.getAttribute('data-cart') + '">' + b.getAttribute('data-view') + ' →</a>');
                if (window.nahauTrack) window.nahauTrack('add_to_cart', {});
            })
            .catch(function () {})
            .then(function () { b.disabled = false; });
    });
})();

/* Meet the voices: auto-scrolling carousel with left/right arrows (pauses on hover/focus/touch, honours reduced motion) */
(function () {
  var root = document.querySelector('[data-nx-carousel]');
  if (!root) return;
  var track = root.querySelector('.nx-car-track');
  var arrows = root.querySelectorAll('[data-car]');
  var interval = parseInt(root.getAttribute('data-interval'), 10) || 3600;
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var timer = null, hovering = false, visible = true;

  function overflow() { return track.scrollWidth - track.clientWidth > 4; }
  function step() { var it = track.querySelector('.nx-car-item'); return it ? it.getBoundingClientRect().width + (parseFloat(getComputedStyle(track).columnGap) || 24) : 300; }
  function go(dir) {
    var max = track.scrollWidth - track.clientWidth;
    if (dir > 0 && track.scrollLeft >= max - 4) { track.scrollTo({ left: 0 }); return; }
    if (dir < 0 && track.scrollLeft <= 4) { track.scrollTo({ left: max }); return; }
    track.scrollBy({ left: dir * step() });
  }
  function stop() { if (timer) { clearInterval(timer); timer = null; } }
  function start() { stop(); if (reduce || hovering || !visible || !overflow()) return; timer = setInterval(function () { go(1); }, interval); }
  function layout() {
    var fits = !overflow();
    root.classList.toggle('is-static', fits);
    arrows.forEach(function (a) { a.hidden = fits; });
    start();
  }
  arrows.forEach(function (a) { a.addEventListener('click', function () { go(a.getAttribute('data-car') === 'prev' ? -1 : 1); start(); }); });
  ['mouseenter', 'focusin', 'touchstart', 'pointerdown'].forEach(function (ev) { root.addEventListener(ev, function () { hovering = true; stop(); }, { passive: true }); });
  ['mouseleave', 'focusout'].forEach(function (ev) { root.addEventListener(ev, function () { hovering = false; start(); }); });
  root.addEventListener('touchend', function () { setTimeout(function () { hovering = false; start(); }, 4000); }, { passive: true });
  if ('IntersectionObserver' in window) new IntersectionObserver(function (en) { visible = en[0].isIntersecting; start(); }, { threshold: 0.2 }).observe(root);
  document.addEventListener('visibilitychange', function () { if (document.hidden) stop(); else start(); });
  window.addEventListener('resize', layout);
  layout();
})();
