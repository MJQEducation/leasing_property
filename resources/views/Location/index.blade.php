
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
<!-- Add Location Button -->
<button class="btn btn-primary mb-3" id="openAddModal">
  <i class="fa fa-plus"></i> Add Location
</button>

<!-- Table -->
<table id="dt-basic-example" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Name (English)</th>
      <th>Name (Khmer)</th>
      <th>Status</th>
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
<!-- Add/Edit Modal -->
<div class="modal fade" id="addLocationModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addLocationModalLabel">Add Location</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="locationId">
          <div class="mb-3">
            <label for="name_en">Name (English)</label>
            <input type="text" class="form-control" id="name_en">
          </div>
          <div class="mb-3">
            <label for="name_kh">Name (Khmer)</label>
            <input type="text" class="form-control" id="name_kh">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="saveLocationButton" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
<script>
  $(document).ready(function () {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    const dataTable = $('#dt-basic-example').DataTable();

    function fetchLocations() {
      $.get('/locations/data', function (response) {
        renderLocations(response.locations);
      });
    }

    function renderLocations(data) {
      dataTable.clear();
      data.forEach(location => {
        const statusBadge = location.status
          ? `<span class="badge bg-success">Active</span>`
          : `<span class="badge bg-danger">Inactive</span>`;

        const actions = `
          <button class="btn btn-sm btn-info edit-btn" data-id="${location.id}">
            <i class="fa fa-edit"></i> Edit
          </button>
          <button class="btn btn-sm btn-danger delete-btn" data-id="${location.id}">
            <i class="fa fa-trash"></i> Delete
          </button>
        `;

        dataTable.row.add([
          location.name_en,
          location.name_kh,
          statusBadge,
          actions
        ]);
      });
      dataTable.draw();
    }

    fetchLocations();

    // Open Add Modal and reset fields
    $('#openAddModal').on('click', function () {
      $('#addLocationModalLabel').text('Add Location');
      $('#locationId').val('');
      $('#name_en').val('');
      $('#name_kh').val('');
      const modal = new bootstrap.Modal(document.getElementById('addLocationModal'));
      modal.show();
    });

    // Save (Add or Edit)
    $('#saveLocationButton').on('click', function () {
      const id = $('#locationId').val();
      const name_en = $('#name_en').val();
      const name_kh = $('#name_kh').val();

      if (!name_en || !name_kh) {
        Swal.fire('Error!', 'Please fill in all fields.', 'error');
        return;
      }

      const url = id ? `/location/${id}` : '/location';
      const method = id ? 'PUT' : 'POST';

      $.ajax({
        url: url,
        method: method,
        headers: { 'X-CSRF-TOKEN': csrfToken },
        data: { name_en, name_kh },
        success: function (response) {
          Swal.fire('Success!', response.message, 'success').then(() => {
            bootstrap.Modal.getInstance(document.getElementById('addLocationModal')).hide();
            fetchLocations();
          });
        },
        error: () => Swal.fire('Error!', 'Something went wrong.', 'error')
      });
    });

    // Edit button click
    $(document).on('click', '.edit-btn', function () {
      const id = $(this).data('id');
      $.get(`/location/${id}/edit`, function (response) {
        $('#locationId').val(response.location.id);
        $('#name_en').val(response.location.name_en);
        $('#name_kh').val(response.location.name_kh);
        $('#addLocationModalLabel').text('Edit Location');
        const modal = new bootstrap.Modal(document.getElementById('addLocationModal'));
        modal.show();
      });
    });

    // Delete button click
    $(document).on('click', '.delete-btn', function () {
        let selectedUserId = $(`#${elementName}`).val();
console.log("Selected User ID:", selectedUserId);

      const id = $(this).data('id');    
      Swal.fire({
        title: `Delete location ${id}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
      }).then(result => {
        if (result.value) {
          $.ajax({
            url: `/destroyLocation/${id}`,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: () => {
              Swal.fire('Deleted!', 'Location deleted.', 'success').then(() => {
                fetchLocations();
              });
            }
          });
        }
      });
    });
  });
</script>
