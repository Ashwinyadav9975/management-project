@extends("layouts.app")
@section("title", "Home")
@section("navbar")
@include('includes.navbar')
@endsection

@section("content")

<style>
    body {
        background-size: cover;
    }

    /* Table general styling */
    table.dataTable {
        border-collapse: collapse;
        width: 100%;
        font-size: 14px;
    }

    th,
    td {
        border: 1px solid #ddd;
        text-align: center;
        padding: 12px;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    .dataTables_wrapper {
        width: 100%;
        overflow-x: auto;
    }

    /* Mobile responsiveness */
    @media screen and (max-width: 768px) {

        th,
        td {
            font-size: 12px;
            padding: 8px;
        }
    }

    .btn {
        padding: 8px 12px;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
    }

    .btn-edit {
        background-color: #007BFF;
        color: white;
    }

    .btn-delete {
        background-color: #DC3545;
        color: white;
    }

    .btn-export {
        background-color: #28a745;
        color: white;
        margin-right: 10px;
    }
</style>

<div class="container">
    @php
    $authUser = Auth::user();
    @endphp
</div>

<!-- Date Filters -->
<div class="container my">
    <div class="row mb-3 justify-content-start">
        <div class="col-12 col-sm-6 col-md-2 d-flex flex-column">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" class="form-control" max="{{ date('Y-m-d') }}">
        </div>
        <div class="col-12 col-sm-6 col-md-2 d-flex flex-column">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" class="form-control" max="{{ date('Y-m-d') }}">
        </div>
    </div>
</div>

<!-- DataTable Display -->
<div class="container">
    <table id="users-table" class="display table table-bordered" style="width:100%">
        <thead class="text-center bg-info">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Mobile</th>
                <th>User Type</th>
                <th>Register Date</th>

                @if ($authUser && $authUser->user_type === 'admin')
                <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>


<script>
    $(document).ready(function() {
        var auth_user_type = '{{ Auth::user() ? Auth::user()->user_type : "" }}';

        var columns = [
            { data: null, render: (data, type, row, meta) => meta.row + 1 },
            { data: 'name', render: data => data.charAt(0).toUpperCase() + data.slice(1) },
            { data: 'email' },
            { data: 'gender' },
            { data: 'mobile' },
            { data: 'user_type', render: data => data.charAt(0).toUpperCase() + data.slice(1) },
            // { 
            //     data: 'created_on', 
            //     render: data => data > 0 ? moment.unix(data).format('DD-MM-YYYY') : moment().format('DD-MM-YYYY') 
            // }
            { 
                data: 'created_on', 
                render: data => {
                    return data ? moment(data).format('DD-MM-YYYY') : '';
                }
            }
        ];

        if (auth_user_type === 'admin') {
            columns.push({
                data: 'action',
                orderable: false,
                render: (data, type, row) => `
                    <button class="btn btn-primary edit-btn" data-id="${row.id}">Edit</button>
                    <button class="btn btn-danger delete-btn" data-id="${row.id}">Delete</button>`
            });
        }

        var table = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            lengthChange:false,
            lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            ajax: {
                url: '{{ route("users.fetch") }}',
                data: d => {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: columns
        });

        validateDates('#start_date', '#end_date', () => table.ajax.reload());

        $('#export-pdf').click(() => exportToPDF(() => table.rows().data().toArray(), 'users_data'));
        $('#export-csv').click(() => exportToCSV(() => table.rows().data().toArray(), 'users_data'));

        handleDeleteButton('.delete-btn', '/user/:id', () => table.ajax.reload());
        handleEditButton('.edit-btn', '/user/edit/:id');
        handleEditButton('.editprofile-btn', '/userprofile/edit/:id');
    });
</script>


@endsection