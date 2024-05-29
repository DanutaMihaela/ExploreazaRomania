<div class="accordion" id="accordion-bookings">
    @foreach ($items as $booking)
        <div class="accordion-item">
            <h2 class="accordion-header" id="booking-item-heading-{{$booking->id}}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#booking-item-{{$booking->id}}" aria-expanded="true" aria-controls="booking-item-{{$booking->id}}">
                    {{$booking->property->name}} ({{date('d-m-Y', strtotime($booking->startDate))}} - {{date('d-m-Y', strtotime($booking->endDate))}})
                    <div class="review-status {{($booking->ratings) ? 'green' : 'yellow'}}"><i class="fa-solid fa-circle fa-lg"></i></div>
                </button>
            </h2>
            <div id="booking-item-{{$booking->id}}" class="accordion-collapse collapse" aria-labelledby="booking-item-heading-{{$booking->id}}" data-bs-parent="#accordion-bookings">
            <div class="accordion-body {{($booking->ratings) ? 'disabled-body' : ''}}">
                <div class="row">
                    <div class="col-6">
                        <p class="heading">Date sejur: <span class="booking-detail">({{date('d-m-Y', strtotime($booking->startDate))}} - {{date('d-m-Y', strtotime($booking->endDate))}})</span></p>
                        <p class="heading">Total nopti: <span class="booking-detail">{{\Carbon\Carbon::parse($booking->startDate)->diffInDays($booking->endDate)}}</span></p>
                        <p class="heading">Total turisti: <span class="booking-detail">{{count($booking->tourists)}}</span></p>
                        <p class="heading">Total pret sejur: <span class="booking-detail">{{$booking->totalPrice}} RON</span></p>
                    </div>
                    <div class="col-6 stars-rating-container">
                        @if($booking->ratings)
                            <div class="disabled-stars" disabled>{!!$booking->ratings->starsHtml!!}</div>
                        @else
                            <div class="row">
                                <div class="col-4"><p class="heading stars-heading">Confort:</p></div>
                                <div class="col-8 stars-container">
                                    <ul class="list-inline rating-list confort">
                                        <li class="star-li" data-type="confort" data-weight="5" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="confort" data-weight="4" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="confort" data-weight="3" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="confort" data-weight="2" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="confort" data-weight="1" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4"><p class="heading stars-heading">Curatenie:</p></div>
                                <div class="col-8 stars-container">
                                    <ul class="list-inline rating-list cleanlines">
                                        <li class="star-li" data-type="cleanlines" data-weight="5" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="cleanlines" data-weight="4" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="cleanlines" data-weight="3" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="cleanlines" data-weight="2" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="cleanlines" data-weight="1" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4"><p class="heading stars-heading">Locatie:</p></div>
                                <div class="col-8 stars-container">
                                    <ul class="list-inline rating-list location">
                                        <li class="star-li" data-type="location" data-weight="5" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="location" data-weight="4" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="location" data-weight="3" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="location" data-weight="2" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="location" data-weight="1" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4"><p class="heading stars-heading">Comunicare gazda:</p></div>
                                <div class="col-8 stars-container">
                                    <ul class="list-inline rating-list communication">
                                        <li class="star-li" data-type="communication" data-weight="5" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="communication" data-weight="4" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="communication" data-weight="3" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="communication" data-weight="2" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                        <li class="star-li" data-type="communication" data-weight="1" data-starred=""><span class="star"><i class="fa fa-star"></i></span></li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-12 review-description-container mt-4">
                        <textarea class="form-control {{($booking->ratings) ? 'review-description-disabled' : ''}}" id="review-description" rows="4" {{($booking->ratings) ? 'disabled' : ''}}>{{($booking->ratings) ? $booking->ratings->description : ''}}</textarea>
                    </div>
                    <div class="col-12 align-self-center mt-4">
                        @if(!$booking->ratings)
                            <button class="btn button-primary-inverted-no-border" id="save-review" data-booking-id="{{$booking->id}}" data-host-id="{{$booking->hostId}}" data-property-id="{{$booking->propertyId}}">Trimite review</button>
                        @endif
                    </div>
                    <p class="review-sent mt-4"><i class="fa-solid fa-check fa-lg"></i> Review-ul a fost salvat cu success!</p>
                </div>
            </div>
            </div>
        </div>
    @endforeach
</div>
@include('partials.pagination')

<style>
    .disabled-body{
        background-color: #ededed;
        opacity: 0.8;
    }
    .disabled-stars{
        pointer-events: none;
    }
    .review-sent{
        color: #2a5b3e;
        display: none;
    }
    #save-review{
        padding: 8px 50px 8px 50px;
    }
    #save-review:hover{
        background-color: #f2f2f2;
    }
    .stars-container{
        font-size: 22px;
        cursor: pointer;
    }
    #review-description{
        height: 100px;
        min-height: 100px;
        max-height: 250px;
    }
    .review-description-disabled{
        background-color: #f1f1f1 !important;
    }
    .stars-heading{
        margin: 5px 0px 0px 0px;
    }

    .rating-list{
        margin: 0px;
    }
    .rating-list li {
        float: right;
        color: lightgrey;
        padding: 0px 5px;
    }

    .rating-list li:hover,
    .rating-list li:hover ~ li {
        color: #2a5b3e;
    }

    .rating-list {
        display: inline-block;
        list-style: none;
    }

    .accordion-item{
        border: 1px solid #2a5b3e9e;
    }
    .accordion-button{
        background-color: #f3f3f3;
        color: #2a5b3e;
    }
    .accordion-button:not(.collapsed){
        background-color: #f3f3f3;
        color: #2a5b3e;
        /* border: 1px solid #2a5b3e; */
    }
    .accordion-button:focus{
        border-color: none;
        box-shadow: none;
        color: #2a5b3e;
        /* border: 1px solid #2a5b3e; */
    }
    .review-status{
        position: absolute;
        right: 55px;
        color: #2a5b3e;
    }
    p{
        margin-bottom: 5px;
    }
    .heading{
        color: #2a5b3e;
        font-size: 16px;
        font-weight: 400;
    }
    .booking-detail{
        font-size: 16px;
        font-weight: 300;
        color: grey;
    }

    .booking-detail.status{
        /* border: 1px solid #c7c8c9; */
        padding: 7px;
        border-radius: 11px;
        cursor: pointer;
    }
    .yellow{
        color: #f4ac01;
    }

    .green{
        color: #2a5b3e
    }

    .accept-booking, .send-message{
        color: #2a5b3e;
        margin: 0px 18px 0px 0px;
    }

    .deny-booking{
        color: #ff0000d6;
        margin: 0px 18px 0px 0px;
    }

    .booking-detail.status.pay:hover{
        color: #0ea1d1;
        background-color: #f2f2f2;
    }

    .accept-booking:hover, .send-message:hover{
        background-color: #f2f2f2;
    }

    .deny-booking:hover{
        background-color: #f2f2f2;
        color: #ff0000d6;
    }
    .booking-messages{
        max-height: 225px;
        overflow-y: scroll;
    }
    .message-container{
        border: 1px solid #dddddd;
        border-radius: 20px;
        padding: 10px 10px 10px 10px;
        font-size: 13px;
    }
    .message-details{
        color: #9f9f9f;
    }
    .message{
        font-weight: 500;
    }
    #booking-message{
        height: 80px;
        min-height: 80px;
        max-height: 180px;
    }

    .response-confirm, .message-sent{
        margin-top: 8px;
        display: none;
    }

    .response-confirm .accept, .message-sent{
        color: #2a5b3e;
    }
    .response-confirm .deny{
        color: #ff0000d6;
    }
</style>