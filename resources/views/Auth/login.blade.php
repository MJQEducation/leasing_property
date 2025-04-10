<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
        Login - Lease Management
    </title>
    <meta name="description" content="Login">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link id="vendorsbundle" rel="stylesheet" media="screen, print"
        href="{{ asset('plugin/css/vendors.bundle.css') }}">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="{{ asset('plugin/css/app.bundle.css') }}">
    <link id="mytheme" rel="stylesheet" media="screen, print" href="#">
    <link id="myskin" rel="stylesheet" media="screen, print" href="{{ asset('plugin/css/skins/skin-master.css') }}">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('plugin/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('plugin/img/favicon/favicon-32x32.png') }}">
    <link rel="mask-icon" href="{{ asset('plugin/img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <link rel="stylesheet" media="screen, print" href="{{ asset('plugin/css/page-login-alt.css') }}">
    <link rel="stylesheet" media="screen, print"
        href="{{ asset('plugin/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('plugin/css/notifications/toastr/toastr.css') }}">

    <link rel="stylesheet" media="screen, print" href="{{ asset('plugin/css/fa-solid.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('plugin/css/fa-brands.css') }}">

</head>
<!-- BEGIN Body -->
<!-- Possible Classes

  * 'header-function-fixed'         - header is in a fixed at all times
  * 'nav-function-fixed'            - left panel is fixed
  * 'nav-function-minify'			  - skew nav to maximize space
  * 'nav-function-hidden'           - roll mouse on edge to reveal
  * 'nav-function-top'              - relocate left pane to top
  * 'mod-main-boxed'                - encapsulates to a container
  * 'nav-mobile-push'               - content pushed on menu reveal
  * 'nav-mobile-no-overlay'         - removes mesh on menu reveal
  * 'nav-mobile-slide-out'          - content overlaps menu
  * 'mod-bigger-font'               - content fonts are bigger for readability
  * 'mod-high-contrast'             - 4.5:1 text contrast ratio
  * 'mod-color-blind'               - color vision deficiency
  * 'mod-pace-custom'               - preloader will be inside content
  * 'mod-clean-page-bg'             - adds more whitespace
  * 'mod-hide-nav-icons'            - invisible navigation icons
  * 'mod-disable-animation'         - disables css based animations
  * 'mod-hide-info-card'            - hides info card from left panel
  * 'mod-lean-subheader'            - distinguished page header
  * 'mod-nav-link'                  - clear breakdown of nav links

  >>> more settings are described inside documentation page >>>
 -->

<body>
    <!-- DOC: script to save and load page settings -->
    <script>
        /**
         *	This script should be placed right after the body tag for fast execution
         *	Note: the script is written in pure javascript and does not depend on thirdparty library
         **/
        'use strict';

        var classHolder = document.getElementsByTagName("BODY")[0],
            /**
             * Load from localstorage
             **/
            themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {},
            themeURL = themeSettings.themeURL || '',
            themeOptions = themeSettings.themeOptions || '';
        /**
         * Load theme options
         **/
        if (themeSettings.themeOptions) {
            classHolder.className = themeSettings.themeOptions;
            console.log("%c✔ Theme settings loaded", "color: #148f32");
        } else {
            console.log("%c✔ Heads up! Theme settings is empty or does not exist, loading default settings...",
                "color: #ed1c24");
        }
        if (themeSettings.themeURL && !document.getElementById('mytheme')) {
            var cssfile = document.createElement('link');
            cssfile.id = 'mytheme';
            cssfile.rel = 'stylesheet';
            cssfile.href = themeURL;
            document.getElementsByTagName('head')[0].appendChild(cssfile);

        } else if (themeSettings.themeURL && document.getElementById('mytheme')) {
            document.getElementById('mytheme').href = themeSettings.themeURL;
        }
        /**
         * Save to localstorage
         **/
        var saveSettings = function() {
            themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item) {
                return /^(nav|header|footer|mod|display)-/i.test(item);
            }).join(' ');
            if (document.getElementById('mytheme')) {
                themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
            };
            localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
        }
        /**
         * Reset settings
         **/
        var resetSettings = function() {
            localStorage.setItem("themeSettings", "");
        }
    </script>
    <div class="blankpage-form-field">
        <div
            class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
            <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                <img src="{{ asset('plugin/img/logo.png') }}" alt="SmartAdmin WebApp" aria-roledescription="logo"
                    style="width:56px!important;height:28px!important;">
                <span class="page-logo-text mr-1"> Lease Management</span>
                <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
            </a>
        </div>
        <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
            <form action="" id="loginform">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" id="username" class="form-control" placeholder="User name" autocomplete="off" />
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="password"
                        autocomplete="off" />
                </div>
                <!--<div class="form-group text-left">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="rememberme">
                        <label class="custom-control-label" for="rememberme"> Remember me for the next 30 days</label>
                    </div>
                </div>-->

                <div class="float-right">
                    <a href="{{ url('/redirect') }}" class="btn btn-default"><i class="fab fa-google"></i>
                        Google</a>
                    <a href="javascript:void(0)" onclick="login()" class="btn btn-default">Login</a>
                </div>
            </form>
        </div>

    </div>
    <div class="login-footer p-2">
        <div class="row">
            <!--<div class="col col-sm-12 text-center">
                <i><strong>System Message:</strong> You were logged out from 198.164.246.1 on Saturday, March, 2017 at
                    10.56AM</i>
            </div>-->
        </div>
    </div>
    <video poster="{{ asset('plugin/img/backgrounds/clouds.png') }}" id="bgvid" playsinline autoplay muted loop>
        <source src="{{ asset('plugin/media/video/cc.webm') }}" type="video/webm">
        <source src="{{ asset('plugin/media/video/cc.mp4') }}" type="video/mp4">
    </video>
    <!-- BEGIN Color profile -->
    <!-- this area is hidden and will not be seen on screens or screen readers -->
    <!-- we use this only for CSS color refernce for JS stuff -->
    <p id="js-color-profile" class="d-none">
        <span class="color-primary-50"></span>
        <span class="color-primary-100"></span>
        <span class="color-primary-200"></span>
        <span class="color-primary-300"></span>
        <span class="color-primary-400"></span>
        <span class="color-primary-500"></span>
        <span class="color-primary-600"></span>
        <span class="color-primary-700"></span>
        <span class="color-primary-800"></span>
        <span class="color-primary-900"></span>
        <span class="color-info-50"></span>
        <span class="color-info-100"></span>
        <span class="color-info-200"></span>
        <span class="color-info-300"></span>
        <span class="color-info-400"></span>
        <span class="color-info-500"></span>
        <span class="color-info-600"></span>
        <span class="color-info-700"></span>
        <span class="color-info-800"></span>
        <span class="color-info-900"></span>
        <span class="color-danger-50"></span>
        <span class="color-danger-100"></span>
        <span class="color-danger-200"></span>
        <span class="color-danger-300"></span>
        <span class="color-danger-400"></span>
        <span class="color-danger-500"></span>
        <span class="color-danger-600"></span>
        <span class="color-danger-700"></span>
        <span class="color-danger-800"></span>
        <span class="color-danger-900"></span>
        <span class="color-warning-50"></span>
        <span class="color-warning-100"></span>
        <span class="color-warning-200"></span>
        <span class="color-warning-300"></span>
        <span class="color-warning-400"></span>
        <span class="color-warning-500"></span>
        <span class="color-warning-600"></span>
        <span class="color-warning-700"></span>
        <span class="color-warning-800"></span>
        <span class="color-warning-900"></span>
        <span class="color-success-50"></span>
        <span class="color-success-100"></span>
        <span class="color-success-200"></span>
        <span class="color-success-300"></span>
        <span class="color-success-400"></span>
        <span class="color-success-500"></span>
        <span class="color-success-600"></span>
        <span class="color-success-700"></span>
        <span class="color-success-800"></span>
        <span class="color-success-900"></span>
        <span class="color-fusion-50"></span>
        <span class="color-fusion-100"></span>
        <span class="color-fusion-200"></span>
        <span class="color-fusion-300"></span>
        <span class="color-fusion-400"></span>
        <span class="color-fusion-500"></span>
        <span class="color-fusion-600"></span>
        <span class="color-fusion-700"></span>
        <span class="color-fusion-800"></span>
        <span class="color-fusion-900"></span>
    </p>
    <!-- END Color profile -->
    <!-- base vendor bundle:
   DOC: if you remove pace.js from core please note on Internet Explorer some CSS animations may execute before a page is fully loaded, resulting 'jump' animations
      + pace.js (recommended)
      + jquery.js (core)
      + jquery-ui-cust.js (core)
      + popper.js (core)
      + bootstrap.js (core)
      + slimscroll.js (extension)
      + app.navigation.js (core)
      + ba-throttle-debounce.js (core)
      + waves.js (extension)
      + smartpanels.js (extension)
      + src/../jquery-snippets.js (core) -->
    <script src="{{ asset('plugin/js/vendors.bundle.js') }}"></script>
    <script src="{{ asset('plugin/js/app.bundle.js') }}"></script>
    <script src="{{ asset('plugin/js/notifications/sweetalert2/sweetalert2.bundle.js') }}"></script>
    <script src="{{ asset('plugin/js/notifications/toastr/toastr.js') }}"></script>
    <script src="{{ asset('plugin/js/myapp.js') }}"></script>
    <!-- Page related scripts -->
</body>
<!-- END Body -->

</html>

<script>
    var password = document.getElementById("password");
    password.addEventListener("keyup", function(event) {
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
            // Cancel the default action, if needed
            event.preventDefault();
            // Trigger the button element with a click
            login();
        }
    });

    function login() {
        var _token = "{{ session('_token') }}";
        var username = $('#loginform #username').val();
        var password = $('#loginform #password').val();

        $.ajax({
            url: "{{ url('api/authenticate') }}",
            type: "POST",
            data: {
                _token: _token,
                username: username,
                password: password
            },
            headers: {
                'Accept': 'application/json'
            },
            success: function(response) {
                if (response.result == "success") {
                    window.location.replace("{{ url('/') }}");
                } else {
                    sweetToast(response.msg, response.result);

                    //Msg(response.msg, response.result);
                }

                //console.log(response);

            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    }
</script>
