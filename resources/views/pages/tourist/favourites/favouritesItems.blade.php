@foreach ($items as $favourite)
    <div class="col-auto d-flex gx-5 gy-5">
        <div class="row d-flex justify-content-center">
            <div class="card" style="width: 18rem;">
                <span class="remove-favourite" data-id="{{$favourite->id}}">
                    <i class="fa-solid fa-square-xmark"></i>
                </span>
                <span class="icon-background-layer"></span>
                @if (count($favourite->property->images) > 1)
                    <div id="carousel-{{$favourite->property->id}}" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($favourite->property->images as $image)
                                <div class="card-image-container carousel-item {{($favourite->property->firstImage == $image) ? 'active' : ''}}">
                                    <img class="card-img-top" src="{{asset('hosts/' . $favourite->hostId . '/propertiesImages/' . $favourite->propertyId . '/' . $image)}}">
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control carousel-control-prev" data-id="{{$favourite->property->id}}" role="button" data-slide="prev">
                            <span class="carousel-prev-icon"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control carousel-control-next" data-id="{{$favourite->property->id}}" role="button" data-slide="next">
                            <span class="carousel-prev-icon"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                @else
                    <div class="card-image-container" style="height: fit-content;">
                        <img class="card-img-top" src="{{asset('hosts/' . $favourite->hostId . '/propertiesImages/' . $favourite->propertyId . '/' . $favourite->property->firstImage)}}" >
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{$favourite->property->name}}<span class="hearted float-end"><i class="fa-solid fa-heart"></i></span>
                    </h5>
                    <div class="description">
                        {{$favourite->property->description}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@include('partials.pagination')

<style>
    .card{
        padding: 0px;
    }
    .card-body{
        padding: 0px;
    }
    .card-footer{
        padding: 20px;
        border: none;
    }
    .card:hover{
        cursor: pointer;
        box-shadow: 0px 0px 14px 0px rgb(42 91 62 / 21%);
    }
    .card:hover > .remove-favourite{
        display: block;
    }
    .card:hover > .remove-favourite{
        display: block;
    }
    .card:hover > .icon-background-layer{
        display: block;
    }
    .card-img-top {
        object-fit: cover;
        max-height: 180px;
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

    .remove-favourite{
        display: none;
        position: absolute;
        right: -13px;
        top: -13px;
        color: #f0460d;
        font-size: 30px;
        z-index: 1;
        cursor: pointer;
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

    .hearted{
        font-size: 22px;
        color: red;
    }
    .description{
        padding: 15px 15px 15px 15px;
        overflow-x: hidden;
        height: 162px;
        min-height: 162px;
    }

    .description::-webkit-scrollbar {
        display: none;
    }
</style>