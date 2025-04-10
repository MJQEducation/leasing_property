<aside class="page-sidebar">
    <div class="page-logo">
        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative"
            data-toggle="modal" data-target="#modal-shortcut">
            <img src="{{ asset('plugin/img/logo.png') }}" alt="AII Language Center" aria-roledescription="logo"
                style="width:56px!important;height:28px!important;">
            <span class="page-logo-text mr-1"> Lease Management</span>
            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <!-- BEGIN PRIMARY NAVIGATION -->
    <nav id="js-primary-nav" class="primary-nav" role="navigation">
        <div class="nav-filter">
            <div class="position-relative">
                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control"
                    tabindex="0">
                <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off"
                    data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                    <i class="fal fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="info-card">
            <img src="" class="profile-image rounded-circle" id="leftpaneluserphoto">

            <div class="info-card-text">
                <a href="#" class="d-flex align-items-center text-white">
                    <span class="text-truncate text-truncate-sm d-inline-block" id="leftpanelusername">
                        Adminitrator
                    </span>
                </a>
                <!--<span class="d-inline-block text-truncate text-truncate-sm" id="leftpanelbranch">Branch : </span>-->
            </div>
            <img src="{{ asset('plugin/img/card-backgrounds/cover-2-lg.png') }}" class="cover" alt="cover">
            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle"
                data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                <i class="fal fa-angle-down"></i>
            </a>
        </div>

        <ul id="js-nav-menu" class="nav-menu">

            <li class="nav-title">System Menu</li>

            <li name='panelList' data-access-to="UserProfile-index">
                <a href="javascript:void(0);" title="Home" data-filter-tags='{"anchor":"single","role":"parent"}'
                    onclick="PanelLinkActive(this);viewIndex('{{ url('userprofile/Index') }}');">
                    <i class="fal fa-home"></i>
                    <span class="nav-link-text">Home</span>
                </a>
            </li>

            <li name='panelList' data-access-to="Dashboard-Index">
                <a href="javascript:void(0);" title="Home" data-filter-tags='{"anchor":"single","role":"parent"}'
                    onclick="PanelLinkActive(this);viewIndex('{{ url('dashboard/index') }}');">
                    <i class="fal fa-tachometer-alt"></i>

                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>


            <li name='panelList' data-access-to="parent">
                <a href="javascript:void(0);" title="Setting" data-filter-tags='{"anchor":"miltiple","role":"parent"}'>
                    <i class="fas fa-portal-exit"></i>
                    <span class="nav-link-text">Lease Management</span>
                </a>
                <ul>
                    <li name='panelList' data-access-to="ExitClearance-index">
                        <a href="javascript:void(0);" title="User"
                            data-filter-tags='{"anchor":"miltiple","role":"child"}'
                            onclick="PanelLinkActive(this);viewIndex('{{ url('exitClearance/index') }}');"
                            class=" waves-effect waves-themed">
                            <span class="nav-link-text">Lease Form</span>
                        </a>
                    </li>

                </ul>
            </li>

            {{-- Contract --}}

            <li name='panelList' data-access-to="parent">
                <a href="javascript:void(0);" title="Setting" data-filter-tags='{"anchor":"miltiple","role":"parent"}'>
                    <i class="fas fa-handshake"></i>
                    <span class="nav-link-text">Contract</span>
                </a>
                <ul>
                    <li name='panelList' data-access-to="Customers-index">
                        <a href="javascript:void(0);" title="User"
                            data-filter-tags='{"anchor":"miltiple","role":"child"}'
                            onclick="PanelLinkActive(this);viewIndex('{{ url('customers/index') }}');"
                            class=" waves-effect waves-themed">
                            <span class="nav-link-text">Customers</span>
                        </a>

                        <a href="javascript:void(0);" title="User"
                            data-filter-tags='{"anchor":"miltiple","role":"child"}'
                            onclick="PanelLinkActive(this);viewIndex('{{ url('stores/index') }}');"
                            class=" waves-effect waves-themed">
                            <span class="nav-link-text">Store</span>
                        </a>

                    </li>

                </ul>
            </li>

            {{-- END Contract --}}

            

            <li name='panelList' data-access-to="parent">
                <a href="javascript:void(0);" title="Setting" data-filter-tags='{"anchor":"miltiple","role":"parent"}'>
                    <i class="fal fa-user-cog"></i>
                    <span class="nav-link-text">System Setting</span>
                </a>
                <ul>
                    <li name='panelList' data-access-to="Admin-viewUser">
                        <a href="javascript:void(0);" title="User"
                            data-filter-tags='{"anchor":"miltiple","role":"child"}'
                            onclick='PanelLinkActive(this);viewUser()' class=" waves-effect waves-themed">
                            <span class="nav-link-text">User</span>
                        </a>
                    </li>
                    <li name='panelList' data-access-to="Admin-viewroles">
                        <a href="javascript:void(0);" title="Role"
                            data-filter-tags='{"anchor":"miltiple","role":"child"}'
                            onclick='PanelLinkActive(this);viewroles()' class=" waves-effect waves-themed">
                            <span class="nav-link-text">Role</span>
                        </a>
                    </li>
                    <li name='panelList' data-access-to="Admin-viewPermission">
                        <a href="javascript:void(0);" title="Permission"
                            data-filter-tags='{"anchor":"miltiple","role":"child"}'
                            onclick='PanelLinkActive(this);viewPermission()' class=" waves-effect waves-themed">
                            <span class="nav-link-text">Permission</span>
                        </a>
                    </li>
                    <li name='panelList' data-access-to="Mainvaluelist-index">
                        <a href="javascript:void(0);" title="Main Value List"
                            data-filter-tags='{"anchor":"miltiple","role":"child"}'
                            onclick='PanelLinkActive(this);viewMvls()' class=" waves-effect waves-themed">
                            <span class="nav-link-text">Main Value List</span>
                        </a>
                    </li>
                    <li name='panelList' data-access-to="PushExit-index">
                        <a href="javascript:void(0);" title="Main Value List"
                            data-filter-tags='{"anchor":"miltiple","role":"child"}'
                            onclick="PanelLinkActive(this);viewIndex('{{ url('pushexit/index') }}')"
                            class=" waves-effect waves-themed">
                            <span class="nav-link-text">Push Exit</span>
                        </a>
                    </li>
                    <li name='panelList' style="display: none">
                        <a href="javascript:void(0);" title="Import Log"
                            data-filter-tags='{"anchor":"miltiple","role":"child"}' onclick='PanelLinkActive(this)'
                            class=" waves-effect waves-themed">
                            <span class="nav-link-text">Import Log</span>
                        </a>
                    </li>
                    <li name='panelList' style="display: none">
                        <a href="javascript:void(0);" title="User Log"
                            data-filter-tags='{"anchor":"miltiple","role":"child"}' onclick='PanelLinkActive(this)'
                            class=" waves-effect waves-themed">
                            <span class="nav-link-text">User Log</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="filter-message js-filter-message bg-success-600"></div>
    </nav>
    <!-- END PRIMARY NAVIGATION -->
    <!-- NAV FOOTER -->
    <div class="nav-footer shadow-top">
        <a href="#" onclick="return false;" data-action="toggle" data-class="nav-function-minify"
            class="hidden-md-down">
            <i class="ni ni-chevron-right"></i>
            <i class="ni ni-chevron-right"></i>
        </a>
        <ul class="list-table m-auto nav-footer-buttons">
            <li>
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Chat logs">
                    <i class="fal fa-comments"></i>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Support Chat">
                    <i class="fal fa-life-ring"></i>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Make a call">
                    <i class="fal fa-phone"></i>
                </a>
            </li>
        </ul>
    </div> <!-- END NAV FOOTER -->
</aside>


<script>

function PanelLinkActive(element) {
        
        var data = JSON.parse(element.getAttribute('data-filter-tags'));
        var panelList = document.getElementsByName('panelList');
        for (var i = 0; i < panelList.length; i++) {
            panelList[i].className = "";
        }
        if (data.anchor == 'single') {
            element.parentElement.classList.add("active");
        } else {
            element.parentElement.parentElement.parentElement.classList.add("active");
            element.parentElement.parentElement.parentElement.classList.add("open");
            element.parentElement.classList.add("active");
        }
    }
function viewUser() {
        $.ajax({
            url: "{{ url('admin/viewUser') }}",
            type: "GET",
            success: function(response) {
                $('#containerDiv').html(response);
            },
            error: function(xhr) {
                Msg('Error GET controller", "error');
            }
        });
    }

    function viewPermission() {
        $.ajax({
            url: "{{ url('admin/viewPermission') }}",
            type: "GET",
            success: function(response) {
                $('#containerDiv').html(response);
            },
            error: function(xhr) {
                Msg('Error GET controller", "error');
            }
        });
    }

    function viewroles() {
        $.ajax({
            url: "{{ url('admin/viewroles') }}",
            type: "GET",
            success: function(response) {
                $('#containerDiv').html(response);
            },
            error: function(xhr) {
                Msg('Error GET controller", "error');
            }
        });
    }

    function viewMvls() {
        $.ajax({
            url: "{{ url('mvl/index') }}",
            type: "GET",
            success: function(response) {
                //console.log(response);
                $('#containerDiv').html(response);
            },
            error: function(xhr) {
                Msg('Error GET controller", "error');
            }
        });
    }

    function viewAssets() {
        $.ajax({
            url: "{{ url('Asset/AssetIndex') }}",
            type: "GET",
            success: function(response) {
                //console.log(response);
                $('#containerDiv').html(response);
            },
            error: function(xhr) {
                Msg('Error GET controller", "error');
            }
        });
    }

    function viewAssetType() {
        $.ajax({
            url: "{{ url('Asset/AssetTypeIndex') }}",
            type: "GET",
            success: function(response) {
                //console.log(response);
                $('#containerDiv').html(response);
            },
            error: function(xhr) {
                Msg('Error GET controller", "error');
            }
        });
    }

    function viewDashboard() {
        
        $.ajax({
            url: "{{ url('Dashboard/Index') }}",
            type: "GET",
            beforeSend: function() {
                blockagePage("Loading...");
            },
            success: function(response) {
                $('#containerDiv').html(response);
                unblockagePage();
            },
            error: function(xhr) {
                Msg('Error GET controller", "error');
                unblockagePage();
            }
        });
    }

    function viewIndex(url) {
        $.ajax({
            url: url,
            type: "GET",
            beforeSend: function() {
                blockagePage("Loading...");
            },
            success: function(response) {
                $('#containerDiv').html(response);
                unblockagePage();
            },
            error: function(xhr) {
                Msg('Error GET controller", "error');
                unblockagePage();
            }
        });
    }
</script>
