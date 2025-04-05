

<?php $__env->startSection("title", "User Dashboard"); ?>

<?php $__env->startSection("content"); ?>

<!-- ✅ Custom Styling -->
<style>
    /* General Styling */
    body {
        background: url('/images/top-view-work-desk-office-workspace-photo.jpg') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }

    /* Container */
    .container {
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
        margin-top: 50px;
        animation: fadeIn 1s ease-in-out;
    }

    /* Table Styling */
    #users-table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        animation: slideIn 0.5s ease-in-out;
    }

    #users-table th {
        background-color: #007bff;
        color: white;
        text-align: center;
        padding: 12px;
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    #users-table td {
        padding: 10px;
        text-align: center;
        border-bottom: 1px solid #ddd;
        font-size: 14px;
    }

    #users-table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
        transform: scale(1.02);
        transition: transform 0.3s ease;
    }

    #users-table tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    #users-table tbody tr:nth-child(even) {
        background-color: #fff;
    }

    /* Heading */
    .page-title {
        text-align: center;
        font-weight: 600;
        color: #333;
        margin-bottom: 30px;
        font-size: 28px;
        letter-spacing: 1px;
        position: relative;
        animation: glitch 1.5s infinite;
    }

    /* Glitch Effect */
    @keyframes glitch {
        0% {
            text-shadow: 1px 0px 5px rgba(255, 0, 0, 0.7), -1px 0px 5px rgba(0, 0, 255, 0.7);
            transform: translate(0, 0);
        }
        20% {
            text-shadow: -2px 0px 5px rgba(255, 0, 0, 0.8), 2px 0px 5px rgba(0, 0, 255, 0.8);
            transform: translate(-2px, 0);
        }
        40% {
            text-shadow: 2px 0px 5px rgba(255, 0, 0, 0.8), -2px 0px 5px rgba(0, 0, 255, 0.8);
            transform: translate(2px, 0);
        }
        60% {
            text-shadow: -2px 0px 5px rgba(255, 0, 0, 0.7), 2px 0px 5px rgba(0, 0, 255, 0.7);
            transform: translate(-2px, 0);
        }
        80% {
            text-shadow: 1px 0px 5px rgba(255, 0, 0, 0.7), -1px 0px 5px rgba(0, 0, 255, 0.7);
            transform: translate(0, 0);
        }
        100% {
            text-shadow: 1px 0px 5px rgba(255, 0, 0, 0.7), -1px 0px 5px rgba(0, 0, 255, 0.7);
            transform: translate(0, 0);
        }
    }

    /* Fade In Effect */
    @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    /* Slide In Effect */
    @keyframes slideIn {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(0);
        }
    }
</style>

<!-- ✅ Dashboard Content -->
<div class="container">
    <h2 class="page-title">User List</h2>
    <table id="users-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Mobile</th>
                <th>User Type</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- ✅ DataTables Script -->
<script>
    $(document).ready(function () {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(route('home_data')); ?>", // Fetch Data
            columns: [
                { data: null, render: (data, type, row, meta) => meta.row + 1 }, // Auto-increment ID
                { data: 'name' },
                { data: 'email' },
                { data: 'gender' },
                { data: 'mobile' },
                { data: 'user_type' }
            ]
        });
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Laravel_project\resources\views/show_dashboard.blade.php ENDPATH**/ ?>