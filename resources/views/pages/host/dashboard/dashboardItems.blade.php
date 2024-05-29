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
<style>
    .card{
        border: 1px solid #2a5b3e9e;
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
</style>