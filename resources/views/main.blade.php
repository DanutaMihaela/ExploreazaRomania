@extends('app')
@section('content')
    <div class="all-container">
        <div class="search-area-container">
            <div class="empty-row"></div>
            @include('partials.search')
            <div class="results-container" style="margin: 30px 0px 0px 0px;">
                <div class="row d-flex justify-content-center" id="results" style="display:none; margin:0px;"></div>
            </div>
        </div>
    </div>
@endsection
<style>
     .all-container{
        background-image: url(assets/images/idylic-background.jpg);
        background-size: cover;
     }
</style>