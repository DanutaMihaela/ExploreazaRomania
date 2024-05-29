@extends('userIndex')
@section('userContent')
    <div class="row">
        <div class="col">
            <div class="statuses">
                <span class="request yellow" data-toggle="tooltip" data-placement="top" title="Cerere sejur"><i class="fa-solid fa-circle fa-lg"></i>(cerere)</span>
                <span class="pay lightblue" data-toggle="tooltip" data-placement="top" title="Sejur de achitat"><i class="fa-solid fa-circle fa-lg"></i>(sejur de achitat)</span>
                <span class="paid blue" data-toggle="tooltip" data-placement="top" title="Sejur achitat"><i class="fa-solid fa-circle fa-lg"></i>(sejur achitat)</span>
                <span class="ongoing green" data-toggle="tooltip" data-placement="top" title="Sejur in desfasurare"><i class="fa-solid fa-circle fa-lg"></i>(sejur în curs)</span>
                <span class="complete grey" data-toggle="tooltip" data-placement="top" title="Sejur completat"><i class="fa-solid fa-circle fa-lg"></i>(sejur completat)</span>
                <span class="denied red" data-toggle="tooltip" data-placement="top" title="Cerere sejur respinsa"><i class="fa-solid fa-circle fa-lg"></i>(cerere sejur respinsă)</span>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center" id="data-row-container" style="display:none"></div>
    @include('modals.property')
@endsection
<style>
    .statuses{
        margin: 0px 0px 20px;
    }
    .lightblue{
        cursor: pointer;
        color: #0ea1d1;
    }
    .blue{
        cursor: pointer;
        color: #4e4ef0;
    }
    .yellow{
        cursor: pointer;
        color: #f4ac01;
    }
    .green{
        cursor: pointer;
        color: #2a5b3e
    }
    .grey{
        cursor: pointer;
        color: #afafaf
    }
    .red{
        cursor: pointer;
        color: #f23801
    }
    span{
        margin: 0px 3px 0px 3px
    }
</style>
