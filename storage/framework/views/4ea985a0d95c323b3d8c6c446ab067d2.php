

<?php $__env->startSection("title", "login"); ?>

<?php $__env->startSection("content"); ?>


<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h2>Login Form</h2>
                </div>



                <div class="card-body">
                    <form method="post" id="loginForm">
                        <?php echo csrf_field(); ?> <!-- CSRF Token for Laravel Security -->

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="email" maxlength="50" placeholder="Enter your email" required>
                        </div>

                        <div class="mb-3" style="position: relative;">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password"
                                required maxlength="20" autocomplete="current-password" style="padding-right: 40px;">

                            <!-- Eye Icon -->
                            <span id="togglePassword"
                                style="position: absolute; right: 10px; top: 38px; cursor: pointer;">
                                <i id="eyeOpen" class="bi bi-eye"></i> <!-- Open Eye -->
                                <i id="eyeSlash" class="bi bi-eye-slash-fill" style="display: none;"></i> <!-- Eye Slash -->
                            </span>
                        </div>


                        <button type="submit" class="btn btn-secondary w-100">Login</button>

                        <div class="text-center mt-3">
                            <p>Don't have an account? <a href="<?php echo e(route('register')); ?>">Sign Up</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- <script>
    $(document).ready(function() {
        // Call the common AJAX function for the login form
        submitFormWithAjax("#loginForm", "<?php echo e(route('login_user.post')); ?>", function(response) {
            // Optionally handle additional actions after success here
            console.log('Login response:', response);
        });
    });
   
</script> -->

<script>
    $(document).ready(function() {
        // Call the common AJAX function for the login form
        submitFormWithAjax("#loginForm", "<?php echo e(route('login_user.post')); ?>", "POST", function(response) {
            // If the login is successful and a redirect URL is provided in the response
            if (response.status === 'success' && response.redirect) {
                // Redirect the user to the provided URL (home page in this case)
                window.location.href = response.redirect;
            } else if (response.status === 'error') {
                // Handle errors if there's a failure (optional)
                Swal.fire("Error!", response.message, "error");
            }
        });
    });
</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Laravel_project\resources\views/login.blade.php ENDPATH**/ ?>