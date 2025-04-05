<style>
    /* General Styling */
    body {
        background: url('https://via.placeholder.com/1920x1080') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }

    /* Navbar Styling */
    .navbar {
        background: rgba(0, 0, 0, 0.8);
        padding: 20px 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    .navbar-brand {
        font-weight: bold;
        font-size: 24px;
        color: #ffffff;
        display: flex;
        align-items: center;
    }

    .navbar-nav .nav-link {
        color: rgba(255, 255, 255, 0.85);
        transition: color 0.3s ease-in-out;
        margin-right: 20px;
        font-size: 16px;
    }

    .navbar-nav .nav-link:hover {
        color: #f8f9fa;
    }

    /* Profile Image */
    .profile-img {
        border-radius: 50%;
        width: 70px;
        height: 70px;
        border: 2px solid #fff;
    }

    /* Navbar Actions */
    .navbar-actions {
        display: flex;
        gap: 30px;
        /* Increased gap for more space between buttons */
        align-items: center;
    }

    .btn-custom {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        font-size: 14px;
    }

    .btn-custom i {
        margin-right: 5px;
    }

    /* Adjusting Spacing in Mobile */
    .navbar-toggler {
        border: 1px solid #fff;
    }

    /* Responsive Design for Mobile */
    @media (max-width: 1200px) {
        .navbar-nav .nav-link {
            margin-right: 10px;
        }
    }

    @media (max-width: 992px) {
        .navbar-brand {
            font-size: 20px;
        }

        .navbar-nav .nav-link {
            margin-right: 10px;
        }

        .profile-img {
            width: 50px;
            height: 50px;
        }
    }

    @media (max-width: 768px) {
        .navbar-brand {
            font-size: 18px;
        }

        .navbar-nav .nav-link {
            margin-right: 5px;
        }

        .profile-img {
            width: 40px;
            height: 40px;
        }

        .navbar-toggler-icon {
            background-color: rgb(121, 120, 120);
        }
    }

    /* Extra Small Screens */
    @media (max-width: 576px) {
        .profile-img {
            width: 35px;
            height: 35px;
        }

        .btn-custom {
            padding: 8px 10px;
            font-size: 13px;
        }

        .navbar-nav .nav-link {
            margin-right: 5px;
            font-size: 14px;
        }
    }
</style>

<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <!-- Left Side: Profile Image and User Name -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            @php
            $profile_image = Auth::user()->image;
            $user_name = Auth::user()->name;
            $default_image = asset('image/image.jpg'); // Default profile image
            @endphp

            <img src="{{ $profile_image ? asset('images/' . $profile_image) : $default_image }}"
                class="profile-img me-3"
                alt="Profile">

            <h2 class="mb-0">Welcome, {{ $user_name ?? 'User' }}</h2>
        </a>

        <!-- Hamburger button for smaller screens -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsing Navbar Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto d-flex align-items-center">
                <!-- Export Buttons -->
                <div class="mb-3">
                    <button class="btn btn-danger btn-custom me-3 mt-3" id="export-csv"><i class="bi bi-file-earmark-spreadsheet"></i> CSV</button>
                    <button class="btn btn-success btn-custom me-3 mt-3" id="export-pdf"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
                </div>

                <div class="navbar-actions">
                    <!-- EditName Button -->
                    <li class="nav-item">
                        <a class="btn btn-primary btn-custom" href="{{ route('edit_profile', ['id' => Auth::id()]) }}">
                            <i class="bi bi-person-badge"></i> EditProfile
                        </a>
                    </li>

                    <!-- Lohout Button -->
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-custom">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </div>
            </ul>
        </div>
    </div>
</nav>