<?php
$currentURL = URL::current();
$currentRoute = Route::currentRouteName();
$pecah = explode("/", $currentURL);
$path = end($pecah);

if ($currentRoute == $path) {
    $actived = 'active';
} else {
    $actived = '';
}
?>
<div id="sidebar-container" class="bg-menu border-right sidebar-expanded sidebar-fixed d-none d-block">
    <ul class="list-group list-group-flush pt-4">
        <a href="javascript:void(0);" data-toggle="sidebar-colapse" class="bg-light list-group-item list-group-item-action sidebar-separator-title text-muted d-flex d-md-none align-items-center">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <small id="collapse-text" class="menu-collapsed">MENU</small>
                <span id="collapse-icon" class="fa fa-fw fa-small-collapse ml-auto fa-angle-double-left"></span>
            </div>
        </a>
        @if($currentRoute == 'complianceCategory')
        <a href="{{ route('complianceCategory') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 active">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-tags fa-fw mr-3"></span>
                <span class="menu-collapsed">Compliance Category</span>
            </div>
        </a>
        @else
        <a href="{{ route('complianceCategory') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-tags fa-fw mr-3"></span>
                <span class="menu-collapsed">Compliance Category</span>
            </div>
        </a>
        @endif
        @if($currentRoute == 'complianceObligations')
        <a href="{{ route('complianceObligations') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 active">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-check-square fa-fw mr-3"></span>
                <span class="menu-collapsed">Compliance Obligations</span>
            </div>
        </a>
        @else
        <a href="{{ route('complianceObligations') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-check-square fa-fw mr-3"></span>
                <span class="menu-collapsed">Compliance Obligations</span>
            </div>
        </a>
        @endif
        @if($currentRoute == 'complianceRegister')
        <a href="{{ route('complianceRegister') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 active">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-list-ol fa-fw mr-3"></span>
                <span class="menu-collapsed">Compliance Register</span>
            </div>
        </a>
        @else
        <a href="{{ route('complianceRegister') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-list-ol fa-fw mr-3"></span>
                <span class="menu-collapsed">Compliance Register</span>
            </div>
        </a>
        @endif
    </ul>
</div>