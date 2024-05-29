@foreach ($statisticsData as $statisticItem)
    <div class="col-auto d-flex gx-5 gy-5">
        <div class="row d-flex justify-content-center">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{$statisticItem['label']}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{$statisticItem['description']}}</h6>
                    <p class="card-text">
                        <span class="total"><span class="statistics-icon"><i class="fa-solid fa-chart-column"></i></span>{{$statisticItem['total']}}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endforeach
@if($nextBooking)
    <div class="row">
        <div class="col">
            <h5 class="next-booking text-center"><span class="next-holiday-icon"><i class="fa-solid fa-mountain-sun"></i></span>Urmatoarul sujer incepe in: {{\Carbon\Carbon::parse(\Carbon\Carbon::now())->diffInDays($nextBooking->startDate)}} zile</h5>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-lg-3 col-sm-6 text-center">
            <div class="card mb-3">
                @if (count($nextBooking->property->images) > 1)
                    <div id="carousel-{{$nextBooking->propertyId}}" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($nextBooking->property->images as $image)
                                <div class="card-image-container carousel-item {{($nextBooking->property->firstImage == $image) ? 'active' : ''}}">
                                    <img class="card-img-top" src="{{asset('hosts/' . $nextBooking->hostId . '/propertiesImages/' . $nextBooking->propertyId . '/' . $image)}}">
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control carousel-control-prev" data-id="{{$nextBooking->property->id}}" role="button" data-slide="prev">
                            <span class="carousel-prev-icon"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control carousel-control-next" data-id="{{$nextBooking->property->id}}" role="button" data-slide="next">
                            <span class="carousel-prev-icon"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                @else
                    <div class="card-image-container">
                        <img class="card-img-top" src="{{asset('hosts/' . $nextBooking->hostId . '/propertiesImages/' . $nextBooking->propertyId . '/' . $nextBooking->property->firstImage)}}">
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title next-booking-card-title">{{$nextBooking->property->name}}</h5>
                    @foreach($nextBooking->tourists as $tourist)
                        <p class="card-text tourist-detail">{{$tourist->firstName . ' ' . $tourist->lastName}}</p>
                    @endforeach
                    <hr>
                    <p class="card-text tourist-detail">({{date('d-m-Y', strtotime($nextBooking->startDate))}} - {{date('d-m-Y', strtotime($nextBooking->endDate))}})</p>
                    <hr>
                    <p class="card-text money-details"><span class="money"><i class="fa-solid fa-coins fa-lg"></i></span>{{$nextBooking->totalPrice}} RON</p>
                </div>
            </div>
        </div>
    </div>
@endif
<style>
    .card-img-top{
        border-top-left-radius: 22px;
        border-top-right-radius: 22px;
    }
    .card-title {
        color: #2a5b3e;
        font-size: 18px;
        min-height: 70px;
        background-color: #ededed;
        padding: 14px;
        color: #2a5b3e;
        border-top-right-radius: 24px;
        border-top-left-radius: 24px;
    }
    .next-booking-card-title{
        border-radius: 0px;
        font-size: 18px;
        line-height: 42px;
    }
    .next-booking{
        margin: 35px 0px 35px 0px;
        color: #2a5b3e;
    }
    .next-holiday-icon{
        margin:0px 15px 0px 0px;
    }
    .tourist-detail{
        margin:0px 0px 5px 0px !important;
        padding: 0px !important;
    }
    .card-body {
        padding: 0px;
    }
    .card {
        padding: 0px;
        border: 1px solid #c0c0c0
        box-shadow: -4px 0px 20px 0px rgb(190 202 194);
        border-radius: 24px;
    }
    .card:hover{
        cursor: pointer;
        box-shadow: 0px 0px 14px 0px rgb(42 91 62 / 21%);
    }
    .card-subtitle {
        font-size: 14px;
        font-weight: 100;
        min-height: 78px;
        padding: 14px;
    }
    .total{
        font-size: 28px;
        color: #555555;
    }
    .statistics-icon{
        margin: 0px 20px 0px 0px;
        color: #2a5b3e;
        font-size: 28px;
    }
    .card-text {
        padding: 0px 0px 15px 25px;
    }
    .carousel .carousel-control {
        visibility: hidden;
    }
    .carousel:hover .carousel-control {
        color: #2a5b3e;
        opacity: 1;
        background-color: #ffffff69;
        font-size: 32px;
        visibility: visible;
    }
    .card-img-top{
        object-fit: cover;
        max-height: 180px;
    }
    .money-details{
        padding: 0px;
        padding-bottom: 14px;
    }
    .money{
        color: #2a5b3e;
        margin: 0px 10px 0px 0px;
    }
</style>