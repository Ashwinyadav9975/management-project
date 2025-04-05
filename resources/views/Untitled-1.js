<script>
    $(document).ready(function() {
        var authUserType = '{{ Auth::user() ? Auth::user()->user_type : "" }}';

        var columns = [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }},
            { data: 'name' },
            { data: 'email' },
            { data: 'gender' },
            { data: 'mobile' },
            { data: 'user_type' },
            { 
                data: 'created_at',
                render: function(data) {
                    return moment(data).format('DD-MM-YYYY'); // Display only date
                }
            }
        ];

        // Add actions column for admin users
        if (authUserType === 'admin') {
            columns.push({
                data: 'action',
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-primary edit-btn" data-id="${row.id}">Edit</button>
                        <button class="btn btn-danger delete-btn" data-id="${row.id}">Delete</button>
                    `;
                }
            });
        }

        // Initialize DataTable with date filter
        var table = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("users.fetch") }}',
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: columns
        });

        // Live date filter event
        $('#start_date, #end_date').on('change', function() {
            table.ajax.reload();
        });

        
        // Delete User (For Admin)
        $(document).on('click', '.delete-btn', function() {
            var userId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this user!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/user/' + userId,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: () => Swal.fire('Deleted!', 'User deleted successfully.', 'success')
                            .then(() => $('#users-table').DataTable().ajax.reload()),
                        error: (err) => Swal.fire('Oops...', err.responseJSON.error || 'Error occurred.', 'error')
                    });
                }
            });
        });

        // Edit User
        $(document).on('click', '.edit-btn', function() {
            var userId = $(this).data('id');
            window.location.href = '/user/edit/' + userId;
        });
    });
</script>
