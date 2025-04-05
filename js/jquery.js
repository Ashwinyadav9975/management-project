$(document).ready(function () {
    function applyValidation(formId) {
        $(formId).validate({
            rules: {
                name: {
                    required: true,
                    minlength: 6
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                mobile: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                gender: {
                    required: true
                },
                type: {
                    required: true
                },
                // Custom validation for image
                image: {
                    required: false,  // Image is optional
                    extension: "jpg|jpeg|png|gif|svg",  // Allowed image formats
                    filesize: 2097152  // Maximum file size of 2MB (in bytes)
                }
            },
            messages: {
                name: {
                    required: "Please enter your name ",
                    minlength: "Name must be at least 6 characters"
                },
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                },
                password: {
                    required: "Please enter your password",
                    minlength: "Password must be at least 6 characters"
                },
                mobile: {
                    required: "Please enter your mobile number",
                    digits: "Mobile number must contain only digits",
                    minlength: "Mobile number must be exactly 10 digits",
                    maxlength: "Mobile number must be exactly 10 digits"
                },
                gender: {
                    required: "Please select your gender"
                },
                type: {
                    required: "Please select your user type"
                },
                image: {
                    extension: "Only image files (jpg, jpeg, png, gif, svg) are allowed.",
                    filesize: "The image size must be less than 2MB."
                }
            },
            errorClass: "text-danger",
            errorElement: "div",
        });
    }

    // Apply validation to forms
    applyValidation("#registrationForm");
    applyValidation("#loginForm"); // Add more forms as needed
    applyValidation("#user-form"); 
    applyValidation("#loginForm"); 
});

// Custom jQuery validation method for checking file size
$.validator.addMethod("filesize", function (value, element, param) {
    var fileSize = element.files[0]?.size || 0; // Get the file size in bytes
    return this.optional(element) || (fileSize <= param);  // Param is the max allowed size (in bytes)
}, "File size is too large.");

// Custom jQuery validation method for checking file extension (image only)
$.validator.addMethod("extension", function (value, element, param) {
    var allowedExtensions = param.split("|");
    var fileName = element.value;
    var fileExtension = fileName.split('.').pop().toLowerCase();  // Extract the file extension
    return this.optional(element) || allowedExtensions.includes(fileExtension);
}, "Invalid file type.");


function isText(evt) {
    var charCode = evt.which ? evt.which : evt.keyCode;
    if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode == 32) {
        return true; // Allow letters (A-Z, a-z) and space
    }
    return false;
}

function isNumber(evt) {
    var charCode = evt.which ? evt.which : evt.keyCode;
    if (charCode >= 48 && charCode <= 57) {
        return true; // Allow numbers (0-9)
    }
    return false;
}
document.getElementById("togglePassword").addEventListener("click", function() {
    let passwordInput = document.getElementById("password");
    let eyeOpen = document.getElementById("eyeOpen");
    let eyeSlash = document.getElementById("eyeSlash");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeOpen.style.display = "none";
        eyeSlash.style.display = "inline";
    } else {
        passwordInput.type = "password";
        eyeOpen.style.display = "inline";
        eyeSlash.style.display = "none";
    }
});


// public/js/common.js

// Function to validate date selection
function validateDates(startDateSelector, endDateSelector, callback) {
    $(startDateSelector + ', ' + endDateSelector).on('change', function() {
        let startDate = new Date($(startDateSelector).val());
        let endDate = new Date($(endDateSelector).val());

        if ($(startDateSelector).val() && $(endDateSelector).val() && endDate < startDate) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date Range!',
                text: 'End date cannot be earlier than the start date!',
                confirmButtonColor: '#d33'
            });
            $(endDateSelector).val("");
        }

        if (callback) callback();
    });
}

// Function to export table data to PDF
function exportToPDF(tableDataFunction, filenamePrefix) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    if (!doc.autoTable) {
        alert("Error: jsPDF AutoTable plugin is missing!");
        return;
    }

    let data = tableDataFunction().map((row, index) => [
        index + 1, row.name, row.email, row.gender, row.mobile, row.user_type, moment(row.created_on).format('DD-MM-YYYY')
    ]);

    doc.text("Users Data", 14, 10);
    doc.autoTable({
        head: [['S.No', 'Name', 'Email', 'Gender', 'Mobile', 'User Type', 'Register Date']],
        body: data,
        startY: 20,
        theme: 'grid',
        styles: { fontSize: 8, cellPadding: 5, valign: 'middle', halign: 'center' },
        headStyles: { fillColor: [44, 62, 80], textColor: [255, 255, 255], fontStyle: 'bold' },
        alternateRowStyles: { fillColor: [240, 240, 240] }
    });

    doc.save(`${filenamePrefix}_${moment().format('YYYY-MM-DD')}.pdf`);
}

// Function to export table data to CSV
function exportToCSV(tableDataFunction, filenamePrefix) {
    let csvContent = "Id,Name,Email,Gender,Mobile,User Type,Register Date\n" +
        tableDataFunction().map(row =>
            `"${row.id}","${row.name}","${row.email}","${row.gender}","${row.mobile}","${row.user_type}","${moment(row.created_on).format('DD-MM-YYYY')}"`)
        .join("\n");

    let link = document.createElement("a");
    link.href = URL.createObjectURL(new Blob([csvContent], { type: "text/csv" }));
    link.download = `${filenamePrefix}_${moment().format('YYYY-MM-DD')}.csv`;
    document.body.appendChild(link);
    link.click();
}

// Function to handle delete confirmation
function handleDeleteButton(deleteSelector, deleteUrl, reloadCallback) {
    $(document).on('click', deleteSelector, function() {
        var userId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this user!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl.replace(':id', userId),
                    type: 'DELETE',
                    data: { _token: $('meta[name="csrf-token"]').attr('content') },
                    success: () => Swal.fire('Deleted!', 'User deleted successfully.', 'success').then(reloadCallback),
                    error: err => Swal.fire('Oops...', err.responseJSON.error || 'Error occurred.', 'error')
                });
            }
        });
    });
}

// Function to handle edit redirection
function handleEditButton(editSelector, editUrl) {
    $(document).on('click', editSelector, function() {
        window.location.href = editUrl.replace(':id', $(this).data('id'));
    });
}
