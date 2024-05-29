    <div class="modal fade" id="quick-property-book">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cerere prenotare</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form>{{-- acest csrf trebuie tot timpul cand se folosesc forms. --}} @csrf
                    <div class="modal-body">
                        <div class="row booking-details">
                            <h5 class="mt-3">Detalii proprietate</h3>
                            <hr>
                            <div class="col-6 card-image-container">
                                <img class="quick-property-book-image" src="">
                            </div>
                            <div class="col-6">
                                <p class="quick-property-description"></p>
                            </div>
                        </div>
                        <div class="row booking-description mt-2 mb-2">
                            <h5 class="mt-3">Detalii sejur</h3>
                            <hr>
                            <p class="request-from-date mb-1"></p>
                            <p class="request-to-date mb-1"></p>
                            <p class="request-rooms mb-1"></p>
                            <p class="request-guests mb-1"></p>
                        </div>
                        <div class="row booking-description mt-2 mb-2">
                            <h5 class="mt-3">Mesaj</h3>
                            <hr>
                            <textarea class="form-control" id="message" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <h5 class="mt-3">Detalii turisti</h3>
                            <hr>
                        </div>
                        <div class="booking-tourists-list mt-2 mb-2"></div>
                    </div>
                </form>
                <div class="modal-footer justify-content-center">
                    <button class="btn button-primary" id="send-book-request" data-property-id="" data-host-id="" data-tourist-id="" data-from-date="" data-to-date="" data-price="">Trimite cerere</button>
                </div>
                <div class="row">
                    <div class="col text-center mt-3 mb-4">
                        <div class="request-success-message"><i class="fa-solid fa-check fa-lg"></i> Cererea a fost trimisa cu success!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        h5{
            color:#2a5b3e
        }
        .booking-tourists-list{
            overflow-y: scroll;
            height: 300px;
            overflow-x: hidden;
        }
        .request-success-message{
            color:#2a5b3e;
            display:none;
        }
        .quick-property-book-image{
            object-fit: cover;
            max-height: 250px;
            min-height: 250px;
        }
    </style>