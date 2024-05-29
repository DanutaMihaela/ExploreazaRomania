
<form>{{-- acest csrf trebuie tot timpul cand se folosesc forms. --}}
    @csrf
    <div class="col-6 offset-3">
        <div class="row justify-content-center row-search-container">
            <div class="col col-from-date nopadding">
                <div class="form-floating">
                    <input type="text" class="form-control search-input search-input-from-date datePickerInput" id="fromDate">
                    <label class="label label-fromDate" for="fromDate">Dată sosirie</label>
                </div>
            </div>
            <div class="col col-to-date nopadding">
                <div class="border-line border-line-left"></div>
                <div class="form-floating">
                    <input type="text" class="form-control search-input search-input-to-date datePickerInput" id="toDate">
                    <label class="label label-toDate" for="toDate">Dată plecare</label>
                </div>
            </div>
            <div class="col col-rooms nopadding">
                <div class="border-line border-line-right"></div>
                <div class="form-floating">
                    <input type="number" min="1" max="99" class="form-control search-input search-input-rooms" id="rooms">
                    <label class="label label-rooms" for="rooms">Camere</label>
                </div>
            </div>
            <div class="col col-guest-number nopadding">
                <div class="border-line border-line-right"></div>
                <div class="form-floating">
                    <input type="text" class="form-control search-input search-input-guests" id="guestsNumber">
                    <label class="label label-guestsNumber" for="guestsNumber">Număr turiști</label>
                </div>
            </div>
            <div class="col-1 col-search nopadding">
                <div class="border-line border-line-right"></div>
                <span class="search-icon" id="search-properties"><i class="fa-solid fa-magnifying-glass"></i></span>
            </div>
        </div>
    </div>
</form>
