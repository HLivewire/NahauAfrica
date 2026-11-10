<div class="nx-banner">
    <div class="nx-wrap">
        <nav class="nx-crumbs" aria-label="Breadcrumb"><a href="{{ nroute('home') }}">{{ __('Home') }}</a> / <span aria-current="page">{{ nsection($section,'name') }}</span></nav>
        <h1 class="nx-h1">{{ nsection($section,'name') }}</h1>
        <p class="nx-tag">{{ nsection($section,'tagline') }}</p>
        <p class="nx-lead">{{ nsection($section,'intro') }}</p>
    </div>
</div>
