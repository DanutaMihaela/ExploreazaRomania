@extends('app')
@section('content')
<div class="row main-row">
    <div class="col-6 mt-5 offset-3">
        <form>
        @csrf
        <div class="mb-3">
            <label for="firstName" class="form-label" >Nume</label>
            <input type="text" class="form-control" id="firstName"  name="firstName" placeholder="Nume">
        <div class="invalid-feedback" id="invalid-firstName"></div>
        </div>
        <div class="mb-3">
            <label for="lastName" class="form-label">Prenume</label>
            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Prenume">
            <div class="invalid-feedback" id="invalid-lastName"></div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label" >Email</label>
            <input type="text" class="form-control" id="contactEmail" name="contactEmail" placeholder="Email">
        <div class="invalid-feedback" id="invalid-contactEmail"></div>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Mesaj</label>
            <textarea name="message" class="form-control" id="message" cols="10" rows="5" placeholder="Transmite-ne mesajul tău"></textarea>
            <div class="invalid-feedback" id="invalid-message"></div>
</div>
            <button id="send-enquiry" class="btn button-primary">Trimite cerere</button>
        </form>
    </div> </div> @endsection

