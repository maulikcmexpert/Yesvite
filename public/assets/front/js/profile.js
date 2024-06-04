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
                dataType: "json",
                data: formData,

                success: function (output) {
                    console.log(output.user);

                    $("#firstname").val(output.user.firstname);
                    $("#lastname").val(output.user.lastname);
                    // $("#male").val(output.user.male);
                    // $("#female").val(output.user.female);
                    $("#birth_date").val(output.user.birth_date);
                    $("#email").val(output.user.email);
                    $("#phone_number").val(output.user.phone_number);
                    $("#zip_code").val(output.user.zip_code);
                    $("#about_me").val(output.user.about_me);
                    if (output.status == 1) {
                        toastr.success(output.message);
                        //  location.reload();
                    } else {
                        //  location.reload();
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
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "upload",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function (response) {
                    toastr.success("Profile updated successfully");
                    $(document).ready(function () {
                        $(".UserImg").attr("src", response);
                    });
                    $("#coverProfile-modal").modal("hide");
                },
                error: function (response) {
                    toastr.error("Error uploading image.");
                    $("#coverProfile-modal").modal("hide");
                },
            });
        });
    });
});
