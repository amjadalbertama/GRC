<nav aria-label="breadcrumb" class="no-side-margin bg-light mb-2">
    <ol class="breadcrumb mb-0 rounded-0 bg-light">
        <li class="breadcrumb-item"><a href="./beranda.html">Home</a></li>
        <li class="breadcrumb-item"><a href="./organization.html">Governance</a></li>
        @if(Route::currentRouteName() == 'policies')
        <li class="breadcrumb-item active" aria-current="page">Policy</li>
        @elseif(Route::currentRouteName() == 'programs')
        <li class="breadcrumb-item active" aria-current="page">Programs</li>
        @elseif(Route::currentRouteName() == 'strategies')
        <li class="breadcrumb-item active" aria-current="page">Strategies</li>
        @endif
    </ol>
</nav>