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
</script>
