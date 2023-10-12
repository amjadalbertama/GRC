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
        <a href="{{ route('controls') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRoute == 'controls' || $currentRoute == 'controlActivity') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-shield fa-fw mr-3"></span>
                <span class="menu-collapsed">Controls</span>
            </div>
        </a>
        <a href="{{ route('kci') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRoute == 'kci') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-key fa-fw mr-3"></span>
                <span class="menu-collapsed">KCI</span>
            </div>
        </a>
        <a href="{{ route('issues') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRoute == 'issues') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-list fa-fw mr-3"></span>
                <span class="menu-collapsed">Issues</span>
            </div>
        </a>
        <a href="{{ route('monev') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRoute == 'monev') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-search fa-fw mr-3"></span>
                <span class="menu-collapsed">Monev</span>
            </div>
        </a>
        <a href="{{ route('audit') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRoute == 'audit' || $currentRoute == 'auditActivity') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-crosshairs fa-fw mr-3"></span>
                <span class="menu-collapsed">Audit</span>
            </div>
        </a>
    </ul>
</div>