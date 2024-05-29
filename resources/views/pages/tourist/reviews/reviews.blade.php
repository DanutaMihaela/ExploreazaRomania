@extends('userIndex')
@section('userContent')
    <div class="row">
        <div class="col">
            <div class="statuses">
                <span class="statuses-circle yellow" data-toggle="tooltip" data-placement="top" title="Nu a-ti lasat nici un review"><i class="fa-solid fa-circle fa-lg"></i>(În așteptare review)</span>
                <span class="statuses-circle green" data-toggle="tooltip" data-placement="top" title="Ati lasat review"><i class="fa-solid fa-circle fa-lg"></i>(review completat)</span>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center" id="data-row-container"></div>
@endsection
<style>
.statuses{
    margin: 0px 0px 20px;
}
.statuses-circle{
    margin:0px 5px 0px 0px;
}
.yellow{
        cursor: pointer;
        color: #f4ac01;
    }
.green{
    cursor: pointer;
    color: #2a5b3e
}
</style>