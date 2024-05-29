
    const urlSearchParams = new URLSearchParams(window.location.search);

    $('[data-toggle="tooltip"]').tooltip();

    $('body').tooltip({
        selector: '[data-toggle="tooltip"]'
    });

    if(urlSearchParams.has('login')){
        $('#loginModal').modal('show');
        window.history.pushState({}, document.title, "/");
    }
    if(urlSearchParams.has('register')){
        $('#registerModal').modal('show');
        window.history.pushState({}, document.title, "/");
    }
    $('.register-from-login').on('click', function(){
        $('#loginModal').modal('hide');
        $('#registerModal').modal('show');
    });
    $('.login-from-register').on('click', function(){
        $('#registerModal').modal('hide');
        $('#loginModal').modal('show');
    });
    $('#search-properties').on('click', function(){
        search(1, true);
    });
    $('.results-container').on('click', '.page-link', function(){
        search($(this).data('page'));
    });
    $('.results-container').on('click', '.carousel-control-next', function(){
        $('#carousel-'+$(this).data('id')).carousel('next');
    });
    $('.results-container').on('click', '.carousel-control-prev', function(){
        $('#carousel-'+$(this).data('id')).carousel('prev');
    });
    $('.results-container').on('click', '.info', function(){
        $('.quick-description').html('').html($(this).data('quick-description'));
        $('#quick-property-description').modal('show');
    });
    $('.results-container').on('click', '.bookRequestProperty', function(){
        
        $(this).closest('.results-container').find('.request-from-date').html('').html('Data sosire: ' + $('#fromDate').val());
        $(this).closest('.results-container').find('.request-to-date').html('').html('Data plecare: ' + $('#toDate').val());
        $(this).closest('.results-container').find('.request-rooms').html('').html('Numar camere: ' + $('#rooms').val());
        $(this).closest('.results-container').find('.request-guests').html('').html('Numar turisti: ' + $('#guestsNumber').val());
        $(this).closest('.results-container').find('.request-guests').html('').html('Pret/noapte: ' + $(this).attr('data-price-per-night'));

        $(this).closest('.results-container').find('.quick-property-book-image').attr('src', $(this).data('first-image-src'));
        $(this).closest('.results-container').find('.quick-property-description').html('').html($(this).data('quick-description'));

        $(this).closest('.results-container').find('#send-book-request').attr("data-property-id", $(this).attr('data-property-id'));
        $(this).closest('.results-container').find('#send-book-request').attr("data-host-id", $(this).attr('data-host-id'));
        $(this).closest('.results-container').find('#send-book-request').attr("data-tourist-id", $(this).attr('data-tourist-id'));
        $(this).closest('.results-container').find('#send-book-request').attr("data-from-date", $('#fromDate').val());
        $(this).closest('.results-container').find('#send-book-request').attr("data-to-date", $('#toDate').val());
        $(this).closest('.results-container').find('#send-book-request').attr("data-price-per-night", $(this).attr('data-price-per-night'));

        var touristDetailHtml = '';
        for (var index = 1; index <= $(this).data('max-tourists'); index++) {
            touristDetailHtml += '<div class="mb-3"><div class="row tourist-details">'+
            '<div class="col-6">'+
                '<label for="tourist-'+index+'-first-name" class="form-label">Nume turist '+index+': </label>'+
                '<input type="text" class="form-control" id="tourist-'+index+'-first-name" name="tourist-'+index+'-first-name">'+
                '<div class="invalid-feedback" id="tourist-'+index+'-first-name"></div>'+
            '</div>'+
                '<div class="col-6">'+
                    '<label for="tourist-'+index+'-last-name" class="form-label">Prenume turist '+index+':</label>'+
                    '<input type="text" class="form-control" id="tourist-'+index+'-last-name" name="tourist-'+index+'-last-name">'+
                    '<div class="invalid-feedback" id="tourist-'+index+'-last-name"></div>'+
                '</div>'+
            '</div></div>';
        };
        $(this).closest('.results-container').find('.booking-tourists-list').html('').html(touristDetailHtml);
        $('#quick-property-book').modal('show');
    });
    $('.results-container').on('click', '.favourite-property', function(){
        $(this).attr('data-favourite', ($(this).attr('data-favourite') == 'hearted') ? 'nothearted' : 'hearted');
        if($(this).attr('data-favourite') == 'hearted'){
            $(this).html('').html('<i class="fa-solid fa-heart"></i>');
        }
        else{
            $(this).html('').html('<i class="fa-regular fa-heart"></i>');
        }
        axios.post("/favourite", {
            hostId: $(this).attr('data-host-id'),
            propertyId: $(this).attr('data-property-id')
        });
    });

    $(".datePickerInput").datepicker({
        monthNames: ['Ianuarie', 'Februarie', 'Martie', 'Aprilie', 'Mai', 'Iunie', 'Iulie', 'August', 'Septembrie', 'Octombrie', 'Noiembrie', 'Decembrie'],
        monthNamesShort: ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun', 'Iul', 'Aug', 'Sept', 'Oct', 'Noi', 'Dec'],
        dayNames: ['Duminica', 'Luni', 'Marti', 'Miercuri', 'Joi', 'Vineri', 'Sambata'],
        dayNamesMin: ['Du', 'Lu', 'Ma', 'Mi', 'Jo', 'Vi', 'Sa'],
        dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        firstDay: 1,
        minDate: new Date(),
        dateFormat: 'dd/mm/yy',
        onSelect: function(date) {
            if($(this).hasClass('search-input-from-date')){
                $(".search-input-to-date").datepicker("option", "defaultDate", date);
            }
        },
        beforeShow: function(input, inst) {
            inst.dpDiv.css({
                marginTop: '0px',
                marginLeft: '-52px'
            });
        }
    });

    $("#send-enquiry").on('click', function(event){
        event.preventDefault();
        axios.post("/contacteaza", {
            firstName: $("#firstName").val(),
            lastName: $("#lastName").val(),
            contactEmail: $("#contactEmail").val(),
            message: $("#message").val()
        })
        .then(function (response) {
        })
        .catch(function (errors) {
            displaySearchValidationErrorMessages(errors.response.data.errors);

        });
    });
    $('.results-container').on('click', '#send-book-request', function(e){
        var bookRequestButton = $(this);
        bookRequestButton.addClass('disabled').html('<i class="fa-solid fa-spinner fa-spin"></i> Trimite cerere');
        e.preventDefault();
        var tourists = [];
        var touristDetailsContainer = bookRequestButton.closest('#quick-property-book').find('.booking-tourists-list').children();
        $.each(touristDetailsContainer, function (index, item) {
            index = index + 1;
            if($(item).find('#tourist-'+index+'-first-name').val() != ''){
                tourists.push({firstName: $(item).find('#tourist-'+index+'-first-name').val(), lastName: $(item).find('#tourist-'+index+'-last-name').val()});
            }
        });
        axios.post("/book", {
            propertyId: $(this).attr('data-property-id'),
            hostId: $(this).attr('data-host-id'),
            touristId: $(this).attr('data-tourist-id'),
            fromDate: $(this).attr('data-from-date'),
            toDate: $(this).attr('data-to-date'),
            pricePerNight: $(this).attr('data-price-per-night'),
            message: bookRequestButton.closest('#quick-property-book').find('#message').val(),
            tourists: JSON.stringify(tourists)
        })
        .then(function (data) {
            if(data.data.success){
                setTimeout(function(){
                    bookRequestButton.html('Trimite cerere');
                    $('.request-success-message').fadeIn();
                    setTimeout(function(){
                        $('#quick-property-book').modal('hide');
                    }, 3000);
                }, 1000);
                $.each($(".bookRequestProperty"), function (index, item) {
                    if($(this).attr('data-host-id') == bookRequestButton.attr('data-host-id') && $(this).attr('data-property-id') == bookRequestButton.attr('data-property-id')){
                        $(this).addClass('disabled');
                    }
                });
            }
        })
        .catch(function (error) {});
    });

    function search(page, initialSearch){
        if(page == 1 && initialSearch){
            $('#results').html('<span class="loading"><i class="fa-solid fa-cog fa-spin"></i></span>').fadeIn();
        }
        axios.post("/search?page=" + page, {
            fromDate: $("#fromDate").val(),
            toDate: $("#toDate").val(),
            rooms: $("#rooms").val(),
            guestsNumber: $("#guestsNumber").val(),
        })
        .then(function (data) {
            setTimeout(function(){
                if(data.data){
                    $('#results').html('').hide().append(data.data).fadeIn();
                }
                else{
                    $('#results').html('').html('<span class="no-results">Cautare nu a produs rezultate</span>').fadeIn();
                }
            }, ((page == 1, initialSearch) ? 1000 : 20));
        })
        .catch(function (error) {
            setTimeout(function(){
                $('#results').html('').html('<span class="no-results">Cautare nu a produs rezultate</span>').fadeIn();
            }, 1000);
        });
    }
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
