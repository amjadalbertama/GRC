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
    @if($currentRoute == 'risk_appetite' || $currentRoute == 'risk_appetite_category')
    <a href="{{ route('risk_appetite') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 active">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-exclamation-circle fa-fw mr-3"></span>
        <span class="menu-collapsed">Risk Appetite</span>
      </div>
    </a>
    @else
    <a href="{{ route('risk_appetite') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-exclamation-circle fa-fw mr-3"></span>
        <span class="menu-collapsed">Risk Appetite</span>
      </div>
    </a>
    @endif
    @if($currentRoute == 'impactria' || $currentRoute == 'impactdetail')
    <a href="{{ route('impactria') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 active">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-heartbeat fa-fw mr-3"></span>
        <span class="menu-collapsed">Impact Criteria</span>
      </div>
    </a>
    @else
    <a href="{{ route('impactria') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-heartbeat fa-fw mr-3"></span>
        <span class="menu-collapsed">Impact Criteria</span>
      </div>
    </a>
    @endif
    @if($currentRoute == 'likelihood')
    <a href="{{ route('likelihood') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 active">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-percent fa-fw mr-3"></span>
        <span class="menu-collapsed">Likelihood Criteria</span>
      </div>
    </a>
    @else
    <a href="{{ route('likelihood') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-percent fa-fw mr-3"></span>
        <span class="menu-collapsed">Likelihood Criteria</span>
      </div>
    </a>
    @endif
    @if($currentRoute == 'risk_matrix' || $currentRoute == 'risk_matrix_settings')
    <a href="{{ route('risk_matrix') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 active">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-th-large fa-fw mr-3"></span>
        <span class="menu-collapsed">Risk Matrix</span>
      </div>
    </a>
    @else
    <a href="{{ route('risk_matrix') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-th-large fa-fw mr-3"></span>
        <span class="menu-collapsed">Risk Matrix</span>
      </div>
    </a>
    @endif
    @if($currentRoute == 'kri')
    <a href="{{ route('kri') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 active">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-bell-o fa-fw mr-3"></span>
        <span class="menu-collapsed">KRI</span>
      </div>
    </a>
    @else
    <a href="{{ route('kri') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-bell-o fa-fw mr-3"></span>
        <span class="menu-collapsed">KRI</span>
      </div>
    </a>
    @endif
    @if($currentRoute == 'risk_register' || $currentRoute == 'risk_register_edit')
    <a href="{{ route('risk_register') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 active">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-list-ol fa-fw mr-3"></span>
        <span class="menu-collapsed">Risk Register</span>
      </div>
    </a>
    @else
    <a href="{{ route('risk_register') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0">
      <div class="d-flex justify-content-start align-items-center">
        <span class="fa fa-list-ol fa-fw mr-3"></span>
        <span class="menu-collapsed">Risk Register</span>
      </div>
    </a>
    @endif
  </ul>
</div>