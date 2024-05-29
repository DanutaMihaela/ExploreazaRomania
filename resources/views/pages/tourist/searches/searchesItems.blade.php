<div class="row">
    <table class="table table-bordered table-hover table-lg">
        <thead class="table-header">
            <tr class="table-header-row">
                <th scope="col table-row-heading">#</th>
                <th scope="col table-row-heading">Dată sosire</th>
                <th scope="col table-row-heading">Dată plecare</th>
                <th scope="col table-row-heading">Numar camere</th>
                <th scope="col table-row-heading">Numar turiști</th>
                <th scope="col table-row-heading">Data căutări</th>
            </tr>
        </thead>
        <tbody class="table-body">
            @foreach($items as $key => $searchItem)
                <tr class="table-body-row">
                    <th class="table-body-row-number" scope="row">{{$searchItem->id}}</th>
                    <td class="table-body-row-item">{{date('d-m-Y', strtotime($searchItem->startDate))}}</td>
                    <td class="table-body-row-item">{{date('d-m-Y', strtotime($searchItem->endDate))}}</td>
                    <td class="table-body-row-item">{{$searchItem->rooms}}</td>
                    <td class="table-body-row-item">{{$searchItem->tourists}}</td>
                    <td class="table-body-row-item">{{date('d-m-Y', strtotime($searchItem->added))}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('partials.pagination')
<style>
    .table{
        background-color: #f2f2f2;
    }
    .table-header-row{
        height: 50px;
        line-height: 30px;
        color: #2a5b3e;
    }
    .table-body-row:hover{
        cursor: pointer;
        background-color: #f8f8f8;
    }
    .table-body-row{
        height: 35px;
        line-height: 25px;
        color: #565656;
    }
    .info{
        color: #2a5b3e;
        font-style: italic;
    }
</style>