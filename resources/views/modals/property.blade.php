<div class="modal fade" id="property">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalii proprietate</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form enctype="multipart/form-data"> {{-- acest csrf trebuie tot timpul cand se folosesc forms. --}} @csrf
                <div class="modal-body">
                    <div class="body-content">
                        <div class="mb-3 mt-3">
                            <label for="name" class="form-label">Nume proprietate</label>
                            <input type="input" class="form-control" id="name" name="name" placeholder="Nume proprietate">
                            <div class="invalid-feedback" id="invalid-name"></div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="description" class="form-label">Descriere:</label>
                            <textarea class="form-control edit-property-description" rows="5" id="description" name="description"></textarea>
                            <div class="invalid-feedback" id="invalid-description"></div>
                        </div>
                        <div class="mb-3 mt-3">
                            <div class="row">
                                <div class="col">
                                    <label for="rooms" class="form-label">Număr camere</label>
                                    <input type="input" class="form-control" id="rooms" name="rooms" placeholder="Numar camere">
                                    <div class="invalid-feedback" id="invalid-rooms"></div>
                                </div>
                                <div class="col">
                                    <label for="guests" class="form-label">Număr maxim total oaspeți</label>
                                    <input type="input" class="form-control" id="guests" name="guests" placeholder="Numar maxim total oaspeti">
                                    <div class="invalid-feedback" id="invalid-guests"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <div class="row">
                                <div class="col-3">
                                    <label for="price" class="form-label">Preț/noapte</label>
                                    <input type="input" class="form-control" id="price" name="price" placeholder="Pret/noapte">
                                </div>
                                <div class="invalid-feedback" id="invalid-price"></div>
                            </div>
                        </div>
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="siteVizibility" id="siteVizibility"> Vizibilă pe site
                          <div class="invalid-feedback" id="invalid-siteVizibility"></div>
                        </label>

                        <div class="mb-3 mt-3">
                            <div class="btn btn-outline-primary btn-sm file-upload-button">Adaugă poze proprietate
                                <input type="file" name="files[]" id="files" multiple/>
                            </div>
                            <div class="files-uploaded"></div>
                            <div class="invalid-feedback" id="invalid-files"></div>
                        </div>
                        <p class="invalid-feedback mt-4" id="invalid-vizibility"></p>
                    </div>
                </div>
            </form>
            <div class="modal-footer justify-content-center">
                <button class="btn button-primary submitPropertyChanges" data-property-id="">Salvează</button>
            </div>
        </div>
    </div>
</div>
<style>
    .file-upload-button {
        position: relative;
        overflow: hidden;
    }
    #files{
        cursor: pointer;
        position: absolute;
        font-size: 50px;
        opacity: 0;
        right: 0;
        top: 0;
    }
    .file-item{
        border: 1px solid #e4e4e4;
        width: fit-content;
        padding: 4px 8px 4px 8px;
        border-radius: 8px;
        margin: 10px 0px 0px 0px;
        background-color: #f8f8f8;
        position: relative;
        display: inline-block;
        margin: 5px 3px 0px 3px;
        cursor: pointer;
    }
    .remove-file-icon{
        position: absolute;
        right: -6px;
        top: -6px;
        display: none;
    }
    .file-item:hover .remove-file-icon{
        display: block;
        color: #295c3e;
        cursor: pointer;
    }
    .invalid-vizibility{
        color: red;
    }
    .edit-property-description{
        min-height: 200px;
        max-height: 200px;
    }
</style>