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

<!-- Add/Edit store Modal -->
<div class="modal fade" id="addstoreModal" tabindex="-1" role="dialog" aria-labelledby="addstoreModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addstoreModalLabel">Store Information</h5>
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
                <button type="button" class="btn btn-primary" id="savestoreButton">Save</button>
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
    });
    
    function clearAddstoreModal() {
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
    let stores = []; // Array to store store data


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
                    $('#addstoreModal #storeId').val('');
                    $('#addstoreModal #name').val('');
                    $('#addstoreModal #name_kh').val('');
                    $('#addabbreviationsModal #substore').prop('checked', false);
                    $('#addabbreviationsModal #store_code').val('');
                    $('#addstoreModal #abbreviation').val('');
                    $('#addstoreModal #store_code').val('');
                    $('#addstoreModal #campus').val(1); 
                    $('#addstoreModal #location').val(1); 

                    $('#addstoreModal #status').val('true'); 

                    $('#addstoreModal #addstoreModalLabel').text('Add New Store');
                    $('#addstoreModal').modal('show');
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

    // Function to render store data into the table
        function renderstores(data) {
            dataTable.clear(); // Clear existing rows
            data.forEach(store => {
                const statusBadge = `<span class="badge ${store.type === 'store' ? 'badge-danger' : 'badge-success'}">${store.type === 'store' ? 'Business Entity' : 'Store'}</span>`;


                const actions = `
                    <button class="btn btn-sm btn-info edit-btn" 
                            data-id="${store.id}" 
                            data-store-type="${store.is_store}" 
                            data-toggle="modal" 
                            data-target="#addstoreModal">
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


function fetchstores() {
    $.ajax({
        url: '/stores/data',
        method: 'GET',
        success: function (response) {
        const stores = response.stores; 
        renderstores(stores); 

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

        if (Array.isArray(response.abbreviation)) {
    response.abbreviation.forEach(function(abbreviation) {
        // Create the option element
        const option = document.createElement("option");

        option.textContent = `${abbreviation.name} (${abbreviation.is_sub ? 'Sub Store' : 'Store'})`;

        option.value = abbreviation.id;

        option.setAttribute('data-is_sub', abbreviation.is_sub);
        option.setAttribute('data-store_code', abbreviation.store_code);

        // Append the option to the select
        abbreviationSelect.append(option);
    });
} else {
    console.log("Abbreviation data is not an array:", response.abbreviation);
}



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
                'Failed to fetch store data.',
                'error'
            );
        }
    });
}


    // Initial fetch of stores
    fetchstores();

    // Save store (Add or Update)
    $(document).on('click', '#savestoreButton', function () {
    const storeId = $('#storeId').val();
    const nameEn = $('#name').val();
    const nameKh = $('#name_kh').val();
    const abbreviation = $('#abbreviation').val();
    const store_code = $('#store_code').val();
        let substore = $('#substore').prop('checked'); 
      
        if (substore) {
            substore = true; 
        } else {
            substore = false; 
        }
    const storeCode = $('#store_code').val();
    const campusId = $('#campus').val(); 
    const locationId = $('#location').val(); 
    const isSub = $('#abbreviation option:selected').data('is_sub');
    const code = $('#abbreviation option:selected').data('store_code');
    const status = $('#status').val(); 



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
            id: storeId, 
            name_en: nameEn,
            code:code ,
            name_kh: nameKh,
            abbreviation_id: abbreviation,
            store_code: storeCode,
            campus_id: campusId,
            location_id: locationId,
            is_store: isSub,
            status: status === 'true' 
        },
        success: function (response) {
            if (response.message) {
                Swal.fire(
                    'Success!',
                    storeId ? 'Store updated successfully!' : 'Store added successfully!',
                    'success'
                ).then(() => {
                    fetchstores(); // Refresh the table with updated data
                    $('#addstoreModal').modal('hide'); // Close the modal
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
    const storeType = $(this).data('store-type'); 
        
    $.ajax({
        url: `/store/${storeId}/edit?storeType=${storeType}`,
        method: 'GET',
        success: function(response) {
            const store = response.store;

            $('#storeId').val(store.id); 
            $('#name').val(store.name_en); 

            $('#name_kh').val(store.name_kh); 

            $('#abbreviation').val(store.abbreviation_id); 

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


    $(document).on('click', '.delete-btn', function () {
        const storeId = $(this).data('id');
        const storeType = $(this).data('store-type'); 

        Swal.fire({
            title: `Are you sure to delete Store with id ${storeId}?`,
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: `/destroyStore/${storeId}/destroy?storeType=${storeType}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        Swal.fire(
                            'Deleted!',
                            'The Store has been deactivated.',
                            'success'
                        ).then(() => {
                            fetchstores(); // Refresh the table after successful deletion
                        });
                    },
                    error: function (xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'Failed to deactivate Store.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>