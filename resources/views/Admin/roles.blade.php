<div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
                Role <span class="fw-300"><i>List</i></span>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-primary btn-sm waves-effect waves-themed" data-toggle="dropdown"
                    onclick="newrole()">New Role</button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <!-- datatable start -->
                <table id="roleslist" class="table table-bordered table-striped table-hover w-100"
                    style="font-size: 12px;border:1px solid #eee;">

                    <thead>
                        <tr>
                            <th style="text-align:center!important">Id</th>
                            <!--0-->
                            <th style="text-align:center!important">Name</th>
                            <!--1-->
                            <th style="text-align:center!important">isAdmin</th>
                            <!--2-->
                            <th style="text-align:center!important">Description</th>
                            <!--3-->
                            <th style="text-align:center!important">Create</th>
                            <!--4-->
                            <th style="text-align:center!important">Action</th>
                            <!--5-->
                        </tr>
                    </thead>
                    <tbody style="border:1px solid #eee;"></tbody>
                </table>
                <!-- datatable end -->
            </div>
        </div>
    </div>
</div>

@include('Admin/roleform')
@include('Admin/rolepermission')

<script>
    $(document).ready(function() {
        getrolelist();
    });

    function getrolelist() {
        $.ajax({
            url: "{{ url('api/admin/getrolelist') }}",
            type: "GET",
            beforeSend: function(xhr) {
                blockagePage('Please Wait...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    return;
                }

                initrolelist(response.data);

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

    function initrolelist(data) {
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
                "class": "dt-left"
            }, //1
            {
                "data": "is_admin",
                "name": "is_admin",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-center",
                "render": function(data, type, row) {
                    return data == true ? "Yes" : "";
                }
            }, //2
            {
                "data": "description",
                "name": "description",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-left"
            }, //3
            {
                "data": "created_at",
                "name": "created_at",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-center",
                "render": function(data, type, row) {
                    return moment(data, "YYYY-MM-DD[T]HH:mm:ss").format("DD-MMM-YYYY hh:mm A");
                }
            }, //4
            {
                "data": null,
                "name": "Action",
                "searchable": false,
                "orderable": false,
                "visible": true,
                "class": "dt-center",
                render: function(data, type, row) {
                    return "<button onclick = \"viewrolepermission(" + row.id +
                        ",'" + row.name +
                        "')\"  class=\"btn btn-info btn-sm\" title=\"Permission\"> <i class=\"fal fa-list\" aria-hidden=\"true \"></i> </button> <button onclick=\"editrole(" +
                        row.id +
                        ")\"  class=\"btn btn-success btn-sm\" title=\"Update\"> <i class=\"fal fa-pencil\" aria-hidden=\"true \"></i> </button>  <button onclick=\"deleterole(" +
                        row.id + ",'" + row.name +
                        "')\"  class=\"btn btn-danger btn-sm\" title=\"Delete\"> <i class=\"fal fa-trash\" aria-hidden=\"true \"></i> </button>";
                }
            }, //5
        ];

        if ($.fn.DataTable.isDataTable('#roleslist')) {
            $('#roleslist').DataTable().clear();
            $('#roleslist').DataTable().destroy();
        }

        //////INT TABLE//////
        var table = $('#roleslist').DataTable({
            "data": data,
            "columns": cols,
            "order": [1, 'asc'],
            "rowId": "id",
            "responsive": "true",
            "select": true
        });
        //////INT TABLE//////
    }

    function clearroleform() {
        $("#roleform #name").val("");
        $("#roleform #is_admin").val("");
        $("#roleform #description").val("");
        $("#roleform #id").val(0);
    }

    function newrole() {
        $("#roleFormLabel").html("New Role");
        clearroleform();
        $("#roleformModal").modal();
    }

    function editrole(roleid) {
        $.ajax({
            url: "{{ url('api/admin/editrole') }}",
            type: "POST",
            data: {
                _token: formToken,
                id: roleid
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

                $("#roleFormLabel").html("Edit Role : " + response.data.name);
                $("#roleform #name").val(response.data.name);
                $("#roleform #is_admin").prop('checked', response.data.is_admin);
                $("#roleform #description").val(response.data.description);
                $("#roleform #id").val(response.data.id);
                $("#roleformModal").modal();

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

    function saverole() {
        var id = $("#roleform #id").val();
        var name = $("#roleform #name").val();
        var is_admin = $("#roleform #is_admin").prop('checked');
        var description = $("#roleform #description").val();
        var action = id == 0 ? "{{ url('api/admin/saverole') }}" : "{{ url('api/admin/updaterole') }}";

        $.ajax({
            url: action,
            type: "POST",
            data: {
                _token: formToken,
                id: id,
                name: name,
                is_admin: is_admin,
                description: description,
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

                if (action == "{{ url('api/admin/saverole') }}") {
                    var table = $('#roleslist').DataTable();
                    table.row.add(response.data).draw();
                } else {
                    var table = $('#roleslist').DataTable();
                    var selectRow = table.row($('#roleslist #' + response.data.id));
                    selectRow.data(response.data);
                    table.draw();
                }

                sweetToast(response.msg, response.result);

                $("#roleformModal").modal('hide');

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

    function deleterole(id, name) {
        Swal.fire({
            title: 'Are you sure?',
            text: "To delete Role :" + name + " !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            console.log(result.value);
            if (result.value) {

                $.ajax({
                    url: "{{ url('api/admin/deleterole') }}",
                    type: "POST",
                    data: {
                        _token: formToken,
                        id: id,
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

                        var table = $('#roleslist').DataTable();
                        var selectRow = table.row($('#roleslist #' + id));
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

    function viewrolepermission(roleid, rolename) {
        $.ajax({
            url: "{{ url('api/admin/getrolepermission') }}",
            type: "POST",
            data: {
                _token: formToken,
                roleid: roleid,
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

                initRolePermissionlist(response.data);
                $("#userroleLabel").html("Role : " + rolename);
                $("#rolepermissionmodal").modal();

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

    function initRolePermissionlist(data) {
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
                "class": "dt-left"
            }, //1
            {
                "data": "module",
                "name": "module",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-left"
            }, //2
            {
                "data": null,
                "name": "Action",
                "searchable": false,
                "orderable": false,
                "visible": true,
                "class": "dt-center",
                render: function(data, type, row) {
                    return "<label class=\"switch\"><input onchange=\"assignPermission(" + row.id + "," + row
                        .role_id +
                        ",this)\" type=\"checkbox\" " + (row.permit == 1 ? "checked" : "") +
                        "><span class=\"slider round\"></span></label>";
                }

            }, //3
        ];

        if ($.fn.DataTable.isDataTable('#rolepermissionlist')) {
            $('#rolepermissionlist').DataTable().clear();
            $('#rolepermissionlist').DataTable().destroy();
        }

        //////INT TABLE//////
        var table = $('#rolepermissionlist').DataTable({
            "data": data,
            "columns": cols,
            "order": [1, 'asc'],
            "rowId": "id",
            "responsive": "true",
            "select": true
        });
        //////INT TABLE//////
    }

    function assignPermission(permissionid, role_id, element) {
        var permit = element.checked;

        $.ajax({
            url: "{{ url('api/admin/assignPermission') }}",
            type: "POST",
            data: {
                _token: formToken,
                permissionid: permissionid,
                role_id: role_id,
                permit: permit,
            },
            beforeSend: function(xhr) {
                //blockagePage('Please Wait...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    return;
                }

                sweetToast(response.msg, response.result);
                //unblockagePage();
            },
            error: function(e) {
                if (e.status = 401) //unauthenticate not login
                {
                    Msg('Login is Required', 'error');
                }

                //unblockagePage();
            }
        });
    }
</script>
