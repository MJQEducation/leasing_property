<div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
                Permission <span class="fw-300"><i>List</i></span>
            </h2>
            <div class="panel-toolbar">

            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <!-- datatable start -->
                <table id="permissionlist" class="table table-bordered table-hover table-striped w-100"
                    style="font-size: 12px;border:1px solid #eee;">

                    <thead>
                        <tr>
                            <th style="text-align:center!important">Id</th>
                            <!--0-->
                            <th style="text-align:center!important">Name</th>
                            <!--1-->
                            <th style="text-align:center!important">Module</th>
                            <!--2-->
                            <th style="text-align:center!important">Remark</th>
                            <!--3-->
                            <th style="text-align:center!important">isExist</th>
                            <!--4-->
                            <th style="text-align:center!important">Create</th>
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

<script>
    $(document).ready(function() {
        getPermissionList();
    });

    function getPermissionList() {
        $.ajax({
            url: "{{ url('api/admin/getpermissionlist') }}",
            type: "GET",
            beforeSend: function(xhr) {
                blockagePage('Loading...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    return;
                }

                initpermissionlist(response.data);

                unblockagePage();
            },
            error: function(e) {
                //Msg('Error getting JSON data', 'error');

                if (e.status = 401) //unauthenticate not login
                {
                    Msg('Login is Required', 'error');
                }

                unblockagePage();
            }
        });
    }

    function initpermissionlist(data) {
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
                "data": "remark",
                "name": "remark",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-left"
            }, //3
            {
                "data": "is_exist",
                "name": "is_exist",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-center",
                "render": function(data, type, row) {
                    return (data == true ? "Yes" : "");
                }
            }, //4
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
            }, //5
        ];

        if ($.fn.DataTable.isDataTable('#permissionlist')) {
            $('#permissionlist').DataTable().clear();
            $('#permissionlist').DataTable().destroy();
        }

        //////INT TABLE//////
        var table = $('#permissionlist').DataTable({
            "data": data,
            "columns": cols,
            "order": [1, 'asc'],
            "rowId": "id",
            "responsive": "true",
            "select": true
        });
        //////INT TABLE//////
    }
</script>
