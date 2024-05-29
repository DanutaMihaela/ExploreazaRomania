
$('#login').on('click', function(){
    $('.invalid-feedback').hide();
    $('.form-control, .form-check-input').removeClass('border-danger');
    $('#login').addClass('disabled').html('<i class="fa-solid fa-spinner fa-spin"></i> Login');
    axios.post("/login", {
        email: $("#email").val(),
        password: $("#password").val(),
        userType: $("input[name='userType']:checked").attr('data-user-type') ?? null
    })
    .then(function (data) {
        setTimeout(function(){
            if(data.data.success){
                $('#login').removeClass('disabled').html('Login');
                window.location.replace("/" + data.data.userType + "/dashboard");
            }
        }, 1000);
    })
    .catch(function (error) {
        setTimeout(function(){
            displayValidationErrorMessages(error.response.data.errors);
            $('#login').removeClass('disabled').html('Login');
        }, 1000);
    });
});

function displayValidationErrorMessages(validationErrors){
    $.each(validationErrors, function (index, value) {
        var errorMesssages = "";
        $.each(value, function (index2, messageValue) {
            if (messageValue) errorMesssages += messageValue + "<br>";
        });
        $("#invalid-" + index).html(errorMesssages).slideDown();
        $("#" + index).addClass("border-danger");
    });
}



