<div class="accordion" id="accordion-bookings">
    @foreach ($items as $booking)
        <div class="accordion-item">
            <h2 class="accordion-header" id="booking-item-heading-{{$booking->id}}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#booking-item-{{$booking->id}}" aria-expanded="true" aria-controls="booking-item-{{$booking->id}}">
                    {{$booking->property->name}} ({{date('d-m-Y', strtotime($booking->startDate))}} - {{date('d-m-Y', strtotime($booking->endDate))}})
                    <div class="booking-status {{$booking->status}}"><i class="fa-solid fa-circle fa-lg"></i></div>
                </button>
            </h2>
            <div id="booking-item-{{$booking->id}}" class="accordion-collapse collapse" aria-labelledby="booking-item-heading-{{$booking->id}}" data-bs-parent="#accordion-bookings">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-6">
                        <p class="heading">Date prenotare: <span class="booking-detail">({{date('d-m-Y', strtotime($booking->startDate))}} - {{date('d-m-Y', strtotime($booking->endDate))}})</span></p>
                        <p class="heading">Total nopți: <span class="booking-detail">{{\Carbon\Carbon::parse($booking->startDate)->diffInDays($booking->endDate)}}</span></p>
                        <p class="heading">Total turiști: <span class="booking-detail">{{count($booking->tourists)}}</span></p>
                        <p class="heading">Total preț sejur: <span class="booking-detail">{{$booking->totalPrice}} RON</span></p>
                        <hr>
                        <div class="col-6 tourists-list">
                            @foreach ($booking->tourists as $index => $tourist)
                                <p class="heading">Turist {{$index = $index + 1}}: <span class="booking-detail">{{$tourist->firstName}} {{$tourist->lastName}}</span></p>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-6 booking-messages">
                        <p class="heading">Mesaje conversație</p>
                        @foreach ($booking->messages as $index => $message)
                            <p class="booking-detail message-container"><span class="message-details">{{ (($message->hostId) ? 'Gazda ' : 'Turist ') . '(' . date('d-m-Y', strtotime($message->added)) . '):'}}</span><span class="message">{{$message->message}}</span></p>
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        @if($booking->status == "request")
                        <button class="card-edit btn button-primary-inverted-no-border booking-request-action accept-booking" data-action-type="pay" data-booking-id="{{$booking->id}}">Acceptă prenotare / Trimite cerere plată</button>
                        <button class="card-edit btn button-primary-inverted-no-border booking-request-action deny-booking" data-action-type="rejected" data-booking-id="{{$booking->id}}">Revocă cerere prenotare</button>
                        @elseif($booking->status == "pay")
                            <p class="heading">Status: <span class="booking-detail">Plata sejurului în asteptare</span></p>
                        @elseif($booking->status == "paid")
                            <p class="heading">Status: <span class="booking-detail">sejur achitat</span></p>
                        @elseif($booking->status == "ongoing")
                            <p class="heading">Status: <span class="booking-detail">sejur acceptat/în curs de desfășurare</span></p>
                        @elseif($booking->status == "complete")
                            <p class="heading">Status: <span class="booking-detail">sejur/prenotare completată</span></p>
                        @elseif($booking->status == "rejected")
                            <p class="heading">Status: <span class="booking-detail">cerere prenotare sejur respinsă pe data de: {{date('d-m-Y', strtotime($booking->updated))}}</span></p>
                        @endif
                        @if($booking->status == "request")
                            <p class="response-confirm"><i class="fa-solid fa-check fa-lg"></i> Răspunsul a fost trimis cu succes</p>
                        @endif
                    </div>
                    <div class="col-6">
                        @if($booking->status != "complete")
                            <textarea class="form-control" id="booking-message" rows="3"></textarea>
                            <button class="card-edit btn button-primary-inverted-no-border send-message mt-3" data-booking-id="{{$booking->id}}">Trimite mesaj</button>
                            <p class="message-sent"><i class="fa-solid fa-check fa-lg"></i> Mesajul a fost trimis</p>
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </div>
    @endforeach
</div>
@include('partials.pagination')


<style>
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
    }
    .accordion-button:focus{
        border-color: none;
        box-shadow: none;
        color: #2a5b3e;
        /* border: 1px solid #2a5b3e; */
    }
    .booking-status{
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
    .request{
        color: #f4ac01;
    }
    .pay{
        color: #0ea1d1;
    }
    .paid{
        color: #4e4ef0;
    }
    .ongoing{
        color: #2a5b3e
    }
    .complete{
        color: #afafaf
    }
    .rejected{
        color: #f23801
    }
    .accept-booking, .send-message{
        color: #2a5b3e;
        margin: 0px 18px 0px 0px;
    }
    .deny-booking{
        color: #ff0000d6;
        margin: 0px 18px 0px 0px;
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