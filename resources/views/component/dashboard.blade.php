<?php
$currentURL = URL::current();
$currentRouteName = Route::currentRouteName();
$pecah = explode("/", $currentURL);
$path = end($pecah);
?>

<div id="sidebar-container" class="bg-menu border-right sidebar-expanded sidebar-fixed d-none d-block">
    <ul class="list-group list-group-flush pt-4">
        <a href="javascript:void(0);" data-toggle="sidebar-colapse" class="bg-light list-group-item list-group-item-action sidebar-separator-title text-muted d-flex d-md-none align-items-center">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <small id="collapse-text" class="menu-collapsed">MENU</small>
                <span id="collapse-icon" class="fa fa-fw fa-small-collapse ml-auto fa-angle-double-left"></span>
            </div>
        </a>
        <a href="{{ route('dashboard_index') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRouteName == 'dashboard_index') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-dashboard fa-fw mr-3"></span>
                <span class="menu-collapsed">Dashboard</span>
            </div>
        </a>
        <a href="{{ route('governance_index') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRouteName == 'governance_index') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-briefcase fa-fw mr-3"></span>
                <span class="menu-collapsed">Governance</span>
            </div>
        </a>
        <a href="{{ route('achievements_index') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRouteName == 'achievements_index') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-table fa-fw mr-3"></span>
                <span class="menu-collapsed">Achievement Details</span>
            </div>
        </a>
        <a href="{{ route('key_indicators_index') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRouteName == 'key_indicators_index') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-pie-chart fa-fw mr-3"></span>
                <span class="menu-collapsed">Key Indicators</span>
            </div>
        </a>
        <a href="{{ route('obligations_index') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRouteName == 'obligations_index') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-list fa-fw mr-3"></span>
                <span class="menu-collapsed">Obligations</span>
            </div>
        </a>
        <a href="{{ route('risks_index') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRouteName == 'risks_index') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-exclamation-triangle fa-fw mr-3"></span>
                <span class="menu-collapsed">Risks</span>
            </div>
        </a>
    </ul>
</div>