@if(Route::currentRouteName() == 'dashboard.index')

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
        <a href="{{ route('profile_name') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 <?php if (Route::currentRouteName() == 'profile') {echo 'active';} ?>">
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
@else
<div id="sidebar-container" class="bg-menu border-right sidebar-expanded sidebar-fixed d-none d-block">
    <ul class="list-group list-group-flush pt-4">
        <a href="javascript:void(0);" data-toggle="sidebar-colapse" class="bg-light list-group-item list-group-item-action sidebar-separator-title text-muted d-flex d-md-none align-items-center">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <small id="collapse-text" class="menu-collapsed">MENU</small>
                <span id="collapse-icon" class="fa fa-fw fa-small-collapse ml-auto"></span>
            </div>
        </a>
        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5)
        <a href="{{ url('organization') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 <?php if (Route::currentRouteName() == 'organization') {
                                                                                                                                                                        echo 'active';
                                                                                                                                                                    } ?>">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-building-o fa-fw mr-3"></span>
                <span class="menu-collapsed">Organization</span>
            </div>
        </a>
        @endif
        <a href="{{ url('capabilities') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 <?php if (Route::currentRouteName() == 'capabilities') {
                                                                                                                                                                        echo 'active';
                                                                                                                                                                    } ?>">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-puzzle-piece fa-fw mr-3"></span>
                <span class="menu-collapsed">Capabilites</span>
            </div>
        </a>
        <a href="{{ url('periods') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 <?php if (Route::currentRouteName() == 'periods') {
                                                                                                                                                                echo 'active';
                                                                                                                                                            } ?>">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-calendar fa-fw mr-3"></span>
                <span class="menu-collapsed">Periods</span>
            </div>
        </a>
        <a href="{{ url('bizenvirnmt') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 <?php if (Route::currentRouteName() == 'bzenvir') {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-binoculars fa-fw mr-3"></span>
                <span class="menu-collapsed">Biz Environment</span>
            </div>
        </a>
        <a href="{{ url('policies') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 <?php if (Route::currentRouteName() == 'policies') {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-briefcase fa-fw mr-3"></span>
                <span class="menu-collapsed">Policies</span>
            </div>
        </a>
        <a href="{{ url('kpi') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 <?php if (Route::currentRouteName() == 'kpi') {
                                                                                                                                                            echo 'active';
                                                                                                                                                        } ?>">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-key fa-fw mr-3"></span>
                <span class="menu-collapsed">KPI</span>
            </div>
        </a>
        <a href="{{ url('objectegory') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 <?php if (Route::currentRouteName() == 'objectegory') {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-object-group fa-fw mr-3"></span>
                <span class="menu-collapsed">Objective Category</span>
            </div>
        </a>
        <a href="{{ url('objective') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 <?php if (Route::currentRouteName() == 'objective') {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-bullseye fa-fw mr-3"></span>
                <span class="menu-collapsed">Objectives</span>
            </div>
        </a>
        <a href="{{ url('strategies') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 <?php if (Route::currentRouteName() == 'strategies') {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-cubes fa-fw mr-3"></span>
                <span class="menu-collapsed">Strategies</span>
            </div>
        </a>
        <a href="{{ url('programs') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 <?php if (Route::currentRouteName() == 'programs') {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-sitemap fa-fw mr-3"></span>
                <span class="menu-collapsed">Programs</span>
            </div>
        </a>
        <!-- <a href="{{ url('ksf') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-calendar-check-o fa-fw mr-3"></span>
                <span class="menu-collapsed">KSF</span>
            </div>
        </a> -->
        @if(Auth::user()->role_id == 8 || Auth::user()->role_id == 5)
        <a href="{{ url('reviewimprove') }}" class="list-group-item list-group-item-action flex-column align-items-start bg-transparent mb-2 py-2 border-bottom-0 <?php if (Route::currentRouteName() == 'reviewimprove' || Route::currentRouteName() == 'details_reviewImprove') {
                                                                                                                                                                        echo 'active';
                                                                                                                                                                    } 
                                                                                                                                                                    ?>">
            <div class="d-flex justify-content-start align-items-center">
                <span class="fa fa-wrench fa-fw mr-3"></span>
                <span class="menu-collapsed">Review & Improvement</span>
            </div>
        </a>
        @endif
    </ul>
</div>
@endif