<div class="modal fade" id="loginModal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Login</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                {{-- acest csrf trebuie tot timpul cand se folosesc forms. --}}
                @csrf
                <div class="modal-body">
                    <div class="body-content">
                        @include('partials.login')
                        <div class="mb-3">
                            <label for="userType" class="form-label d-block">Tip utilizator: </label>
                            <div class="btn-group" role="group">
                                <input type="radio" name="userType" class="btn-check" id="btnCheckTourist" data-user-type="tourist" autocomplete="off">
                                <label class="btn btn-outline-primary px-4" for="btnCheckTourist">Turist</label>
                                <input type="radio" name="userType" class="btn-check" id="btnCheckHost" data-user-type="host" autocomplete="off">
                                <label class="btn btn-outline-primary px-4" for="btnCheckHost">Gazdă</label>
                            </div>
                            <div class="invalid-feedback" id="invalid-userType"></div>
                        </div>
                        <div class="invalid-feedback" id="invalid-credentials"></div>
                        <p class="mt-3" style="color:#2a5b3e">Nu aveți un cont? Inregistrați-vă <a class="register-from-login" style="cursor:pointer;">aici</a></p>
                    </div>
                </div>
            </form>
            <div class="modal-footer justify-content-center">
                <button class="btn button-primary" id="login">Login</button>
            </div>
        </div>
    </div>
</div>