$(document).ready(function () {

    // Membership Search
    $("#membershipSearchForm").on("submit", function (e) {
        e.preventDefault();

        // get the input value (membership name)
        let query = $("#membershipSearchInput").val().trim();

        if (query === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Empty Search',
                text: 'Please enter a valid membership name.',
                showConfirmButton: true
            });
            return;
        }

        $.ajax({
            url: searchMembershipbyId, 
            type: "GET",
            data: { q: query }, 
            success: function (res) {
                if (res.status === "success") {
                    // Redirect to edit page 
                     window.open(editMembershipUrl + "/" + res.id, "_blank");
                }
            },
            error: function (xhr) {
                let msg = "Something went wrong!";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: msg,
                    showConfirmButton: true
                });
            }
        });
    });
});
