<form id="editForm">
    <div class="modal" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sunting Section</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Section</label>
                        <input type="text" id="name" class="form-control" name="name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="order">Urutan</label>
                        <select name="order" id="order" class="form-control"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="submitEdit">Sunting</button>
                </div>
            </div>
        </div>
    </div>
</form>
