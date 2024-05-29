@foreach ($items as $property)
    <div class="col-auto d-flex gx-5 gy-5">
        <div class="card" style="width: 18rem;">
            @if (!$search)
                <span class="remove-property" data-property-id="{{$property->id}}">
                    <i class="fa-solid fa-square-xmark"></i>
                </span>
                <span class="icon-background-layer"></span>
            @endif
            @if (count($property->images) > 1)
                <div id="carousel-{{$property->id}}" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($property->images as $image)
                            <div class="card-image-container carousel-item {{($property->firstImage == $image) ? 'active' : ''}}">
                                <img class="card-img-top" src="{{asset('hosts/' . $property->hostId . '/propertiesImages/' . $property->id . '/' . $image)}}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control carousel-control-prev" data-id="{{$property->id}}" role="button" data-slide="prev">
                        <span class="carousel-prev-icon"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control carousel-control-next" data-id="{{$property->id}}" role="button" data-slide="next">
                        <span class="carousel-prev-icon"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            @else
                <div class="card-image-container" style="height: fit-content;">
                    <img class="card-img-top" src="{{asset('hosts/' . $property->hostId . '/propertiesImages/' . $property->id . '/' . $property->firstImage)}}" >
                </div>
            @endif
            <h5 class="card-title">{{$property->name}}
                @if ($search && isset($user) && $userType == 'tourist')
                    <div class="favourite-property" data-favourite="{{($userType == 'tourist' && isset($property->userFavourite) && $property->userFavourite == 1) ? 'hearted' : 'nothearted'}}" data-property-id="{{$property->id}}" data-host-id="{{$property->hostId}}">
                        @if($userType == 'tourist' && isset($property->userFavourite) && $property->userFavourite == 1)
                            <i class="fa-solid fa-heart"></i>
                        @else
                            <i class="fa-regular fa-heart"></i>
                        @endif
                    </div>
                @endif
            </h5>
            @if (!$search)
                <div class="card-body">
                    <p class="card-text multi-line">{{$property->description}}</p>
                </div>
            @endif
            <ul class="list-group list-group-flush">
                @if ($search)
                    <li class="list-group-item">Descriere
                        <span class="stats-value float-end">
                            <span class="info" data-quick-description="{{$property->description}}"><i class="fa-solid fa-circle-info fa-lg"></i></span>
                        </span>
                    </li>
                @endif
                <li class="list-group-item">Camere:
                    <span class="stats-value float-end">{{$property->rooms}}</span>
                </li>
                <li class="list-group-item">Maxim persoane:
                    <span class="stats-value float-end">{{$property->guests}}</span>
                </li>
                <li class="list-group-item">Preț/noapte:
                    <span class="stats-value float-end"><span class="money"><i class="fa-solid fa-coins fa-lg"></i></span> {{number_format($property->price_per_night, 2, '.', ','); }}RON</span>
                </li>
                <li class="list-group-item">Evaluări:
                    @if(($property->rating))
                        <span class="stats-value float-end">{{$property->rating}} <span class="info"><i class="fa-solid fa-star fa-lg"></i></span></span>
                    @else
                        <span class="stats-value float-end">-</span>
                    @endif
                </li>
                @if (!$search)
                    <li class="list-group-item">Vizibilitate site:
                        <span class="stats-value float-end {{($property->siteVizibility) ? 'disponibila' : 'indisponibila'}}"><i class="fa-solid fa-circle"></i></span>
                    </li>
                @endif
            </ul>
            <div class="card-body text-center">
                @if (!$search)
                    <button class="card-edit btn button-primary-inverted-no-border editProperty" data-property-id="{{$property->id}}"><i class="fa-solid fa-pen"></i> Editează</button>
                @else
                    <span class="span-bookRequestProperty" @if($userType != 'tourist') data-toggle="tooltip" data-placement="top" title="Logheaza-te ca turist pentru a putea prenota" @endif @if($userType == 'tourist' && isset($property->userOngoingBooking) && $property->userOngoingBooking) data-toggle="tooltip" data-placement="top" title="Prenotare sau cerere in curst pentru aceasta proprietate" @endif>
                        <button class="card-edit btn button-primary-inverted-no-border bookRequestProperty {{($userType != 'tourist' || ($userType == 'tourist' && isset($property->userOngoingBooking) && $property->userOngoingBooking)) ? 'disabled' : ''}}" data-property-id="{{$property->id}}" data-host-id="{{$property->hostId}}" data-tourist-id="{{($user) ? $user->id : ''}}" data-quick-description="{{$property->description}}"  data-price-per-night="{{$property->price_per_night}}" data-first-image-src="{{asset('hosts/' . $property->hostId . '/propertiesImages/' . $property->id . '/' . $property->firstImage)}}" data-max-tourists="{{$property->guests}}">Prenoteaza</button>
                    </span>
                @endif
            </div>
        </div>
    </div>
@endforeach
@include('partials.pagination')
@if ($search)
    @include('modals.propertyDescription')
    @include('modals.book')
@endif
<style>
    .card:hover{
        cursor: pointer;
        box-shadow: 0px 0px 14px 0px rgb(42 91 62 / 21%);
    }
    .card:hover > .remove-property{
        display: block;
    }
    .card:hover > .icon-background-layer{
        display: block;
    }
    .card-img-top {
        height: 16vw;
        object-fit: cover;
        max-height: 250px;
        min-height: 250px;
    }
    .multi-line {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
        height: 73px;
    }
    .card-title{
        padding: 15px 15px 15px 15px;
        border-bottom: 1px solid #dfdfdf;
        margin: 0px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        position:relative
    }
    .button-primary-inverted-no-border{
        background-color: white;
        color: #2a5b3e;
        padding-right: 40px;
        padding-left: 40px;
    }

    .button-primary-inverted-no-border:hover{
        background-color: #2a5b3e;
        color: white;
        opacity: 0.9;
    }
    .indisponibila{
        color: #e78362;
        margin-top: 5px;
    }
    .disponibila{
        color: #4fa572;
        margin-top: 5px;
    }
    .remove-property{
        display: none;
        position: absolute;
        right: -13px;
        top: -13px;
        color: #f0460d;
        font-size: 30px;
        z-index: 1;
        cursor: pointer;
    }
    .favourite-property{
        position: absolute;
        right: 16px;
        top: 22px;
        color: #f0460d;
        font-size: 22px;
        z-index: 1;
        cursor: pointer;
        padding: 5px;
    }
    .heart.heart-on.hide-heart, .heart.heart-off.hide-heart{
        display: none;
    }
    .icon-background-layer{
        display: none;
        background-color: white;
        right: -4px;
        top: -4px;
        width: 15px;
        height: 15px;
        position: absolute;
        z-index: 0;
        cursor: pointer;
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
    img{
        height: 100%;
        object-fit: cover;
    }
    .info{
        color: #2a5b3e;
    }
    .money{
        color: #2a5b3e;
        margin: 0px 5px;
    }
</style>

