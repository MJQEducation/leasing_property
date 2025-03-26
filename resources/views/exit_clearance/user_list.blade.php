<div class="modal fade" id="employeesListModal_base" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary-700">
                <h5 class="modal-title">Employees List</h5>
                {{-- data-dismiss="modal" aria-label="Close" --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <input id="data_id" style="display:none" />
            </div>
            <div class="modal-body" style="padding-bottom: 0px">
                <!-- datatable start -->
                <table id="employeesList_base" class="table table-bordered table-striped table-hover w-100"
                    style="font-size: 12px;border:1px solid #eee;">
                    <thead>
                        <tr>
                            <th style="text-align:center!important">Id</th>
                            <!--0-->
                            <th style="text-align:center!important">Card ID</th>
                            <!--1-->
                            <th style="text-align:center!important">Name</th>
                            <!--2-->
                            <th style="text-align:center!important">Position</th>
                            <!--3-->
                            <th style="text-align:center!important">Action</th>
                            <!--4-->
                        </tr>
                    </thead>
                    <tbody style="border:1px solid #eee;">

                    </tbody>
                </table>
                <!-- datatable end -->
            </div>
        </div>
    </div>
</div>

<script>
    var employeesList_base = "";
    $(document).ready(async function() {
        employeesList_base = $("#employeesList_base").html();
        initEmployeeList_base();
    });

    var initEmployeeList_base = () => {
        var cols = [{
                "data": "id",
                "name": "id",
                "searchable": false,
                "orderable": false,
                "visible": false
            }, //0
            {
                "data": "card_id",
                "name": "card_id",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-center",
            }, //1
            {
                "data": "name",
                "name": "name",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-left",
            }, //2
            {
                "data": "position",
                "name": "position",
                "searchable": true,
                "orderable": true,
                "visible": true,
                "class": "dt-left",
            }, //3
            {
                "data": null,
                "name": "Action",
                "searchable": false,
                "orderable": false,
                "visible": true,
                "class": "dt-center",
                render: function(data, type, row) {
                    const user_data = JSON.stringify(row); //jsonToPropertiesString(row);

                    const str =
                        `<button onclick='dropUserToClearanceForm(event)' class='btn btn-success dropUser' user_data='${user_data}'>delegate</button>`;

                    return str;
                }
            }, //8
        ];

        if ($.fn.DataTable.isDataTable('#employeesList_base')) {
            $('#employeesList_base').DataTable().clear();
            $('#employeesList_base').DataTable().destroy();
            $('#employeesList_base').html(exitClearanceList);
        }

        //////INT TABLE//////
        var table = $('#employeesList_base').DataTable({
            "ajax": {
                "url": "{{ url('api/Social/getEmployeeList') }}",
                "type": "POST",
                "datatype": "json",
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
            "order": [1, 'asc'],
            "rowId": "id",
            "responsive": true,
            "stateSave": false,
            "select": true
        });
        //////INT TABLE//////
    }
</script>
