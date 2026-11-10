<footer class="main-footer">
    <span><strong>{{ __('Copyright ') }}</strong>&copy;{!! $companyInfo->copyright !!} <b>{{ __('Version') }}</b> {{ $companyInfo->version??'' }}</span>
    <span>{{ __('Admin design adapted from DropX Admin') }} &middot; Designed &amp; developed by <a href="https://datadropx.net" target="_blank" rel="noopener">DataDropX</a></span>
</footer>
<script>
(function(){
  var b=document.getElementById('dxTheme');
  if(b)b.addEventListener('click',function(){var n=document.documentElement.getAttribute('data-theme')==='dark'?'light':'dark';document.documentElement.setAttribute('data-theme',n);try{localStorage.setItem('nahau_admin_theme',n)}catch(e){}});
  var f=document.getElementById('dxFull');
  if(f)f.addEventListener('click',function(){if(!document.fullscreenElement)document.documentElement.requestFullscreen&&document.documentElement.requestFullscreen();else document.exitFullscreen()});
})();

  /* highlight the page you are on, and open its section */
  (function(){
    var side=document.querySelector('.main-sidebar .nav-sidebar');if(!side)return;
    var here=location.pathname.replace(/\/+$/,'')||'/';
    var best=null,bl=-1;
    side.querySelectorAll('a.nav-link[href]').forEach(function(a){
      var h=a.getAttribute('href');if(!h||h==='#'||h.indexOf('javascript')===0)return;
      var p;try{p=new URL(h,location.origin).pathname.replace(/\/+$/,'')||'/'}catch(e){return}
      var ok=(p===here)||(p!=='/admin'&&p!=='/'&&here.indexOf(p+'/')===0);
      if(ok&&p.length>bl){best=a;bl=p.length}
    });
    if(!best)return;
    side.querySelectorAll('a.nav-link.active').forEach(function(a){a.classList.remove('active')});
    side.querySelectorAll('li.menu-open').forEach(function(l){l.classList.remove('menu-open')});
    best.classList.add('active');
    var li=best.closest('li.nav-item');
    while(li){
      var parent=li.parentElement&&li.parentElement.closest('li.nav-item');
      if(parent){parent.classList.add('menu-open');var pl=parent.querySelector(':scope>a.nav-link');if(pl)pl.classList.add('active');var tv=parent.querySelector(':scope>ul.nav-treeview');if(tv)tv.style.display='block'}
      li=parent;
    }
  })();
</script>
