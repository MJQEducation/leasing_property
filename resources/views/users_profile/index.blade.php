{{-- <div class="row">
    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <span id='panelTotalAsset'>0</span>
                    <small class="m-0 l-h-n">TOTAL ASSETS</small>
                </h3>
            </div>
            <i class="fas fa-car-building position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                style="font-size:6rem"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <span id='panelTotalCheck'>0</span>
                    <small class="m-0 l-h-n">END OF USFULL LIFE</small>
                </h3>
            </div>
            <i class="fas fa-abacus position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n1"
                style="font-size: 6rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <span id='panelTotalVerify'>0</span>
                    <small class="m-0 l-h-n">TOTAL RESIDUAL VALUE</small>
                </h3>
            </div>

            <i class="fas fa-lightbulb-dollar position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                style="font-size: 6rem;"></i>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="p-3 bg-danger-200 rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                    <span id='panelTotalApprove'>0</span>
                    <small class="m-0 l-h-n">READY FOR DISPOSAL</small>
                </h3>
            </div>
            <i class="fas fa-trash position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n2"
                style="font-size: 6rem;"></i>
        </div>
    </div>
</div> --}}
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Exit <span class="fw-300"><i>List</i></span>
                </h2>
                <div class="panel-toolbar">
                    <select onchange="assignFilter(event)" class="custom-select form-control" id="filterSelection"
                        name="department" autocomplete="off">
                        <option value="All Request">All Request</option>
                        <option value="Relate to me">Relate to me</option>
                    </select>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- datatable start -->
                    <table id="exitClearanceList" class="table table-bordered table-hover table-striped w-100"
                        style="font-size: 12px;border:1px solid #eee;">

                        <thead>
                            <tr>
                                <th style="text-align:center!important">Id</th>
                                <!--0-->
                                <th style="text-align:center!important">Hired Date</th>
                                <!--1-->
                                <th style="text-align:center!important">Last Date</th>
                                <!--2-->
                                <th style="text-align:center!important">Card ID</th>
                                <!--3-->
                                <th style="text-align:center!important">Name</th>
                                <!--4-->
                                <th style="text-align:center!important">Position</th>
                                <!--5-->
                                <th style="text-align:center!important">Department</th>
                                <!--6-->
                                <th style="text-align:center!important">Status</th>
                                <!--7-->
                                <th style="text-align:center!important">Action</th>
                                <!--8-->
                            </tr>
                        </thead>
                        <tbody style="border:1px solid #eee;"></tbody>
                    </table>
                    <!-- datatable end -->
                </div>
            </div>
        </div>

    </div>
</div>


<!--List Profile-->
<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
        <div id="panel-1" class="panel" style="margin-bottom:10px">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300" id="panelUserId">User Profile</span>
                </h2>
                <div class="panel-toolbar">
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- User summary -->

                    <div class="row no-gutters row-grid">
                        <div class="col-12">
                            <div class="d-flex flex-column align-items-center justify-content-center p-4">
                                <a href="javascript:void(0);" onclick="showUserPhoto()">
                                    <img id="panelUserImage" src=""
                                        class="rounded-circle shadow-2 img-thumbnail" alt="" />
                                </a>

                                <h5 class="mb-0 fw-700 text-center mt-3">
                                    <span id="panelStudentId" style="display:none"></span>
                                    <span id="panelUserName"></span><br />
                                    <span id="panelUserPosition"></span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-6" style='display:none'>
                            <div class="text-center py-3">
                                <h5 class="mb-0 fw-700">
                                    <small class="text-muted mb-0">Dept/Business</small>
                                    <span id="panelDepartment"></span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-6" style='display:none'>
                            <div class="text-center py-3">
                                <h5 class="mb-0 fw-700">
                                    <small class="text-muted mb-0">Campus</small>
                                    <span id="panelCampus"></span>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <!-- Student summary -->
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
        <div id="panel-1" class="panel" style="margin-bottom:10px">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300" id="panelUserId">User Signature</span>
                </h2>
                <div class="panel-toolbar">
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- User summary -->
                    <a href="javascript:void(0);" onclick="showSignatorphoto()">
                        <img src='' class='img-thumbnail' id='userSignator' />
                    </a>
                    <!-- User summary -->
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3" style='display:none'>
        <div id="panel-1" class="panel" style="margin-bottom:10px">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300" id="panelUserId">Assign Campus</span>
                </h2>
                <div class="panel-toolbar">
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- Campus summary -->
                    <table class="table m-0 table-bordered table-striped" id="myAssignCampus">
                        <thead>
                            <tr style='text-align:center'>
                                <th>Campus</th>
                                <th>Default</th>
                            </tr>
                        </thead>
                        <tbody id="myAssignCampus_body">
                        </tbody>
                    </table>
                    <!-- Campus summary -->
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3" style='display:none'>
        <div id="panel-1" class="panel" style="margin-bottom:10px">
            <div class="panel-hdr">
                <h2>
                    <span class="fw-300" id="panelUserId">Department/Unit</span>
                </h2>
                <div class="panel-toolbar">
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- Department summary -->
                    <table class="table m-0 table-bordered table-striped" id="myAssignDepartment">
                        <thead>
                            <tr style='text-align:center'>
                                <th>Campus</th>
                                <th>Default</th>
                            </tr>
                        </thead>
                        <tbody id="myAssignDepartment_body">

                        </tbody>
                    </table>
                    <!-- Department summary -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--List Profile-->

<div id='fileViewDiv'>
</div>

@include('users_profile/signatorImgCrop')

<script src="{{ asset('plugin/js/xlsx.js') }}"></script>

<script>
    var exitClearanceList = "";

    $(document).ready(function() {
        exitClearanceList = $("#exitClearanceList").html();

        $.fn.dataTable.moment('DD-MMM-YYYY HH:mm:ss');
        getUserInfo();
        getMyAssignCampus();
        getMyAssignDepartment();

        $('#filterSelection').val('Relate to me').change();
    });

    function showUserPhoto() {
        $(".img-container img").attr('src', null);
        $("#userphotoid").html(appuserid);

        $('#imageCropDiv').modal();
        $('#clearimageselectbtn').trigger('click');
        $('#clearimagebtn').trigger('click');
        $("#aspectRatio2").trigger('click');
        $('#userPictureLabel').html(appusername);
        $('#urlPath').html("{{ url('api/userprofile/saveUserImage') }}");

        $(".img-container img").attr('src', null);
    }

    function showSignatorphoto() {
        $(".img-container img").attr('src', null);
        $("#userphotoid").html(appuserid);

        $('#imageCropDiv').modal();
        $('#clearimageselectbtn').trigger('click');
        $('#clearimagebtn').trigger('click');
        $("#aspectRatio0").trigger('click');
        $('#userPictureLabel').html(appusername);
        $('#urlPath').html("{{ url('api/userprofile/saveSignatureImage') }}");

        $(".img-container img").attr('src', null);
    }

    var getUserInfo = async () => {
        var data = await getAsyncData('{{ url('api/userprofile/getMyInfo') }}');

        $("#panelUserName").html(data.user.name);
        $("#panelUserPosition").html(data.user.position);
        $("#panelDepartment").html(data.department);
        $("#panelCampus").html(data.campus ? data.campus : '');
        $("#userSignator").prop('src', data.signature);
        $("#panelUserImage").prop('src', data.userPhoto);
    }

    var getMyAssignCampus = async () => {
        var data = await getAsyncData('{{ url('api/userprofile/getMyAssignCampus') }}');
        var str = "";

        for (var i = 0; i < data.length; i++) {
            str = `${str}<tr>
                                <td style='text-align:left'>${data[i].campus}</td>
                                <td style='text-align:center'>
                                    <label class="switch">
                                        <input onchange="assignDefualtCampus(${data[i].id})" ${(data[i].is_default===true?"checked":"")}  type="checkbox" id="defaultCampus${data[i].id}"><span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>`;
        }

        $("#myAssignCampus_body").html(str);
    }

    var assignDefualtCampus = async (id) => {
        var postData = {
            id
        };

        var response = await sendAsyncData('{{ url('api/userprofile/assignDefualtCampus') }}', postData, true);

        getMyAssignCampus();
        getUserInfo();
    }

    var getMyAssignDepartment = async () => {
        var data = await getAsyncData('{{ url('api/userprofile/getMyAssignDepartment') }}');
        var str = "";

        for (var i = 0; i < data.length; i++) {
            str = `${str}<tr>
                                <td style='text-align:left'>${data[i].department}</td>
                                <td style='text-align:center'>
                                    <label class="switch">
                                        <input onchange="assignDefualtDepartment(${data[i].id})" ${(data[i].is_default===true?"checked":"")}  type="checkbox" id="defaultDepartment${data[i].id}"><span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>`;
        }

        $("#myAssignDepartment_body").html(str);
    }

    var assignDefualtDepartment = async (id) => {
        var postData = {
            id
        };

        var response = await sendAsyncData('{{ url('api/userprofile/assignDefualtDepartment') }}', postData,
            true);

        getMyAssignDepartment();
        getUserInfo();
    }

    var assignFilter = (event) => {
        let filterSelect = event.target.value;

        if (filterSelect === "All Request") {
            initExitClearanceList("getExitClearanceAllList");
        } else {
            initExitClearanceList("getExitClearanceRelateList");
        }

    }

    var initExitClearanceList = (route) => {
        var cols = [{
                "data": "id",
                "name": "id",
                "searchable": false,
                "orderable": false,
                "visible": false
            }, //0
            {
                "data": "hired_date",
                "name": "hired_date",
                "searchable": false,
                "orderable": true,
                "visible": true,
                "class": "dt-center",
                "render": function(data, type, row) {
                    return moment(data, "YYYY-MM-DD[T]HH:mm:ss").format("MMM DD, YYYY");
                }
            }, //1
            {
                "data": "last_working_date",
                "name": "last_working_date",
                "searchable": false,
                "orderable": true,
                "visible": true,
                "class": "dt-center",
                "render": function(data, type, row) {
                    return moment(data, "YYYY-MM-DD[T]HH:mm:ss").format("MMM DD, YYYY");
                }
            }, //2
            {
                "data": "card_id",
                "name": "card_id",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-center",
            }, //3
            {
                "data": "name",
                "name": "name",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-left",
            }, //4
            {
                "data": "position",
                "name": "position",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-left",
            }, //5
            {
                "data": "department",
                "name": "department",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-left",
            }, //6
            {
                "data": "status",
                "name": "status",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-left",
                render: function(data, type, row) {
                    var str = "";

                    if (row.status === "Completed") {
                        str =
                            `${data} <span class="color-success-800"><i class="fas fa-bowling-ball"></i></span>`;

                        return str;
                    } else if (row.status === "Rejected") {
                        str =
                            `${data} <span class="color-danger-800"><i class="fas fa-bowling-ball"></i></span>`;

                        return str;
                    } else {
                        str =
                            `${data} <span class="color-warning-800"><i class="fas fa-bowling-ball"></i></span>`;

                        return str;
                    }
                }
            }, //7
            {
                "data": null,
                "name": "Action",
                "searchable": false,
                "orderable": false,
                "visible": true,
                "class": "dt-center",
                render: function(data, type, row) {
                    let str = "";
                    str =
                        `<div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="fal fa-cog" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                                style="position: absolute; top: 32px; left: -5px; will-change: top, left;">
                                <a class="dropdown-item" href="javascript:void(0);" onclick="printExitClearance(${row.id})">
                                    <i class="fas fa-print color-success-600"></i> Print
                                </a>
                            </div>
                        </div>`;

                    return str;
                }
            }, //8
        ];

        if ($.fn.DataTable.isDataTable('#exitClearanceList')) {
            $('#exitClearanceList').DataTable().clear();
            $('#exitClearanceList').DataTable().destroy();
            $('#exitClearanceList').html(exitClearanceList);
        }

        //////INT TABLE//////
        var table = $('#exitClearanceList').DataTable({
            "ajax": {
                "url": `{{ url('api/ExitClearance/${route}') }}`,
                "type": "POST",
                "datatype": "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF if needed
                },
                "data": {
                    _token: formToken,
                },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
                },
                // success: function(response) {
                //     console.log(response);
                // }
            },
            "searchDelay": 500,
            "columns": cols,
            "serverSide": "true",
            "processing": "true",
            "order": [2, 'desc'],
            "rowId": "id",
            "responsive": true,
            "stateSave": true,
            "select": true
        });
        //////INT TABLE//////
    }

    var printExitClearance = async (id) => {
        blockagePage('Get View ...');

        let disposalPdf = await getAsyncView('{{ url('exit_clearance/getExitClearancePDF') }}', {
            id
        });

        $("#fileView_base").html(disposalPdf);
        $("#exitClearancePDFViewModal").modal();

        unblockagePage();
    }
</script>
