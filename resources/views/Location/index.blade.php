<!-- Add Location Modal -->
<div class="modal fade" id="addLocationModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="addLocationModalLabel">Add Location</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="locationId">
          <div class="mb-3">
            <label>Name (English)</label>
            <input type="text" class="form-control" id="name_en">
          </div>
          <div class="mb-3">
            <label>Name (Khmer)</label>
            <input type="text" class="form-control" id="name_kh">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="saveLocationButton" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
  
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
              $('#addLocationModal').modal('hide');
              $('#addLocationModalLabel').text('Add Location');
              $('#locationId').val('');
              $('#name_en').val('');
              $('#name_kh').val('');
              fetchLocations();
            });
          },
          error: () => Swal.fire('Error!', 'Something went wrong.', 'error')
        });
      });
    
      $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        $.get(`/location/${id}/edit`, function (response) {
            $('#locationId').val(response.location.id);
            $('#name_en').val(response.location.name_en);
            $('#name_kh').val(response.location.name_kh);
            $('#addLocationModalLabel').text('Edit Location');
            $('#addLocationModal').modal('show');
        });
        });

    
        $(document).on('click', '.delete-btn', function () {
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
          Swal.fire('Deleted!', 'Location deactivated.', 'success').then(() => {
            fetchLocations();
          });
        }
      });
    }
  });
});

    });
    </script>
    