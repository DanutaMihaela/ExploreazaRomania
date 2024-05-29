<div class="row main-row">
    <div class="col-6 mt-5 offset-3">
        <form>
            {{-- acest csrf trebuie tot timpul cand se folosesc forms. --}}
            @csrf
            <div class="mb-3">
                <label for="firstName" class="form-label">Nume</label>
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Nume" value="{{$user->firstName}}">
                <div class="invalid-feedback" id="invalid-firstName"></div>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Prenume</label>
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Prenume" value="{{$user->lastName}}">
                <div class="invalid-feedback" id="invalid-lastName"></div>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Telefon</label>
                <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Telefon" value="{{$user->telephone}}">
                <div class="invalid-feedback" id="invalid-telephone"></div>
            </div>
            <div class="mb-3">
                <label for="website" class="form-label">website</label>
                <input type="text" class="form-control" id="website" name="website" placeholder="website" value="{{$user->website}}">
                <div class="invalid-feedback" id="invalid-website"></div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{$user->email}}">
                <div class="invalid-feedback" id="invalid-email"></div>
            </div>
            <button id="saveProfile" class="btn button-primary">Salvează schimbările</button>
            <p class="profile-saved mt-4" style="display:none;"><i class="fa-solid fa-check fa-lg"></i> Profilul a fost salvat cu succes</p>
        </form>
    </div>
</div>