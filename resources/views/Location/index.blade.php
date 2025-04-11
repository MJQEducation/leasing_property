<div class="row">
  <div class="col-xl-12">
      <div id="panel-1" class="panel">
          <div class="panel-hdr">
              <h2>
                  Locations <span class="fw-300"><i>Table</i></span>
              </h2>
              <div class="panel-toolbar">
                  <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse">

                  </button>
                  <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen">
       
                  </button>
                  <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close">
 
                  </button>
              </div>
          </div>
          <div class="panel-container show">
              <div class="panel-content">
                  <!-- Table -->
                  <table class="table table-bordered text-center" id="locationTable">
                      <thead style="background-color: #7a59ad;color:white">
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
  <div class="modal-dialog modal-dialog-centered">
      <form id="addLocationForm" class="modal-content">
          @csrf
          <div class="modal-header">
              <h5 class="modal-title" id="addLocationModalLabel">Add Location</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <input type="hidden" name="id" id="locationId">
              <div class="mb-3">
                  <label for="name_en" class="form-label">Name (English)</label>
                  <input type="text" name="name_en" id="name_en" class="form-control" placeholder="Enter English name" required>
              </div>
              <div class="mb-3">
                  <label for="name_kh" class="form-label">Name (Khmer)</label>
                  <input type="text" name="name_kh" id="name_kh" class="form-control" placeholder="Enter Khmer name" required>
              </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Save</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
      </form>
  </div>
</div>

<script>
  $(document).ready(function () {
      const csrfToken = $('meta[name="csrf-token"]').attr('content');
  
      // Initialize DataTable
      const dataTable = $('#locationTable').DataTable({
    responsive: true,
    lengthChange: true,
    paging: true,
    searching: true,
    info: true,
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50],
    dom:
        "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'B>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    buttons: [
        {
            text: 'Add New',
            className: 'btn btn-primary btn-sm mr-1',
            action: function (e, dt, node, config) {
                $('#addLocationForm')[0].reset();
                $('#addLocationModalLabel').text('Add Location');
                $('#addLocationModal').modal('show');
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
        url: '/locations/data',
        type: 'GET',
        error: function (xhr) {
            console.error('Error fetching data:', xhr.responseText);
            Swal.fire('Error!', 'Failed to load data. Please try again.', 'error');
        }
    },
    columns: [
        { data: 'name_en', name: 'name_en' },
        { data: 'name_kh', name: 'name_kh' },
        {
            data: 'status',
            render: function (data) {
                return data
                    ? `<span class="badge bg-success">Active</span>`
                    : `<span class="badge bg-danger">Inactive</span>`;
            },
            orderable: true,
            searchable: true
        },
        {
            data: null,
            render: function (data) {
                return `
                    <button class="btn btn-sm btn-info editBtn" data-id="${data.id}">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="${data.id}">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                `;
            },
            orderable: false,
            searchable: false
        }
    ]
});
  
      // Handle form submission for creating or updating a location
      $('#addLocationForm').submit(function (e) {
          e.preventDefault();
          const id = $('#locationId').val();
          const url = id ? `/location/${id}` : '/location';
          const method = id ? 'PUT' : 'POST';
  
          $.ajax({
              url: url,
              method: method,
              headers: { 'X-CSRF-TOKEN': csrfToken },
              data: $(this).serialize(),
              success: function (response) {
                  Swal.fire('Success!', response.message, 'success').then(() => {
                      $('#addLocationModal').modal('hide');
                      dataTable.ajax.reload();
                  });
              },
              error: function (xhr) {
                  Swal.fire('Error!', xhr.responseJSON.message || 'Something went wrong.', 'error');
              }
          });
      });
  
      // Handle click on "Edit" button
      $(document).on('click', '.editBtn', function () {
          const id = $(this).data('id');
          $.get(`/location/${id}/edit`, function (response) {
              $('#locationId').val(response.location.id);
              $('#name_en').val(response.location.name_en);
              $('#name_kh').val(response.location.name_kh);
              $('#addLocationModalLabel').text('Edit Location');
              $('#addLocationModal').modal('show');
          }).fail(function (xhr) {
              Swal.fire('Error!', xhr.responseJSON.message || 'Failed to fetch location details.', 'error');
          });
      });
  
      // Handle click on "Delete" button
      $(document).on('click', '.deleteBtn', function () {
          const id = $(this).data('id');
          Swal.fire({
              title: 'Are you sure?',
              text: 'You will not be able to recover this location!',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
              if (result.value) {
                  $.ajax({
                      url: `/destroyLocation/${id}`,
                      method: 'DELETE',
                      headers: { 'X-CSRF-TOKEN': csrfToken },
                      success: function () {
                          Swal.fire('Deleted!', 'Location has been deleted.', 'success').then(() => {
                              dataTable.ajax.reload();
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