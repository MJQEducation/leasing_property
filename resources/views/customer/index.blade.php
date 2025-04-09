<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Customer <span class="fw-300"><i>Table</i></span>
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
                                <th>Phone</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->ownerName }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->created_at }}</td>
                                <td>
                                    @if ($customer->active)
                                    <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info edit-btn" data-id="{{ $customer->id }}" data-toggle="modal" data-target="#addCustomerModal">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $customer->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @endforeach
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
                <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add/Edit Customer Form -->
                <form id="addCustomerForm" method="POST">
                    @csrf
                    <input type="hidden" id="customerId" name="customerId"> <!-- Hidden input for customer ID -->
                    <input type="hidden" name="_method" value="PUT"> <!-- Spoof the PUT method -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter customer name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="addCustomerForm" class="btn btn-primary" id="saveCustomerButton">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Script -->
<script>
    $(document).ready(function () {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        $('#dt-basic-example').DataTable({
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
                        $('#addCustomerModal #customerId').val('');
                        $('#addCustomerModal #name').val('');
                        $('#addCustomerModal #phone').val('');
                        $('#addCustomerModalLabel').text('Add New Customer');
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

        // Save Customer (Create/Update)
        $(document).on('click', '#saveCustomerButton', function () {
    const customerId = $('#customerId').val(); 
    const ownerName = $('#name').val();
    const phone = $('#phone').val();

    let url = '/customer'; 
    let method = 'POST'; 

    if (customerId) {
        url = `/customer/${customerId}`; 
        method = 'PUT'; 
    }

    $.ajax({
        url: url,
        method: method,
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            ownerName: ownerName,
            phone: phone
        },
        success: function (response) {
            Swal.fire(
                'Success!',
                customerId ? 'Customer updated successfully!' : 'Customer added successfully!',
                'success'
            ).then(() => {
                Location.reload(); 
            });
        },
        error: function (xhr, status, error) {
            Swal.fire(
                'Error!',
                'There was an issue saving the customer data.',
                'error'
            );
        }
    });
});

        // Edit Customer
        $(document).on('click', '.edit-btn', function () {
            const customerId = $(this).data('id');
            $.ajax({
                url: `/customer/${customerId}/edit`,
                method: 'GET',
                success: function (response) {
                    $('#customerId').val(response.customer.id);
                    $('#name').val(response.customer.ownerName);
                    $('#phone').val(response.customer.phone);
                    $('#addCustomerModalLabel').text('Edit Customer');
                    $('#addCustomerModal').modal('show');
                },
                error: function (xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'Unable to fetch customer data.',
                        'error'
                    );
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
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/customer/${customerId}`,
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
                                location.reload();
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