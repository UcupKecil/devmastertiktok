<form id="transferForm">
    <div class="modal" tabindex="-1" role="dialog" id="transferModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transfer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Member</label>
                        <input type="text" id="name" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Saldo member</label>
                        <input type="text" id="point" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="debit">Jumlah terkirim</label>
                        <input type="text" id="debit" class="form-control price" name="debit"
                            autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="submitTransfer">Transfer</button>
                </div>
            </div>
        </div>
    </div>
</form>
