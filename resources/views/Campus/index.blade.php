
<div class="container">
    <h4 class="mb-4">Campus Management</h4>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">+ Add Campus</button>

    <table class="table table-bordered" id="campusTable">
        <thead>
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

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="createForm" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Campus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="name_en" class="form-control mb-2" placeholder="Name (EN)" required>
                <input type="text" name="name_kh" class="form-control mb-2" placeholder="Name (KH)" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
    loadCampuses();

    function loadCampuses() {
        $.get('/campuses/data', function (res) {
            let rows = '';
            $.each(res.campuses, function (i, campus) {
                rows += `
                    <tr>
                        <td>${campus.id}</td>
                        <td>${campus.name_en}</td>
                        <td>${campus.name_kh}</td>
                        <td>${campus.created_by}</td>
                        <td>
                            <button class="btn btn-sm btn-info editBtn" data-id="${campus.id}">Edit</button>
                            <button class="btn btn-sm btn-danger deleteBtn" data-id="${campus.id}">Delete</button>
                        </td>
                    </tr>
                `;
            });
            $('#campusTable tbody').html(rows);
        });
    }

    $('#createForm').submit(function (e) {
        e.preventDefault();
        $.post('/campus', $(this).serialize(), function (res) {
            $('#createModal').modal('hide');
            $('#createForm')[0].reset();
            loadCampuses();
        });
    });

    $(document).on('click', '.editBtn', function () {
        let id = $(this).data('id');
        $.get(`/campus/${id}/edit`, function (res) {
            $('#editId').val(res.campus.id);
            $('#editNameEn').val(res.campus.name_en);
            $('#editNameKh').val(res.campus.name_kh);
            $('#editModal').modal('show');
        });
    });

    $('#editForm').submit(function (e) {
        e.preventDefault();
        let id = $('#editId').val();
        $.ajax({
            url: `/campus/${id}`,
            type: 'PUT',
            data: $(this).serialize(),
            success: function () {
                $('#editModal').modal('hide');
                loadCampuses();
            }
        });
    });

    $(document).on('click', '.deleteBtn', function () {
        let id = $(this).data('id');
        if (confirm('Are you sure to delete this campus?')) {
            $.ajax({
                url: `/destroyCampus/${id}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function () {
                    loadCampuses();
                }
            });
        }
    });
});
</script>
