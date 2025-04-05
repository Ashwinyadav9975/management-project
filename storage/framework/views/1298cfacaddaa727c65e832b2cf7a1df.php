<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h2>Edit Profile</h2>
                </div>

                <div class="card-body">
                    <!-- Form to edit user details -->
                    <form id="user-form" method="POST" class="validateForm" action="<?php echo e(route('userprofile.update', $user->id)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?> <!-- Ensure the method is set to PUT -->

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" maxlength="50" onkeypress="return isText(event)" value="<?php echo e(old('name', $user->name)); ?>" required>
                        </div>

                      
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" minlength="10" maxlength="10" onkeypress="return isNumber(event)" onkeypress="return isNumber(event)" value="<?php echo e(old('mobile', $user->mobile)); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="male" <?php echo e(old('gender', $user->gender) == 'male' ? 'selected' : ''); ?>>Male</option>
                                <option value="female" <?php echo e(old('gender', $user->gender) == 'female' ? 'selected' : ''); ?>>Female</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Choose Profile Picture</label>
                            <input type="file" name="image" id="image" class="form-control" accept=".jpg, .jpeg, .png, .gif" />
                            <small class="text-muted">Accepted file types: JPG, JPEG, PNG, GIF (Max size: 2MB)</small>
                        </div>

                        <div class="w-100">
                            <div class="row">
                                <div class="col-7">
                                    <button type="submit" name="submit" class="btn btn-success w-100">Update Profile</button>
                                </div>
                                <div class="col-4">
                                    <a href="<?php echo e(route('home')); ?>" class="btn btn-danger w-100">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- <script>
    $(document).ready(function() {
        $('#user-form').on('submit', function(e) {
            e.preventDefault(); // Prevent normal form submission

            let formData = new FormData(this);

            $.ajax({
                url: "<?php echo e(route('userprofile.update', $user->id)); ?>",
                method: "POST", 
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait while we update your profile.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Profile Updated!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = response.redirect;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = '';

                    $.each(errors, function (key, value) {
                        errorMsg += value + "<br>";
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errorMsg || 'Something went wrong! Please try again.'
                    });
                }
            });
        });
    });
   

</script> -->
<script>
    $(document).ready(function() {
        // Call the common AJAX function for updating the profile
        submitFormWithAjax("#user-form", "<?php echo e(route('userprofile.update', $user->id)); ?>", "POST", function(response) {
            console.log("Profile update response:", response);
        });
    });
</script>
<script src="<?php echo e(asset('js/ajax-helper.js')); ?>"></script> <!-- Include Common AJAX helper -->
<?php echo $__env->make('Edit_profile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Laravel_project\resources\views/Edit_profile.blade.php ENDPATH**/ ?>