$(document).ready(function () {
    var base_url = $("#base_url").val();

    // var page = 1;
  


    var base_url=$('#base_url').val();
    var busy1 = false;
    var busy2=false;
    var limit = 6;
    var offset = 0;
    var offset1 = 0;

$("#product-scroll").on("scroll", function () {
        if (busy1) return; 
        var scrollTop = $(this).scrollTop(); 
        var scrollHeight = $(this)[0].scrollHeight; 
        var elementHeight = $(this).height();
            if (scrollTop + elementHeight >= scrollHeight) {
                busy1 = true;
                offset += limit;
                var type="yesvite";
            loadMoreData(search_name=null,type,offset,limit);
        }
});


let debounceTimer;
$("#product-scroll-phone").on("scroll", function () {
   
    clearTimeout(debounceTimer);
    // debounceTimer = setTimeout(() => {
        if (busy2) return; 

        var scrollTop = $(this).scrollTop(); 
        var scrollHeight = $(this)[0].scrollHeight; 
        var elementHeight = $(this).height();
        console.log({scrollTop,
            scrollHeight,
            elementHeight})
            if (scrollTop + elementHeight >= scrollHeight) {
                alert();
                busy2 = true;
                offset1 += limit;
                var type="phone";
                loadMorePhones(search_name=null,type,offset1,limit);
            // function loadMoreData(page, search_name)
            // loadMoreGroups(page, search_group);
            // loadMorePhones(page, search_phone);
        }
    // }, 200);
});

// let debounceTimer;
// let busy2 = false; // Ensure busy2 is initialized

// $("#product-scroll-phone").on("scroll", function () {
//     clearTimeout(debounceTimer);

//     debounceTimer = setTimeout(() => {
//         if (busy2) return;

//         let scrollTop = $(this).scrollTop();
//         let scrollHeight = $(this)[0].scrollHeight;
//         let elementHeight = $(this).height();

//         console.log({
//             scrollTop,
//             scrollHeight,
//             elementHeight
//         });

//         if (scrollTop + elementHeight >= scrollHeight - 10) { // Adding a buffer of 10px
//             busy2 = true;

//             offset1 += limit; // Increment the offset
//             let type = "phone";

//             loadMorePhones(null, type, offset1, limit)
//                 .then(() => {
//                     busy2 = false; // Reset busy2 after successful load
//                 })
//                 .catch(err => {
//                     console.error("Error loading more phones:", err);
//                     busy2 = false; // Reset busy2 even on error
//                 });
//         }
//     }, 200);
// });

$(document).on("keyup", ".search_name", function () {
        var search_name = $(this).val();
        page = 1;
        $("#yesviteUser").html("");
        // loadMoreData(page, search_name);
        if(search_name==''){
            offset=0;
            limit=6;
        
        }else{
            offset=null;
            limit=null;
        }
        loadMoreData(search_name,type=null,offset,limit);

});

$(document).on("keyup", ".search_group", function () {
        search_group = $(this).val();
        page = 1;
        $("#yesviteGroups").html("");
        loadMoreGroups(page, search_group);
});

$(document).on("keyup", ".search_phone", function () {
    var search_phone = $(this).val();
        page = 1;
        $("#yesvitePhones").html("");
        if(search_phone==''){
            offset1=null;
            limit=6;
        }else{
            offset1=null;
            limit=null;
        }
        loadMorePhones(search_phone,type=null,offset1,limit);
});

    function loadMoreData(search_name,type,offset,limit) {
        console.log({search_name,type,offset,limit});
        $.ajax({
            url: base_url + "contacts/load",
            type: "POST",
            data: {
                search_name: search_name,
                _token: $('meta[name="csrf-token"]').attr("content"), // Adding CSRF token
                type:type,
                offset:offset,
                limit:limit
            },
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                if (data.status == "0") {
                    $("#loader").hide();
                    return;
                }
                $("#loader").hide();
                if(data.search=='1'){
                    $("#yesviteUser").html(data.view);
                }else{
                    $("#yesviteUser").append(data.view);
                }

                busy1 = false;
            },
            error: function (jqXHR, ajaxOptions, thrownError) {
                console.error("AJAX Error:", thrownError);
                console.error("Response:", jqXHR.responseText);
                alert("server not responding...");
            },
        })
    }

    function loadMoreGroups(page, search_group = "") {
        $.ajax({
            url: base_url + "contacts/loadgroups?page=" + page,
            type: "POST",
            data: {
                search_group: search_group,
                _token: $('meta[name="csrf-token"]').attr("content"), // Adding CSRF token
            },
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                if (data.html == " ") {
                    $("#loader").html("No more groups found");
                    return;
                }
                $("#loader").hide();
                $("#yesviteGroups").html(data);
            },
            error: function (jqXHR, ajaxOptions, thrownError) {
                console.error("AJAX Error:", thrownError);
                console.error("Response:", jqXHR.responseText);
                alert("server not responding...");
            },
        });
    }

    function loadMorePhones(search_phone,type,offset1,limit) {
        console.log({search_phone,type,offset1,limit});
        $.ajax({
            url: base_url + "contacts/loadphones",
            type: "POST",
            data: {
                search_phone: search_phone,
                _token: $('meta[name="csrf-token"]').attr("content"), // Adding CSRF token
                type:type,
                offset:offset1,
                limit:limit
            },
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                if (data.status == "0") {
                    $("#loader").hide();
                    // busy2 = true; 
                    busy2 = false;

                    return;
                }
                $("#loader").hide();
                // $("#yesvitePhones").append(data);


                if(data.search=='1'){
                    $("#yesvitePhones").html(data.view);
                }else{
                    $("#yesvitePhones").append(data.view);
                }


                busy2 = false;

            },
            error: function (jqXHR, ajaxOptions, thrownError) {
                console.error("AJAX Error:", thrownError);
                console.error("Response:", jqXHR.responseText);
                alert("server not responding...");
            },
        });
    }

    $(".phone_number").intlTelInput({
        initialCountry: "US",
        separateDialCode: true,
        // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
    });

    $("[name=phone_number]").on("blur", function () {
        var instance = $("[name=phone_number]");

        var phoneNumber = instance.intlTelInput(
            "getSelectedCountryData"
        ).dialCode;
        $("#country_code").val(phoneNumber);
    });


    $(document).on("input","#phone_number", function () {
        // alert();
        let input = $(this).val().replace(/\D/g, ''); // Remove any non-numeric characters
        let formattedNumber = '';
    
        if (input.length <= 3) {
            formattedNumber = input;
        } else if (input.length <= 6) {
            formattedNumber = `${input.slice(0, 3)}-${input.slice(3)}`;
        } else {
            formattedNumber = `${input.slice(0, 3)}-${input.slice(3, 6)}-${input.slice(6, 15)}`;
        }
    
        $(this).val(formattedNumber);
    });


    $.validator.addMethod("phoneUS", function (phone_number, element) {
        phone_number = phone_number.replace(/\D/g, ""); // Remove non-digits for validation
        return (
            this.optional(element) ||
            (phone_number.length === 10 && phone_number.match(/^\d{10}$/))
        );
    }, "Please enter a valid US phone number (e.g., 123-456-7890)");


    $("#add_contact").validate({
        rules: {
            Fname: "required",
            Lname: "required",
            email: {
                required: true,
                email: true,
                remote: {
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    url: base_url + "contacts/check_new_contactemail", // Your Laravel API endpoint
                    type: "POST",
                    data: {
                        email: function () {
                            return $(".addnew_email").val();
                        },
                    },
                },
            },

            phone_number: {
                // required: true,
                // digits: true,
                phoneUS: true,
                minlength: 10,
                maxlength: 15,
                // remote: {
                //     headers: {
                //         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                //             "content"
                //         ),
                //     },
                //     url: base_url + "profile/check_new_contactnumber", // Your Laravel API endpoint
                //     type: "POST",
                //     data: {
                //         phone_number: function () {
                //             return $(".addnew_contact").val();
                //         },
                //         id: function () {
                //             return $("input[name='id']").val();
                //         },
                //     },
                // },
            },
        },
        messages: {
            Fname: "Please enter your First name",
            Lname: "Please enter your Last name",
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address",
                remote: "Email is already exsits",
            },
            phone_number: {
                // required: "Please enter a Phone Number",
                // digits: "Please enter a valid Phone Number",
                phoneUS: "Please enter a valid phone number in the format 123-456-7890",
                minlength: "Phone Number must be minimum 10 digit",
                maxlength: "Phone Number must be maxmimum 15 digit",
                // remote: "Phone Number is already exsits",
            },
        },
        submitHandler: function (form) {
            var formActionURL = $("#add_contact").attr("action");
            var formData = $("#add_contact").serialize();
            $.ajax({
                method: "POST",
                url: formActionURL,
                // dataType: "json",
                data: formData,

                success: function (output) {
                    console.log(output.status);
                    $("#myModal1").modal("hide");

                    if (output.status == 1) {
                        removeLoaderHandle("#save_contact", "Save Contact");
                        $("#Fname").val(output.user.firstname);
                        $("#Lname").val(output.user.lastname);

                        $("#email").val(output.user.email);
                        
                        $("#phone_number").val(output.user.phone_number);

                        toastr.success(output.message);

                        $("#add_contact")[0].reset();
                        $("#myModal1").modal("hide");
                    } else {
                        removeLoaderHandle("#save_contact", "Save Contact");
                        toastr.error(output.message);
                    }
                },
            });
        },
    });

    

    $("#save_contact").click(function () {
        loaderHandle("#save_contact", "Saving");
        $("#add_contact").submit();
    });

    $(document).on("click", ".edit-contact", function (e) {
        e.preventDefault(); // Prevent the default action
        $(".form-control").next().addClass("floatingfocus");

        var contactId = $(this).data("id");

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            method: "POST",
            url: base_url + "contacts/edit/" + contactId,
            // dataType: "json",
            // data: formData,

            success: function (output) {
                console.log(output.edit);

                if (output.status == 1) {
                    // alert();
                    $("#edit_Fname").val(output.edit.firstName);
                    $("#edit_Lname").val(output.edit.lastName);
                    $("#email").val(output.edit.email);
                    var phoneNumber = output.edit.phone; // "+1 4444-464-4646"
                    phoneNumber = phoneNumber.replace('+1 ', '');
                    $("#phone_number").val(phoneNumber);
                    $("#edit_id").val(output.edit.id);
                }
            },
        });
    });

    $(document).on("click", ".edit-yesvite-contact", function (e) {
        // alert();
        e.preventDefault(); // Prevent the default action

        $(".form-control").next().addClass("floatingfocus");

        var contactId = $(this).data("id");

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            method: "POST",
            url: base_url + "contacts/edit_yesvite/" + contactId,
            // dataType: "json",
            // data: formData,

            success: function (output) {
                // console.log(output.edit);

                if (output.status == 1) {
                    // alert();
                    $("#edit_Fname").val(output.edit.firstname);
                    $("#edit_Lname").val(output.edit.lastname);
                    $("#email").val(output.edit.email);
                    $("#phone_number").val(output.edit.phone_number);
                    $("#edit_id").val(output.edit.id);
                }
            },
        });
    });

    $("#edit_contact_form").validate({
        rules: {
            edit_Fname: "required",
            edit_Lname: "required",
            email: {
                required: true,
                email: true,
                remote: {
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    url: base_url + "contacts/check_new_contactemail", // Your Laravel API endpoint
                    type: "POST",
                    data: {
                        email: function () {
                            return $(".addnew_email").val();
                        },
                    },
                },
            },
            phone_number: {
                // required: true,
                // digits: true,
                phoneUS: true,
                minlength: 10,
                maxlength: 15,
                // remote: {
                //     headers: {
                //         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                //             "content"
                //         ),
                //     },
                //     url: base_url + "profile/check_new_contactnumber", // Your Laravel API endpoint
                //     type: "POST",
                //     data: {
                //         phone_number: function () {
                //             return $(".addnew_contact").val();
                //         },
                //         id: function () {
                //             return $("input[name='id']").val();
                //         },
                //     },
                // },
            },
        },
        messages: {
            edit_Fname: "Please enter your First name",
            edit_Lname: "Please enter your Last name",
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address",
                remote: "Email is already exsits",
            },
            phone_number: {
                required: "Please enter a Phone Number",
                // digits: "Please enter a valid Phone Number",
                phoneUS: "Please enter a valid phone number in the format 123-456-7890",
                minlength: "Phone Number must be minimum 10 digit",
                maxlength: "Phone Number must be maxmimum 15 digit",
                // remote: "Phone Number is already exsits",
            },
        },
        submitHandler: function (form) {
            var formActionURL = $("#edit_contact_form").attr("action");
            var formData = $("#edit_contact_form").serialize();
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                method: "POST",
                url: formActionURL,
                // dataType: "json",
                data: formData,

                success: function (output) {
                    console.log(output.user);

                    if (output.status == 1) {
                        removeLoaderHandle("#save_contact", "Save Contact");
                        $("#Fname").val(output.user.firstname);
                        $("#Lname").val(output.user.lastname);

                        $("#email").val(output.user.email);
                        $("#phone_number").val(output.user.phone_number);

                        toastr.success(output.message);

                        $("#edit_contact_form")[0].reset();
                        $("#myModal").modal("hide");
                        window.location.reload();
                    } else {
                        removeLoaderHandle("#save_contact", "Save Contact");
                        toastr.error(output.message);
                    }
                },
            });
        },
    });

    // $("#save_edit_contact").click(function () {
    //     loaderHandle("#save_edit_contact", "Saving");
    //     $("#save_edit_contact").submit();
    // });

    $("#myModal").on("hidden.bs.modal", function (event) {
        $(".form-control").next().removeClass("floatingfocus");
        $("#edit_contact_form .label-error .error").text("");
    });

    $("#myModal1").on("hidden.bs.modal", function (event) {
        $(".form-control").next().removeClass("floatingfocus");
        $("#add_contact .label-error .error").text("");
        $("#add_contact")[0].reset();
    });
});
$('label[for="email"]').removeClass("floatingfocus");
