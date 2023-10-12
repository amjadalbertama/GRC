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
    <a href="{{ route('settings') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRouteName == 'settings') active @endif">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-cog fa-fw mr-3"></span>
        <span class="menu-collapsed">General Settings</span>
      </div>
    </a>
    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == null)
    <a href="./masterdata.html" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRouteName == 'masterdata') active @endif">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-database fa-fw mr-3"></span>
        <span class="menu-collapsed">Master Data</span>
      </div>
    </a>
    <a href="{{ route('users') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRouteName == 'users') active @endif">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-users fa-fw mr-3"></span>
        <span class="menu-collapsed">User</span>
      </div>
    </a>
    <a href="{{ route('hakakses.index') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 @if($currentRouteName == 'hakakses.index') active @endif">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-universal-access fa-fw mr-3"></span>
        <span class="menu-collapsed">Access Rights</span>
      </div>
    </a>
    @endif
  </ul>
</div>