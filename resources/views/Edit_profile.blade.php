@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h2>Edit Profile</h2>
                </div>

                <div class="card-body">
                    <!-- Form to edit user details -->
                    <form id="user-form" method="POST" class="validateForm" action="{{ route('userprofile.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Ensure the method is set to PUT -->

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" maxlength="50" onkeypress="return isText(event)" value="{{ old('name', $user->name) }}" required>
                        </div>

                      
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" minlength="10" maxlength="10" onkeypress="return isNumber(event)" onkeypress="return isNumber(event)" value="{{ old('mobile', $user->mobile) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
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
                                    <a href="{{ route('home') }}" class="btn btn-danger w-100">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
    $(document).ready(function() {
        // Call the common AJAX function for updating the profile
        submitFormWithAjax("#user-form", "{{ route('userprofile.update', $user->id) }}", "POST", function(response) {
            console.log("Profile update response:", response);
        });
    });
</script>


@endsection
