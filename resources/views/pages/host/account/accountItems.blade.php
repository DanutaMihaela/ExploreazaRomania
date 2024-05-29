
@foreach($accountPlans as $plan)
<div class="col-auto d-flex gx-5 gy-5">
    <div class="row d-flex justify-content-center">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                @if($user->planId == $plan->id && $user->siteVizibility)
                    <div class="ribbon-wrapper"><div class="ribbon">{{($user->trial) ? 'Trial' : 'Planul tau'}}</div></div>
                @endif
                <h5 class="card-title text-center my-auto">
                    <span class="align-middle">{{ucfirst($plan->planName)}}</span>
                </h5>
                <h6 class="card-subtitle mb-2 text-muted">{{$plan->planDescription}}</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        @if($plan->id != 4)
                            <span>Vizibilitate site: <span class="float-end">{{$plan->siteVizibilityDuration}} {{($plan->siteVizibilityDurationType == 'months') ? (($plan->siteVizibilityDuration == 1) ? 'luna' : 'luni' ) : (($plan->siteVizibilityDuration == 1) ? 'an' : 'ani' )}}</span></span>
                        @else
                            <span>Vizibilitate: <span class="float-end">NELIMITATA</span></span>
                        @endif
                    </li>
                    <li class="list-group-item">
                        @if($plan->id != 4)
                            <span>Proprietăți vizibile: <span class="float-end">{{$plan->propertiesVizibilityNumber}}</span></span>
                        @else
                            <span>Proprietăți vizibile: <span class="float-end">NELIMITATE</span></span>
                        @endif
                    </li>
                    <li class="list-group-item">
                        <span>Preț/Luna: <span class="float-end">{{$plan->planPrice . ' RON'}}</span></span>
                    </li>
                </ul>
                <div class="text-center pb-4 pt-4">
                    @if($user->planId != $plan->id || $user->siteVizibility == 0)
                        <button href="#" class="btn button-primary account-upgrade-action">Upgrade</a>
                    @endif
                </div>
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
        font-size: 24px;
        background-color: #ededed;
        padding: 14px;
        color: #2a5b3e;
        border-top-right-radius: 24px;
        border-top-left-radius: 24px;
        line-height: 2;
    }

    .card-body {
        padding: 0px;
    }

    .card {
        position: relative;
        padding: 0px;
        border: 1px solid #c0c0c0
        box-shadow: -4px 0px 20px 0px rgb(190 202 194);
        border-radius: 25px;
    }

    .card:hover{
        cursor: pointer;
        box-shadow: 0px 0px 14px 0px rgb(42 91 62 / 21%);
    }

    .card-subtitle {
        font-size: 14px;
        font-weight: 100;
        min-height: 146px;
        padding: 14px;
        border-bottom: 1px solid #dfdfdf;
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

    .list-group{
        border-bottom: 1px solid #dfdfdf;
    }

    li.list-group-item{
        padding: 18px;
        color: #414141;
    }

    .account-upgrade-action{
        padding: 8px 40px 8px 40px;
    }

    .float-end{
        font-weight: 300;
        color: #2a5b3e;
    }

    .ribbon-wrapper {
        width: 85px;
        height: 88px;
        overflow: hidden;
        position: absolute;
        top: -1px;
        left: -1px;
    }
    .ribbon {
        font: bold 15px sans-serif;
        color: #333;
        text-align: center;
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        -ms-transform: rotate(-45deg);
        -o-transform: rotate(-45deg);
        position: relative;
        padding: 8px 8px 8px 0px;
        top: 11px;
        left: -33px;
        width: 138px;
        background-color: #2a5b3e;
        color: #fff;
        font-size: 14px;
        font-weight: 100;
        letter-spacing: 1px;
        box-shadow: 0px 0px 4px 1px rgb(42 91 62 / 60%);
    }
}
</style>