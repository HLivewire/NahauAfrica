/* NahauAfrica reading page: settings are remembered in this browser only */
(function () {
    var KEY = 'nahau_reader_v1', body = document.body;
    var out = document.getElementById('rd-size-out'), range = document.getElementById('rd-size');
    var drawer = document.getElementById('rd-drawer'), scrim = document.querySelector('.rd-scrim'), gear = document.querySelector('[data-rd-open]');
    var closeTimer = null, lastFocus = null;

    function defaults() {
        var w = window.innerWidth;
        var size = w >= 2200 ? 28 : w >= 1600 ? 24 : w >= 1100 ? 21 : w >= 700 ? 20 : 18;
        return { size: size, theme: 'light', font: 'serif', lh: '1.8', width: w >= 1600 ? 'wide' : 'medium' };
    }
    function load() {
        var d = defaults();
        try { var s = JSON.parse(localStorage.getItem(KEY) || 'null'); if (s) for (var k in d) if (s[k] != null) d[k] = s[k]; } catch (e) {}
        return d;
    }
    var st = load();
    function save() { try { localStorage.setItem(KEY, JSON.stringify(st)); } catch (e) {} }

    function apply() {
        st.size = Math.min(44, Math.max(15, parseInt(st.size, 10) || 20));
        body.style.setProperty('--rd-fs', st.size + 'px');
        body.style.setProperty('--rd-lh', st.lh);
        body.setAttribute('data-theme', st.theme); body.setAttribute('data-font', st.font); body.setAttribute('data-width', st.width);
        if (range) range.value = st.size; if (out) out.textContent = st.size + ' px';
        mark('[data-rd-theme]', 'rdTheme', st.theme); mark('[data-rd-font]', 'rdFont', st.font);
        mark('[data-rd-lh]', 'rdLh', st.lh); mark('[data-rd-width]', 'rdWidth', st.width);
    }
    function mark(sel, key, val) {
        document.querySelectorAll(sel).forEach(function (b) { b.setAttribute('aria-checked', b.dataset[key] === String(val) ? 'true' : 'false'); });
    }
    function open() {
        lastFocus = document.activeElement; clearTimeout(closeTimer);
        scrim.hidden = false; drawer.removeAttribute('inert'); drawer.setAttribute('aria-hidden', 'false');
        requestAnimationFrame(function () { requestAnimationFrame(function () { scrim.classList.add('is-open'); drawer.classList.add('is-open'); }); });
        gear.setAttribute('aria-expanded', 'true');
        setTimeout(function () { var f = drawer.querySelector('.rd-x'); if (f) f.focus(); }, 500);
    }
    function close() {
        scrim.classList.remove('is-open'); drawer.classList.remove('is-open');
        drawer.setAttribute('aria-hidden', 'true'); drawer.setAttribute('inert', ''); gear.setAttribute('aria-expanded', 'false');
        closeTimer = setTimeout(function () { scrim.hidden = true; }, 700);
        if (lastFocus && lastFocus.focus) lastFocus.focus();
    }

    document.addEventListener('click', function (e) {
        var t = e.target.closest('button,[data-rd-close]'); if (!t) return;
        if (t.matches('[data-rd-open]')) return open();
        if (t.matches('[data-rd-close]')) return close();
        if (t.dataset.rdSize) { st.size = parseInt(st.size, 10) + parseInt(t.dataset.rdSize, 10); }
        else if (t.dataset.rdTheme) st.theme = t.dataset.rdTheme;
        else if (t.dataset.rdFont) st.font = t.dataset.rdFont;
        else if (t.dataset.rdLh) st.lh = t.dataset.rdLh;
        else if (t.dataset.rdWidth) st.width = t.dataset.rdWidth;
        else if (t.matches('[data-rd-reset]')) { try { localStorage.removeItem(KEY); } catch (er) {} st = defaults(); }
        else return;
        apply(); save();
    });
    if (range) range.addEventListener('input', function () { st.size = range.value; apply(); save(); });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && drawer.classList.contains('is-open')) close();
        if (e.key === 'Tab' && drawer.classList.contains('is-open')) {
            var f = drawer.querySelectorAll('button,input'); if (!f.length) return;
            var first = f[0], last = f[f.length - 1];
            if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
            else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
        }
    });

    var bar = document.querySelector('.rd-progress span');
    function progress() {
        var h = document.documentElement.scrollHeight - window.innerHeight;
        if (bar) bar.style.width = (h > 0 ? Math.min(100, (window.scrollY / h) * 100) : 100) + '%';
    }
    window.addEventListener('scroll', progress, { passive: true }); window.addEventListener('resize', progress);
    apply(); progress();
})();
