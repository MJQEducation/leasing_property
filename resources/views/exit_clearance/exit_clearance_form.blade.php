<div class="container py-4">
    <div class="row justify-content-between border p-2">
        <img src="{{ asset('files/sysimg/invoiceMJQE.png') }}" height="72" alt="">
        <span class="text-right">
            Code <br> Version 3.0
        </span>
    </div>
    <div class="row flex-column text-center border pt-2">
        <h4>ទម្រង់ចាកចេញពីការងារ</h4>
        <h4>Lease Property FORM</h4>
    </div>
    <div class="row border pt-2 px-2">
        <p class="text-justify">ទម្រង់នេះ គឺនឹងត្រូវប្រើនៅពេលដែលបុគ្គលិកណាម្នាក់បានឈប់ពីការងារ។
            ប្រធានផ្នែករបស់បុគ្គលិកត្រូវបំពេញទម្រង់នេះ ជាមួយផ្នែកដែលពា់ព័ន្ធនៅថ្ងៃធ្វើការចុងក្រោយ
            ដើម្បីធានាថាបុគ្គលិកបានប្រគល់ទ្រព្យសម្បត្តិក្រុមហ៊ុន និងដោះស្រាយបញ្ហាដែលមិនទាន់ដោះស្រាយ
            មុនពេលដែលបានចុះហត្ថលេខា។ ទម្រង់ដែលបានបំពេញទាំងអស់
            ត្រូវដាក់ជូនផ្នែកធនធានមនុស្ស មុនពេលការទូទាត់ប្រាក់ខែចុចក្រោយ។
        </p>
        <p class="text-justify">
            This form is to be completed whenever any employee terminate his/her employment. Employee's line manager has
            to complete
            his/her employee's clearance with the related departments on his/her last employment in order to ensure that
            the employee
            returns all company's assets and solve outstanding matters before before signing off. All duly completed
            forms should be
            submitted to the Human Resources Department before the last payment will be related.
        </p>
    </div>

    <div class="row border pt-2 px-2">
        <form id='employeeInfoForm' class='w-100'>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group row" style="margin-bottom:5px">
                        <label for="card_id" class="col-sm-4 col-form-label">អត្តលេខ/ID :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="card_id" name="card_id" autocomplete="off"
                                onblur="existUser(event);getExitEmployeeInfo(event);"
                                validate-attribute='{"required":"true"}' maxlength="20" />
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
                            <input type="text" class="form-control" id="emp_id" name="emp_id" autocomplete="off"
                                validate-attribute='{"required":"true"}' maxlength="20" />
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
                            <input type="text" class="form-control" id="name" name="name" autocomplete="off"
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
                            <input type="text" class="form-control" id="position" name="position" autocomplete="off"
                                validate-attribute='{"required":"true"}' maxlength="100" />
                            <div class="invalid-feedback">
                                Position is Require!!
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group row">
                        <label for="department" class="col-sm-4 col-form-label">សាខា/ផ្នែក/Campus/Dept:</label>
                        <div class="col-sm-8">
                            <select class="custom-select form-control"id="department" name="department"
                                autocomplete="off" validate-attribute='{"required":"true"}'>

                                <?php
                                foreach ($departments as $department) {
                                    echo "<option value='$department->abbreviation'>$department->abbreviation</option>";
                                }
                                ?>
                            </select>


                            <div class="invalid-feedback">
                                Department is Require!!
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group row" style="margin-bottom:5px">
                        <label for="line_management" class="col-sm-4 col-form-label">ឈ្មោះប្រធាន/Line Manager's
                            Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="line_management" name="line_management"
                                autocomplete="off" validate-attribute='{"required":"true"}' maxlength="100" />
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
                            <input type="text" class="form-control" id="email" name="email"
                                autocomplete="off" validate-attribute='{"required":"false"}' maxlength="100" />
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
                            <input type="text" class="form-control" id="phone" name="phone"
                                autocomplete="off" validate-attribute='{"required":"false"}' maxlength="100" />
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
                            <input type="text" class="form-control" id="hired_date" name="hired_date"
                                autocomplete="off" validate-attribute='{"required":"true"}' maxlength="100" />
                            <div class="invalid-feedback">
                                Hire date Require!!
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group row" style="margin-bottom:5px">
                        <label for="last_working_date" class="col-sm-4 col-form-label">ថ្ងៃបញ្ចប់ការងារ/Last Date:
                        </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="last_working_date"
                                name="last_working_date" autocomplete="off" validate-attribute='{"required":"true"}'
                                maxlength="100" />
                            <div class="invalid-feedback">
                                Last date Require!!
                            </div>
                        </div>
                    </div>
                </div>

                <input style="display:none!important" type="text" class="form-control" id="id"
                    autocomplete="off" validate-attribute='{"required":"true"}' value="0" />
            </div>
        </form>
    </div>

    <div class="row">
        <table class="table table-bordered mb-0">
            <thead>
                <tr class="text-center">
                    <th scope="col" style="width: 40px;">ល.រ. <br> N<sup>o</sup></th>
                    <th scope="col">ការពិពណ៌នាអំពីវត្ថុ <br> Item Description</th>
                    <th scope="col" style="width: 250px;">ស្ថានភាពត្រួតពិនិត្យ <br> Verification Status</th>
                    <th scope="col" style="width: 360px;">ហត្ថលេខា និងឈ្មោះអ្នកទទួលខុសត្រូវ <br> Name and Signature
                        of Responsible Person</th>
                </tr>
            </thead>
            <tbody id="checkListContainer">

            </tbody>
        </table>
    </div>

    <br />

    <form id="employeeApprovalForm" class='w-100'>
        <div class="row">
            <div id="panel-1" class="panel w-100" style="margin-bottom:10px">
                <div class="panel-hdr">
                    <h2>
                        <span class="fw-300"></span>
                    </h2>
                    <div class="panel-toolbar">
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class='col-sm-12 col-md-6 col-lg-6'>
                                <div class="card mb-2" style="margin-bottom:0!important">
                                    <div class="card-body">

                                        <div style="display:flex;flex-direction:row;">
                                            <div style="flex-grow:1;align-self:center">

                                                <a href="javascript:void(0);" onclick="viewUserPhoto(event)">
                                                    <img src="data:image/jpeg;base64,{{ $noPhoto }}"
                                                        class="profile-image rounded-circle" name="approverImg" />
                                                </a>
                                            </div>

                                            <div style="display:flex;flex-direction:column;flex-grow:5;">
                                                <label for="personnelOfficer"
                                                    class="d-flex align-items-center">រៀបចំដោយ /
                                                    Prepared by:</label>

                                                <select class="form-control border-0 w-100" id="personnelOfficer"
                                                    name="personnelOfficer" validate-attribute='{"required":"true"}'
                                                    style="height: 42px!important"></select>
                                                <div class="invalid-feedback">
                                                    Personnel officer Require!!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-sm-12 col-md-6 col-lg-6'>
                                <div class="card mb-2" style="margin-bottom:0!important">
                                    <div class="card-body">

                                        <div style="display:flex;flex-direction:row;">
                                            <div style="flex-grow:1;align-self:center">

                                                <a href="javascript:void(0);" onclick="viewUserPhoto(event)">
                                                    <img src="data:image/jpeg;base64,{{ $noPhoto }}"
                                                        class="profile-image rounded-circle" name="approverImg" />
                                                </a>
                                            </div>

                                            <div style="display:flex;flex-direction:column;flex-grow:5;">
                                                <label for="lineManager"
                                                    class="d-flex align-items-center">ត្រូតពិនិត្យដោយ
                                                    / Checked by
                                                    :</label>

                                                <select class="form-control border-0 w-100" id="lineManager"
                                                    name="lineManager" validate-attribute='{"required":"true"}'
                                                    style="height: 42px!important"></select>
                                                <div class="invalid-feedback">
                                                    Line Manager Require!!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="panel-1" class="panel w-100" style="margin-bottom:10px">
                <div class="panel-hdr">
                    <h2>
                        <span class="fw-300"></span>
                    </h2>
                    <div class="panel-toolbar">
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class='col-sm-12 col-md-6 col-lg-6'>
                                <div class="card mb-2" style="margin-bottom:0!important">
                                    <div class="card-body">

                                        <div style="display:flex;flex-direction:row;">
                                            <div style="flex-grow:1;align-self:center">

                                                <a href="javascript:void(0);" onclick="viewUserPhoto(event)">
                                                    <img src="data:image/jpeg;base64,{{ $noPhoto }}"
                                                        class="profile-image rounded-circle" name="approverImg" />
                                                </a>
                                            </div>

                                            <div style="display:flex;flex-direction:column;flex-grow:5;">
                                                <label for="employeeSignature"
                                                    class="d-flex align-items-center">បុគ្គលិក
                                                    / Employee </label>

                                                <select class="form-control border-0 w-100" id="employeeSignature"
                                                    name="employeeSignature" validate-attribute='{"required":"true"}'
                                                    style="height: 42px!important"></select>
                                                <div class="invalid-feedback">
                                                    Employee is Require!!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-sm-12 col-md-6 col-lg-6'>
                                <div class="card mb-2" style="margin-bottom:0!important">
                                    <div class="card-body">

                                        <div style="display:flex;flex-direction:row;">
                                            <div style="flex-grow:1;align-self:center">

                                                <a href="javascript:void(0);" onclick="viewUserPhoto(event)">
                                                    <img src="data:image/jpeg;base64,{{ $noPhoto }}"
                                                        class="profile-image rounded-circle" name="approverImg" />
                                                </a>
                                            </div>

                                            <div style="display:flex;flex-direction:column;flex-grow:5;">
                                                <label for="hodRepresentative"
                                                    class="d-flex align-items-center">អនុម័តដោយ
                                                    ប្រធានផ្នែក
                                                    ឬអ្នកតំណាង / Endorsed by HoD or Authorized :</label>

                                                <select class="form-control border-0 w-100" id="hodRepresentative"
                                                    name="hodRepresentative" validate-attribute='{"required":"true"}'
                                                    style="height: 42px!important"></select>
                                                <div class="invalid-feedback">
                                                    Person in Charge Require!!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="panel-1" class="panel w-100" style="margin-bottom:10px">
                <div class="panel-hdr">
                    <h2>
                        <span class="fw-300"></span>
                    </h2>
                    <div class="panel-toolbar">
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class='col-sm-12 col-md-6 col-lg-6'>
                                <div class="card mb-2" style="margin-bottom:0!important">
                                    <div class="card-body">

                                        <div style="display:flex;flex-direction:row;">
                                            <div style="flex-grow:1;align-self:center">

                                                <a href="javascript:void(0);" onclick="viewUserPhoto(event)">
                                                    <img src="data:image/jpeg;base64,{{ $noPhoto }}"
                                                        class="profile-image rounded-circle" name="approverImg" />
                                                </a>
                                            </div>

                                            <div style="display:flex;flex-direction:column;flex-grow:5;">
                                                <label for="CDSignature" class="d-flex align-items-center">អនុម័តដោយ
                                                    នាយកសាលា ឬអ្នកតំណាង /
                                                    Endorsed by Campus Director or Authorized : </label>

                                                <select class="form-control border-0 w-100" id="CDSignature"
                                                    name="CDSignature" validate-attribute='{"required":"false"}'
                                                    style="height: 42px!important"></select>
                                                <div class="invalid-feedback">
                                                    Person in Charge Require!!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-sm-12 col-md-6 col-lg-6'>
                                <div class="card mb-2" style="margin-bottom:0!important">
                                    <div class="card-body">

                                        <div style="display:flex;flex-direction:row;">
                                            <div style="flex-grow:1;align-self:center">

                                                <a href="javascript:void(0);" onclick="viewUserPhoto(event)">
                                                    <img src="data:image/jpeg;base64,{{ $noPhoto }}"
                                                        class="profile-image rounded-circle" name="approverImg" />
                                                </a>
                                            </div>

                                            <div style="display:flex;flex-direction:column;flex-grow:5;">
                                                <label for="principalSignature"
                                                    class="d-flex align-items-center">អនុម័តដោយ ចាងហ្វាង ឬអ្នកតំណាង /
                                                    Endorsed by Principle or Authorized :</label>

                                                <select class="form-control border-0 w-100" id="principalSignature"
                                                    name="principalSignature"
                                                    validate-attribute='{"required":"false"}'
                                                    style="height: 42px!important"></select>
                                                <div class="invalid-feedback">
                                                    Person in Charge Require!!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="panel-1" class="panel w-100">
                <div class="panel-hdr">
                    <h2>
                        <span class="fw-300">ផ្នែកធនធានមនុស្ស / Human Resources Department Only</span>
                    </h2>
                    <div class="panel-toolbar">
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class='col-sm-12 col-md-6 col-lg-6'>
                                <div class="card mb-2" style="margin-bottom:0!important">
                                    <div class="card-body">

                                        <div style="display:flex;flex-direction:row;">
                                            <div style="flex-grow:1;align-self:center">

                                                <a href="javascript:void(0);" onclick="viewUserPhoto(event)">
                                                    <img src="data:image/jpeg;base64,{{ $noPhoto }}"
                                                        class="profile-image rounded-circle" name="approverImg" />
                                                </a>
                                            </div>

                                            <div style="display:flex;flex-direction:column;flex-grow:5;">
                                                <label for="hrDepartment"
                                                    class="d-flex align-items-center">ទទួលដោយ/Received by:</label>

                                                <select class="form-control border-0 w-100" id="hrDepartment"
                                                    name="hrDepartment" validate-attribute='{"required":"true"}'
                                                    style="height: 42px!important"></select>
                                                <div class="invalid-feedback">
                                                    HR Received Require!!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='col-sm-12 col-md-6 col-lg-6'>
                                <div class="card mb-2" style="margin-bottom:0!important">
                                    <div class="card-body">

                                        <div style="display:flex;flex-direction:row;">
                                            <div style="display:flex;flex-direction:column;flex-grow:1;">
                                                <div class="form-group">
                                                    <label class="form-label" for="example-textarea">សម្គាល់ /
                                                        Remark</label>
                                                    <textarea class="form-control" id="remark" rows="2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <br />

    <div class="row">
        <button class="btn btn-primary" onclick="saveExitClearance()">Save Lease Property</button>
        &nbsp;
        <button class="btn btn-danger" onclick="clearForm()">Clear</button>
    </div>
</div>
