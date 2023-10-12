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
                <span id="collapse-icon" class="fa fa-fw fa-small-collapse ml-auto"></span>
            </div>
        </a>
        <a href="{{ route('home') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 <?php if (Route::currentRouteName() == 'home') {echo 'active';} ?>">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-home fa-fw mr-3"></span>
                <span class="menu-collapsed">Home</span>
            </div>
        </a>
        <a href="{{ route('profile') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 <?php if (Route::currentRouteName() == 'profile') {echo 'active';} ?>">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-user fa-fw mr-3"></span>
                <span class="menu-collapsed">Profile</span>
            </div>
        </a>
        <a href="{{ route('notification') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 <?php if (Route::currentRouteName() == 'notification') {echo 'active';} ?>">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-bell-o fa-fw mr-3"></span>
                <span class="menu-collapsed">Notifications</span>
            </div>
        </a>
    </ul>
</div>