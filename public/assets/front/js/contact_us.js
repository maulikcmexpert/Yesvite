$(document).ready(function(){
    // alert();
$("#contact_us_form").validate({
    rules: {
        name: {
            required: true,
            },
        email: {
                required: true,
                email: true,
                },
                        message:{
                            required: true,
                            }
    },
    messages: {
        name: {
            required:"Please enter your First name"
              },
        email: {
            required: "Please enter your Email address",
            email: "Please enter a valid email address",
            },
        message:{
            required:"Please enter your Message"
              }
    },
});

$(".form-control").on("focusout change keyup focus", function () {
    var text_val = $(this).val();
    if (text_val === "") {
        $(this).next().removeClass("floatingfocus");
    } else {
        $(this).next().addClass("floatingfocus");
    }
});

$(".form-control").each(function () {
    var text = $(this).val();
    if (text === "") {
        $(this).next().removeClass("floatingfocus");
    } else {
        $(this).next().addClass("floatingfocus");
    }
});

$('html').mouseover(function() {
    $(".form-control").each(function () {
        var text = $(this).val();
        if (text === "") {
            $(this).next().removeClass("floatingfocus");
        } else {
            $(this).next().addClass("floatingfocus");
        }
    });
}); 
});