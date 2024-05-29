$('.user-content-container').on('click', '.page-link', function(){
    getPageData($(this).data('area'), $(this).data('page'), false);
});

$('.user-content-container').on('click', '.carousel-control-next', function(){
    $('#carousel-'+$(this).data('id')).carousel('next');
});

$('.user-content-container').on('click', '.carousel-control-prev', function(){
    $('#carousel-'+$(this).data('id')).carousel('prev');
});

$('.user-content-container').on('click', '.remove-favourite', function(){
    axios.post("/tourist/removeFavourite", {
        id: $(this).attr('data-id')
    })
    .then(function () {
        getPageData('favourites', 1, true);
    })
});

$('.user-content-container').on('click', '.star-li', function(){
    var weight = $(this).attr('data-weight')

    var ratingList = $(this).closest('.rating-list').children();
    $.each(ratingList, function(index, listItem){

        $(listItem).css('color', 'lightgrey');
        $(listItem).attr('data-starred', '');

        var currentLiWeight = $(listItem).attr('data-weight');
        if(currentLiWeight <= weight){
            $(listItem).attr('data-starred', 1).css('color', '#2a5b3e');
        }
    });
});

$('.user-content-container').on('click', '.pay', function(){
    var thisElement = $(this);
    $(thisElement).addClass('disabled').html('<i class="fa-solid fa-spinner fa-spin"></i> Plata in curs');
    axios.post("/tourist/pay", {
        bookingId:$(this).attr('data-booking-id'),
    })
    .then(function (data) {
        if(data.data.success){
            setTimeout(function(){
                $(thisElement).html('<i class="fa-solid fa-check"></i> Plata efectuata');
                setTimeout(function(){
                    getPageData('bookings', 1, true);
                }, 3000);
            }, 1000);
        }
    })
    .catch(function (error) {});
});


$('.user-content-container').on('click', '#save-review', function(){
    var thisElement = $(this);
    var feedbackItem = $(this).closest('.accordion-body').find('.review-sent');
    $(thisElement).addClass('disabled').html('<i class="fa-solid fa-spinner fa-spin"></i> Trimite review');
    var starsRatingObject = {};
    var starsRatingContainer = $(this).closest('.accordion-body').find('.star-li');

    $.each(starsRatingContainer, function(index, listItem){
        if(!starsRatingObject[$(listItem).attr('data-type')]){
            var itemName = $(listItem).attr('data-type');
            starsRatingObject[itemName] = 0;
        }
        if($(listItem).attr('data-starred') == '1'){
            starsRatingObject[$(listItem).attr('data-type')] = parseInt(starsRatingObject[$(listItem).attr('data-type')]) + 1;
        }
    });
    axios.post("/tourist/saveReview", {
        bookingId:$(this).attr('data-booking-id'),
        hostId:$(this).attr('data-host-id'),
        propertyId:$(this).attr('data-property-id'),
        reviewDescription: $(this).closest('.accordion-body').find('#review-description').val(),
        starsObject: JSON.stringify(starsRatingObject),
        starsHTML: $(this).closest('.accordion-body').find('.stars-rating-container').html()
    })
    .then(function (data) {
        if(data.data.success){
            setTimeout(function(){
                feedbackItem.fadeIn();
                $(thisElement).html('Trimite review')
                setTimeout(function(){
                    getPageData('reviews', 1, true);
                }, 3000);
            }, 1000);
        }
    })
    .catch(function (error) {});
});
$('.user-content-container').on('click', '.send-message', function(){
    var thisElement = $(this);

    if($(thisElement).closest('.accordion-body').find('#booking-message').val() != ''){

        var feedbackItem = $(this).closest('.accordion-body').find('.message-sent');
        $(thisElement).addClass('disabled').html('<i class="fa-solid fa-spinner fa-spin"></i> Trimite mesaj');
        axios.post("/tourist/sendMessage", {
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

$.each($('.user-menu-container .nav-link'), function(index, navItem){
    if($(this).hasClass('active')){
        getPageData($(this).attr('data-menu-link'), 1, true)
    }
});
function getPageData(view, page, initialSearch){
    if(page == 1 && initialSearch){
        $('#data-row-container').html('<span class="loading"><i class="fa-solid fa-cog fa-spin"></i></span>').fadeIn();
    }
    axios.post("/tourist/getPageData?page=" + page, {
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
            $('#data-row-container').html('No data found').fadeIn();
        }, 1000);
    });
}

$('#data-row-container').on('click', '#saveProfile', function(event){
    $('.profile-saved').hide();
    $('.form-control, .form-check-input').removeClass('border-danger');
    $('.invalid-feedback').hide();

    event.preventDefault();
    console.log('click pe buton functioneaza');

     axios.post("/saveTouristProfile", {
        alias: $("#alias").val(),
        firstName: $("#firstName").val(),
        lastName: $("#lastName").val(),
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