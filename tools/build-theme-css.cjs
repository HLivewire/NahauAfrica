/* Builds public/frontend/css/theme-core.min.css: the legacy theme CSS (bootstrap, fontawesome, fonts, style, ...)
 * merged into ONE file, unused rules removed and minified.  Run after editing any of those source files or
 * adding new Blade markup that uses theme classes:
 *     npm i --no-save purgecss@6 clean-css@5 && node tools/build-theme-css.cjs
 */
const fs = require('fs'), path = require('path');
const { PurgeCSS } = require('purgecss'); const CleanCSS = require('clean-css');
const root = path.resolve(__dirname, '..'), pub = path.join(root, 'public'), out = path.join(pub, 'frontend/css/theme-core.min.css');
const sources = ['frontend/fontawesome/all.css', 'frontend/fonts/fonts.css', 'frontend/fonts/front_clock.css', 'frontend/css/bootstrap.min.css', 'frontend/css/normalize.css', 'frontend/css/default.css', 'frontend/css/style.css', 'frontend/css/responsive.css', 'frontend/css/maan_news_style.css', 'frontend/css/color-change.css'];
function rebase(css, file) {
  return css.replace(/url\(\s*(['"]?)([^)'"]+)\1\s*\)/g, (m, q, u) => {
    if (/^(data:|https?:|\/\/|#)/.test(u)) return m;
    const [p, tail] = u.split(/(?=[?#])/); const abs = path.resolve(path.dirname(path.join(pub, file)), p);
    return 'url(' + path.relative(path.dirname(out), abs).split(path.sep).join('/') + (tail || '') + ')';
  }).replace(/@import\s+url\([^)]*\)[^;]*;/g, '');
}
/* the shipped bootstrap.min.css is cut off mid-rule: keep everything up to the last balanced top-level block */
function balanced(c) { let d = 0, last = 0, str = null; for (let i = 0; i < c.length; i++) { const ch = c[i]; if (!str && ch === '/' && c[i + 1] === '*') { const e = c.indexOf('*/', i + 2); i = e < 0 ? c.length : e + 1; continue; } if (str) { if (ch === str && c[i - 1] !== '\\') str = null; continue; } if (ch === '"' || ch === "'") str = ch; else if (ch === '{') d++; else if (ch === '}') { d--; if (d === 0) last = i + 1; } } return c.slice(0, last || c.length); }
const walk = (d, ext, acc = []) => { for (const f of fs.readdirSync(d, { withFileTypes: true })) { const p = path.join(d, f.name); if (f.isDirectory()) walk(p, ext, acc); else if (ext.some(e => f.name.endsWith(e))) acc.push(p); } return acc; };
(async () => {
  const v = d => walk(path.join(root, 'resources/views', d), ['.php']);
  const content = [...v('nahau'), ...v('frontend/layouts'), path.join(root, 'resources/views/frontend/master.blade.php'), ...walk(path.join(root, 'app/Nahau'), ['.php']), ...walk(path.join(pub, 'frontend/js'), ['.js']).filter(f => !/vendor|swiper|\.map/.test(f)), path.join(root, 'public/frontend/css/nahau-site.css')];
  let all = '', keep = '';
  const purgeable = /fontawesome|bootstrap/;
  for (const s of sources) { let c = fs.readFileSync(path.join(pub, s), 'utf8'); c = balanced(c); (purgeable.test(s) ? (all += '\n' + rebase(c, s)) : (keep += '\n' + rebase(c, s))); }
  const safelist = { standard: ['html', 'body', 'show', 'fade', 'collapse', 'collapsing', 'active', 'open', 'disabled', 'in', 'table', 'img-fluid', 'figure', 'blockquote', 'row', 'container', 'clearfix', 'sticky', 'fixed', 'scrolled', 'is-loading'],
    greedy: [/^fa[-bsrl]?$/, /^fa-(facebook|twitter|x-twitter|instagram|linkedin|youtube|tiktok|whatsapp|telegram|pinterest|envelope|phone|location|globe|search|bars|times|angle|chevron|arrow|calendar|clock|user|eye|heart|share|link|check|plus|minus|star|play)/, /^col-/, /^modal/, /^dropdown/, /^nav/, /^table/, /^text-/, /^bg-/, /^d-/, /^m[trblxy]?-\d/, /^p[trblxy]?-\d/, /^maan-(open|active|show|fixed|sticky|scroll|dark|light)/, /^swiper/, /^nx-/, /^nahau-/, /data-theme/, /dark/, /^theme-/, /^black-white/, /^color-/, /^wp-/, /^alignleft|^alignright|^aligncenter/] };
  const res = await new PurgeCSS().purge({ content: content.map(raw => ({ raw: fs.readFileSync(raw, 'utf8'), extension: raw.endsWith('.js') ? 'js' : 'html' })), css: [{ raw: all }], safelist, fontFace: false, keyframes: true, variables: false, defaultExtractor: c => c.match(/[A-Za-z0-9_-]+/g) || [] });
  /* only the self-contained libraries (bootstrap, fontawesome) are purged; the theme's own files are kept whole because their rules are switched by classes that are set at run time */
  const merged = [...sources].map(x => x).length ? (res[0].css) : '';
  const min = new CleanCSS({ level: 1 }).minify(merged + keep).styles;
  fs.writeFileSync(out, min); console.log('theme-core.min.css', (all.length / 1024) | 0, 'KB ->', (min.length / 1024) | 0, 'KB');
})();
