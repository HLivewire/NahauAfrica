/* NahauAfrica admin shell: theme, dropdowns, sidebar, search, modals (fetch + SweetAlert), charts. */
(function () {
  var $ = function (s, r) { return (r || document).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };
  var esc = function (s) { return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); };
  var store = function (k, v) { try { if (v === undefined) return localStorage.getItem(k); v === null ? localStorage.removeItem(k) : localStorage.setItem(k, v); } catch (e) {} };
  var T = function (s) { var d = (window.NH && NH.dict) || {}; return s && d[s] ? d[s] : s; };
  var sw = function (o) { ['title', 'text', 'confirmButtonText', 'cancelButtonText'].forEach(function (k) { if (o[k]) o[k] = (NH.dict && o[k].replace) ? o[k].replace(/^(Futa ")?([^"]*)(")?/, function (m, a, b, c) { return a ? T('Futa "') + b + c : T(m); }) : o[k]; }); return window.Swal ? Swal.fire(o) : Promise.resolve({ isConfirmed: confirm(o.title || '') }); };
  var NH = window.NH = window.NH || {};

  /* ---------- theme ---------- */
  $$('#themeBtn, .js-theme').forEach(function (b) { b.onclick = function () {
    var r = document.documentElement, t = r.getAttribute('data-theme');
    var dark = t === 'dark' || (!t && matchMedia('(prefers-color-scheme: dark)').matches);
    var n = dark ? 'light' : 'dark'; r.setAttribute('data-theme', n); store('nh_theme', n);
  }; });

  /* ---------- dropdowns ---------- */
  function closeDD() { $$('.dd.open').forEach(function (d) { d.classList.remove('open'); }); $('#sres').classList.remove('open'); }
  document.addEventListener('click', function (e) {
    var t = e.target.closest('[data-dd]');
    if (t) { var d = $('#' + t.getAttribute('data-dd')), was = d.classList.contains('open'); closeDD(); if (!was) d.classList.add('open'); return; }
    if (!e.target.closest('.dd') && !e.target.closest('#searchBox')) closeDD();
  });

  /* ---------- search ---------- */
  var gs = $('#gs');
  gs.addEventListener('input', function () {
    var q = gs.value.trim().toLowerCase(), r = $('#sres');
    if (!q) { r.classList.remove('open'); return; }
    var hits = (NH.go || []).filter(function (g) { return g[0].toLowerCase().indexOf(q) > -1; }).slice(0, 6);
    r.innerHTML = hits.length ? hits.map(function (g) { return '<a class="srl" data-go href="' + esc(g[1]) + '">' + esc(g[0]) + '<small>' + T('Nenda') + '</small></a>'; }).join('') : '<div class="note" style="padding:10px">' + T('Hakuna kilichopatikana') + '</div>';
    r.classList.add('open');
  });
  gs.addEventListener('keydown', function (e) { if (e.key === 'Enter') { var a = $('#sres [data-go]'); if (a) location.href = a.href; } if (e.key === 'Escape') { gs.blur(); closeDD(); } });
  document.addEventListener('keydown', function (e) {
    if (e.key === '/' && !/INPUT|TEXTAREA|SELECT/.test(document.activeElement.tagName)) { e.preventDefault(); gs.focus(); }
    if (e.key === 'Escape') { if ($('#ov').classList.contains('on')) closeM(); closeDD(); }
  });

  /* ---------- sidebar ---------- */
  var side = $('#side'), noPeek = false;
  function closeSide() { side.classList.remove('open'); $('#scrim').classList.remove('on'); }
  $('#nav').addEventListener('click', function (e) {
    var g = e.target.closest('[data-g]');
    if (g) { var o = !g.classList.contains('open'); g.classList.toggle('open', o); g.setAttribute('aria-expanded', o); g.nextElementSibling.classList.toggle('open', o); }
  });
  $('#burger').onclick = function () { var o = side.classList.toggle('open'); $('#scrim').classList.toggle('on', o); };
  $('#scrim').onclick = closeSide;
  function setCol(c) { document.body.classList.toggle('sb-c', c); store('nh_col', c ? '1' : '0'); }
  side.addEventListener('mouseenter', function () { if (!noPeek) side.classList.add('peek'); });
  side.addEventListener('mouseleave', function () { side.classList.remove('peek'); noPeek = false; });
  side.addEventListener('focusin', function () { if (!noPeek) side.classList.add('peek'); });
  side.addEventListener('focusout', function (e) { if (!side.contains(e.relatedTarget)) side.classList.remove('peek'); });
  $('#collapseBtn').onclick = function () { var c = !document.body.classList.contains('sb-c'); noPeek = c; side.classList.remove('peek'); setCol(c); };

  /* ---------- modal ---------- */
  var ov = $('#ov'), modal = $('#modal');
  function closeM() { ov.classList.remove('on'); }
  NH.closeModal = closeM;
  ov.addEventListener('mousedown', function (e) { if (e.target === ov) closeM(); });
  function openHtml(html) {
    modal.innerHTML = html;
    var w = $('[data-w]', modal); modal.style.maxWidth = w ? w.getAttribute('data-w') : '720px';
    ov.classList.add('on'); bindModal();
    var f = $('input:not([type=hidden]):not([type=checkbox]),select,textarea', modal); f && setTimeout(function () { f.focus(); }, 60);
  }
  function openModal(url) {
    closeDD(); closeSide();
    modal.innerHTML = '<div class="mload">' + T('Inapakia…') + '</div>'; modal.style.maxWidth = '420px'; ov.classList.add('on');
    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }, credentials: 'same-origin' })
      .then(function (r) { if (!r.ok) throw r.status; return r.text(); }).then(openHtml)
      .catch(function (s) { closeM(); sw({ icon: 'error', title: 'Imeshindwa kufungua', text: s === 403 ? 'Huna ruhusa ya kufanya hivi.' : 'Jaribu tena.' }); });
  }
  NH.openModal = openModal;
  document.addEventListener('click', function (e) {
    var m = e.target.closest('[data-modal]');
    if (m) { e.preventDefault(); openModal(m.getAttribute('data-modal')); return; }
    if (e.target.closest('[data-close]')) { closeM(); return; }
    var d = e.target.closest('[data-del]');
    if (d) { e.preventDefault(); del(d); }
  });
  function del(b) {
    sw({ icon: 'warning', title: 'Futa "' + (b.getAttribute('data-name') || 'kipengee hiki') + '"?', text: b.getAttribute('data-text') || 'Kitendo hiki hakirudishwi.', showCancelButton: true, confirmButtonText: 'Ndiyo, futa', cancelButtonText: 'Ghairi', confirmButtonColor: '#EC1F00' })
      .then(function (r) {
        if (!r.isConfirmed) return;
        var fd = new FormData(); fd.append('_method', 'DELETE'); fd.append('_token', NH.csrf);
        send(b.getAttribute('data-del'), fd).then(function (res) {
          if (res.ok) { sw({ icon: 'success', title: res.json.message || 'Imefutwa', timer: 1500, showConfirmButton: false }).then(function () { location.reload(); }); }
          else sw({ icon: 'error', title: 'Haikufanikiwa', text: (res.json && res.json.message) || 'Jaribu tena.' });
        });
      });
  }
  function send(url, fd) {
    return fetch(url, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'X-CSRF-TOKEN': NH.csrf }, credentials: 'same-origin' })
      .then(function (r) { return r.json().catch(function () { return {}; }).then(function (j) { return { ok: r.ok, status: r.status, json: j }; }); });
  }
  function bindModal() {
    $$('form[data-ajax]', modal).forEach(function (f) {
      f.addEventListener('submit', function (e) {
        e.preventDefault();
        var btn = $('[type=submit]', modal) || $('[type=submit][form="' + f.id + '"]'), msg = f.getAttribute('data-ok') || 'Imehifadhiwa';
        $$('.err', f).forEach(function (x) { x.textContent = ''; }); $$('.bad', f).forEach(function (x) { x.classList.remove('bad'); });
        btn && btn.setAttribute('disabled', 'disabled');
        send(f.action, new FormData(f)).then(function (res) {
          btn && btn.removeAttribute('disabled');
          if (res.status === 422) {
            var errs = res.json.errors || {}, first = null;
            Object.keys(errs).forEach(function (k) {
              var el = $('[data-err="' + k + '"]', f), inp = f.elements[k]; if (el) el.textContent = errs[k][0];
              if (inp && inp.classList) { inp.classList.add('bad'); first = first || inp; }
            });
            if (first) { var pn = first.closest && first.closest('[data-pane]'); if (pn) { var tb = $('[data-tab="' + pn.getAttribute('data-pane') + '"]', modal); tb && tb.click(); } first.focus && first.focus(); }
            sw({ icon: 'error', title: 'Kuna kosa kwenye fomu', text: res.json.message || 'Angalia sehemu zilizoonyeshwa.', timer: 2600, showConfirmButton: false });
          } else if (res.ok) {
            var j = res.json || {};
            closeM();
            sw({ icon: 'success', title: j.message || msg, text: j.text || '', timer: 1800, timerProgressBar: true, showConfirmButton: false }).then(function () {
              if (j.logout) location.href = j.logout; else if (j.redirect) location.href = j.redirect; else if (!j.stay) location.reload();
            });
          } else {
            sw({ icon: 'error', title: 'Haikufanikiwa', text: (res.json && res.json.message) || (res.status === 403 ? 'Huna ruhusa ya kufanya hivi.' : 'Jaribu tena.') });
          }
        });
      });
    });
    var bt = $('#b2', modal), rt = $('#rt', modal);
    if (bt && rt) { var upd = function () { var n = bt.value.replace(/<[^>]*>/g, ' ').trim().split(/\s+/).filter(Boolean).length; rt.textContent = Math.max(n ? 1 : 0, Math.round(n / 200)) + ' ' + T('dakika'); }; bt.addEventListener('input', upd); upd(); }
    $$('input[type=file][data-preview]', modal).forEach(function (inp) {
      inp.addEventListener('change', function () {
        var im = document.getElementById(inp.getAttribute('data-preview')), f = inp.files && inp.files[0];
        if (!im || !f) return; im.src = URL.createObjectURL(f); im.style.display = '';
      });
    });
    $$('[data-count-for]', modal).forEach(function (c) {
      var t = document.getElementById(c.getAttribute('data-count-for')), mx = +c.getAttribute('data-max');
      var u = function () { c.textContent = t.value.length + ' / ' + mx; c.style.color = t.value.length > mx ? 'var(--red)' : ''; }; t.addEventListener('input', u); u();
    });
    $$('[data-tab]', modal).forEach(function (b) {
      b.onclick = function () {
        $$('[data-tab]', modal).forEach(function (x) { x.setAttribute('aria-selected', x === b); });
        $$('[data-pane]', modal).forEach(function (p) { p.style.display = p.getAttribute('data-pane') === b.getAttribute('data-tab') ? '' : 'none'; });
      };
    });
  }

  /* ---------- flash + forced password change ---------- */
  if (NH.flash) sw({ icon: 'success', title: NH.flash, timer: 2000, showConfirmButton: false, timerProgressBar: true });
  if (NH.forcePw) setTimeout(function () { openModal(NH.pwUrl); }, 400);

  /* ---------- charts (used by the dashboard) ---------- */
  var svgNS = function (w, h, inner) { return '<svg class="chart" viewBox="0 0 ' + w + ' ' + h + '" role="img">' + inner + '</svg>'; };
  NH.line = function (el, labels, vals, color) {
    color = color || 'var(--pri)';
    var W = 620, H = 260, L = 34, B = 26, T = 10, R = 8, n = vals.length, mx = Math.max.apply(null, vals.concat([4])), step = Math.ceil(mx / 4); mx = step * 4;
    var X = function (i) { return L + (W - L - R) * (n === 1 ? .5 : i / (n - 1)); }, Y = function (v) { return T + (H - T - B) * (1 - v / mx); };
    var g = '';
    for (var k = 0; k <= 4; k++) { var yv = step * k; g += '<line x1="' + L + '" x2="' + (W - R) + '" y1="' + Y(yv) + '" y2="' + Y(yv) + '" stroke="var(--grid)"/><text x="' + (L - 6) + '" y="' + (Y(yv) + 3) + '" text-anchor="end">' + yv + '</text>'; }
    var pts = vals.map(function (v, i) { return [X(i), Y(v)]; }), d = 'M' + pts[0][0] + ',' + pts[0][1];
    for (var i = 1; i < n; i++) { var p = pts[i - 1], q = pts[i], mxp = (p[0] + q[0]) / 2; d += ' C' + mxp + ',' + p[1] + ' ' + mxp + ',' + q[1] + ' ' + q[0] + ',' + q[1]; }
    var area = d + ' L' + X(n - 1) + ',' + (H - B) + ' L' + X(0) + ',' + (H - B) + 'Z';
    var xl = labels.map(function (t, i) { return '<text x="' + X(i) + '" y="' + (H - 6) + '" text-anchor="middle">' + esc(t) + '</text>'; }).join('');
    var dots = pts.map(function (p, i) { return '<circle cx="' + p[0] + '" cy="' + p[1] + '" r="3.5" fill="var(--card)" stroke="' + color + '" stroke-width="2" data-i="' + i + '"/>'; }).join('');
    el.innerHTML = '<div class="tip"></div>' + svgNS(W, H, '<defs><linearGradient id="lg1" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="' + color + '" stop-opacity=".22"/><stop offset="1" stop-color="' + color + '" stop-opacity="0"/></linearGradient></defs>' + g + '<path d="' + area + '" fill="url(#lg1)"/><path class="line-a" d="' + d + '" stroke="' + color + '" pathLength="1"/>' + dots + xl);
    var tip = $('.tip', el), svg = $('svg', el);
    $$('circle', el).forEach(function (c) {
      c.addEventListener('mouseenter', function () { var i = +c.getAttribute('data-i'), r = svg.getBoundingClientRect(), s = r.width / W; tip.textContent = labels[i] + ': ' + vals[i]; tip.style.left = (pts[i][0] * s - tip.offsetWidth / 2) + 'px'; tip.style.top = (pts[i][1] * s - 40) + 'px'; tip.style.opacity = 1; });
      c.addEventListener('mouseleave', function () { tip.style.opacity = 0; });
    });
  };
  NH.bars = function (el, rows, color) {
    color = color || 'var(--pri)';
    var mx = Math.max.apply(null, rows.map(function (r) { return r[1]; }).concat([1]));
    el.innerHTML = rows.map(function (r) { return '<div style="margin:10px 0"><div style="display:flex;justify-content:space-between;font-size:12px;gap:10px"><span style="font-weight:700;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">' + esc(r[0]) + '</span><span style="color:var(--mut)">' + r[1] + '</span></div><div style="height:8px;border-radius:99px;background:var(--hov);margin-top:4px;overflow:hidden"><div style="height:100%;width:' + (r[1] / mx * 100) + '%;background:' + color + ';border-radius:99px;transition:width .8s cubic-bezier(.4,0,.2,1)"></div></div></div>'; }).join('');
  };
  NH.donut = function (el, rows) {
    var cols = ['var(--pri)', '#7B3FE4', 'var(--grn)', 'var(--org)', 'var(--cy)'], tot = rows.reduce(function (a, r) { return a + r[1]; }, 0), R = 52, C = 2 * Math.PI * R, off = 0, s = '';
    rows.forEach(function (r, i) { var len = tot ? r[1] / tot * C : 0; s += '<circle cx="70" cy="70" r="' + R + '" fill="none" stroke="' + cols[i % 5] + '" stroke-width="16" stroke-dasharray="' + len + ' ' + (C - len) + '" stroke-dashoffset="' + (-off) + '" transform="rotate(-90 70 70)"/>'; off += len; });
    if (!tot) s = '<circle cx="70" cy="70" r="' + R + '" fill="none" stroke="var(--hov)" stroke-width="16"/>';
    el.innerHTML = '<div style="display:flex;gap:18px;align-items:center;flex-wrap:wrap"><svg viewBox="0 0 140 140" style="width:140px;height:140px;flex:none">' + s + '<text x="70" y="68" text-anchor="middle" style="font:800 20px var(--font);fill:var(--tx)">' + tot + '</text><text x="70" y="84" text-anchor="middle">' + T('jumla') + '</text></svg><div style="flex:1;min-width:120px">' + rows.map(function (r, i) { return '<div class="lg-row"><i style="background:' + cols[i % 5] + '"></i>' + esc(r[0]) + '<span>' + r[1] + '</span></div>'; }).join('') + '</div></div>';
  };
  /* multi-series smooth lines (opts.pct => 0-100% axis), grouped bars, gauge, sparkline */
  var CL = ['var(--pri)', '#9DB6FF', 'var(--cy)'];
  NH.multi = function (el, labels, series, opts) {
    opts = opts || {}; var W = 620, H = opts.h || 240, L = 38, B = 26, T = 10, R = 10, n = labels.length, all = [];
    series.forEach(function (s) { all = all.concat(s.vals); });
    var mx = opts.pct ? 100 : Math.max.apply(null, all.concat([4])), step = opts.pct ? 25 : Math.ceil(mx / 4); mx = step * 4;
    var X = function (i) { return L + (W - L - R) * (n === 1 ? .5 : i / (n - 1)); }, Y = function (v) { return T + (H - T - B) * (1 - v / mx); }, g = '';
    for (var k = 0; k <= 4; k++) { var yv = step * k; g += '<line x1="' + L + '" x2="' + (W - R) + '" y1="' + Y(yv) + '" y2="' + Y(yv) + '" stroke="var(--grid)"/><text x="' + (L - 6) + '" y="' + (Y(yv) + 3) + '" text-anchor="end">' + yv + (opts.pct ? '%' : '') + '</text>'; }
    var every = Math.max(1, Math.ceil(n / 6)), xl = labels.map(function (t, i) { return i % every ? '' : '<text x="' + X(i) + '" y="' + (H - 6) + '" text-anchor="middle">' + esc(t) + '</text>'; }).join(''), paths = '';
    series.forEach(function (s, si) {
      var c = s.color || CL[si % 3], p = s.vals.map(function (v, i) { return [X(i), Y(v)]; }), d = 'M' + p[0][0] + ',' + p[0][1];
      for (var i = 1; i < n; i++) { var a = p[i - 1], b = p[i], m = (a[0] + b[0]) / 2; d += ' C' + m + ',' + a[1] + ' ' + m + ',' + b[1] + ' ' + b[0] + ',' + b[1]; }
      paths += '<path class="line-a" d="' + d + '" stroke="' + c + '" pathLength="1" style="stroke-width:' + (si ? 2 : 2.6) + '"/>';
      if (opts.dots) p.forEach(function (q) { paths += '<circle cx="' + q[0] + '" cy="' + q[1] + '" r="3.3" fill="var(--card)" stroke="' + c + '" stroke-width="2"/>'; });
    });
    var lg = series.length > 1 || opts.legend ? '<div class="lgd">' + series.map(function (s, i) { return '<span><i style="background:' + (s.color || CL[i % 3]) + '"></i>' + esc(s.name) + '</span>'; }).join('') + '</div>' : '';
    el.innerHTML = lg + svgNS(W, H, g + paths + xl);
  };
  NH.gbars = function (el, labels, series) {
    var W = 620, H = 250, L = 34, B = 26, T = 10, R = 8, all = []; series.forEach(function (s) { all = all.concat(s.vals); });
    var mx = Math.max.apply(null, all.concat([4])), step = Math.ceil(mx / 4); mx = step * 4;
    var Y = function (v) { return T + (H - T - B) * (1 - v / mx); }, g = '', n = labels.length, cw = (W - L - R) / n, bw = Math.min(14, cw / (series.length + 1.2));
    for (var k = 0; k <= 4; k++) { var yv = step * k; g += '<line x1="' + L + '" x2="' + (W - R) + '" y1="' + Y(yv) + '" y2="' + Y(yv) + '" stroke="var(--grid)"/><text x="' + (L - 6) + '" y="' + (Y(yv) + 3) + '" text-anchor="end">' + yv + '</text>'; }
    labels.forEach(function (lb, i) {
      var x0 = L + cw * i + cw / 2 - bw * series.length / 2 - (series.length - 1) * 1.5;
      series.forEach(function (s, si) { var v = s.vals[i], x = x0 + si * (bw + 3); g += '<rect x="' + x + '" y="' + Y(v) + '" width="' + bw + '" height="' + (H - B - Y(v)) + '" rx="3" fill="' + (s.color || CL[si % 3]) + '"><title>' + esc(s.name) + ' ' + esc(lb) + ': ' + v + '</title></rect>'; });
      g += '<text x="' + (L + cw * i + cw / 2) + '" y="' + (H - 6) + '" text-anchor="middle">' + esc(lb) + '</text>';
    });
    el.innerHTML = '<div class="lgd">' + series.map(function (s, i) { return '<span><i style="background:' + (s.color || CL[i % 3]) + '"></i>' + esc(s.name) + '</span>'; }).join('') + '</div>' + svgNS(W, H, g);
  };
  NH.gauge = function (el, pct) {
    var R = 50, C = Math.PI * R, len = C * Math.max(0, Math.min(100, pct)) / 100;
    el.innerHTML = '<svg viewBox="0 0 130 78" style="width:150px;display:block;margin:6px auto"><path d="M15,68 A50,50 0 0 1 115,68" fill="none" stroke="var(--hov)" stroke-width="14" stroke-linecap="round"/><path d="M15,68 A50,50 0 0 1 115,68" fill="none" stroke="var(--pri)" stroke-width="14" stroke-linecap="round" stroke-dasharray="' + len + ' ' + C + '"/><text x="65" y="66" text-anchor="middle" style="font:800 18px var(--font);fill:var(--tx)">' + pct + '%</text></svg>';
  };
  NH.spark = function (el, vals) {
    var mx = Math.max.apply(null, vals.concat([1])), w = 100 / vals.length;
    el.innerHTML = '<svg viewBox="0 0 100 40" preserveAspectRatio="none" style="width:100%;height:56px;display:block">' + vals.map(function (v, i) { var h = Math.max(2, v / mx * 38); return '<rect x="' + (i * w + w * .2) + '" y="' + (40 - h) + '" width="' + w * .6 + '" height="' + h + '" rx="1.2" fill="' + (i % 2 ? '#9DB6FF' : 'var(--pri)') + '"/>'; }).join('') + '</svg>';
  };
})();

/* ---- loading spinners on buttons (links that navigate, form submits, ajax saves) ---- */
(function () {
  var cur = null, sel = 'a.btn:not([data-modal]):not([data-del]), a.so, a[href$="/logout"], a[href$="/signout"]';
  function on(b) {
    if (!b || b.classList.contains('is-loading')) return;
    var sp = document.createElement('span'); sp.className = 'nx-spin'; sp.setAttribute('aria-hidden', 'true');
    sp.style.color = getComputedStyle(b).color; b.appendChild(sp);
    b.classList.add('is-loading'); b.setAttribute('aria-busy', 'true');
  }
  function off(b) {
    if (!b) return; b.classList.remove('is-loading'); b.removeAttribute('aria-busy');
    var s = b.querySelector(':scope > .nx-spin'); if (s) s.remove();
  }
  function offAll() { document.querySelectorAll('.is-loading').forEach(off); cur = null; }
  var of = window.fetch;
  if (of) window.fetch = function () {
    var st = cur, p = of.apply(this, arguments);
    if (st && !st.f) { st.f = true; var done = function () { off(st.b); if (cur === st) cur = null; }; p.then(done, done); }
    return p;
  };
  document.addEventListener('submit', function (e) {
    var f = e.target, b = e.submitter || f.querySelector('[type=submit]');
    if (!b || b.hasAttribute('data-no-spin')) return;
    on(b); var st = cur = { b: b, f: false };
    setTimeout(function () { if (e.defaultPrevented && !st.f) { off(b); if (cur === st) cur = null; } }, 0);
  }, true);
  document.addEventListener('click', function (e) {
    var a = e.target.closest && e.target.closest(sel);
    if (!a || e.defaultPrevented || e.metaKey || e.ctrlKey || e.shiftKey || e.button) return;
    var h = a.getAttribute('href'); if (!h || h.charAt(0) === '#' || a.target === '_blank' || /^(mailto|tel):/.test(h) || a.hasAttribute('data-no-spin')) return;
    setTimeout(function () { if (!e.defaultPrevented) on(a); }, 0);
  });
  document.addEventListener('click', function (e) {
    var a = e.target.closest && e.target.closest('a.so, a[href$="/logout"], a[href$="/signout"]');
    if (!a || e.defaultPrevented || e.metaKey || e.ctrlKey || e.shiftKey || e.button) return;
    var o = document.querySelector('.nx-busy') || document.body.appendChild(Object.assign(document.createElement('div'), { className: 'nx-busy', innerHTML: '<i></i><span></span>' }));
    o.setAttribute('role', 'status'); o.querySelector('span').textContent = ((window.NH && NH.dict && NH.dict['Inatoka…']) || 'Inatoka…'); o.classList.add('on');
  });
  window.addEventListener('pageshow', function () { offAll(); var o = document.querySelector('.nx-busy'); if (o) o.classList.remove('on'); });

  /* ---------- conditional form fields: <div data-dep="kind=hero"> shows only while select[name=kind] has that value ---------- */
  function applyDeps(root) {
    Array.prototype.slice.call((root || document).querySelectorAll('[data-dep]')).forEach(function (el) {
      var p = el.getAttribute('data-dep').split('='), c = el.closest('form') && el.closest('form').querySelector('[name="' + p[0] + '"]');
      if (c) el.style.display = c.value === p[1] ? '' : 'none';
    });
  }
  document.addEventListener('change', function (e) { if (e.target.closest && e.target.closest('form') && e.target.matches('select')) applyDeps(e.target.closest('form')); });
  new MutationObserver(function () { applyDeps(document.getElementById('modal')); }).observe(document.body, { childList: true, subtree: true });
  applyDeps();
})();
