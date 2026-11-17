<div class="nx-ai" data-nx-ai data-url="{{ route('nahau.assistant') }}" data-lang="{{ nlocale() }}">
    <div class="nx-ai-panel" role="dialog" aria-label="{{ __('Nahau helper') }}" hidden>
        <div class="nx-ai-head"><b>{{ __('Nahau helper') }}</b><span>{{ __('Ask about stories, jobs or how to apply') }}</span><button type="button" class="nx-ai-x" aria-label="{{ __('Close') }}">&times;</button></div>
        <div class="nx-ai-log" aria-live="polite"><p class="nx-ai-m bot">{{ __('Hi! I can help you find stories, apply for opportunities, or send us your own story. What do you need?') }}</p></div>
        <div class="nx-ai-chips"><button type="button">{{ __('How do I apply for a job?') }}</button><button type="button">{{ __('How do I submit my story?') }}</button><button type="button">{{ __('Contact the team') }}</button></div>
        <form class="nx-ai-form"><input type="text" maxlength="500" placeholder="{{ __('Type your question…') }}" aria-label="{{ __('Your question') }}" required><button type="submit" aria-label="{{ __('Send') }}">&#10148;</button></form>
    </div>
    <div class="nx-ai-dock"><span class="nx-ai-pill" role="button" tabindex="-1">{{ __('Ask about Nahau Africa') }}</span><button type="button" class="nx-ai-fab" aria-label="{{ __('Open help assistant') }}" aria-expanded="false"><svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a8 8 0 0 1-11.6 7.1L4 20l1-4.6A8 8 0 1 1 21 12Z"/></svg></button></div>
</div>
<style>
.nx-ai{position:fixed;right:22px;bottom:22px;z-index:1500;font-family:'Jost',sans-serif}
.nx-ai-dock{display:flex;align-items:center;gap:14px}
.nx-ai-pill{background:#fff;color:#161d2f;font:700 17px 'Jost',sans-serif;padding:15px 24px;border-radius:999px;border:1px solid #e3e3e3;box-shadow:0 10px 30px rgba(0,0,0,.14);cursor:pointer;white-space:nowrap}
.nx-ai-fab{position:relative;width:58px;height:58px;border:0;border-radius:50%;background:#E0262B;color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 8px 22px rgba(224,38,43,.4)}
.nx-ai-fab::after{content:"";position:absolute;inset:0;border-radius:50%;background:rgba(224,38,43,.35);animation:nxaip 2.2s ease-out infinite;z-index:-1}
@keyframes nxaip{0%{transform:scale(1);opacity:.8}100%{transform:scale(1.7);opacity:0}}
.nx-ai-fab svg{width:28px !important;height:28px !important;display:block;fill:none !important;stroke:#fff !important}
.nx-ai-fab:hover{background:#c40000}
@media (prefers-reduced-motion:reduce){.nx-ai-fab::after{animation:none}}
.nx-ai-panel{height:auto;position:absolute;right:0;bottom:76px;width:350px;max-width:calc(100vw - 32px);background:#fff;border-radius:16px;box-shadow:0 18px 50px rgba(0,0,0,.25);overflow:hidden;display:flex;flex-direction:column}
.nx-ai-panel[hidden]{display:none}
.nx-ai-head{position:relative;background:#232427;color:#fff;padding:14px 44px 14px 16px}
.nx-ai-head b{display:block;font-size:17px}.nx-ai-head span{font-size:13px;opacity:.8}
.nx-ai-x{position:absolute;right:10px;top:8px;border:0;background:none;color:#fff;font-size:26px;cursor:pointer;line-height:1}
.nx-ai-log{padding:14px;height:260px;overflow:auto;display:flex;flex-direction:column;gap:10px;background:#F7F7F7}
.nx-ai-m{margin:0;padding:10px 13px;border-radius:14px;font-size:15px;line-height:1.45;max-width:88%}
.nx-ai-m.bot{background:#fff;color:#232427;align-self:flex-start}.nx-ai-m.me{background:#232427;color:#fff;align-self:flex-end}
.nx-ai-m a{display:block;margin-top:6px;color:#E60000;font-weight:600;text-decoration:underline;text-decoration-color:#E60000}
.nx-ai-chips{display:flex;flex-wrap:wrap;gap:6px;padding:8px 14px;background:#F7F7F7}
.nx-ai-chips button{border:1px solid #ddd;background:#fff;border-radius:999px;padding:6px 12px;font:500 13px 'Jost',sans-serif;cursor:pointer}
.nx-ai-form{display:flex;gap:8px;padding:10px 12px;border-top:1px solid #eee}
.nx-ai-form input{letter-spacing:0;height:auto;flex:1;border:1px solid #ddd;border-radius:10px;padding:10px 12px;font:500 15px 'Jost',sans-serif;min-width:0}
.nx-ai-form button{border:0;border-radius:10px;background:#E60000;color:#fff;width:42px;cursor:pointer;font-size:16px}
@media (max-width:480px){.nx-ai{right:12px;bottom:12px}.nx-ai-pill{display:none}}
</style>
<script>
(function(){var w=document.querySelector('[data-nx-ai]');if(!w)return;var fab=w.querySelector('.nx-ai-fab'),pn=w.querySelector('.nx-ai-panel'),pill=w.querySelector('.nx-ai-pill'),log=w.querySelector('.nx-ai-log'),f=w.querySelector('form'),inp=f.querySelector('input');
function open(o){pn.hidden=!o;pill.style.display=o?'none':'';fab.setAttribute('aria-expanded',o);if(o)inp.focus()}
fab.addEventListener('click',function(){open(pn.hidden)});pill.addEventListener('click',function(){open(true)});w.querySelector('.nx-ai-x').addEventListener('click',function(){open(false)});
document.addEventListener('keydown',function(e){if(e.key==='Escape')open(false)});
function add(t,c,links){var p=document.createElement('p');p.className='nx-ai-m '+c;p.textContent=t;(links||[]).forEach(function(l){var a=document.createElement('a');a.href=l.url;a.textContent=l.title;p.appendChild(a)});log.appendChild(p);log.scrollTop=log.scrollHeight;return p}
function ask(q){add(q,'me');var wait=add('…','bot');var fd=new FormData();fd.append('message',q);fd.append('lang',w.dataset.lang);
fetch(w.dataset.url,{method:'POST',body:fd,headers:{'Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},credentials:'same-origin'}).then(function(r){if(!r.ok)throw 0;return r.json()}).then(function(j){wait.remove();add(j.reply,'bot',j.links)}).catch(function(){wait.remove();add(w.dataset.lang==='sw'?'Samahani, nimeshindwa kujibu sasa. Jaribu tena.':'Sorry, I could not answer just now. Please try again.','bot')})}
f.addEventListener('submit',function(e){e.preventDefault();var q=inp.value.trim();if(q){inp.value='';ask(q)}});
w.querySelectorAll('.nx-ai-chips button').forEach(function(b){b.addEventListener('click',function(){ask(b.textContent)})});})();
</script>
