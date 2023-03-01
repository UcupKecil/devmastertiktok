<form id="editPasswordForm">
    <input type="hidden" id="id">
    <div class="modal" tabindex="-1" role="dialog" id="editPassword">
        <div class="modal-dialog modal-xs" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sunting Profil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="name">Kata Sandi Lama</label>
                                <input type="password" id="old_password" placeholder="Silahkan isi Kata sandi lama."
                                    class="form-control" name="old_password" autocomplete="off">

                                <label for="name">Kata Sandi</label>
                                <input type="password" id="password" placeholder="Silahkan isi Kata sandi baru."
                                    class="form-control" name="password" autocomplete="off">

                                <label for="name">Konfirmasi Kata Sandi</label>
                                <input type="password" id="new_password" placeholder="Silahkan Konfirmasi kata sandi."
                                    class="form-control" name="new_password" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="submitEditPassword">Sunting</button>
                </div>
            </div>
        </div>
    </div>
</form>
