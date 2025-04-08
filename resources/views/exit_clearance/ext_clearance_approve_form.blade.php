<div class="modal fade" id="exitClearanceCheckListBaseModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary-700">
                <h5 class="modal-title">Lease Management Check List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="card_id" class="col-sm-4 col-form-label">អត្តលេខ/ID :</label>
                                <div class="col-sm-8">
                                    <input value="{{ $exit_clearance->card_id }}" type="text" class="form-control"
                                        id="card_id" name="card_id" autocomplete="off"
                                        onblur="getExitEmployeeInfo(event)" validate-attribute='{"required":"true"}'
                                        maxlength="20" disabled />
                                    <div class="invalid-feedback">
                                        Card ID Require!!
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="display: none">
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="emp_id" class="col-sm-4 col-form-label">អត្តលេខ/ID :</label>
                                <div class="col-sm-8">
                                    <input value="{{ $exit_clearance->card_id }}" type="text" class="form-control"
                                        id="emp_id" name="emp_id" autocomplete="off"
                                        validate-attribute='{"required":"true"}' maxlength="20" disabled />
                                    <div class="invalid-feedback">
                                        ID Require!!
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="name" class="col-sm-4 col-form-label">ឈ្មោះបុគ្គលិក/Name:</label>
                                <div class="col-sm-8">
                                    <input value="{{ $exit_clearance->name }}" type="text" class="form-control"
                                        id="name" name="name" autocomplete="off"
                                        validate-attribute='{"required":"true"}' maxlength="100" disabled />
                                    <div class="invalid-feedback">
                                        Name is Require!!
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="position" class="col-sm-4 col-form-label">តួនាទី/Position:</label>
                                <div class="col-sm-8">
                                    <input value="{{ $exit_clearance->position }}" type="text" class="form-control"
                                        id="position" name="position" autocomplete="off"
                                        validate-attribute='{"required":"true"}' maxlength="100" disabled />
                                    <div class="invalid-feedback">
                                        Position is Require!!
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="department" class="col-sm-4 col-form-label">សាខា/ផ្នែក/Campus/Dept:</label>
                                <div class="col-sm-8">
                                    <input value="{{ $exit_clearance->department }}" type="text" class="form-control"
                                        id="department" name="department" autocomplete="off"
                                        validate-attribute='{"required":"true"}' maxlength="100" disabled />
                                    <div class="invalid-feedback">
                                        Department is Require!!
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="line_management" class="col-sm-4 col-form-label">ឈ្មោះប្រធាន/Line
                                    Manager's
                                    Name:</label>
                                <div class="col-sm-8">
                                    <input value="{{ $exit_clearance->line_management }}" type="text"
                                        class="form-control" id="line_management" name="line_management"
                                        autocomplete="off" validate-attribute='{"required":"true"}' maxlength="100"
                                        disabled />
                                    <div class="invalid-feedback">
                                        Line Manager is Require!!
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="email" class="col-sm-4 col-form-label">អ៊ីមែល/Email:</label>
                                <div class="col-sm-8">
                                    <input value="{{ $exit_clearance->email }}" type="text" class="form-control"
                                        id="email" name="email" autocomplete="off"
                                        validate-attribute='{"required":"false"}' maxlength="100" disabled />
                                    <div class="invalid-feedback">
                                        Department is Require!!
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="phone" class="col-sm-4 col-form-label">ទូរស័ព្ទ/Cellular
                                    Phone:</label>
                                <div class="col-sm-8">
                                    <input value="{{ $exit_clearance->phone }}" type="text" class="form-control"
                                        id="phone" name="phone" autocomplete="off"
                                        validate-attribute='{"required":"false"}' maxlength="100" disabled />
                                    <div class="invalid-feedback">
                                        Phone is Require!!
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="hired_date" class="col-sm-4 col-form-label">ថ្ងៃចូលធ្វើការ/Date of Hire:
                                </label>
                                <div class="col-sm-8">
                                    <input
                                        value=" {{ \Carbon\Carbon::parse($exit_clearance->hired_date)->format('M d, Y') }} "
                                        type="text" class="form-control" id="hired_date" name="hired_date"
                                        autocomplete="off" validate-attribute='{"required":"true"}' maxlength="100"
                                        disabled />
                                    <div class="invalid-feedback">
                                        Hire date Require!!
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group row" style="margin-bottom:5px">
                                <label for="last_working_date" class="col-sm-4 col-form-label">ថ្ងៃបញ្ចប់ការងារ/Last
                                    Date:
                                </label>
                                <div class="col-sm-8">
                                    <input
                                        value="{{ \Carbon\Carbon::parse($exit_clearance->last_working_date)->format('M d, Y') }}"
                                        type="text" class="form-control" id="last_working_date"
                                        name="last_working_date" autocomplete="off"
                                        validate-attribute='{"required":"true"}' maxlength="100" disabled />
                                    <div class="invalid-feedback">
                                        Last date Require!!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr class="text-center">
                                <th scope="col" style="width: 40px;">ល.រ. <br> N<sup>o</sup></th>
                                <th scope="col">ការពិពណ៌នាអំពីវត្ថុ <br> Item Description</th>
                                <th scope="col" style="width: 250px;">ស្ថានភាពត្រួតពិនិត្យ <br> Verification Status
                                </th>
                                <th scope="col" colspan='2' style="width: 360px;">ហត្ថលេខា
                                    និងឈ្មោះអ្នកទទួលខុសត្រូវ <br> Name
                                    and
                                    Signature
                                    of Responsible Person</th>
                            </tr>
                        </thead>
                        <tbody id="checkListContainer_base">

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-header bg-primary-700">
                <div class="row w-100" style="display:flex;flex-direction:row;justify-content:flex-end;">
                    <button onclick="saveApproveCheckList()" type="button" class="btn btn-success">
                        Save
                    </button>

                    &nbsp;&nbsp;
                    <button onclick="printExitClearance_base({{ $exit_id }})" type="button"
                        class="btn btn-info">
                        Print
                    </button>

                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@include('exit_clearance.user_list')
@include('exit_clearance.exit_clearance_check_list_remark')

<script>
    var form_data = @json($form_data);
    $(document).ready(function() {
        console.log(form_data);

        init_form_check_list();

        $('.has-tooltip').tooltip();
    });

    var init_form_check_list = () => {
        let form_data_json = form_data.map(e => JSON.parse(e.check_list));
        form_data_json.sort(function(a, b) {
            return a.ordinal - b.ordinal;
        });

        let checkListBody = '';
        for (let i = 0; i < form_data_json.length; i++) {
            checkListBody = `${checkListBody}
                    <tr name="Bulleting"
                        data-id="${form_data_json[i].id}"
                        data-mvl-id="${form_data_json[i].id}"
                        data-order="${form_data_json[i].ordinal}">
                        <th scope="col" class="text-center text-info">${form_data_json[i].num}</th>
                        <th scope="col" colspan="4" class="text-info">${form_data_json[i].name_kh}/${form_data_json[i].name_en}</th>
                    </tr>
                `;

            form_data_json[i].check_list.sort(function(a, b) {
                return a.ordinal - b.ordinal;
            });

            form_data_json[i].check_list.forEach(
                checklist => {
                    checkListBody = `${checkListBody}
                    <tr>
                        <td scope="row" class="text-right">${checklist.ordinal}</td>
                        <td>${checklist.name_kh}/${checklist.name_en}</td>
                        <td>
                            <div class='form-group'>
                                <select class='custom-select form-control'
                                    ${checklist.is_checked==='Unavailable' || checklist.is_checked==='Checked'  || !checklist.is_allow_check?'disabled':''}
                                    data-mvl-type="Check List"
                                    data-id="${checklist.id}"
                                    data-id-parent="${form_data_json[i].id}"
                                    data-mvl-id="${checklist.id}"
                                    data-order="${checklist.ordinal}"
                                    id="aprrove ${checklist.name_en}${checklist.id}"
                                    onchange="checkListChange(event)"
                                >
                                    <option value='Unchecked'  ${checklist.is_checked==='Unchecked'?'selected':''}>Unchecked</option>
                                    <option value='Checked' ${checklist.is_checked==='Checked'?'selected':''}>បញ្ចប់រួចរាល់/Completed</option>
                                    <option value='Unavailable' ${checklist.is_checked==='Unavailable'?'selected':''}>មិនមាន/Unavailable</option>
                                </select>
                            </div>
                        </td>
                        <td class="text-info" data-mvl-type="Bulletins Checker ${form_data_json[i].value}"><a href="javascript:void(0);" onclick="showUserList(${checklist.id})" class="has-tooltip" data-template='<div class="tooltip" role="tooltip"><div class="tooltip-inner bg-primary-500"></div></div>' data-placement='right' data-toggle="tooltip" title="" data-original-title="Delegation">
                            ${checklist.emp_name}</a></td>
                        <td class="text-info">
                            <a href="javascript:void(0);" onclick="getCheckListRemark(${checklist.id})">Remark</a>
                        </td>
                    </tr>`
                }
            );
        }

        form_data = form_data_json;

        $("#checkListContainer_base").html(checkListBody);

        $("#exitClearanceCheckListBaseModal").modal();

        resizeDatatable("employeesList_base");
    }

    var showUserList = (checklist_id) => {
        $("#employeesListModal_base").modal();

        let dropUserButton = $(".dropUser").toArray();
        $("#data_id").val(checklist_id);
    }

    var dropUserToClearanceForm = async (event) => {
        let btn = event.target;
        let user = JSON.parse(btn.getAttribute('user_data'));
        let checklist_id = $("#data_id").val();

        let response = await sendAsyncData("{{ url('api/Social/checkListDelegation') }}", {
            checklist_id,
            user
        }, true);

        form_data = response;

        init_form_check_list();

        $("#employeesListModal_base").modal('hide');
    }

    var checkListChange = (event) => {
        let element = event.target;
        let check_list_id = element.getAttribute("data-id");
        let buletin_id = element.getAttribute("data-id-parent")
        let checked = element.value;

        let check_bulletin = form_data.filter(e => e.id == buletin_id)[0];
        let bulletin_index = form_data.findIndex(e => e.id == buletin_id);

        let check_list_update = check_bulletin.check_list.filter((e) => e.id == check_list_id);
        let check_list_update_index = check_bulletin.check_list.findIndex((e) => e.id == check_list_id);

        check_list_update = {
            ...check_list_update[0],
            is_checked: checked
        };

        form_data[bulletin_index].check_list[check_list_update_index] = check_list_update;
    }

    var saveApproveCheckList = async () => {
        let result = await conditionSWAlert("Do you want to save", "question", "Yes Save!")

        if (result) {
            let response = await sendAsyncData("{{ url('api/Social/saveApproveCheckList') }}", {
                form_data
            }, true);

            $("#exitClearanceCheckListBaseModal").modal('hide');

            getMyNotification();
        }
    }

    var printExitClearance_base = async (id) => {
        blockagePage('Get View ...');

        let disposalPdf = await getAsyncView('{{ url('exit_clearance/getExitClearancePDF') }}', {
            id
        });

        $("#fileView_base").html(disposalPdf);
        $("#exitClearancePDFViewModal").modal();

        unblockagePage();
    }

    var getCheckListRemark = async (id) => {
        let postData = {
            id
        };
        let response = await sendAsyncData("{{ url('api/ExitClearance/getCheckListRemark') }}", postData,
            true);

        $('#check_list_remark').attr('data-check-list-id', id);
        $('#check_list_remark').summernote("code", response);

        $('#exitClearanceCheckListRemarkBaseModal').modal();
    }

    var saveRemark = async () => {
        let htmlContent = $('#check_list_remark').summernote('code');
        let check_id = $('#check_list_remark').attr('data-check-list-id');

        if (htmlContent.length > 100000) {
            Msg('Content is too large', 'error');
            return;
        }

        postData = {
            check_id,
            htmlContent
        }

        let response = await sendAsyncData("{{ url('api/ExitClearance/saveCheckListRemark') }}", postData,
            true);

        $('#exitClearanceCheckListRemarkBaseModal').modal('hide');
    }
</script>
