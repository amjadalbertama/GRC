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
        <a href="{{ route('overview') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRoute == 'overview') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-dashboard fa-fw mr-3"></span>
                <span class="menu-collapsed">Overview</span>
            </div>
        </a>
        <a href="{{ route('report_risk') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRoute == 'report_risk') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-file-text-o fa-fw mr-3"></span>
                <span class="menu-collapsed">Risk Report</span>
            </div>
        </a>
        <a href="{{ route('report_compliance') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRoute == 'report_compliance') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-file-text-o fa-fw mr-3"></span>
                <span class="menu-collapsed">Compliance Report</span>
            </div>
        </a>
        <a href="{{ route('report_governance') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRoute == 'report_governance') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-file-text-o fa-fw mr-3"></span>
                <span class="menu-collapsed">Governance Report</span>
            </div>
        </a>
        <a href="{{ route('report_control') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRoute == 'report_control') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-file-text-o fa-fw mr-3"></span>
                <span class="menu-collapsed">Control Report</span>
            </div>
        </a>
        <a href="{{ route('report_issue') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRoute == 'report_issue') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-file-text-o fa-fw mr-3"></span>
                <span class="menu-collapsed">Issue Report</span>
            </div>
        </a>
        <a href="{{ route('report_monev') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRoute == 'report_monev') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-file-text-o fa-fw mr-3"></span>
                <span class="menu-collapsed">Monev Report</span>
            </div>
        </a>
        <a href="{{ route('report_audit') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRoute == 'report_audit') active @endif">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-file-text-o fa-fw mr-3"></span>
                <span class="menu-collapsed">Audit Report</span>
            </div>
        </a>
    </ul>
</div>