<ul class="pagination justify-content-center mt-5 mb-5">
    <li class="page-item {{($items->onFirstPage()) ? 'disabled' : ''}}">
        <a class="page-link previous-page" data-page="{{$items->currentPage() - 1}}" data-area="{{$page}}" tabindex="-1"><span class="icon"><i class="fa-solid fa-circle-chevron-left fa-xl"></i></span></a>
    </li>
    <li class="page-item {{($items->currentPage() == $items->lastPage()) ? 'disabled' : ''}}">
        <a class="page-link next-page" data-page="{{$items->currentPage() + 1}}" data-area="{{$page}}"><span class="icon"><i class="fa-solid fa-circle-chevron-right fa-xl"></i></span></a>
    </li>
</ul>
<style>
    .page-item{
        cursor: pointer;
    }
    .page-item a{
        margin: 0px 10px 0px 10px;
        padding: 5px 30px 5px 30px;
    }

    .page-item.disabled .icon{
        color: lightgrey;
    }
    .page-item .icon{
        color: #2a5a3e;
        font-size: 20px;
    }
    .page-item a:hover{
        border: 1px solid #2a5a3e;
        background-color: white;
    }
</style>