<div class="modal fade" id="registerModal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Inregistrează-te</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                {{-- acest csrf trebuie tot timpul cand se folosesc forms. --}}
                @csrf
                <div class="modal-body">
                    <p>Bine ai venit pe Explorează România. <br> Inregistrează-te ca și turist dacă vrei să găsești locuri de cazare sau ca și gazdă dacă ai un loc de cazare disponibil.</p>
                    <div class="body-content mt-4 mb-4">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item nav-fill w-50 register-user-type" data-user-type="tourist">
                                        <a class="nav-link justify-content-center custom-nav-link active" data-bs-toggle="tab" href="#turist">Turist</a>
                                    </li>
                                    <li class="nav-item nav-fill w-50 register-user-type" data-user-type="host">
                                        <a class="nav-link justify-content-center custom-nav-link" data-bs-toggle="tab" href="#gazda">Gazdă</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane container active px-0" id="turist">
                                @include('partials.registerTourist')
                            </div>
                            <div class="tab-pane container fade px-0" id="gazda">
                                @include('partials.registerHost')
                            </div>
                        </div>
                    </div>
                    <p class="mt-3" style="color:#2a5b3e">Aveți deja un cont? Logați-vă <a class="login-from-register" style="cursor:pointer;">aici</a></p>
                </div>
                <input type="hidden" id="registerType" value="tourist">
            </form>
            <div class="modal-footer justify-content-center">
                <button class="btn button-primary" id="registerUser">Inregistrează-te</button>
            </div>
        </div>
    </div>
</div>