<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* General Styling */
        body {
            background: url('/images/top-view-work-desk-office-workspace-photo.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            margin: 0;
        }

        .card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 10px;
            background: transparent;
            box-shadow: 0px 10px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .card-body {
            padding: 0;
        }

        .card-title {
            font-size: 2rem;
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
        }

        .card-text {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .btn {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 18px;
            text-transform: uppercase;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-register {
            background-color: #4CAF50;
            color: white;
        }

        .btn-register:hover {
            background-color: #45a049;
            transform: scale(1.05);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-login {
            background-color: #007bff;
            color: white;
        }

        .btn-login:hover {
            background-color: #0056b3;
            transform: scale(1.05);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* For small devices */
        @media (max-width: 576px) {
            .card {
                max-width: 90%;
            }

            .btn {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

    <!-- Card Container -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Welcome to Our Platform</h5>
            <p class="card-text">Please choose an option below to get started.</p>
            <!-- Register Button -->
            <a href="{{ route('register')}}" class="btn btn-register">Sign Up</a>
            <!-- Login Button -->
            <a href="<?= ('/login') ?>" class="btn btn-login">Login here</a>
        </div>
    </div>

    <!-- Bootstrap JS & Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

</body>

</html>
