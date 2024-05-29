@extends('userIndex')
@section('userContent')
    <div class="row">
        <div class="col">
            <button class="btn button-primary float-end addPropery"><i class="fa-solid fa-plus"></i> Adaugă proprietate</button>
        </div>
    </div>
    <div class="row d-flex justify-content-center" id="data-row-container" style="display:none"></div>
    @include('modals.property')
@endsection

