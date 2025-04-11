<style>
    /* Toggle Switch */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: 0.4s;
  border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  border-radius: 50%;
  left: 4px;
  bottom: 4px;
  background-color: white;
  transition: 0.4s;
}

input:checked + .slider {
  background-color: #4CAF50;
}

input:checked + .slider:before {
  transform: translateX(26px);
}

</style>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Abbreviations <span class="fw-300"><i>Table</i></span>
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- Datatable -->
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100 text-center">
                        <thead class="bg-primary-600">
                            <tr>
                                <th>Name</th>
                                <th>Store Code</th>
                                <th>Created By</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be dynamically populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit abbreviations Modal -->
<div class="modal fade" id="addabbreviationsModal" tabindex="-1" role="dialog" aria-labelledby="addabbreviationsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addabbreviationsModalLabel">Add New Abbreviations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Inputs for Name, Store Code, Created By, and Status -->
                <input type="hidden" id="abbreviationsId"> <!-- Hidden input for abbreviations ID -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter abbreviation name" required>
                </div>
                
                <div class="form-group">
                    <label for="store_code">Abbreviation</label>
                    <input type="text" class="form-control" id="abbreviation" placeholder="Enter abbreviation">
                </div>
                {{-- <div class="form-group">
                    <label for="created_by">Created By</label>
                    <input type="text" class="form-control" id="created_by" placeholder="Enter creator's name" required>
                </div> --}}
                <div class="form-group">
                    <label for="substore">Is SubStore</label>
                    <label class="switch">
                        <input type="checkbox" id="substore">
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="form-group" id="store_code_group" style="display: none;">
                    <label for="store_code">Store Code</label>
                    <input type="text" class="form-control" id="store_code" placeholder="Enter store code" required>
                </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveabbreviationsButton">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
$(document).ready(function () {
    document.getElementById('substore').addEventListener('change', function() {
    var storeCodeGroup = document.getElementById('store_code_group');
    if (this.checked) {
        // If checked, show the store_code input
        storeCodeGroup.style.display = 'block';
    } else {
        // If unchecked, hide the store_code input
        storeCodeGroup.style.display = 'none';
    }
});

    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    let abbreviations = []; // Array to store abbreviations data

    // Initialize DataTable
    const dataTable = $('#dt-basic-example').DataTable({
        responsive: true,
        lengthChange: true,
        paging: true,
        searching: true,
        info: true,
        pageLength: 10,
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
        dom:
            "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'B>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                text: 'Add New',
                className: 'btn btn-primary btn-sm mr-1',
                action: function (e, dt, node, config) {
                    $('#addabbreviationsModal #abbreviationsId').val('');
                    $('#addabbreviationsModal #substore').prop('checked', false);
                    $('#addabbreviationsModal #store_code_group').css("display","none");
                    $('#addabbreviationsModal #name').val('');
                    $('#addabbreviationsModal #store_code').val('');
                    $('#addabbreviationsModal #created_by').val('');
                    $('#addabbreviationsModal #status').val('1');
                    $('#addabbreviationsModalLabel').text('Add New Abbreviation');
                    $('#addabbreviationsModal').modal('show');
                    $('#addabbreviationsModal #store_code').attr("readonly", false);

                }
            },
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                titleAttr: 'Generate PDF',
                className: 'btn-outline-danger btn-sm mr-1'
            },
            {
                extend: 'excelHtml5',
                text: 'Excel',
                titleAttr: 'Generate Excel',
                className: 'btn-outline-success btn-sm mr-1'
            },
            {
                extend: 'csvHtml5',
                text: 'CSV',
                titleAttr: 'Generate CSV',
                className: 'btn-outline-primary btn-sm mr-1'
            },
            {
                extend: 'copyHtml5',
                text: 'Copy',
                titleAttr: 'Copy to clipboard',
                className: 'btn-outline-primary btn-sm mr-1'
            },
            {
                extend: 'print',
                text: 'Print',
                titleAttr: 'Print Table',
                className: 'btn-outline-primary btn-sm'
            }
        ]
    });

    // Function to render abbreviations data into the table
    function renderAbbreviations(data) {
        dataTable.clear(); 
        data.forEach(abbreviation => {
            const statusBadge = abbreviation.status
                ? `<span class="badge badge-success">Active</span>`
                : `<span class="badge badge-danger">Inactive</span>`;
            const actions = `
                <button class="btn btn-sm btn-info edit-btn" data-id="${abbreviation.id}" data-toggle="modal" data-target="#addabbreviationsModal">
                    <i class="fa fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-danger delete-btn" data-id="${abbreviation.id}">
                    <i class="fa fa-trash"></i> Delete
                </button>
            `;
            if(abbreviation.store_code!=null)
            {
                var code=abbreviation.store_code;
            }
            else{
                code='N/A'
            }
            dataTable.row.add([
                abbreviation.name,
                code,
                abbreviation.created_by,
                statusBadge,
                actions
            ]);
        });
        dataTable.draw(); 
    }



    function fetchAbbreviations() {
        $.ajax({
            url: '/abbreviations/data',
            method: 'GET',
            success: function (response) {
                abbreviations = response.abbreviations;
                renderAbbreviations(abbreviations);
            },
            error: function (xhr, status, error) {
                Swal.fire(
                    'Error!',
                    'Failed to fetch abbreviations data.',
                    'error'
                );
            }
        });
    }

    // Initial fetch of abbreviations
    fetchAbbreviations();

    // Save abbreviation (Add or Update)
    $(document).on('click', '#saveabbreviationsButton', function () {
        const abbreviationId = $('#abbreviation').val();
        const name = $('#name').val();
        const store_code = $('#store_code').val();
        let substore = $('#substore').prop('checked'); 
      
        if (substore) {
            substore = true; 
        } else {
            substore = false; 
        }

        if (!name || !store_code) {
            Swal.fire('Error!', 'Please fill in all fields.', 'error');
            return;
        }

        let url = '/abbreviations';
        let method = 'POST';

        if (abbreviationId) {
            url = `/abbreviations/${abbreviationId}`;
            method = 'PUT';
        }

        $.ajax({
            url: url,
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                name: name,
                store_code: store_code,
                substore : substore
            },
            success: function (response) {
                if (response.message) {
                    Swal.fire(
                        'Success!',
                        abbreviationId ? 'Abbreviation updated successfully!' : 'Abbreviation added successfully!',
                        'success'
                    ).then(() => {
                        fetchAbbreviations(); 
                        $('#addabbreviationsModal').modal('hide'); // Close the modal
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.fire(
                    'Error!',
                    'Failed to save abbreviation.',
                    'error'
                );
            }
        });
    });

    // Edit abbreviation - Pre-fill form data in the modal
    $(document).on('click', '.edit-btn', function () {
        const abbreviationId = $(this).data('id');
        const abbreviation = abbreviations.find(abbr => abbr.id === abbreviationId);
        if (abbreviation) {
            $('#addabbreviationsModal #abbreviation').val(abbreviation.abbreviation);
            $('#addabbreviationsModal #name').val(abbreviation.name);       
            $('#addabbreviationsModal #created_by').val(abbreviation.created_by);
            $('#addabbreviationsModal #store_code').val(abbreviation.store_code);
            $('#addabbreviationsModal #store_code').attr("readonly", true);
            if (abbreviation.is_sub) {
                $('#addabbreviationsModal #substore').prop('checked', true);
                $('#addabbreviationsModal #store_code_group').css("display","block");
            } else {
                $('#addabbreviationsModal #substore').prop('checked', false);
                $('#addabbreviationsModal #store_code_group').css("display","none");

            }

            $('#addabbreviationsModal #status').val(abbreviation.status ? '1' : '0');
            $('#addabbreviationsModalLabel').text('Edit Abbreviation');
        }
    });

    // Delete abbreviation
    $(document).on('click', '.delete-btn', function () {
        const abbreviationId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: `/destroyabbreviations/${abbreviationId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        Swal.fire(
                            'Deleted!',
                            'The abbreviation has been deleted.',
                            'success'
                        );
                        fetchAbbreviations(); // Reload the table
                    },
                    error: function (xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'Failed to delete abbreviation.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});

</script>