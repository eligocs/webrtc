$(document).ready(function () {
    const firstname_err = "Please enter your first name";
    const lastname_err = "Please enter your last name";
    const name_err = "Please enter your institute name";
    const email_err = "Please enter a valid email address";
    const address_err = "Please enter your address";
    const mobile_no_err = "Please enter valid mobile number";
    const type_of_class_err = "Please enter type of class";
    const description_err = "Please enter description";
    const required = "required";
    const post_institute_form_url = $("#join-institute-form").val();
    const check_email_url = $("#check_email_url").val();
    const success = "Success";

    $("#join-institute-form").validate({
        rules: {
            firstname: required,
            lastname: required,
            name: required,
            email: {
                required: true,
                email: true
            },
            address: required,
            mobile_no: {
                required: true,
                digits: true,
                maxlength: 10,
                minlength: 10
            },
            type_of_class: required,
            description: required
        },
        messages: {
            firstname: firstname_err,
            lastname: lastname_err,
            name: name_err,
            email: email_err,
            address: address_err,
            mobile_no: mobile_no_err,
            type_of_class: type_of_class_err,
            description: description_err
        },
        submitHandler: function (form) {
            submitForm("#join-institute-form");
        }
    });

    function submitForm(form_id) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        $(".response").html("");
        $(".send_application_btn").html(
            '<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>'
        );
        let form_data = $(form_id).serialize();
        $.ajax({
            type: "POST",
            url: post_institute_form_url,
            data: form_data,
            success: function (return_data) {
                $(".send_application_btn").html("SEND APPLICATION");
                //$(form_id).trigger("reset");
                if (return_data.status == success) {
                    // $(form_id).trigger("reset");
                    // $(".join-institute-form-modal").html(
                    //     "Your Application has been successfully sent."
                    // );
                    window.location.href =
                        "thank-you"; // redirecting to payment
                    // $("#confirmModal").modal("show");
                } else {
                    $(".response").html(
                        '<p class="js_response_error">' +
                        return_data.error +
                        "</p>"
                    );
                }
            }
        });
    }
});
