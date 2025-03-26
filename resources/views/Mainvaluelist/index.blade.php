<div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
                Main Value <span class="fw-300"><i>List</i></span>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-primary btn-sm waves-effect waves-themed" onclick="newMVL()">New
                    MVL</button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <!-- datatable start -->
                <table id="mvlList" class="table table-bordered table-striped table-hover w-100"
                    style="font-size: 12px;border:1px solid #eee;">

                    <thead>
                        <tr>
                            <th style="text-align:center!important">Id</th>
                            <!--0-->
                            <th style="text-align:center!important">Abbreviation</th>
                            <!--1-->
                            <th style="text-align:center!important">Name En</th>
                            <!--2-->
                            <th style="text-align:center!important">Name Kh</th>
                            <!--3-->
                            <th style="text-align:center!important">Parent</th>
                            <!--4-->
                            <th style="text-align:center!important">Type</th>
                            <!--5-->
                            <th style="text-align:center!important">Ordinal</th>
                            <!--6-->
                            <th style="text-align:center!important">Value</th>
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

@include('Mainvaluelist/mvlform')


<script>
    $(document).ready(function() {
        $("#mvlform #type").select2();
        $("#mvlform #parent_mvl").select2();

        getMVLList();
    });

    var newMVL = async () => {
        await getMVLType();
        await getParentMVL();

        $("#mvlFormLabel").html("New Main Value List")

        $("#mvlform #abbreviation").val("");
        $("#mvlform #name_en").val("");
        $("#mvlform #name_kh").val("");
        $("#mvlform #type").val(null).change();
        $("#mvlform #parent_mvl").val(null).change();
        $("#mvlform #value").val("");
        $("#mvlform #ordinal").val(0);
        $("#mvlform #id").val(0);
        $("#mvlformModal").modal();
    }

    function saveMVL() {
        var abbreviation = $("#mvlform #abbreviation").val();
        var name_en = $("#mvlform #name_en").val();
        var name_kh = $("#mvlform #name_kh").val();
        var type = $("#mvlform #type").val();
        var parent_mvl = $("#mvlform #parent_mvl").val();
        var value = $("#mvlform #value").val() == null ? "" : $("#mvlform #value").val();
        var ordinal = $("#mvlform #ordinal").val();
        var id = $("#mvlform #id").val();
        var action = (id == 0 ? "{{ url('api/mvl/saveMVL') }}" : "{{ url('api/mvl/updateMVL') }}");

        if (name_en == "") {
            sweetToast("Name English is Required", "error");
            return;
        }

        if (type == "" || type == null) {
            sweetToast("Type is Required", "error");
            return;
        }

        if (parent_mvl == "" || parent_mvl == null) {
            parent_mvl = null;
        }

        var data = {
            _token: formToken,
            abbreviation: abbreviation,
            name_en: name_en,
            name_kh: name_kh,
            type: type,
            parent_mvl: parent_mvl,
            value: value,
            ordinal: ordinal,
            id: id
        }

        $.ajax({
            url: action,
            type: "POST",
            data: data,
            beforeSend: function(xhr) {
                blockagePage('Please wait...');
                xhr.setRequestHeader('Authorization', `Bearer ${AuthToken}`);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    return;
                }

                if (action == "{{ url('api/mvl/saveMVL') }}") {
                    var table = $('#mvlList').DataTable();
                    table.row.add(response.data).draw();
                } else {
                    var table = $('#mvlList').DataTable();
                    var selectRow = table.row($('#mvlList #' + response.data.id));
                    selectRow.data(response.data);
                    table.draw();
                }

                sweetToast(response.msg, response.result);

                $("#mvlformModal").modal('hide');

                unblockagePage();
            },
            error: function(e) {
                Msg(e.Message(), 'error');

                unblockagePage();
            }
        });
    }

    var editMVL = async (id) => {
        await getMVLType();
        await getParentMVL();

        $.ajax({
            url: "{{ url('api/mvl/editMVL') }}",
            type: "POST",
            data: {
                _token: formToken,
                id: id
            },
            beforeSend: function(xhr) {
                blockagePage('Please wait...');
                xhr.setRequestHeader('Authorization', `Bearer ${AuthToken}`);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    return;
                }

                $("#mvlFormLabel").html("Update : " + response.data.name_en)
                $("#mvlform #abbreviation").val(response.data.abbreviation);
                $("#mvlform #name_en").val(response.data.name_en);
                $("#mvlform #name_kh").val(response.data.name_kh);
                $("#mvlform #type").val(response.data.type).trigger('change');
                $("#mvlform #parent_mvl").val(response.data.parent_mvl).trigger('change');
                $("#mvlform #value").val(response.data.value);
                $("#mvlform #ordinal").val(response.data.ordinal);
                $("#mvlform #id").val(response.data.id);
                $("#mvlformModal").modal();

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

    function deleteMVL(id, name_en) {
        Swal.fire({
            title: 'Are you sure?',
            text: "To delete MVL :" + name_en + " !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            console.log(result.value);
            if (result.value) {

                $.ajax({
                    url: "{{ url('api/mvl/deleteMVL') }}",
                    type: "POST",
                    data: {
                        _token: formToken,
                        id: id
                    },
                    beforeSend: function(xhr) {
                        blockagePage('Please wait...');
                        xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
                    },
                    success: function(response) {
                        if (response.result == "error") {
                            sweetToast(response.msg, response.result);
                            return;
                        }

                        sweetToast(response.msg, response.result);

                        var table = $('#mvlList').DataTable();
                        var selectRow = table.row($('#mvlList #' + id));
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

    var getMVLType = async () => {
        let mvlType = await getAsyncData("{{ url('api/mvl/getMVLTypes') }}");

        mvlType = mvlType.map(e => {
            return {
                id: e.name_en,
                text: e.name_en
            }
        });

        mvlType.push({
            id: "MVL",
            text: "MVL"
        });

        $("#mvlform #type").select2("destroy").select2({
            dropdownParent: $('#mvlformModal'),
            data: mvlType
        });
    }

    var getParentMVL = async () => {
        let mvlParent = await getAsyncData("{{ url('api/mvl/getParentMVL') }}");

        mvlParent = mvlParent.map(e => {
            return {
                id: e.id,
                text: e.name_en
            }
        });

        mvlParent.push({
            id: null,
            text: null
        });

        $("#mvlform #parent_mvl").select2("destroy").select2({
            dropdownParent: $('#mvlformModal'),
            data: mvlParent
        });
    }

    function getMVLList() {
        $.ajax({
            url: "{{ url('api/mvl/getMVLList') }}",
            type: "GET",
            beforeSend: function(xhr) {
                blockagePage('Please wait...');
                xhr.setRequestHeader('Authorization', 'Bearer ' + AuthToken);
            },
            success: function(response) {
                if (response.result == "error") {
                    sweetToast(response.msg, response.result);
                    return;
                }
                initMainValueList(response.data);

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

    function initMainValueList(data) {
        var cols = [{
                "data": "id",
                "name": "id",
                "searchable": false,
                "orderable": false,
                "visible": false
            }, //0
            {
                "data": "abbreviation",
                "name": "abbreviation",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "render": function(data, type, row) {
                    return data;
                }
            }, //1
            {
                "data": "name_en",
                "name": "name_en",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "render": function(data, type, row) {
                    return data;
                }
            }, //2
            {
                "data": "name_kh",
                "name": "name_kh",
                "searchable": true,
                "orderable": true,
                "visible": true,
            }, //3
            {
                "data": "parent",
                "name": "parent",
                "searchable": true,
                "orderable": true,
                "visible": true,
            }, //4
            {
                "data": "type",
                "name": "type",
                "searchable": true,
                "orderable": true,
                "visible": true,
            }, //5
            {
                "data": "ordinal",
                "name": "ordinal",
                "searchable": true,
                "orderable": true,
                "visible": true,
            }, //6
            {
                "data": "value",
                "name": "value",
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
                    return `<button onclick="editMVL(${row.id})"  class="btn btn-success btn-sm" title="Update"> <i class="fal fa-pencil" aria-hidden="true"></i> </button>
                    <button onclick="deleteMVL(${row.id},'${row.name_en.replaceAll("'", "\\'")}')"  class="btn btn-danger btn-sm" title="Delete"> <i class="fal fa-trash" aria-hidden="true "></i> </button>`;
                }

            }, //8
        ];

        if ($.fn.DataTable.isDataTable('#mvlList')) {
            $('#mvlList').DataTable().clear();
            $('#mvlList').DataTable().destroy();
        }

        //////INT TABLE//////
        var table = $('#mvlList').DataTable({
            "data": data,
            "columns": cols,
            "order": [1, 'asc'],
            "rowId": "id",
            "responsive": "true"
        });
        //////INT TABLE//////
    }
</script>
