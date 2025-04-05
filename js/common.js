$(document).ready(function () {
    /** ==============================
     *  COMMON FORM SUBMISSION HANDLER 
     *  ============================== */
    function handleFormSubmission(formSelector, url, method = "POST", successRedirect = null) {
        $(formSelector).on("submit", function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            if (method.toUpperCase() === "PUT") {
                formData.append("_method", "PUT");
            }

            Swal.fire({
                title: "Processing...",
                text: "Please wait...",
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading(),
            });

            $.ajax({
                url: url,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: { "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content") },
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: response.message,
                        confirmButtonText: "OK",
                    }).then(() => {
                        if (successRedirect) window.location.href = successRedirect;
                    });
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = errors ? Object.values(errors).join("<br>") : "Something went wrong!";
                    Swal.fire({ icon: "error", title: "Error", html: errorMsg });
                },
            });
        });
    }

    /** ==============================
     *  VALIDATION: DATE RANGE CHECK 
     *  ============================== */
    function validateDates(startDateSelector, endDateSelector) {
        $(startDateSelector + ", " + endDateSelector).on("change", function () {
            let startDate = new Date($(startDateSelector).val());
            let endDate = new Date($(endDateSelector).val());

            if ($(startDateSelector).val() && $(endDateSelector).val() && endDate < startDate) {
                Swal.fire({ icon: "error", title: "Invalid Date", text: "End date cannot be earlier than start date!" });
                $(endDateSelector).val("");
            }
        });
    }

    /** ==============================
     *  UTILITY FUNCTIONS 
     *  ============================== */
    function isText(evt) {
        let charCode = evt.which || evt.keyCode;
        return (charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode == 32;
    }

    function isNumber(evt) {
        let charCode = evt.which || evt.keyCode;
        return charCode >= 48 && charCode <= 57;
    }

    // Make functions globally available
    window.commonFunctions = {
        handleFormSubmission,
        validateDates,
        isText,
        isNumber,
    };
});
