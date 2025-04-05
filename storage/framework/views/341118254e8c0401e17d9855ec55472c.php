<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h2>Edit User</h2>
                </div>

                <div class="card-body">
                    <form id="user-form">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <input type="hidden" name="id" value="<?php echo e($user->id); ?>">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" minlength="6" maxlength="20" onkeypress="return isText(event)" value="<?php echo e(old('name', $user->name)); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" minlength="10" maxlength="10" onkeypress="return isNumber(event)" value="<?php echo e(old('mobile', $user->mobile)); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male" <?php echo e(old('gender', $user->gender) == 'male' ? 'selected' : ''); ?>>Male</option>
                                <option value="female" <?php echo e(old('gender', $user->gender) == 'female' ? 'selected' : ''); ?>>Female</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-7">
                                <button type="submit" id="submit-btn" class="btn btn-success w-100">Update Profile</button>
                            </div>
                            <div class="col-4">
                                <a href="<?php echo e(route('home')); ?>" class="btn btn-danger w-100">Cancel</a>
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
        $('#user-form').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.append('_method', 'PUT');

            let submitButton = $('#submit-btn');
            submitButton.prop('disabled', true).text("Processing...");

            $.ajax({
                url: "<?php echo e(route('user.update', $user->id)); ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"
                },
                beforeSend: function() {
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
                        Swal.fire("Success!", response.message, "success").then(() => {
                            window.location.href = response.redirect;
                        });
                    } else {
                        Swal.fire("Error!", response.message, "error");
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = "";

                    if (errors) {
                        Object.values(errors).forEach((msg) => {
                            errorMessages += msg + "\n";
                        });
                    } else {
                        errorMessages = "Something went wrong!";
                    }

                    Swal.fire("Validation Error!", errorMessages, "error");
                },
                complete: function() {
                    submitButton.prop('disabled', false).text("Update Profile");
                }
            });
        });
    });

  
</script> -->
<script>
    $(document).ready(function() {
        // Call the common AJAX function for updating user profile
        submitFormWithAjax("#user-form", "<?php echo e(route('user.update', $user->id)); ?>", "PUT", function(response) {
            console.log("User update response:", response);
        });
    });
</script>

<script src="<?php echo e(asset('js/ajax-helper.js')); ?>"></script> <!-- Include Common AJAX helper -->
<?php echo $__env->make('edit_user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>  <!-- Profile-specific script -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Laravel_project\resources\views/edit_user.blade.php ENDPATH**/ ?>