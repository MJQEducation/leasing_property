<div class="demo-v-spacing">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#tabExitsList" role="tab">
                <i class="fas fa-list text-success"></i>
                <span class="hidden-sm-down ml-1">Exits List</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tabExitsForm" role="tab" id="AnchortabExitsForm">
                <i class="fas fa-door-open text-info"></i>
                <span class="hidden-sm-down ml-1">Exits Form</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tabContractForm" role="tab"">   
                <i class="fas fa-file-contract text-info"></i>
                <span class="hidden-sm-down ml-1">Contract</span>
            </a>
        </li>
    </ul>

    <div class="tab-content p-3">
        <div class="tab-pane fade show active" id="tabExitsList" role="tabpanel">
            @include('exit_clearance.exit_clearance_list')
        </div>
        <div class="tab-pane fade" id="tabExitsForm" role="tabpanel">
            @include('exit_clearance.exit_clearance_form')
        </div>
        <div class="tab-pane fade" id="tabContractForm" role="tabpanel">
            @include('exit_clearance.exit_clearance_form')
        </div>
    </div>
</div>

<script>
    var nullPhoto = '{{ $noPhoto }}';
    var exitClearanceList = "";
    var clearCheckList = ""; //stored a clear checklist form with init when getCheckList() involk

    $(document).ready(async function() {
        exitClearanceList = $("#exitClearanceList").html();

        initInputFormat();

        await getCheckList();
        initBulletinChecker(initBuletinCheckerRow);

        initExitClearanceList();

        initApproval();
    });

    //Form//
    {
        var clearForm = async () => {
            blockagePage('Clearing ...');

            $("#employeeInfoForm #id").val(0);
            $("#employeeInfoForm #card_id").val('');
            $("#employeeInfoForm #emp_id").val('');
            $("#employeeInfoForm #name").val('');
            $("#employeeInfoForm #position").val('');
            $("#employeeInfoForm #department").val('');
            $("#employeeInfoForm #line_management").val('');
            $("#employeeInfoForm #email").val('');
            $("#employeeInfoForm #phone").val('');
            $("#employeeInfoForm #hired_date").datepicker('setDate', null);
            $("#employeeInfoForm #last_working_date").datepicker('setDate', null);

            $("#employeeApprovalForm #personnelOfficer").val(null).trigger('change');
            $("#employeeApprovalForm #lineManager").val(null).trigger('change');
            $("#employeeApprovalForm #employeeSignature").val(null).trigger('change');
            $("#employeeApprovalForm #hodRepresentative").val(null).trigger('change');
            $("#employeeApprovalForm #hrDepartment").val(null).trigger('change');
            $("#employeeApprovalForm #remark").val('');

            document.querySelectorAll("[data-mvl-type='Check List']").forEach(checkbox => {
                checkbox.checked = false;
            });

            document.querySelectorAll("[data-mvl-type='Bulletins Checker']").forEach(selectBox => {
                let select_box_id = selectBox.id;
                $(`#${select_box_id}`).val('').trigger('change');
            });

            let invalid_component = $(".is-invalid");
            for (let i = 0; i < invalid_component.length; i++) {
                invalid_component[i].classList.remove("is-invalid");
            }

            unblockagePage();
        }

        var initInputFormat = () => {
            $('#employeeInfoForm #hired_date').datepicker({
                todayHighlight: true,
                orientation: "bottom left",
                templates: {
                    leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
                    rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
                },
                format: 'M dd, yyyy'
            });

            $('#employeeInfoForm #last_working_date').datepicker({
                todayHighlight: true,
                orientation: "bottom left",
                templates: {
                    leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
                    rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
                },
                format: 'M dd, yyyy'
            });
        }

        var getCheckList = async () => {
            let response = await getAsyncData('{{ url('api/ExitClearance/getExitClearanceCheckList') }}');

            let checkListBody = "";

            response.forEach(element => {
                checkListBody = `${checkListBody}
                    <tr name="Bulleting"
                        data-id="${element.Bulleting.id}"
                        data-mvl-id="${element.Bulleting.mvl_id}"
                        data-order="${element.Bulleting.ordinal}">
                        <th scope="col" class="text-center text-info">${element.Bulleting.value}</th>
                        <th scope="col" colspan="2" class="text-info">${element.Bulleting.name_kh}/${element.Bulleting.name_en}</th>
                        <td>
                            <div class="form-group row" style="margin-bottom:5px">
                                <div class="col-sm-12">
                                    <select class="form-control border-0 w-100"
                                        data-value=""
                                        data-mvl-type="Bulletins Checker"
                                        data-mvl-type-initializer="Bulletins Checker ${element.Bulleting.value}"
                                        data-required-message="${element.Bulleting.name_en } checker is required"
                                        id="bulletinsChecker${element.Bulleting.mvl_id}"
                                        name="bulletinsChecker"
                                        validate-attribute='{"required":"true"}'
                                        style="height: 42px!important"></select>
                                    <div class="invalid-feedback">
                                        Require!!
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                `;

                element.CheckList.forEach(
                    checklist => {
                        checkListBody = `${checkListBody}
                    <tr>
                        <td scope="row" class="text-right">${checklist.ordinal}</td>
                        <td>${checklist.name_kh}/${checklist.name_en}</td>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input
                                    disabled
                                    type="checkbox"
                                    class="custom-control-input"
                                    data-mvl-type="Check List"
                                    data-id="${checklist.id}"
                                    data-mvl-parent="parent${element.Bulleting.mvl_id}"
                                    data-mvl-id="${checklist.mvl_id}"
                                    data-order="${checklist.ordinal}"
                                    id="${checklist.name_en}${checklist.id}" />
                                <label class="custom-control-label" for="${checklist.name_en}${checklist.id}">បញ្ចប់រួចរាល់/Completed</label>
                            </div>
                        </td>
                        <td class="text-info" data-mvl-type="Bulletins Checker ${element.Bulleting.value}"></td>
                    </tr>`
                    }
                )
            });

            $("#checkListContainer").html(checkListBody);
            clearCheckList = checkListBody;
        }

        var initBulletinChecker = (initBuletinCheckerRow = undefined) => {
            // let bulletinsChecker = $("[name='bulletinsChecker']");

            // if (bulletinsChecker.length === 0) {
            //     return;
            // }

            // let userData = [];

            // for (let i = 0; i < users.length; i++) {
            //     userData.push({
            //         id: users[i].id,
            //         text: `${users[i].card_id?(users[i].card_id + ' - '):''}${users[i].name}`,
            //         html: `<div style="flex:1;justify-content:flex-start;margin-left:10px;">
            //             <div style="display:flex;flex-direction:column;">
            //                 <div class="fs-lg text-truncate text-truncate-lg">${users[i].name}</div>
            //                 <div class="fs-lg text-truncate text-truncate-lg color-danger-800">${users[i].position}</div>
            //             </div>
            //         </div>`,
            //     });
            // }

            // for (let j = 0; j < bulletinsChecker.length; j++) {
            //     initSelect2(bulletinsChecker[j].id, userData, initBuletinCheckerRow);
            // }
        }

        var initSelect2 = (elementName, userData, initBuletinCheckerRow) => {
            let value = $(`#${elementName}`).attr('data-value');

            $(`#${elementName}`).removeAttr('data-value');

            $(`#${elementName}`).select2({
                data: userData,
                templateResult: (obj) => {
                    return obj.html;
                },
                escapeMarkup: function(m) {
                    return m;
                }
            });

            $(`#${elementName}`).change(initBuletinCheckerRow);
            $(`#${elementName}`).val(!value ? null : value).trigger("change");
        }

        var initBuletinCheckerRow = (event) => {
            let element = event.target;
            let initializerName = element.getAttribute('data-mvl-type-initializer');

            let data = $(`#${element.id}`).select2('data').length > 0 ? $(`#${element.id}`).select2('data')[0] :
                null;

            document.querySelectorAll(`[data-mvl-type='${initializerName}']`).forEach(td => {
                td.innerHTML = !data ? '' : data.text;
            });
        }

        var getCheckListData = () => {
            let bulletingElements = document.body.querySelectorAll("[name='Bulleting']");
            let exit_id = $("#employeeInfoForm #id").val();
            let data = [];
            bulletingElements.forEach((bulleting, index) => {
                let bulletingId = bulleting.getAttribute("data-id");
                let bulletingOrder = bulleting.getAttribute("data-order");
                let bulletingMvl = bulleting.getAttribute("data-mvl-id");
                let checkerElement = $(`#bulletinsChecker${bulletingMvl}`);
                let checked_id = checkerElement.val();

                checkerElement.removeClass("is-invalid");

                if (!checked_id) {
                    Msg(checkerElement.attr('data-required-message'), "error");
                    checkerElement.addClass("is-invalid");
                    return null;
                }

                let check_list_element = document.body.querySelectorAll(
                    `[data-mvl-parent='parent${bulletingMvl}']`);

                let check_list = [];
                check_list_element.forEach(e => {
                    check_list.push({
                        "id": +e.getAttribute("data-id"),
                        "bulletin_id": +bulletingId,
                        "questionnaire": +e.getAttribute("data-mvl-id"),
                        "is_checked": e.checked,
                        "checked_id": +checked_id,
                        "checked_code": "",
                        "emp_name": "",
                        "position": "",
                        "ordinal": +e.getAttribute("data-order"),
                    });
                });


                data.push({
                    "id": +bulletingId,
                    "exit_id": +exit_id,
                    "questionnaire": +bulletingMvl,
                    "checked_id": +checked_id,
                    "checked_code": "",
                    "emp_name": "",
                    "position": "",
                    "ordinal": +bulletingOrder,
                    "checklist": check_list,
                })
            });

            return data;
        }

        var getExitClearanceData = () => {
            if (!formValidation('employeeInfoForm')) {
                Msg("Data didn't pass Validation", "error");
                return undefined;
            }

            if (!formValidation('employeeApprovalForm')) {
                Msg("Invalid Approval Data", "error");
                return undefined;
            }

            let id = $("#employeeInfoForm #id").val();
            let card_id = $("#employeeInfoForm #card_id").val();
            let emp_id = $("#employeeInfoForm #emp_id").val();
            let name = $("#employeeInfoForm #name").val();
            let position = $("#employeeInfoForm #position").val();
            let department = $("#employeeInfoForm #department").val();
            let line_management = $("#employeeInfoForm #line_management").val();
            let email = $("#employeeInfoForm #email").val();
            let phone = $("#employeeInfoForm #phone").val();
            let hired_date = $("#employeeInfoForm #hired_date").val();
            let last_working_date = $("#employeeInfoForm #last_working_date").val();
            let checklistElement = document.body.querySelectorAll("[data-mvl-type='Check List']");

            //Approval Form//
            let personnelOfficer = $("#employeeApprovalForm #personnelOfficer").val();
            let lineManager = $("#employeeApprovalForm #lineManager").val();
            let employeeSignature = $("#employeeApprovalForm #employeeSignature").val();
            let hodRepresentative = $("#employeeApprovalForm #hodRepresentative").val();
            let hrDepartment = $("#employeeApprovalForm #hrDepartment").val();

            let CDSignature = $("#employeeApprovalForm #CDSignature").val();
            let principalSignature = $("#employeeApprovalForm #principalSignature").val();

            let remark = $("#employeeApprovalForm #remark").val();

            let signatures = [];

            let signatureOridnal = 1;

            signatures.push({
                sign_title: "Personnel Officer",
                signed_id: personnelOfficer,
                ordinal: signatureOridnal,
            });

            signatureOridnal++;

            signatures.push({
                sign_title: "Line Manager",
                signed_id: lineManager,
                ordinal: signatureOridnal,
            });
            signatureOridnal++;

            signatures.push({
                sign_title: "Employee",
                signed_id: employeeSignature,
                ordinal: signatureOridnal,
            });
            signatureOridnal++;

            signatures.push({
                sign_title: "HOD",
                signed_id: hodRepresentative,
                ordinal: signatureOridnal,
            });
            signatureOridnal++;

            if (CDSignature) {
                signatures.push({
                    sign_title: "CD",
                    signed_id: CDSignature,
                    ordinal: signatureOridnal,
                });
                signatureOridnal++;
            }

            if (principalSignature) {
                signatures.push({
                    sign_title: "Principal",
                    signed_id: principalSignature,
                    ordinal: signatureOridnal,
                });
                signatureOridnal++;
            }

            signatures.push({
                sign_title: "HR Dept",
                signed_id: hrDepartment,
                ordinal: signatureOridnal,
            });
            signatureOridnal++;
            //Approval Form//

            let bulletins = getCheckListData();

            if (!bulletins) {
                return undefined;
            }

            let data = {
                id,
                card_id,
                emp_id: emp_id === '' ? null : emp_id,
                name,
                position,
                department,
                line_management,
                email,
                phone,
                hired_date,
                last_working_date,
                remark,
                bulletins,
                signatures
            }

            return data;
        }

        var existUser = async (arg) => {
            //arg can be object event or string card_id
            let card_id = "";

            if ((typeof arg) === "object") {
                card_id = arg.target.value;
            } else {
                card_id = arg;
            }

            let postData = {
                card_id
            };

            let isExist = await sendAsyncData('{{ url('api/ExitClearance/existUser') }}',
                postData, true);

            return isExist;
        }

        var saveExitClearance = async () => {
            blockagePage('Saving ...');
            let card_id = $("#employeeInfoForm #card_id").val();
            let isUserExist = await existUser(card_id);

            if (!isUserExist) {
                unblockagePage();
                return;
            }

            let exitClearanceData = getExitClearanceData();

            //console.log(exitClearanceData);

            if (!exitClearanceData) {
                unblockagePage();
                return;
            }

            let action = exitClearanceData.id == 0 ? '{{ url('api/ExitClearance/saveExitClearance') }}' :
                '{{ url('api/ExitClearance/updateExitClearance') }}';

            let exitClearanceId = await sendAsyncData(action, exitClearanceData, true);

            initExitClearanceList();

            let id_element = $("#employeeInfoForm #id");
            id_element.val(exitClearanceId);

            unblockagePage();
        }

        var initApproval = async () => {
            initApproverSelect2("personnelOfficer", getApproverImage);
            initApproverSelect2("lineManager", getApproverImage);
            initApproverSelect2("employeeSignature", getApproverImage);
            initApproverSelect2("hodRepresentative", getApproverImage);
            initApproverSelect2("hrDepartment", getApproverImage);
            initApproverSelect2("CDSignature", getApproverImage);
            initApproverSelect2("principalSignature", getApproverImage);

            let bulletinsCheckers = $("[name='bulletinsChecker']");

            for (let i = 0; i < bulletinsCheckers.length; i++) {
                initApproverSelect2(bulletinsCheckers[i].id, initBuletinCheckerRow);
            }
        }

        var getApproverImage = async (event) => {
            let userPhotoElement = event.target.parentElement.parentElement.querySelector(
                'img[name="approverImg"]');
            let userid = event.target.value;

            let photo = await sendAsyncData('{{ url('api/ExitClearance/getUserImage') }}', {
                userid
            }, false);

            userPhotoElement.src = `data:image/jpeg;base64,${photo}`;
            userPhotoElement.setAttribute("userid", userid);
        }

        var viewUserPhoto = async (event) => {
            let element = event.target;
            let userid = element.getAttribute('userid')

            if (userid) {
                let response = await getAsyncView('{{ url('ExitClearance/viewUserPhoto') }}', {
                    userid
                });

                if (response.result === 'error') {
                    Msg(response.msg, response.result);
                    return;
                }

                $("#fileView").html(response);
                $("#userViewPhoto").modal();
            }
        }

        var getExitEmployeeInfo = async (event) => {
            let card_id = event.target.value;
            let postData = {
                card_id
            };
            let employee_info = await sendAsyncData('{{ url('api/ExitClearance/getExitEmployeeInfo') }}',
                postData,
                false);

            console.log(employee_info);

            if (employee_info) {
                $("#employeeInfoForm #emp_id").val(employee_info.id);
                $("#employeeInfoForm #name").val(employee_info.name);
                $("#employeeInfoForm #position").val(employee_info.position);
            } else {
                $("#employeeInfoForm #emp_id").val('');
                $("#employeeInfoForm #name").val('');
                $("#employeeInfoForm #position").val('');
            }
        }

        var getDepartment = async () => {
            console.log(departments);
        }
    }
    //Form//

    //List//
    {
        var initExitClearanceList = () => {
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
                        if (row.status === "Completed" || row.status === "Rejected") {
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
                        } else {
                            str =
                                `<div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="fal fa-cog" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                                style="position: absolute; top: 32px; left: -5px; will-change: top, left;">
                                <a class="dropdown-item" href="javascript:void(0);" onclick="editExitClearance(${row.id})">
                                    <i class="fas fa-pencil color-info-600"></i> Edit
                                </a>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="printExitClearance(${row.id})">
                                    <i class="fas fa-print color-success-600"></i> Print
                                </a>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="removeExitClearance(${row.id},'${row.name}')">
                                    <i class="fal fa-trash color-danger-600" aria-hidden="true"></i> Cancel
                                </a>
                            </div>
                        </div>`;
                        }

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
                    "url": "{{ url('api/ExitClearance/getExitClearanceList') }}",
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

        var editExitClearance = async (id) => {
            blockagePage('Loading ...');

            let response = await sendAsyncData('{{ url('api/ExitClearance/editExitClearance') }}', {
                id
            }, true);

            if (!response) {
                unblockagePage();
                return;
            }

            let exitClearance = response.exitClearace;
            let checkLists = response.checkLists;
            let signatures = response.signatures;

            initExitClearanceHeader(exitClearance);
            initExitClearanceCheckList(checkLists);
            initExitClearanceSignature(signatures);

            let bulletinsCheckers = $("[name='bulletinsChecker']");

            for (let i = 0; i < bulletinsCheckers.length; i++) {
                initApproverSelect2(bulletinsCheckers[i].id, initBuletinCheckerRow);
            }

            unblockagePage();

            $("#AnchortabExitsForm").click();
        }

        var initExitClearanceSignature = (signatures) => {
            let personnelOfficer = signatures.filter(e => e.sign_title === "Personnel Officer")[0];
            let options = new Option(personnelOfficer.emp_name, personnelOfficer.signed_id, false, false);
            $("#employeeApprovalForm #personnelOfficer").empty();
            $('#employeeApprovalForm #personnelOfficer').append(options).trigger('change')

            let lineManager = signatures.filter(e => e.sign_title === "Line Manager")[0];
            options = new Option(lineManager.emp_name, lineManager.signed_id, false, false);
            $("#employeeApprovalForm #lineManager").empty();
            $('#employeeApprovalForm #lineManager').append(options).trigger('change');

            let employeeSignature = signatures.filter(e => e.sign_title === "Employee")[0];
            options = new Option(employeeSignature.emp_name, employeeSignature.signed_id, false, false);
            $("#employeeApprovalForm #employeeSignature").empty();
            $('#employeeApprovalForm #employeeSignature').append(options).trigger('change');

            let hodRepresentative = signatures.filter(e => e.sign_title === "HOD")[0];
            options = new Option(hodRepresentative.emp_name, hodRepresentative.signed_id, false, false);
            $("#employeeApprovalForm #hodRepresentative").empty();
            $('#employeeApprovalForm #hodRepresentative').append(options).trigger('change');

            let hrDepartment = signatures.filter(e => e.sign_title === "HR Dept")[0];
            options = new Option(hrDepartment.emp_name, hrDepartment.signed_id, false, false);
            $("#employeeApprovalForm #hrDepartment").empty();
            $('#employeeApprovalForm #hrDepartment').append(options).trigger('change');
        }

        var initExitClearanceHeader = (exitClearance) => {
            $("#employeeInfoForm #id").val(exitClearance.id);
            $("#employeeInfoForm #card_id").val(exitClearance.card_id);
            $("#employeeInfoForm #emp_id").val(exitClearance.emp_id);
            $("#employeeInfoForm #name").val(exitClearance.name);
            $("#employeeInfoForm #position").val(exitClearance.position);
            $("#employeeInfoForm #department").val(exitClearance.department);
            $("#employeeInfoForm #line_management").val(exitClearance.line_management);
            $("#employeeInfoForm #email").val(exitClearance.email);
            $("#employeeInfoForm #phone").val(exitClearance.phone);
            $("#employeeInfoForm #hired_date").datepicker('setDate', moment(exitClearance.hired_date,
                "YYYY-MM-DD[T]HH:mm:ss").format("MMM DD, YYYY"));
            $("#employeeInfoForm #last_working_date").datepicker('setDate', moment(exitClearance
                .last_working_date, "YYYY-MM-DD[T]HH:mm:ss").format("MMM DD, YYYY"));

            $("#employeeApprovalForm #remark").val(exitClearance.remark);
        }

        var initExitClearanceCheckList = (checkLists) => {

            let checkListBody = "";

            checkLists.forEach(element => {

                //console.log(element);

                checkListBody = `${checkListBody}
                                    <tr name="Bulleting"
                                        data-id="${element.bulletin.id}"
                                        data-mvl-id="${element.bulletin.mvl_id}"
                                        data-order="${element.bulletin.ordinal}">
                                        <th scope="col" class="text-center text-info">${element.bulletin.value}</th>
                                        <th scope="col" colspan="2" class="text-info">${element.bulletin.name_kh}/${element.bulletin.name_en}</th>
                                        <td>
                                            <div class="form-group row" style="margin-bottom:5px">
                                                <div class="col-sm-12">
                                                    <select class="form-control border-0 w-100"
                                                        data-value="${element.bulletin.checked_id}"
                                                        data-mvl-type="Bulletins Checker"
                                                        data-mvl-type-initializer="Bulletins Checker ${element.bulletin.value}"
                                                        data-required-message="${element.bulletin.name_en} checker is required"
                                                        id="bulletinsChecker${element.bulletin.mvl_id}"
                                                        name="bulletinsChecker"
                                                        validate-attribute='{"required":"true"}'
                                                        style="height: 42px!important">
                                                            <option value='${element.bulletin.checked_id}'>${element.bulletin.emp_name}</option>
                                                        </select>
                                                    <div class="invalid-feedback">
                                                        Require!!
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>`;

                element.checklists.forEach(
                    checklist => {
                        checkListBody = `${checkListBody}
                                <tr>
                                    <td scope="row" class="text-right">${checklist.ordinal}</td>
                                    <td>${checklist.name_kh}/${checklist.name_en}</td>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                disabled
                                                type="checkbox"
                                                class="custom-control-input"s
                                                data-mvl-type="Check List"
                                                data-id="${checklist.id}"
                                                data-mvl-parent="parent${element.bulletin.mvl_id}"
                                                data-mvl-id="${checklist.mvl_id}"
                                                data-order="${checklist.ordinal}"
                                                id="${checklist.name_en}${checklist.id}"
                                                ${checklist.is_checked==="Checked"?"checked='checked'":""}

                                                />
                                            <label class="custom-control-label" for="${checklist.name_en}${checklist.id}">បញ្ចប់រួចរាល់/Completed</label>
                                        </div>
                                    </td>
                                    <td class="text-info" data-mvl-type="Bulletins Checker ${element.bulletin.value}">${checklist.emp_name}</td>
                                </tr>`;
                    }
                )
            });

            $("#checkListContainer").html(checkListBody);
            clearCheckList = checkListBody;

            initBulletinChecker();
        }

        var assingSelect2Event = () => {
            //Use only in edit while initBuletingCheckerRow even is undefine
            let bulletinsChecker = $("[name='bulletinsChecker']");

            for (let i = 0; i < bulletinsChecker.length; i++) {
                $(`#${bulletinsChecker[i].id}`).change(initBuletinCheckerRow);
            }
        }

        var removeExitClearance = async (id, name) => {
            let result = await conditionSWAlert(`Do you want to remove Lease Management ${name}?`, 'question',
                'Yes Remove!')

            if (!result) {
                return;
            }

            let response = await sendAsyncData('{{ url('api/ExitClearance/removeExitClearance') }}', {
                id
            }, true);

            initExitClearanceList();
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
    }
    //List//

    var initApproverSelect2 = (elementName, getApproverImage = undefined) => {
        $(`#${elementName}`).select2({
            minimumInputLength: 3,
            ajax: {
                url: '{{ url('api/ExitClearance/getUsers') }}',
                delay: 250,
                dataType: "json",
                type: "POST",
                data: function(params) {
                    var query = {
                        _token: formToken,
                        search: params.term,
                        page: params.page || 1
                    }

                    // Query parameters will be ?search=[term]&page=[page]
                    return query;
                },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", "Bearer " + AuthToken);
                },
                processResults: function(response) {
                    let users = response.data;
                    let items = users.map(element => {
                        return {
                            id: element.id,
                            text: element.name,
                            html: `<div style="flex:1;justify-content:flex-start;margin-left:10px;">
                                    <div style="display:flex;flex-direction:column;">
                                        <div class="fs-lg text-truncate text-truncate-lg">${element.name}</div>
                                        <div class="fs-lg text-truncate text-truncate-lg color-danger-800">${element.position}</div>
                                    </div>
                                </div>`,
                        }
                    });

                    return {
                        results: items,
                        pagination: {
                            more: false,
                        }
                    };
                },
            },
            templateResult: (obj) => {
                return obj.html;
            },
            escapeMarkup: function(m) {
                return m;
            }
        });

        $(`#${elementName}`).change(getApproverImage);
    }
</script>
