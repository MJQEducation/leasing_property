<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-chart-area'></i> Analytics <span class='fw-300'>Dashboard</span>
    </h1>
    <div class="subheader-block d-lg-flex align-items-center">
        <div class="d-inline-flex flex-column justify-content-center mr-3">
            <span class="fw-300 fs-xs d-block opacity-50">
                <small>EXPENSES</small>
            </span>
            <span class="fw-500 fs-xl d-block color-primary-500">
                $47,000
            </span>
        </div>
        <span class="sparklines hidden-lg-down" sparkType="bar" sparkBarColor="#886ab5" sparkHeight="32px"
            sparkBarWidth="5px" values="3,4,3,6,7,3,3,6,2,6,4"></span>
    </div>
    <div
        class="subheader-block d-lg-flex align-items-center border-faded border-right-0 border-top-0 border-bottom-0 ml-3 pl-3">
        <div class="d-inline-flex flex-column justify-content-center mr-3">
            <span class="fw-300 fs-xs d-block opacity-50">
                <small>MY PROFITS</small>
            </span>
            <span class="fw-500 fs-xl d-block color-danger-500">
                $38,500
            </span>
        </div>
        <span class="sparklines hidden-lg-down" sparkType="bar" sparkBarColor="#fe6bb0" sparkHeight="32px"
            sparkBarWidth="5px" values="1,4,3,6,5,3,9,6,5,9,7"></span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div id="panel-1" class="panel panel-locked" data-panel-lock="false" data-panel-close="false"
            data-panel-fullscreen="false" data-panel-collapsed="false" data-panel-color="false"
            data-panel-locked="false" data-panel-refresh="false" data-panel-reset="false">
            <div class="panel-hdr">
                <h2>
                    Live Feeds
                </h2>
                <div class="panel-toolbar pr-3 align-self-end">
                    <ul id="demo_panel-tabs" class="nav nav-tabs border-bottom-0 nav-tabs-clean" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab_default-1" role="tab">Live
                                Stats</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab_default-2" role="tab">Revenue</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content border-faded border-left-0 border-right-0 border-top-0">
                    <div class="row no-gutters">
                        <div class="col-lg-7 col-xl-8">
                            <div class="position-relative">
                                <div
                                    class="custom-control custom-switch position-absolute pos-top pos-left ml-5 mt-3 z-index-cloud">
                                    <input type="checkbox" class="custom-control-input" id="start_interval">
                                    <label class="custom-control-label" for="start_interval">Live Update</label>
                                </div>
                                <div id="updating-chart" style="height:242px"></div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4 pl-lg-3">
                            <div class="d-flex mt-2">
                                My Tasks
                                <span class="d-inline-block ml-auto">130 / 500</span>
                            </div>
                            <div class="progress progress-sm mb-3">
                                <div class="progress-bar bg-fusion-400" role="progressbar" style="width: 65%;"
                                    aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex">
                                Transfered
                                <span class="d-inline-block ml-auto">440 TB</span>
                            </div>
                            <div class="progress progress-sm mb-3">
                                <div class="progress-bar bg-success-500" role="progressbar" style="width: 34%;"
                                    aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex">
                                Bugs Squashed
                                <span class="d-inline-block ml-auto">77%</span>
                            </div>
                            <div class="progress progress-sm mb-3">
                                <div class="progress-bar bg-info-400" role="progressbar" style="width: 77%;"
                                    aria-valuenow="77" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex">
                                User Testing
                                <span class="d-inline-block ml-auto">7 days</span>
                            </div>
                            <div class="progress progress-sm mb-g">
                                <div class="progress-bar bg-primary-300" role="progressbar" style="width: 84%;"
                                    aria-valuenow="84" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-6 pr-1">
                                    <a href="#" class="btn btn-default btn-block">Generate PDF</a>
                                </div>
                                <div class="col-6 pl-1">
                                    <a href="#" class="btn btn-default btn-block">Report a Bug</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-content p-0">
                    <div class="row row-grid no-gutters">
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="px-3 py-2 d-flex align-items-center">
                                <div class="js-easy-pie-chart color-primary-300 position-relative d-inline-flex align-items-center justify-content-center"
                                    data-percent="75" data-piesize="50" data-linewidth="5" data-linecap="butt"
                                    data-scalelength="0">
                                    <div
                                        class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-lg">
                                        <span class="js-percent d-block text-dark"></span>
                                    </div>
                                </div>
                                <span class="d-inline-block ml-2 text-muted">
                                    SERVER LOAD
                                    <i class="fal fa-caret-up color-danger-500 ml-1"></i>
                                </span>
                                <div class="ml-auto d-inline-flex align-items-center">
                                    <div class="sparklines d-inline-flex" sparktype="line" sparkheight="30"
                                        sparkwidth="70" sparklinecolor="#886ab5" sparkfillcolor="false"
                                        sparklinewidth="1" values="5,6,5,3,8,6,9,7,4,2"></div>
                                    <div class="d-inline-flex flex-column small ml-2">
                                        <span
                                            class="d-inline-block badge badge-success opacity-50 text-center p-1 width-6">97%</span>
                                        <span
                                            class="d-inline-block badge bg-fusion-300 opacity-50 text-center p-1 width-6 mt-1">44%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="px-3 py-2 d-flex align-items-center">
                                <div class="js-easy-pie-chart color-success-500 position-relative d-inline-flex align-items-center justify-content-center"
                                    data-percent="79" data-piesize="50" data-linewidth="5" data-linecap="butt">
                                    <div
                                        class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-lg">
                                        <span class="js-percent d-block text-dark"></span>
                                    </div>
                                </div>
                                <span class="d-inline-block ml-2 text-muted">
                                    DISK SPACE
                                    <i class="fal fa-caret-down color-success-500 ml-1"></i>
                                </span>
                                <div class="ml-auto d-inline-flex align-items-center">
                                    <div class="sparklines d-inline-flex" sparktype="line" sparkheight="30"
                                        sparkwidth="70" sparklinecolor="#1dc9b7" sparkfillcolor="false"
                                        sparklinewidth="1" values="5,9,7,3,5,2,5,3,9,6"></div>
                                    <div class="d-inline-flex flex-column small ml-2">
                                        <span
                                            class="d-inline-block badge badge-info opacity-50 text-center p-1 width-6">76%</span>
                                        <span
                                            class="d-inline-block badge bg-warning-300 opacity-50 text-center p-1 width-6 mt-1">3%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="px-3 py-2 d-flex align-items-center">
                                <div class="js-easy-pie-chart color-info-500 position-relative d-inline-flex align-items-center justify-content-center"
                                    data-percent="23" data-piesize="50" data-linewidth="5" data-linecap="butt">
                                    <div
                                        class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-lg">
                                        <span class="js-percent d-block text-dark"></span>
                                    </div>
                                </div>
                                <span class="d-inline-block ml-2 text-muted">
                                    DATA TTF
                                    <i class="fal fa-caret-up color-success-500 ml-1"></i>
                                </span>
                                <div class="ml-auto d-inline-flex align-items-center">
                                    <div class="sparklines d-inline-flex" sparktype="line" sparkheight="30"
                                        sparkwidth="70" sparklinecolor="#51adf6" sparkfillcolor="false"
                                        sparklinewidth="1" values="3,5,2,5,3,9,6,5,9,7"></div>
                                    <div class="d-inline-flex flex-column small ml-2">
                                        <span
                                            class="d-inline-block badge bg-fusion-500 opacity-50 text-center p-1 width-6">10GB</span>
                                        <span
                                            class="d-inline-block badge bg-fusion-300 opacity-50 text-center p-1 width-6 mt-1">10%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="px-3 py-2 d-flex align-items-center">
                                <div class="js-easy-pie-chart color-fusion-500 position-relative d-inline-flex align-items-center justify-content-center"
                                    data-percent="36" data-piesize="50" data-linewidth="5" data-linecap="butt">
                                    <div
                                        class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-lg">
                                        <span class="js-percent d-block text-dark"></span>
                                    </div>
                                </div>
                                <span class="d-inline-block ml-2 text-muted">
                                    TEMP.
                                    <i class="fal fa-caret-down color-success-500 ml-1"></i>
                                </span>
                                <div class="ml-auto d-inline-flex align-items-center">
                                    <div class="sparklines d-inline-flex" sparktype="line" sparkheight="30"
                                        sparkwidth="70" sparklinecolor="#fd3995" sparkfillcolor="false"
                                        sparklinewidth="1" values="5,3,9,6,5,9,7,3,5,2"></div>
                                    <div class="d-inline-flex flex-column small ml-2">
                                        <span
                                            class="d-inline-block badge badge-danger opacity-50 text-center p-1 width-6">124</span>
                                        <span
                                            class="d-inline-block badge bg-info-300 opacity-50 text-center p-1 width-6 mt-1">40F</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div id="panel-2" class="panel" data-panel-fullscreen="false">
            <div class="panel-hdr">
                <h2>
                    Smart Chat
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content p-0">
                    <div class="d-flex flex-column">
                        <div class="bg-subtlelight-fade custom-scroll" style="height: 244px">
                            <div class="h-100">
                                <!-- message -->
                                <div class="d-flex flex-row px-3 pt-3 pb-2">
                                    <!-- profile photo : lazy loaded -->
                                    <span class="status status-danger">
                                        <span class="profile-image rounded-circle d-inline-block"
                                            style="background-image:url('{{ asset('plugin/img/demo/avatars/avatar-j.png') }}')"></span>
                                    </span>
                                    <!-- profile photo end -->
                                    <div class="ml-3">
                                        <a href="javascript:void(0);" title="Lisa Hatchensen"
                                            class="d-block fw-700 text-dark">Lisa Hatchensen</a>
                                        Hey did you meet the new board of director? He's a bit of a geek if you ask
                                        me...anyway here is the report you requested. I am off to launch with Lisa
                                        and Andrew, you wanna join?
                                        <!-- file download -->
                                        <div class="d-flex mt-3 flex-wrap">
                                            <div class="btn-group mr-1 mt-1" role="group"
                                                aria-label="Button group with nested dropdown ">
                                                <button type="button"
                                                    class="btn btn-default btn-xs btn-block px-1 py-1 fw-500"
                                                    data-action="toggle">
                                                    <span class="d-block text-truncate text-truncate-sm">
                                                        <i class="fal fa-file-pdf mr-1 color-danger-700"></i>
                                                        Report-2013-demographic-repo
                                                    </span>
                                                </button>
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupDrop1" type="button"
                                                        class="btn btn-default btn-xs dropdown-toggle px-2 js-waves-off"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"></button>
                                                    <div class="dropdown-menu p-0 fs-xs"
                                                        aria-labelledby="btnGroupDrop1">
                                                        <a class="dropdown-item px-3 py-2" href="#">Forward</a>
                                                        <a class="dropdown-item px-3 py-2" href="#">Open</a>
                                                        <a class="dropdown-item px-3 py-2" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="btn-group mr-1 mt-1" role="group"
                                                aria-label="Button group with nested dropdown ">
                                                <button type="button"
                                                    class="btn btn-default btn-xs btn-block px-1 py-1 fw-500"
                                                    data-action="toggle">
                                                    <span class="d-block text-truncate text-truncate-sm">
                                                        <i class="fal fa-file-pdf mr-1 color-danger-700"></i>
                                                        Bloodworks Patient 34124BA
                                                    </span>
                                                </button>
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupDrop2" type="button"
                                                        class="btn btn-default btn-xs dropdown-toggle px-2 js-waves-off"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"></button>
                                                    <div class="dropdown-menu p-0 fs-xs"
                                                        aria-labelledby="btnGroupDrop2">
                                                        <a class="dropdown-item px-3 py-2" href="#">Forward</a>
                                                        <a class="dropdown-item px-3 py-2" href="#">Open</a>
                                                        <a class="dropdown-item px-3 py-2" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- file download end -->
                                    </div>
                                </div>
                                <!-- message end -->
                                <!-- message reply -->
                                <div class="d-flex flex-row px-3 pt-3 pb-2">
                                    <!-- profile photo : lazy loaded -->
                                    <span class="status status-danger">
                                        <span class="profile-image rounded-circle d-inline-block"
                                            style="background-image:url('{{ asset('plugin/img/demo/avatars/avatar-admin.png') }}')"></span>
                                    </span>
                                    <!-- profile photo end -->
                                    <div class="ml-3">
                                        <a href="javascript:void(0);" title="Lisa Hatchensen"
                                            class="d-block fw-700 text-dark">Dr. Codex Lantern</a>
                                        Thanks for the file! You guys go ahead, I have to call some of my patients.
                                    </div>
                                </div>
                                <!-- message reply end -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 bg-faded">
                    <textarea rows="3"
                        class="form-control rounded-top border-bottom-left-radius-0 border-bottom-right-radius-0 border"
                        placeholder="write a reply..."></textarea>
                    <div class="d-flex align-items-center py-2 px-2 bg-white border border-top-0 rounded-bottom">
                        <div class="btn-group dropup">
                            <button type="button" class="btn btn-icon fs-lg dropdown-toggle no-arrow"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fal fa-smile"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-animated text-center rounded-pill overflow-hidden"
                                style="width: 280px">
                                <div class="px-1 py-0">
                                    <a href="javascript:void(0);" class="emoji emoji--like" data-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="Like">
                                        <div class="emoji__hand">
                                            <div class="emoji__thumb"></div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="emoji emoji--love" data-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="Love">
                                        <div class="emoji__heart"></div>
                                    </a>
                                    <a href="javascript:void(0);" class="emoji emoji--haha" data-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="Haha">
                                        <div class="emoji__face">
                                            <div class="emoji__eyes"></div>
                                            <div class="emoji__mouth">
                                                <div class="emoji__tongue"></div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="emoji emoji--yay" data-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="Yay">
                                        <div class="emoji__face">
                                            <div class="emoji__eyebrows"></div>
                                            <div class="emoji__mouth"></div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="emoji emoji--wow" data-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="Wow">
                                        <div class="emoji__face">
                                            <div class="emoji__eyebrows"></div>
                                            <div class="emoji__eyes"></div>
                                            <div class="emoji__mouth"></div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="emoji emoji--sad" data-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="Sad">
                                        <div class="emoji__face">
                                            <div class="emoji__eyebrows"></div>
                                            <div class="emoji__eyes"></div>
                                            <div class="emoji__mouth"></div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="emoji emoji--angry" data-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="Angry">
                                        <div class="emoji__face">
                                            <div class="emoji__eyebrows"></div>
                                            <div class="emoji__eyes"></div>
                                            <div class="emoji__mouth"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-icon fs-lg">
                            <i class="fal fa-paperclip"></i>
                        </button>
                        <div class="custom-control custom-checkbox custom-control-inline ml-auto hidden-sm-down">
                            <input type="checkbox" class="custom-control-input" id="defaultInline1">
                            <label class="custom-control-label" for="defaultInline1">Press <strong>ENTER</strong>
                                to send</label>
                        </div>
                        <button class="btn btn-primary btn-sm ml-auto ml-sm-0">
                            Reply
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="panel-3" class="panel">
            <div class="panel-hdr">
                <h2 class="js-get-date"></h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div id="panel-4" class="panel">
            <div class="panel-hdr">
                <h2>Bird's Eyes</h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content jqvmap-bg-ocean p-0" style="height: 330px;">
                    <div id="vector-map" class="w-100 h-100 p-4"></div>
                </div>
                <div class="panel-content jqvmap-bg-ocean">
                    <div class="d-flex align-items-center">
                        <img class="d-inline-block js-jqvmap-flag mr-3 border-faded" alt="flag"
                            src="{{ asset('files/sysimg/camboflag.png') }}" style="width:55px; height: auto;">
                        <h4 class="d-inline-block fw-300 m-0 text-muted fs-lg">
                            Showcasing information:
                            <small class="js-jqvmap-country mb-0 fw-500 text-dark">Kingdom of Cambodia -
                                $3,760,125.00</small>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div id="panel-5" class="panel">
            <div class="panel-hdr">
                <h2>Subscriptions Hourly</h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <h5>Subscription Views / hour</h5>
                    <div id="flotBar1" style="width: 100%; height: 160px;"></div>
                </div>
            </div>
        </div>
        <div id="panel-6" class="panel">
            <div class="panel-hdr">
                <h2>Secession Scale </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content p-0 mb-g">
                    <div class="alert alert-success alert-dismissible fade show border-faded border-left-0 border-right-0 border-top-0 rounded-0 m-0"
                        role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                        <strong>Last update was on <span class="js-get-date"></span></strong> - Your logs are
                        all up to date.
                    </div>
                </div>
                <div class="panel-content">
                    <div class="row  mb-g">
                        <div class="col-md-6 d-flex align-items-center">
                            <div id="flotPie" class="w-100" style="height:250px"></div>
                        </div>
                        <div class="col-md-6 col-lg-5 mr-lg-auto">
                            <div class="d-flex mt-2 mb-1 fs-xs text-primary">
                                Current Usage
                            </div>
                            <div class="progress progress-xs mb-3">
                                <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex mt-2 mb-1 fs-xs text-info">
                                Net Usage
                            </div>
                            <div class="progress progress-xs mb-3">
                                <div class="progress-bar bg-info-500" role="progressbar" style="width: 30%;"
                                    aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex mt-2 mb-1 fs-xs text-warning">
                                Users blocked
                            </div>
                            <div class="progress progress-xs mb-3">
                                <div class="progress-bar bg-warning-500" role="progressbar" style="width: 40%;"
                                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex mt-2 mb-1 fs-xs text-danger">
                                Custom cases
                            </div>
                            <div class="progress progress-xs mb-3">
                                <div class="progress-bar bg-danger-500" role="progressbar" style="width: 15%;"
                                    aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex mt-2 mb-1 fs-xs text-success">
                                Test logs
                            </div>
                            <div class="progress progress-xs mb-3">
                                <div class="progress-bar bg-success-500" role="progressbar" style="width: 25%;"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex mt-2 mb-1 fs-xs text-dark">
                                Uptime records
                            </div>
                            <div class="progress progress-xs mb-3">
                                <div class="progress-bar bg-fusion-500" role="progressbar" style="width: 10%;"
                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //$('#js-page-content').smartPanel();

        //
        //
        var dataSetPie = [{
                label: "Asia",
                data: 4119630000,
                color: color.primary._500
            },
            {
                label: "Latin America",
                data: 590950000,
                color: color.info._500
            },
            {
                label: "Africa",
                data: 1012960000,
                color: color.warning._500
            },
            {
                label: "Oceania",
                data: 95100000,
                color: color.danger._500
            },
            {
                label: "Europe",
                data: 727080000,
                color: color.success._500
            },
            {
                label: "North America",
                data: 344120000,
                color: color.fusion._400
            }
        ];


        $.plot($("#flotPie"), dataSetPie, {
            series: {
                pie: {
                    innerRadius: 0.5,
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 2 / 3,
                        threshold: 0.1
                    }
                }
            },
            legend: {
                show: false
            }
        });


        $.plot('#flotBar1', [{
                data: [
                    [1, 0],
                    [2, 0],
                    [3, 0],
                    [4, 1],
                    [5, 3],
                    [6, 3],
                    [7, 10],
                    [8, 11],
                    [9, 10],
                    [10, 9],
                    [11, 12],
                    [12, 8],
                    [13, 10],
                    [14, 6],
                    [15, 3]
                ],
                bars: {
                    show: true,
                    lineWidth: 0,
                    fillColor: color.fusion._50,
                    barWidth: .3,
                    order: 'left'
                }
            },
            {
                data: [
                    [1, 0],
                    [2, 0],
                    [3, 1],
                    [4, 2],
                    [5, 2],
                    [6, 5],
                    [7, 8],
                    [8, 12],
                    [9, 10],
                    [10, 11],
                    [11, 3]
                ],
                bars: {
                    show: true,
                    lineWidth: 0,
                    fillColor: color.success._500,
                    barWidth: .3,
                    align: 'right'
                }
            }
        ], {
            grid: {
                borderWidth: 0,
            },
            yaxis: {
                min: 0,
                max: 15,
                tickColor: 'rgba(0,0,0,0.05)',
                ticks: [
                    [0, ''],
                    [5, '$5000'],
                    [10, '$25000'],
                    [15, '$45000']
                ],
                font: {
                    color: '#444',
                    size: 10
                }
            },
            xaxis: {
                mode: 'categories',
                tickColor: 'rgba(0,0,0,0.05)',
                ticks: [
                    [0, '3am'],
                    [1, '4am'],
                    [2, '5am'],
                    [3, '6am'],
                    [4, '7am'],
                    [5, '8am'],
                    [6, '9am'],
                    [7, '10am'],
                    [8, '11am'],
                    [9, '12nn'],
                    [10, '1pm'],
                    [11, '2pm'],
                    [12, '3pm'],
                    [13, '4pm'],
                    [14, '5pm']
                ],
                font: {
                    color: '#999',
                    size: 9
                }
            }
        });


        /*
         * VECTOR MAP
         */

        var data_array = {
            "af": "16.63",
            "al": "0",
            "dz": "158.97",
            "ao": "85.81",
            "ag": "1.1",
            "ar": "351.02",
            "am": "8.83",
            "au": "1219.72",
            "at": "366.26",
            "az": "52.17",
            "bs": "7.54",
            "bh": "21.73",
            "bd": "105.4",
            "bb": "3.96",
            "by": "52.89",
            "be": "461.33",
            "bz": "1.43",
            "bj": "6.49",
            "bt": "1.4",
            "bo": "19.18",
            "ba": "16.2",
            "bw": "12.5",
            "br": "2023.53",
            "bn": "11.96",
            "bg": "44.84",
            "bf": "8.67",
            "bi": "1.47",
            "kh": "11.36",
            "cm": "21.88",
            "ca": "1563.66",
            "cv": "1.57",
            "cf": "2.11",
            "td": "7.59",
            "cl": "199.18",
            "cn": "5745.13",
            "co": "283.11",
            "km": "0.56",
            "cd": "12.6",
            "cg": "11.88",
            "cr": "35.02",
            "ci": "22.38",
            "hr": "59.92",
            "cy": "22.75",
            "cz": "195.23",
            "dk": "304.56",
            "dj": "1.14",
            "dm": "0.38",
            "do": "50.87",
            "ec": "61.49",
            "eg": "216.83",
            "sv": "21.8",
            "gq": "14.55",
            "er": "2.25",
            "ee": "19.22",
            "et": "30.94",
            "fj": "3.15",
            "fi": "231.98",
            "fr": "2555.44",
            "ga": "12.56",
            "gm": "1.04",
            "ge": "11.23",
            "de": "3305.9",
            "gh": "18.06",
            "gr": "305.01",
            "gd": "0.65",
            "gt": "40.77",
            "gn": "4.34",
            "gw": "0.83",
            "gy": "2.2",
            "ht": "6.5",
            "hn": "15.34",
            "hk": "226.49",
            "hu": "132.28",
            "is": "0",
            "in": "1430.02",
            "id": "695.06",
            "ir": "337.9",
            "iq": "84.14",
            "ie": "204.14",
            "il": "201.25",
            "it": "2036.69",
            "jm": "13.74",
            "jp": "5390.9",
            "jo": "27.13",
            "kz": "129.76",
            "ke": "32.42",
            "ki": "0.15",
            "kw": "117.32",
            "kg": "4.44",
            "la": "6.34",
            "lv": "23.39",
            "lb": "39.15",
            "ls": "1.8",
            "lr": "0.98",
            "lt": "35.73",
            "lu": "52.43",
            "mk": "9.58",
            "mg": "8.33",
            "mw": "5.04",
            "my": "218.95",
            "mv": "1.43",
            "ml": "9.08",
            "mt": "7.8",
            "mr": "3.49",
            "mu": "9.43",
            "mx": "1004.04",
            "md": "5.36",
            "rw": "5.69",
            "ws": "0.55",
            "st": "0.19",
            "sa": "434.44",
            "sn": "12.66",
            "rs": "38.92",
            "sc": "0.92",
            "sl": "1.9",
            "sg": "217.38",
            "sk": "86.26",
            "si": "46.44",
            "sb": "0.67",
            "za": "354.41",
            "es": "1374.78",
            "lk": "48.24",
            "kn": "0.56",
            "lc": "1",
            "vc": "0.58",
            "sd": "65.93",
            "sr": "3.3",
            "sz": "3.17",
            "se": "444.59",
            "ch": "522.44",
            "sy": "59.63",
            "tw": "426.98",
            "tj": "5.58",
            "tz": "22.43",
            "th": "312.61",
            "tl": "0.62",
            "tg": "3.07",
            "to": "0.3",
            "tt": "21.2",
            "tn": "43.86",
            "tr": "729.05",
            "tm": "0",
            "ug": "17.12",
            "ua": "136.56",
            "ae": "239.65",
            "gb": "2258.57",
            "us": "14624.18",
            "uy": "40.71",
            "uz": "37.72",
            "vu": "0.72",
            "ve": "285.21",
            "vn": "101.99",
            "ye": "30.02",
            "zm": "15.69",
            "zw": "0"
        };

        $('#vector-map').vectorMap({
            map: 'world_en',
            backgroundColor: 'transparent',
            color: color.warning._50,
            borderOpacity: 0.5,
            borderWidth: 1,
            hoverColor: color.success._300,
            hoverOpacity: null,
            selectedColor: color.success._500,
            selectedRegions: ['US'],
            enableZoom: true,
            showTooltip: true,
            scaleColors: [color.primary._400, color.primary._50],
            values: data_array,
            normalizeFunction: 'polynomial',
            onRegionClick: function(element, code, region) {
                /*var message = 'You clicked "'
                            + region
                            + '" which has the code: '
                            + code.toLowerCase();

                        console.log(message);*/

                var randomNumber = Math.floor(Math.random() * 10000000);
                var arrow;

                if (Math.random() >= 0.5 == true) {
                    arrow =
                        '<div class="ml-2 d-inline-flex"><i class="fal fa-caret-up text-success fs-xs"></i></div>'
                } else {
                    arrow =
                        '<div class="ml-2 d-inline-flex"><i class="fal fa-caret-down text-danger fs-xs"></i></div>'
                }

                $('.js-jqvmap-flag').attr('src',
                    'https://lipis.github.io/flag-icon-css/flags/4x3/' + code.toLowerCase() +
                    '.svg');
                $('.js-jqvmap-country').html(region + ' - ' + '$' + randomNumber.toFixed(2).replace(
                    /(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + arrow);
            }
        });


        /* TAB 1: UPDATING CHART */
        var data = [],
            totalPoints = 200;
        var getRandomData = function() {
            if (data.length > 0)
                data = data.slice(1);

            // do a random walk
            while (data.length < totalPoints) {
                var prev = data.length > 0 ? data[data.length - 1] : 50;
                var y = prev + Math.random() * 10 - 5;
                if (y < 0)
                    y = 0;
                if (y > 100)
                    y = 100;
                data.push(y);
            }

            // zip the generated y values with the x values
            var res = [];
            for (var i = 0; i < data.length; ++i)
                res.push([i, data[i]])
            return res;
        }
        // setup control widget
        var updateInterval = 1500;
        $("#updating-chart").val(updateInterval).change(function() {

            var v = $(this).val();
            if (v && !isNaN(+v)) {
                updateInterval = +v;
                $(this).val("" + updateInterval);
            }

        });
        // setup plot
        var options = {
            colors: [color.primary._700],
            series: {
                lines: {
                    show: true,
                    lineWidth: 0.5,
                    fill: 0.9,
                    fillColor: {
                        colors: [{
                                opacity: 0.6
                            },
                            {
                                opacity: 0
                            }
                        ]
                    },
                },

                shadowSize: 0 // Drawing is faster without shadows
            },
            grid: {
                borderColor: 'rgba(0,0,0,0.05)',
                borderWidth: 1,
                labelMargin: 5
            },
            xaxis: {
                color: '#F0F0F0',
                tickColor: 'rgba(0,0,0,0.05)',
                font: {
                    size: 10,
                    color: '#999'
                }
            },
            yaxis: {
                min: 0,
                max: 100,
                color: '#F0F0F0',
                tickColor: 'rgba(0,0,0,0.05)',
                font: {
                    size: 10,
                    color: '#999'
                }
            }
        };
        var plot = $.plot($("#updating-chart"), [getRandomData()], options);
        /* live switch */
        $('input[type="checkbox"]#start_interval').click(function() {
            if ($(this).prop('checked')) {
                $on = true;
                updateInterval = 1500;
                update();
            } else {
                clearInterval(updateInterval);
                $on = false;
            }
        });
        var update = function() {
            if ($on == true) {
                plot.setData([getRandomData()]);
                plot.draw();
                setTimeout(update, updateInterval);

            } else {
                clearInterval(updateInterval)
            }

        }



        /*calendar */
        var todayDate = moment().startOf('day');
        var YM = todayDate.format('YYYY-MM');
        var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
        var TODAY = todayDate.format('YYYY-MM-DD');
        var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');


        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['dayGrid', 'list', 'timeGrid', 'interaction', 'bootstrap'],
            themeSystem: 'bootstrap',
            timeZone: 'UTC',
            //dateAlignment: "month", //week, month
            buttonText: {
                today: 'today',
                month: 'month',
                week: 'week',
                day: 'day',
                list: 'list'
            },
            eventTimeFormat: {
                hour: 'numeric',
                minute: '2-digit',
                meridiem: 'short'
            },
            navLinks: true,
            header: {
                left: 'title',
                center: '',
                right: 'today prev,next'
            },
            footer: {
                left: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                center: '',
                right: ''
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [{
                    title: 'All Day Event',
                    start: YM + '-01',
                    description: 'This is a test description', //this is currently bugged: https://github.com/fullcalendar/fullcalendar/issues/1795
                    className: "border-warning bg-warning text-dark"
                },
                {
                    title: 'Reporting',
                    start: YM + '-14T13:30:00',
                    end: YM + '-14',
                    className: "bg-white border-primary text-primary"
                },
                {
                    title: 'Surgery oncall',
                    start: YM + '-02',
                    end: YM + '-03',
                    className: "bg-primary border-primary text-white"
                },
                {
                    title: 'NextGen Expo 2019 - Product Release',
                    start: YM + '-03',
                    end: YM + '-05',
                    className: "bg-info border-info text-white"
                },
                {
                    title: 'Dinner',
                    start: YM + '-12',
                    end: YM + '-10'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: YM + '-09T16:00:00',
                    className: "bg-danger border-danger text-white"
                },
                {
                    id: 1000,
                    title: 'Repeating Event',
                    start: YM + '-16T16:00:00'
                },
                {
                    title: 'Conference',
                    start: YESTERDAY,
                    end: TOMORROW,
                    className: "bg-success border-success text-white"
                },
                {
                    title: 'Meeting',
                    start: TODAY + 'T10:30:00',
                    end: TODAY + 'T12:30:00',
                    className: "bg-primary text-white border-primary"
                },
                {
                    title: 'Lunch',
                    start: TODAY + 'T12:00:00',
                    className: "bg-info border-info"
                },
                {
                    title: 'Meeting',
                    start: TODAY + 'T14:30:00',
                    className: "bg-warning text-dark border-warning"
                },
                {
                    title: 'Happy Hour',
                    start: TODAY + 'T17:30:00',
                    className: "bg-success border-success text-white"
                },
                {
                    title: 'Dinner',
                    start: TODAY + 'T20:00:00',
                    className: "bg-danger border-danger text-white"
                },
                {
                    title: 'Birthday Party',
                    start: TOMORROW + 'T07:00:00',
                    className: "bg-primary text-white border-primary text-white"
                },
                {
                    title: 'Gotbootstrap Meeting',
                    url: 'http://gotbootstrap.com/',
                    start: YM + '-28',
                    className: "bg-info border-info text-white"
                }
            ],
            viewSkeletonRender: function() {
                $('.fc-toolbar .btn-default').addClass('btn-sm');
                $('.fc-header-toolbar h2').addClass('fs-md');
                $('#calendar').addClass('fc-reset-order')
            },

        });

        calendar.render();
    });
</script>
