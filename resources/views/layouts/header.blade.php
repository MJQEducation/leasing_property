<header class="page-header" role="banner">
    <!-- we need this logo when user switches to nav-function-top -->
    <div class="page-logo">
        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative"
            data-toggle="modal" data-target="#modal-shortcut">
            <img src="{{ asset('plugin/img/logo.png') }}" alt="AII Language Center" aria-roledescription="logo">
            <span class="page-logo-text mr-1"> Language Center</span>
            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <!-- DOC: nav menu layout change shortcut -->
    <div class="hidden-md-down dropdown-icon-menu position-relative">
        <a href="#" class="header-btn btn js-waves-off" data-action="toggle" data-class="nav-function-hidden"
            title="Hide Navigation">
            <i class="ni ni-menu"></i>
        </a>
        <ul>
            <li>
                <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-minify"
                    title="Minify Navigation">
                    <i class="ni ni-minify-nav"></i>
                </a>
            </li>
            <li>
                <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-fixed"
                    title="Lock Navigation">
                    <i class="ni ni-lock-nav"></i>
                </a>
            </li>
        </ul>
    </div>
    <!-- DOC: mobile button appears during mobile width -->
    <div class="hidden-lg-up">
        <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
            <i class="ni ni-menu"></i>
        </a>
    </div>
    <!--<div class="search">
        <form class="app-forms hidden-xs-down" role="search" action="page_search.html" autocomplete="off">
            <input type="text" id="search-field" placeholder="Search for anything" class="form-control" tabindex="1">
            <a href="#" onclick="return false;" class="btn-danger btn-search-close js-waves-off d-none"
                data-action="toggle" data-class="mobile-search-on">
                <i class="fal fa-times"></i>
            </a>
        </form>
    </div>-->
    <div class="ml-auto d-flex">
        <!-- activate app search icon (mobile) -->
        <!--<div class="hidden-sm-up">
            <a href="#" class="header-icon" data-action="toggle" data-class="mobile-search-on"
                data-focus="search-field" title="Search">
                <i class="fal fa-search"></i>
            </a>
        </div>-->
        <!-- app settings -->
        <div class="hidden-md-down">
            <a href="#" class="header-icon" data-toggle="modal" data-target=".js-modal-settings">
                <i class="fal fa-cog"></i>
            </a>
        </div>
        <!-- app shortcuts -->
        <div>
            <a href="#" class="header-icon" data-toggle="dropdown" title="My Apps">
                <i class="fal fa-cube"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-animated w-auto h-auto">
                <div
                    class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top">
                    <h4 class="m-0 text-center color-white">
                        Quick Shortcut
                        <small class="mb-0 opacity-80">User Applications & Addons</small>
                    </h4>
                </div>
                <div class="custom-scroll h-100">
                    <ul class="app-list">
                        <li>
                            <a href="#" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-2 icon-stack-3x color-primary-600"></i>
                                    <i class="base-3 icon-stack-2x color-primary-700"></i>
                                    <i class="ni ni-settings icon-stack-1x text-white fs-lg"></i>
                                </span>
                                <span class="app-list-name">
                                    Services
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-2 icon-stack-3x color-primary-400"></i>
                                    <i class="base-10 text-white icon-stack-1x"></i>
                                    <i class="ni md-profile color-primary-800 icon-stack-2x"></i>
                                </span>
                                <span class="app-list-name">
                                    Account
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-9 icon-stack-3x color-success-400"></i>
                                    <i class="base-2 icon-stack-2x color-success-500"></i>
                                    <i class="ni ni-shield icon-stack-1x text-white"></i>
                                </span>
                                <span class="app-list-name">
                                    Security
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-18 icon-stack-3x color-info-700"></i>
                                    <span
                                        class="position-absolute pos-top pos-left pos-right color-white fs-md mt-2 fw-400">28</span>
                                </span>
                                <span class="app-list-name">
                                    Calendar
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-7 icon-stack-3x color-info-500"></i>
                                    <i class="base-7 icon-stack-2x color-info-700"></i>
                                    <i class="ni ni-graph icon-stack-1x text-white"></i>
                                </span>
                                <span class="app-list-name">
                                    Stats
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-4 icon-stack-3x color-danger-500"></i>
                                    <i class="base-4 icon-stack-1x color-danger-400"></i>
                                    <i class="ni ni-envelope icon-stack-1x text-white"></i>
                                </span>
                                <span class="app-list-name">
                                    Messages
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-4 icon-stack-3x color-fusion-400"></i>
                                    <i class="base-5 icon-stack-2x color-fusion-200"></i>
                                    <i class="base-5 icon-stack-1x color-fusion-100"></i>
                                    <i class="fal fa-keyboard icon-stack-1x color-info-50"></i>
                                </span>
                                <span class="app-list-name">
                                    Notes
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-16 icon-stack-3x color-fusion-500"></i>
                                    <i class="base-10 icon-stack-1x color-primary-50 opacity-30"></i>
                                    <i class="base-10 icon-stack-1x fs-xl color-primary-50 opacity-20"></i>
                                    <i class="fal fa-dot-circle icon-stack-1x text-white opacity-85"></i>
                                </span>
                                <span class="app-list-name">
                                    Photos
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-19 icon-stack-3x color-primary-400"></i>
                                    <i class="base-7 icon-stack-2x color-primary-300"></i>
                                    <i class="base-7 icon-stack-1x fs-xxl color-primary-200"></i>
                                    <i class="base-7 icon-stack-1x color-primary-500"></i>
                                    <i class="fal fa-globe icon-stack-1x text-white opacity-85"></i>
                                </span>
                                <span class="app-list-name">
                                    Maps
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-5 icon-stack-3x color-success-700 opacity-80"></i>
                                    <i class="base-12 icon-stack-2x color-success-700 opacity-30"></i>
                                    <i class="fal fa-comment-alt icon-stack-1x text-white"></i>
                                </span>
                                <span class="app-list-name">
                                    Chat
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-5 icon-stack-3x color-warning-600"></i>
                                    <i class="base-7 icon-stack-2x color-warning-800 opacity-50"></i>
                                    <i class="fal fa-phone icon-stack-1x text-white"></i>
                                </span>
                                <span class="app-list-name">
                                    Phone
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-6 icon-stack-3x color-danger-600"></i>
                                    <i class="fal fa-chart-line icon-stack-1x text-white"></i>
                                </span>
                                <span class="app-list-name">
                                    Projects
                                </span>
                            </a>
                        </li>
                        <li class="w-100">
                            <a href="#" class="btn btn-default mt-4 mb-2 pr-5 pl-5"> Add more apps </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- app message -->
        <a href="#" class="header-icon" data-toggle="modal" data-target=".js-modal-messenger"
            style="display:none">
            <i class="fal fa-globe"></i>
            <span class="badge badge-icon">!</span>
        </a>
        <!-- app notification -->
        <div>
            <a href="#" class="header-icon" data-toggle="dropdown" title="You got 11 notifications">
                <i class="fal fa-bell"></i>
                <span class="badge badge-icon" id="noticationRequestNumber"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-animated dropdown-xl">
                <div
                    class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top mb-2">
                    <h4 class="m-0 text-center color-white">
                        <span id="noticationRequestText">11 Request</span>
                        <small class="mb-0 opacity-80">User Notifications</small>
                    </h4>
                </div>
                <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link px-4 fs-md js-waves-on fw-500" data-toggle="tab" href="#tab-messages"
                            data-i18n="drpdwn.messages">Messages</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link px-4 fs-md js-waves-on fw-500" data-toggle="tab" href="#tab-feeds"
                            data-i18n="drpdwn.feeds">Feeds</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-4 fs-md js-waves-on fw-500" data-toggle="tab" href="#tab-events"
                            data-i18n="drpdwn.events">Events</a>
                    </li> --}}
                </ul>
                <div class="tab-content tab-notification">
                    <div class="tab-pane active" id="tab-messages" role="tabpanel">
                        <div class="custom-scroll h-100">
                            <ul class="notification" id="requestNotification">

                            </ul>
                        </div>
                    </div>
                </div>
                <div
                    class="py-2 px-3 bg-faded d-block rounded-bottom text-right border-faded border-bottom-0 border-right-0 border-left-0">
                    <a href="#" class="fs-xs fw-500 ml-auto">view all notifications</a>
                </div>
            </div>
        </div>
        <!-- app user menu -->
        <div>
            <a href="#" data-toggle="dropdown" title="drlantern@gotbootstrap.com"
                class="header-icon d-flex align-items-center justify-content-center ml-2">
                <img src="" class="profile-image rounded-circle" name="headeruserphoto">
                <!-- you can also add username next to the avatar with the codes below:
<span class="ml-1 mr-1 text-truncate text-truncate-header hidden-xs-down">Me</span>
<i class="ni ni-chevron-down hidden-xs-down"></i> -->
            </a>
            <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
                <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
                    <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
                        <span class="mr-2">
                            <img src="" class="rounded-circle profile-image" name="headeruserphoto">
                        </span>
                        <div class="info-card-text">
                            <div class="fs-lg text-truncate text-truncate-lg" name="headerusername">Dr. Codex Lantern
                            </div>
                            <!--<span class="text-truncate text-truncate-md opacity-80">drlantern@gotbootstrap.com</span>-->
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider m-0"></div>
                <a href="#" class="dropdown-item" data-action="app-reset">
                    <span data-i18n="drpdwn.reset_layout">Reset Layout</span>
                </a>
                <a href="#" class="dropdown-item" data-toggle="modal" data-target=".js-modal-settings">
                    <span data-i18n="drpdwn.settings">Settings</span>
                </a>
                <div class="dropdown-divider m-0"></div>
                <a href="#" class="dropdown-item" data-action="app-fullscreen">
                    <span data-i18n="drpdwn.fullscreen">Fullscreen</span>
                    <i class="float-right text-muted fw-n">F11</i>
                </a>
                <a href="#" class="dropdown-item" data-action="app-print">
                    <span data-i18n="drpdwn.print">Print</span>
                    <i class="float-right text-muted fw-n">Ctrl + P</i>
                </a>
                <div class="dropdown-multilevel dropdown-multilevel-left" style="display: none">
                    <div class="dropdown-item">
                        Language
                    </div>
                    <div class="dropdown-menu">
                        <a href="javascript:void(0);" class="dropdown-item active" data-action="lang"
                            data-lang="en">English</a>
                        <a href="javascript:void(0);" class="dropdown-item" data-action="lang"
                            data-lang="ch">ខ្មែរ</a>
                    </div>
                </div>
                <div class="dropdown-divider m-0"></div>
                <a id="headerResetPasswordBTN" class="dropdown-item fw-500 pt-3 pb-3" href="javascript:void(0);"
                    onclick="new function(){$('#layoutresetPasswordform #layoutresetpassword').val('');$('#layoutresetPasswordModal').modal();}">
                    <span>Change Password</span>
                </a>
                <a class="dropdown-item fw-500 pt-3 pb-3" href="javascript:void(0);" onclick="logOut()">
                    <span data-i18n="drpdwn.page-logout">Logout</span>
                </a>
            </div>
        </div>
    </div>
</header>

@include('layouts.resetPassword')
