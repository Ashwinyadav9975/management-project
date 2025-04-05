function submitFormWithAjax(formSelector, url, method = "POST", successCallback) {
    $(document).ready(() => {
        $(formSelector).on("submit", function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            if (["PUT", "DELETE"].includes(method)) formData.append('_method', method);

            $.ajax({
                url, method: "POST", data: formData, processData: false, contentType: false,
                beforeSend: () => Swal.fire({ title: 'Processing...', text: 'Please wait...', allowOutsideClick: false, showConfirmButton: false, didOpen: Swal.showLoading }),
                success: ({ status, message, redirect }) => {
                    Swal.fire(status === 'success' ? "Success!" : "Error!", message, status).then(() => {
                        if (status === 'success' && redirect) window.location.href = redirect;
                    });
                    successCallback?.({ status, message, redirect });
                },
                error: ({ responseJSON }) => {
                    let errorMessages = Object.values(responseJSON?.errors || { error: ["Something went wrong!"] }).flat().join("\n");
                    Swal.fire("Validation Error!", errorMessages, "error");
                }
            });
        });
    });
}
