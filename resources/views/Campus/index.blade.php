<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Campuses <span class="fw-300"><i>Table</i></span>
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- Table -->
                    <table class="table table-bordered text-center" id="campusTable">
                        <thead style="background-color: #7a59ad;color:white">
                            <tr>
                                <th>ID</th>
                                <th>Name (EN)</th>
                                <th>Name (KH)</th>
                                <th>Created By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="createForm" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Campus</h5>
            </div>
            <div class="modal-body">
                <input type="text" name="name_en" class="form-control mb-2" placeholder="Name (EN)" required>
                <input type="text" name="name_kh" class="form-control mb-2" placeholder="Name (KH)" required>
            </div>
            <div class="modal-footer">
                <button type="submit" style="background-color: #7a59ad;color:white;border:none" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm" class="modal-content">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="editId">
            <div class="modal-header">
                <h5 class="modal-title">Edit Campus</h5>
              
            </div>
            <div class="modal-body">
                <input type="text" name="name_en" id="editNameEn" class="form-control mb-2" required>
                <input type="text" name="name_kh" id="editNameKh" class="form-control mb-2" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Fetch CSRF token
    
        // Initialize DataTable
        const dataTable = $('#campusTable').DataTable({
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
                        // Reset and open the "Add Campus" modal
                        $('#createForm')[0].reset();
                        $('#createModal').modal('show');
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
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: '/campuses/data',
                type: 'GET',
                error: function (xhr) {
                    Swal.fire('Error!', 'Failed to load data. Please try again.', 'error');
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name_en', name: 'name_en' },
                { data: 'name_kh', name: 'name_kh' },
                { data: 'created_by', name: 'created_by' },
                {
                    data: null,
                    render: function (data) {
                        return `
                            <button class="btn btn-sm btn-info editBtn" data-id="${data.id}">Edit</button>
                            <button class="btn btn-sm btn-danger deleteBtn" data-id="${data.id}">Delete</button>
                        `;
                    },
                    orderable: false,
                    searchable: false
                }
            ]
        });
    
        // Handle form submission for creating a new campus
        $('#createForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: '/campus',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    $('#createModal').modal('hide');
                    $('#createForm')[0].reset();
                    dataTable.ajax.reload(); // Reload the DataTable after adding
                    Swal.fire('Success!', 'Campus created successfully.', 'success');
                },
                error: function (xhr) {
                    Swal.fire('Error!', xhr.responseJSON.message || 'Something went wrong.', 'error');
                }
            });
        });
    
        // Handle click on "Edit" button
        $(document).on('click', '.editBtn', function () {
            const id = $(this).data('id');
            $.get(`/campus/${id}/edit`, function (res) {
                $('#editId').val(res.campus.id);
                $('#editNameEn').val(res.campus.name_en);
                $('#editNameKh').val(res.campus.name_kh);
                $('#editModal').modal('show');
            }).fail(function (xhr) {
                Swal.fire('Error!', xhr.responseJSON.message || 'Failed to fetch campus details.', 'error');
            });
        });
    
        // Handle form submission for updating a campus
        $('#editForm').submit(function (e) {
            e.preventDefault();
            const id = $('#editId').val();
            $.ajax({
                url: `/campus/${id}`,
                type: 'PUT',
                data: $(this).serialize(),
                success: function (response) {
                    $('#editModal').modal('hide');
                    dataTable.ajax.reload(); // Reload the DataTable after updating
                    Swal.fire('Success!', 'Campus updated successfully.', 'success');
                },
                error: function (xhr) {
                    Swal.fire('Error!', xhr.responseJSON.message || 'Something went wrong.', 'error');
                }
            });
        });
    
        // Handle click on "Delete" button
        $(document).on('click', '.deleteBtn', function () {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this campus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/destroyCampus/${id}`,
                        type: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        success: function () {
                            Swal.fire('Deleted!', 'Campus has been deleted.', 'success').then(() => {
                                dataTable.ajax.reload(); // Reload the DataTable after deletion
                            });
                        },
                        error: function (xhr) {
                            Swal.fire('Error!', xhr.responseJSON.message || 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });
    });
    </script>