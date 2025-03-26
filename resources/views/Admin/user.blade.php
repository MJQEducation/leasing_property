<div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
                User <span class="fw-300"><i>List</i></span>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-primary btn-sm waves-effect waves-themed" onclick="newUser()">New User</button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <!-- datatable start -->
                <table id="userlist" class="table table-bordered table-hover table-striped w-100"
                    style="font-size: 12px;border:1px solid #eee;">

                    <thead>
                        <tr>
                            <th style="text-align:center!important">Id</th>
                            <!--0-->
                            <th style="text-align:center!important">Nº</th>
                            <!--1-->
                            <th style="text-align:center!important">-</th>
                            <!--2-->
                            <th style="text-align:center!important">Card ID</th>
                            <!--3-->
                            <th style="text-align:center!important">Name</th>
                            <!--4-->
                            <th style="text-align:center!important">Username</th>
                            <!--5-->
                            <th style="text-align:center!important">Position</th>
                            <!--6-->
                            <th style="text-align:center!important">Email</th>
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

@include('Admin/userrole')
@include('Admin/userform')
@include('Admin/resetPassword')
@include('Admin/userImgCrop')
@include('Admin/campuspermission')
@include('Admin/departmentPermission')

<div id="viewUserPhotoDiv">
</div>

<script>
    var FilterButtonExist = false;
    $(document).ready(function() {
        initUserList();
    });

    function getDepartment(userid, username) {
        $.ajax({
            url: "{{ url('api/admin/getDepartment') }}",
            type: "POST",
            data: {
                _token: formToken,
                userid: userid
            },
            beforeSend: function(xhr) {
                blockagePage('Please Wait...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    return;
                }

                var department = response.data;
                initDepartment(department);
                $("#departmentPermissionModal #departmentPermissionLabel").html(username);
                $("#departmentPermissionModal").modal();
                unblockagePage();
            },
            error: function(e) {
                Msg('Error getting Department information', 'error');

                unblockagePage();
            }
        });
    }

    function initDepartment(data) {
        var cols = [{
                "data": "id",
                "name": "id",
                "searchable": false,
                "orderable": false,
                "visible": false
            }, //0
            {
                "data": "department",
                "name": "department",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-left",
            }, //1
            {
                "data": "is_assign",
                "name": "is_assign",
                "searchable": false,
                "orderable": false,
                "visible": true,
                "class": "dt-center",
                "render": function(data, type, row) {
                    return `<label class="switch">
                            <input onchange="assignDepartment(${row.department_id},${row.user_id},this)"
                            type="checkbox" ${row.is_assign===1?"checked" : ""} />
                            <span class="slider round"></span>
                        </label>`;
                }
            }
        ];

        if ($.fn.DataTable.isDataTable('#DepartmentPermissionlist')) {
            $('#DepartmentPermissionlist').DataTable().clear();
            $('#DepartmentPermissionlist').DataTable().destroy();
        }


        //////INT TABLE//////
        var table = $('#DepartmentPermissionlist').DataTable({
            "data": data,
            "columns": cols,
            "order": [1, 'asc'],
            "rowId": "id",
            "responsive": "true",
            "stateSave": true,
            "select": true
        });
        //////INT TABLE//////
    }

    function assignDepartment(department, user_id, element) {
        var is_assign = element.checked == true ? 1 : 0;

        $.ajax({
            url: "{{ url('api/admin/assignDepartment') }}",
            type: "POST",
            data: {
                _token: formToken,
                user_id: user_id,
                department: department,
                is_assign: is_assign,
            },
            beforeSend: function(xhr) {
                blockagePage('Please Wait...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    console.log(response);
                    return;
                }

                Msg(response.msg, response.result);
                unblockagePage();
            },
            error: function(e) {
                Msg('Error Assign Department', 'error');

                unblockagePage();
            }
        });
    }


    function getCampus(userid, username) {
        $.ajax({
            url: "{{ url('api/admin/getCampus') }}",
            type: "POST",
            data: {
                _token: formToken,
                userid: userid
            },
            beforeSend: function(xhr) {
                blockagePage('Please Wait...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    return;
                }

                var campus = response.data;
                initCampus(campus);
                $("#campuspermissionmodal #usercampusLabel").html(username);
                $("#campuspermissionmodal").modal();
                unblockagePage();
            },
            error: function(e) {
                Msg('Error getting campus information', 'error');

                unblockagePage();
            }
        });
    }

    function initCampus(data) {
        var cols = [{
                "data": "id",
                "name": "id",
                "searchable": false,
                "orderable": false,
                "visible": false
            }, //0
            {
                "data": "campus",
                "name": "campus",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-center",
            }, //1
            {
                "data": "is_assign",
                "name": "is_assign",
                "searchable": false,
                "orderable": false,
                "visible": true,
                "class": "dt-center",
                "render": function(data, type, row) {
                    return `<label class="switch">
                            <input onchange="assignCampus(${row.campus_id},${row.user_id},this)"
                            type="checkbox" ${row.is_assign===1?"checked" : ""} />
                            <span class="slider round"></span>
                        </label>`;
                }
            }
        ];

        if ($.fn.DataTable.isDataTable('#campuspermissionlist')) {
            $('#campuspermissionlist').DataTable().clear();
            $('#campuspermissionlist').DataTable().destroy();
        }


        //////INT TABLE//////
        var table = $('#campuspermissionlist').DataTable({
            "data": data,
            "columns": cols,
            "order": [1, 'asc'],
            "rowId": "id",
            "responsive": "true",
            "stateSave": true,
            "select": true
        });
        //////INT TABLE//////
    }

    function assignCampus(campus, user_id, element) {
        var is_assign = element.checked == true ? 1 : 0;

        $.ajax({
            url: "{{ url('api/admin/assignCampus') }}",
            type: "POST",
            data: {
                _token: formToken,
                user_id: user_id,
                campus: campus,
                is_assign: is_assign,
            },
            beforeSend: function(xhr) {
                blockagePage('Please Wait...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    console.log(response);
                    return;
                }

                Msg(response.msg, response.result);
                unblockagePage();
            },
            error: function(e) {
                Msg('Error Assign Campus', 'error');

                unblockagePage();
            }
        });
    }

    function getUsers() {
        $.ajax({
            url: "{{ url('api/admin/maniUsers') }}",
            type: "POST",
            data: {
                _token: formToken,
                start: 0,
                end: 10
            },
            beforeSend: function(xhr) {
                blockagePage('Please Wait...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    return;
                }

                unblockagePage();
            },
            error: function(e) {
                if (e.status = 401) //unauthenticate not login
                {
                    Msg('Login is Required', 'error');
                }

                unblockagePage();
            }
        });
    }

    function newUser() {
        $("#userForm #name").val("");
        $("#userForm #position").val("");
        $("#userForm #card_id").val("");
        $("#userForm #username").val("");
        $("#userForm #email").val("");
        $("#userForm #id").val(0);
        $("#userFormLabel").html("New User");

        $("#userFormModal").modal();
    }

    function viewUserPhoto(userid) {
        $.ajax({
            url: "{{ url('admin/viewUserPhoto') }}",
            type: "POST",
            data: {
                _token: formToken,
                userid: userid
            },
            beforeSend: function(xhr) {
                blockagePage('Please Wait...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    return;
                }
                $("#viewUserPhotoDiv").html(response);
                $("#userViewPhoto").modal();

                unblockagePage();
            },
            error: function(e) {
                if (e.status = 401) //unauthenticate not login
                {
                    Msg('Login is Required', 'error');
                }

                unblockagePage();
            }
        });
    }

    function initUserList() {
        var cols = [{
                "data": "id",
                "name": "id",
                "searchable": false,
                "orderable": false,
                "visible": false
            }, //0
            {
                "data": "no",
                "name": "no",
                "searchable": false,
                "orderable": false,
                "visible": true,
                "class": "dt-right",
            }, //1
            {
                "data": "photo",
                "name": "photo",
                "searchable": false,
                "orderable": false,
                "visible": true,
                "class": "dt-center",
                "render": function(data, type, row) {
                    if (data == null) {
                        return "";
                    } else {
                        return "<a href='javascript:void(0);' onclick='viewUserPhoto(" + row.id + ")'> " +
                            "<center><div class=\"profile-image-md rounded-circle\" style=\"background-image:url('data:image/jpeg;base64," +
                            data + "'); background-size: cover;\"></div></center>" + "</a>";
                    }

                }
            }, //2
            {
                "data": "card_id",
                "name": "card_id",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-center"
            }, //3
            {
                "data": "name",
                "name": "name",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "render": function(data, type, row) {
                    return "<a href='javascript:void(0);' onclick='viewUserPhoto(" + row.id + ")'> " + data +
                        "</a>";
                }
            }, //4
            {
                "data": "username",
                "name": "username",
                "searchable": true,
                "orderable": true,
                "visible": true,
            }, //5
            {
                "data": "position",
                "name": "position",
                "searchable": true,
                "orderable": true,
                "visible": true,
            }, //6
            {
                "data": "email",
                "name": "email",
                "searchable": true,
                "orderable": true,
                "visible": true,
            }, //7
            {
                "data": null,
                "name": "Action",
                "searchable": false,
                "orderable": false,
                "visible": true,
                "class": "dt-center",
                render: function(data, type, row) {

                    let str = `<div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fal fa-cog" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="getUserRole(${row.id},'${row.username}')">
                                        <i class="fal fa-list" aria-hidden="true"></i> Role
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="getCampus(${row.id},'${row.name}')">
                                        <i class="fal fa-home" aria-hidden="true"></i> Campus
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="getDepartment(${row.id},'${row.name}')">
                                        <i class="fas fa-home-alt"></i> Department
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="editUser(${row.id},'${row.username}')">
                                        <i class="fal fa-pencil" aria-hidden="true"></i> Edit
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="deleteUser(${row.id},'${row.username}')">
                                        <i class="fal fa-trash" aria-hidden="true"></i> Remove
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="showPassword(${row.id},'${row.username}')">
                                        <i class="fal fa-pencil-alt" aria-hidden="true"></i> Change Password
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="showphoto(${row.id},'${row.name}')">
                                        <i class="fal fa-image" aria-hidden="true"></i> Photo
                                    </a>
                                </div>
                            </div>`;

                    return str;
                }

            }, //8
        ];

        if ($.fn.DataTable.isDataTable('#userlist')) {
            $('#userlist').DataTable().clear();
            $('#userlist').DataTable().destroy();
        }


        //////INT TABLE//////
        var table = $('#userlist').DataTable({
            "ajax": {
                "url": "{{ url('api/admin/getUsers') }}",
                "type": "POST",
                "datatype": "json",
                "data": {
                    _token: formToken,
                },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
                },
                /*success: function(response) {
                    console.log(response);
                }*/
            },
            "searchDelay": 500,
            "columns": cols,
            "serverSide": "true",
            "processing": "true",
            "order": [3, 'asc'],
            "rowId": "id",
            "responsive": "true",
            "stateSave": true,
            "select": true
        });
        //////INT TABLE//////
    }

    function showphoto(userid, username) {
        $("#userphotoid").html(userid);
        $('#imageCropDiv').modal();
        $('#clearimageselectbtn').trigger('click');
        $('#clearimagebtn').trigger('click');
        $('#userPictureLabel').html(username);

        $(".img-container img").attr('src', null);
    }

    function editUser(userid) {
        $.ajax({
            url: "{{ url('api/admin/editUser') }}",
            type: "POST",
            data: {
                _token: formToken,
                id: userid
            },
            beforeSend: function(xhr) {
                blockagePage('Please Wait...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    return;
                }

                $("#userForm #card_id").val(response.data.card_id);
                $("#userForm #name").val(response.data.name);
                $("#userForm #position").val(response.data.position);
                $("#userForm #username").val(response.data.username);
                $("#userForm #email").val(response.data.email);
                $("#userForm #id").val(response.data.id);
                $("#userFormLabel").html("Edit : " + response.data.username);
                $("#userFormModal").modal();

                unblockagePage();
            },
            error: function(e) {
                if (e.status = 401) //unauthenticate not login
                {
                    Msg('Login is Required', 'error');
                }

                unblockagePage();
            }
        });
    }

    function saveUser() {
        let id = $("#userForm #id").val();
        let card_id = $("#userForm #card_id").val();
        let name = $("#userForm #name").val();
        let position = $("#userForm #position").val();
        let username = $("#userForm #username").val();
        let email = $("#userForm #email").val();
        let action = id == 0 ? "{{ url('api/admin/saveUser') }}" : "{{ url('api/admin/updateUser') }}";
        let postData = {
            _token: formToken,
            id: id,
            card_id: card_id,
            name: name,
            position: position,
            username: username,
            email: email,
        };

        $.ajax({
            url: action,
            type: "POST",
            data: postData,
            beforeSend: function(xhr) {
                blockagePage('Please Wait...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    Msg(response.data.errorInfo[2], response.result);

                    return;
                }

                if (action == "{{ url('api/admin/saveUser') }}") {
                    var table = $('#userlist').DataTable();
                    table.row.add(response.data).draw();
                } else {
                    var table = $('#userlist').DataTable();
                    var selectRow = table.row($('#userlist #' + response.data.id));
                    selectRow.data(response.data);
                    table.draw();
                }

                sweetToast(response.msg, response.result);

                $("#userFormModal").modal('hide');

                unblockagePage();
            },
            error: function(e) {

                Msg('Error Saving User', 'error');
                unblockagePage();
            }
        });
    }

    function deleteUser(userid, username) {
        Swal.fire({
            title: 'Are you sure?',
            text: "To delete user :" + username + " !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            console.log(result.value);
            if (result.value) {

                $.ajax({
                    url: "{{ url('api/admin/deleteUser') }}",
                    type: "POST",
                    data: {
                        _token: formToken,
                        id: userid,
                    },
                    beforeSend: function(xhr) {
                        blockagePage('Please Wait...');
                        xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
                    },
                    success: function(response) {
                        if (response.result == "error") {
                            sweetToast(response.msg, response.result);
                            return;
                        }

                        sweetToast(response.msg, response.result);

                        var table = $('#userlist').DataTable();
                        var selectRow = table.row($('#userlist #' + userid));
                        table.row(selectRow).remove().draw();

                        unblockagePage();
                    },
                    error: function(e) {
                        if (e.status = 401) //unauthenticate not login
                        {
                            Msg('Login is Required', 'error');
                        }

                        unblockagePage();
                    }
                });

            }
        });
    }

    function getUserRole(userid, username) {
        $.ajax({
            url: "{{ url('api/admin/getUserRole') }}",
            type: "POST",
            data: {
                _token: formToken,
                userid: userid
            },
            beforeSend: function(xhr) {
                blockagePage('Please Wait...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    return;
                }

                initUserRoleList(response.data);

                $("#userRoleLabel").html("Role : " + username);

                $("#UserRoleModal").modal();

                unblockagePage();
            },
            error: function(e) {
                if (e.status = 401) //unauthenticate not login
                {
                    Msg('Login is Required', 'error');
                }

                unblockagePage();
            }
        });
    }

    function initUserRoleList(data) {
        var cols = [{
                "data": "id",
                "name": "id",
                "searchable": false,
                "orderable": false,
                "visible": false
            }, //0
            {
                "data": "name",
                "name": "name",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-center"
            }, //1
            {
                "data": "is_admin",
                "name": "is_admin",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-center"
            }, //2
            {
                "data": null,
                "name": "Action",
                "searchable": false,
                "orderable": false,
                "visible": true,
                "class": "dt-center",
                render: function(data, type, row) {
                    return "<label class=\"switch\"><input onchange=\"assignRole(" + row.id + "," + row
                        .userid +
                        ",this)\" type=\"checkbox\" " + (row.permit == 1 ? "checked" : "") +
                        "><span class=\"slider round\"></span></label>";
                }

            }, //3
        ];

        if ($.fn.DataTable.isDataTable('#RoleList')) {
            $('#RoleList').DataTable().clear();
            $('#RoleList').DataTable().destroy();
        }

        //////INT TABLE//////
        var table = $('#RoleList').DataTable({
            "data": data,
            "columns": cols,
            "order": [1, 'asc'],
            "rowId": "id",
            "responsive": "true",
            "select": true
        });
        //////INT TABLE//////
    }

    function assignRole(roleid, userid, element) {
        var checked = element.checked == true ? true : false;

        $.ajax({
            url: "{{ url('api/admin/assignRole') }}",
            type: "POST",
            data: {
                _token: formToken,
                userid: userid,
                roleid: roleid,
                checked: checked,
            },
            beforeSend: function(xhr) {
                blockagePage('Please Wait...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    return;
                }

                Msg(response.msg, response.result);
                unblockagePage();
            },
            error: function(e) {
                if (e.status = 401) //unauthenticate not login
                {
                    Msg('Login is Required', 'error');
                }

                unblockagePage();
            }
        });
    }

    function showPassword(userid, username) {
        $("#userpasswordform #password").val("");
        $("#userpasswordform #id").val(userid);
        $("#userPasswordResetLabel").html("Reset " + username + " password");
        $("#userpasswordform").modal();
    }

    function resetPassword() {
        var password = $("#userpasswordform #password").val();
        var userid = $("#userpasswordform #id").val();

        $.ajax({
            url: "{{ url('api/admin/resetPassword') }}",
            type: "POST",
            data: {
                _token: formToken,
                id: userid,
                password: password
            },
            beforeSend: function(xhr) {
                blockagePage('Please Wait...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    return;
                }

                sweetToast(response.msg, response.result);
                $("#userpasswordform").modal("hide");

                unblockagePage();
            },
            error: function(e) {
                Msg('Error while reset password', 'error');

                unblockagePage();
            }
        });
    }
</script>
