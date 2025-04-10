<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Store <span class="fw-300"><i>Table</i></span>
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
                                <th>Store Code</th>
                                <th>Abbreviation</th>
                                <th>Name</th>
                                <th>Name Khmer</th>
                                <th>Campus</th>
                                <th>Location</th>
                                <th>Store Type</th>
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

<!-- Add/Edit Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">Store Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Hidden input for Store ID -->
                <input type="hidden" id="storeId">

                <div class="form-group">
                    <label for="name">Store Name (EN)</label>
                    <input type="text" class="form-control" id="name" placeholder="Store name in English" required>
                </div>
                <div class="form-group">
                    <label for="name_kh">Store Name (KH)</label>
                    <input type="text" class="form-control" id="name_kh" placeholder="Store name in Khmer">
                </div>
                <div class="form-group">
                    <label for="abbreviation">abbreviation</label>
                    <select class="form-control" id="abbreviation">
                    </select>
                </div>
                <div class="form-group">
                    <label for="store_code">Store Code</label>
                    <input type="text" class="form-control" id="store_code" placeholder="e.g. AFC001">
                </div>
                <div class="form-group">
                    <label for="campus">Campus</label>
                    <select class="form-control" id="campus">
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="location">Location</label>
                    <select class="form-control" id="location">
                    </select>
                </div>
                
                {{-- <div class="form-group">
                    <label for="is_sub">Store Type</label>
                    <select class="form-control" id="is_sub">
                        <option value="true">Store</option>
                        <option value="false">Sub Store</option>
                    </select>
                </div> --}}
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveCustomerButton">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
    
    function clearAddCustomerModal() {
    $('#storeId').val('');
    $('#name').val('');
    $('#name_kh').val('');
    $('#abbreviation').val('');
    $('#store_code').val('');
    $('#campus').empty(); 
    $('#location').empty(); 


    $('#is_sub').val('store'); 
    $('#status').val('true'); 
}

  $(document).ready(function () {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    let customers = []; // Array to store customer data


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
                    $('#addCustomerModal #storeId').val('');
                    $('#addCustomerModal #name').val('');
                    $('#addCustomerModal #name_kh').val('');
                    
                    $('#addCustomerModal #abbreviation').val('');
                    $('#addCustomerModal #store_code').val('');
                    $('#addCustomerModal #campus').val(1); 
                    $('#addCustomerModal #location').val(1); 

                    $('#addCustomerModal #status').val('true'); 

                    $('#addCustomerModal #addCustomerModalLabel').text('Add New Store');
                    $('#addCustomerModal').modal('show');
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

    // Function to render customer data into the table
        function renderCustomers(data) {
            dataTable.clear(); // Clear existing rows
            data.forEach(store => {
                const statusBadge = `<span class="badge ${store.is_store === 'store' ? 'badge-danger' : 'badge-success'}">${store.is_store === 'store' ? 'Store' : 'Sub Store'}</span>`;


                const actions = `
                    <button class="btn btn-sm btn-info edit-btn" 
                            data-id="${store.id}" 
                            data-store-type="${store.is_store}" 
                            data-toggle="modal" 
                            data-target="#addCustomerModal">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-danger delete-btn" data-store-type="${store.is_store}" data-id="${store.id}">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                `;
                dataTable.row.add([
                    store.store_code,
                    store.abbreviation,
                    store.name_en,
                    store.name_kh,
                    store.campus,
                    store.location,
                    statusBadge,
                    actions
                ]);
            });
            dataTable.draw(); 
        }


function fetchCustomers() {
    $.ajax({
        url: '/stores/data',
        method: 'GET',
        success: function (response) {
        const stores = response.stores; 
        renderCustomers(stores); 

        // Dropdown elements
        const campusSelect = $('#campus');
        const locationSelect = $('#location');
        const abbreviationSelect = $('#abbreviation');

        // Clear previous options
        campusSelect.empty();
        locationSelect.empty();
        abbreviationSelect.empty();

        // Populate Campus dropdown
        if (Array.isArray(response.campus)) {
            response.campus.forEach(function(campus) {
                campusSelect.append(new Option(campus.name_en, campus.id));
            });
        } else {
            console.log("Campus data is not an array:", response.campus);
        }
        console.log(response.abbreviation);
        if (Array.isArray(response.abbreviation)) {
            response.abbreviation.forEach(function(abbreviation) {
                abbreviationSelect.append(
                new Option(`${abbreviation.abbreviation} (${abbreviation.is_sub ? 'Store' : 'Sub Store'})`, abbreviation.id)
            );
            });
        } else {
            console.log("Campus data is not an array:", response.abbreviation);
        }

        // Populate Location dropdown
        if (Array.isArray(response.location)) {
            response.location.forEach(function(location) {
                locationSelect.append(new Option(location.name_en, location.id));
            });
        } else {
            console.log("Location data is not an array:", response.location);
        }

        // Set default values for the first store
        if (stores.length > 0) {
            const store = stores[0];

            // Set form fields
            $('#storeId').val(store.id);
            $('#name').val(store.name_en);
            $('#name_kh').val(store.name_kh);
            $('#abbreviation').val(store.abbreviation);
            $('#store_code').val(store.store_code);
            $('#status').val(store.status ? 'true' : 'false'); 
            $('#is_sub').val(store.type);
            $('#campus').val(store.campus_id); 
            $('#location').val(store.location_id); 
        }
},
        error: function (xhr, status, error) {
            Swal.fire(
                'Error!',
                'Failed to fetch customer data.',
                'error'
            );
        }
    });
}


    // Initial fetch of customers
    fetchCustomers();

    // Save Customer (Add or Update)
    $(document).on('click', '#saveCustomerButton', function () {
    const storeId = $('#storeId').val();
    const nameEn = $('#name').val().trim();
    const nameKh = $('#name_kh').val().trim();
    const abbreviation = $('#abbreviation').val().trim();
    const storeCode = $('#store_code').val().trim();
    const campusId = $('#campus').val(); // Selected campus ID
    const locationId = $('#location').val(); // Selected location ID
    const isSub = $('#is_sub').val(); // Store type: 'store' or 'substore'
    const status = $('#status').val(); // Status: 'true' or 'false'

    // Basic client-side validation
    if (!nameEn || !abbreviation || !storeCode || !campusId || !locationId) {
        Swal.fire('Error!', 'Please fill in all required fields.', 'error');
        return;
    }

    // Determine the URL and method for the AJAX request
    let url = '/store';
    let method = 'POST';

    if (storeId) {
        url = `/store/${storeId}`;
        method = 'PUT';
    }

    // Send the AJAX request
    $.ajax({
        url: url,
        method: method,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            id: storeId, // Include the store ID for updates
            name_en: nameEn,
            name_kh: nameKh,
            abbreviation: abbreviation,
            store_code: storeCode,
            campus_id: campusId,
            location_id: locationId,
            is_store: isSub, // Store type: 'store' or 'substore'
            status: status === 'true' // Convert status to boolean
        },
        success: function (response) {
            if (response.message) {
                Swal.fire(
                    'Success!',
                    storeId ? 'Store updated successfully!' : 'Store added successfully!',
                    'success'
                ).then(() => {
                    fetchCustomers(); // Refresh the table with updated data
                    $('#addCustomerModal').modal('hide'); // Close the modal
                });
            } else {
                Swal.fire(
                    'Error!',
                    'There was an issue saving the store data.',
                    'error'
                );
            }
        },
        error: function (xhr, status, error) {
            Swal.fire(
                'Error!',
                'There was an issue saving the store data.',
                'error'
            );
        }
    });
});

    // Edit store
    $(document).on('click', '.edit-btn', function () {
    const storeId = $(this).data('id');
    const storeType = $(this).data('store-type'); // Get storeType from the button's data attribute

    // Send the storeId as part of the URL and storeType as a query string
    $.ajax({
        url: `/store/${storeId}/edit?storeType=${storeType}`, // Query param in the URL
        method: 'GET',
        success: function(response) {
            const store = response.store;

            $('#storeId').val(store.id); 
            $('#name').val(store.name_en); 

            $('#name_kh').val(store.name_kh); 

            $('#abbreviation').val(store.abbreviation); 

            $('#store_code').val(store.store_code); 

            $('#campus').val(store.campus_id); 

            $('#location').val(store.location_id); 

            $('#is_sub').val(store.is_store === 'store' ? 'store' : 'substore');

            $('#status').val(store.status ? 'true' : 'false');
        },
        error: function(error) {
            console.error(error);
        }
    });
});


    // Delete Customer
    $(document).on('click', '.delete-btn', function () {
        const customerId = $(this).data('id');
        Swal.fire({
            title: `Are you sure to delete customer with id ${customerId}?`,
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then((result) => {
            if (result.draw) {
                $.ajax({
                    url: `/destroyCustomer/${customerId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        Swal.fire(
                            'Deleted!',
                            'The customer has been deactivated.',
                            'success'
                        ).then(() => {
                            fetchCustomers(); // Refresh the table after successful deletion
                        });
                    },
                    error: function (xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'Failed to deactivate customer.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>