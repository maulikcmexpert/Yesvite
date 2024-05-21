$(document).ready(function () {
    // Initialize jQuery validation
    $("#updateUserForm").validate({
        rules: {
            firstname: "required",
            lastname: "required",
            // gender: "required",
            // birth_date: "required",
            // email: {
            //     required: true,
            //     email: true,
            // },
            // phone_number: {
            //     required: true,
            //     digits: true,
            // },
            // address: "required",
            // city: "required",
            // state: "required",
            zip_code: {
                required: true,
                digits: true,
            },
            // about_me: "required",
        },
        messages: {
            firstname: "Please enter your first name",
            lastname: "Please enter your last name",
            // gender: "Please select your gender",
            // birth_date: "Please enter your birth date",
            // email: "Please enter a valid email address",
            // phone_number: "Please enter a valid phone number",
            // address: "Please enter your address",
            // city: "Please enter your city",
            //   state: "Please enter your state",
            zip_code: "Please enter a valid zip code",
            //  about_me: "Please tell us about yourself",
        },
        submitHandler: function (form) {
            // Form validation passed, submit the form via AJAX
            var formActionURL = $("#updateUserForm").attr("action");
            var formData = $("#updateUserForm").serialize();
            $.ajax({
                // headers: {
                //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                // },
                method: "POST",
                url: formActionURL,
                data: formData,
                success: function (output) {
                    console.log(output.status);
                    if (output.status == 1) {
                        $("#myModal3").modal("hide");
                        location.reload();
                        toastr.success(output.message);
                    } else {
                        $("#myModal3").modal("hide");
                        location.reload();
                        toastr.error(output.message);
                    }
                },
            });
        },
    });

    // Trigger form submission
    $("#save_changes").click(function () {
        $("#updateUserForm").submit();
    });

    $(document).ready(function () {
        $("#fileField").on("change", function () {
            var formData = new FormData();
            formData.append("file", $(this)[0].files[0]);

            $.ajax({
                url: "upload",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                // headers: {
                //     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                //         "content"
                //     ),
                // },
                success: function (response) {
                    alert("Image uploaded successfully!");
                    console.log(response);
                },
                error: function (response) {
                    alert("Error uploading image.");
                    console.log(response);
                },
            });
        });
    });
});
