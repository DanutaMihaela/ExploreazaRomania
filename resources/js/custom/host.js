var uploadedImages = [];
var imagesToDelete = [];
$('.files-uploaded').html('');


$(".addPropery").on('click', function(){
    $('.invalid-feedback').hide();
    $('.form-control, .form-check-input').removeClass('border-danger');
    $('.submitPropertyChanges').attr('data-property-id', '');
    $("#property").modal('show');
});

$('#property').on('hidden.bs.modal', function (e) {
    $(this).find("input,textarea,select").val('').end().find("input[type=checkbox], input[type=radio]").prop("checked", "").end();
    uploadedImages = [];
    $('.files-uploaded').html('');
});

$.each($('.user-menu-container .nav-link'), function(index, navItem){
    if($(this).hasClass('active')){
        getPageData($(this).attr('data-menu-link'), 1, true)
    }
});

$('#files').on('change', function(event){
    var selectedInputFiles = $(this)[0].files;
    var selectedInputFilesHtml = $('.files-uploaded').html();
    $.each(selectedInputFiles, function(index, uploadedFile){
        var newFile = true;
        $.each(uploadedImages, function(index, file){
            if(file.name == uploadedFile.name){
                newFile = false;
            }
        });
        if(newFile){
            uploadedImages.push(uploadedFile);
            selectedInputFilesHtml += '<div class="file-item" data-file-name="'+uploadedFile.name+'"><span class="remove-file-icon" data-file-to-remove="'+uploadedFile.name+'"><i class="fa-solid fa-xmark remove-file"></i></span><span class="file-name">'+uploadedFile.name+'</span></div>';
        }
    });
    $('.files-uploaded').html(selectedInputFilesHtml);
});

$('.files-uploaded').on('click', '.remove-file-icon', function(e) {
    e.preventDefault();
    var fileNameToRemove = $(this).attr('data-file-to-remove');
    $(this).parent().remove();

    var indexToRemove;
    $.each(uploadedImages, function(index, file){
        if(fileNameToRemove == file.name){
            indexToRemove = index;
        }
    });
    uploadedImages.splice(indexToRemove, 1);
    imagesToDelete.push(fileNameToRemove);
});


$('.submitPropertyChanges').on('click', function(event){
    event.preventDefault();
    $('.invalid-feedback').hide();
    $('.form-control, .form-check-input').removeClass('border-danger');
    $('.submitPropertyChanges').addClass('disabled').html('<i class="fa-solid fa-spinner fa-spin"></i> Salveaza');

    var formData = new FormData();
    $.each(uploadedImages, function(index, file){
        formData.append("files[]", file);
    });
    formData.append('id', $(this).attr('data-property-id'));
    formData.append('name', $('#name').val());
    formData.append('description', $('#description').val());
    formData.append('rooms', $('#rooms').val());
    formData.append('price', $('#price').val());
    formData.append('guests', $('#guests').val());
    formData.append('siteVizibility', ($('#siteVizibility').is(":checked")) ? "1" : "0");
    formData.append('imagesToDelete', imagesToDelete);
    axios.post('/host/saveProperty', formData, {})
    .then(function (data) {
        setTimeout(function(){
            if(data.data.success){
                $('.submitPropertyChanges').removeClass('disabled').html('Salveaza');
                $('#property').modal('hide');
                $('#property').on('hidden.bs.modal', function (e) {
                    $(this).find("input,textarea,select").val('').end().find("input[type=checkbox], input[type=radio]").prop("checked", "").end();
                });
                uploadedImages = [];
                $('.files-uploaded').html('');
                getPageData('properties', 1, true);
            }
        }, 1000);
    })
    .catch(function (error) {
        setTimeout(function(){
            displayValidationErrorMessages(error.response.data.errors);
            $('.submitPropertyChanges').removeClass('disabled').html('Salveaza');
        }, 1000);
    });
});

$(".user-content-container").on('click', '.editProperty', function(){
    $('.invalid-feedback').hide();
    $('.form-control, .form-check-input').removeClass('border-danger');
    $('.submitPropertyChanges').attr('data-property-id', $(this).attr('data-property-id'));
    axios.post("/host/getProperty", {
        id: $(this).attr('data-property-id')
    })
    .then(function (data) {
        setTimeout(function(){
            var propertyData = data.data;
            if(propertyData){
                $("#property #name").val(propertyData.name);
                $("#property #description").val(propertyData.description);
                $("#property #rooms").val(propertyData.rooms);
                $("#property #guests").val(propertyData.guests);
                $("#property #price").val(propertyData.price_per_night);
                $("#property #siteVizibility").prop('checked', propertyData.siteVizibility);

                $("#property").modal('show');
                var selectedInputFilesHtml = '';
                $.each(propertyData.images, function(index, file){
                    var newFile = new File([""], file.name, {
                        type: file.mimeType,
                        mimetypes: file.mimeType
                    });
                    uploadedImages.push(newFile);
                });

                $.each(uploadedImages, function(index, image){
                    selectedInputFilesHtml += '<div class="file-item" data-file-name="'+image.name+'"><span class="remove-file-icon" data-file-to-remove="'+image.name+'"><i class="fa-solid fa-xmark remove-file"></i></span><span class="file-name">'+image.name+'</span></div>';
                });
                $('.files-uploaded').html(selectedInputFilesHtml);
            }
        }, 100);
    })
    .catch(function (error) {
        setTimeout(function(){}, 1000);
    });
});
$(".user-content-container").on('click', '.remove-property', function(){
    axios.post("/host/removeProperty", {
        id: $(this).attr('data-property-id')
    })
    .then(function () {
        getPageData('properties', 1, true);
    })
});

$('.user-content-container').on('click', '.page-link', function(){
    getPageData($(this).data('area'), $(this).data('page'), false);
});

$('.user-content-container').on('click', '.carousel-control-next', function(){
    $('#carousel-'+$(this).data('id')).carousel('next');
});

$('.user-content-container').on('click', '.carousel-control-prev', function(){
    $('#carousel-'+$(this).data('id')).carousel('prev');
});
$('.user-content-container').on('click', '.booking-request-action', function(){
    var thisElement = $(this);
    var feedbackItem = $(this).closest('.accordion-body').find('.response-confirm');
    $(feedbackItem).addClass((($(this).attr('data-action-type') == 'pay') ? 'green' : 'red'));
    $(thisElement).addClass('disabled').html('<i class="fa-solid fa-spinner fa-spin"></i>' + (($(this).attr('data-action-type') == 'pay') ? ' Accepta prenotare - Trimite cerere plata' : ' Revoca cerere prenotare'));

    axios.post("/host/updateBookingStatus", {
        
        bookingId: $(this).attr('data-booking-id'),
        newStatus: $(this).attr('data-action-type')
    })
    .then(function (data) {
        if(data.data.success){
            setTimeout(function(){
                feedbackItem.fadeIn();
                $(thisElement).html((($(thisElement).attr('data-action-type') == 'pay') ? ' Accepta prenotare - Trimite cerere plata' : ' Revoca cerere prenotare'));
                setTimeout(function(){
                    getPageData('bookings', 1, true);
                }, 3000);
            }, 1000);
        }
    })
    .catch(function (error) {
        setTimeout(function(){
        }, 1000);
    });
});

$('.user-content-container').on('click', '.send-message', function(){
    var thisElement = $(this);
    if($(thisElement).closest('.accordion-body').find('#booking-message').val() != ''){

        var feedbackItem = $(this).closest('.accordion-body').find('.message-sent');
        $(thisElement).addClass('disabled').html('<i class="fa-solid fa-spinner fa-spin"></i> Trimite mesaj');
        axios.post("/host/sendMessage", {
            bookingId: $(thisElement).attr('data-booking-id'),
            message: $(thisElement).closest('.accordion-body').find('#booking-message').val()
        })
        .then(function (data) {
            if(data.data.success){
                setTimeout(function(){
                    feedbackItem.fadeIn();
                    $(thisElement).html('Trimite mesaj')
                    setTimeout(function(){
                        getPageData('bookings', 1, true);
                    }, 3000);
                }, 1000);
            }
        })
        .catch(function (error) {});
    }
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
function getPageData(view, page, initialSearch){
    if(page == 1 && initialSearch){
        $('#data-row-container').html('<span class="loading"><i class="fa-solid fa-cog fa-spin"></i></span>').fadeIn();
    }
    axios.post("/host/getPageData?page=" + page, {
        view: view
    })
    .then(function (data) {
        setTimeout(function(){
            
            if(data.data){
                $('#data-row-container').html('').hide().append(data.data).fadeIn();
            }
            else{
                $('#data-row-container').html('No data found').fadeIn();
            }
        }, ((page == 1, initialSearch) ? 1000 : 20));
    })
    .catch(function (error) {
        setTimeout(function(){
            setTimeout(function(){
                $('#data-row-container').html('No data found').fadeIn();
            }, 1000);
        }, 1000);
    });
}
$('#data-row-container').on('click', '#saveProfile', function(event){
    $('.profile-saved').hide();
    $('.form-control, .form-check-input').removeClass('border-danger');
    $('.invalid-feedback').hide();

    event.preventDefault();
    console.log('click pe buton functioneaza host');

     axios.post("/saveHostProfile", {
        
        firstName: $("#firstName").val(),
        lastName: $("#lastName").val(),
        telephone: $("#telephone").val(),
        website: $("#website").val(),
        email: $("#email").val()
        
    })
    .then(function (response) {
        $('.profile-saved').fadeIn();
        setTimeout(function(){
            $('.profile-saved').fadeOut();
        }, 3000);
    })
    .catch(function (errors) {
        displaySearchValidationErrorMessages(errors.response.data.errors);
    });
});
function displaySearchValidationErrorMessages(validationErrors){
    $.each(validationErrors, function (index, value) {
        var errorMesssages = "";
        $.each(value, function (index2, messageValue) {
            if (messageValue) errorMesssages += messageValue + "<br>";
        });
        $("#invalid-" + index).html(errorMesssages).slideDown();
        $("#" + index).addClass("border-danger");
    });
}