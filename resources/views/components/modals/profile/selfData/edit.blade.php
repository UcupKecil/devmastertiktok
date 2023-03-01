<form id="editDataForm">
    <input type="hidden" id="id">
    <div class="modal" tabindex="-1" role="dialog" id="editData">
        <div class="modal-dialog modal-lg" role="document">
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
                            <div class="col-lg-6">
                                <label for="name">Nama</label>
                                <input type="text" id="name" placeholder="Silahkan isi nama terlebih dahulu."
                                    class="form-control" name="name" value="{{ $currentUser->name }}"
                                    autocomplete="off">
                            </div>
                            <div class="col-lg-6">
                                <label for="phone">Telepon</label>
                                <input type="text" id="phone" class="form-control" name="phone" value="{{ $detailUser->phone }}" autocomplete="off">
                            </div>
                           
                               
                            <div class="col-lg-6">
                                <label for="bank_id">Bank</label>
                                <select name="bank_id" id="bank_id" class="form-control">
                                    @foreach ($bank as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                                </div>

                                


                                <div class="col-lg-6">
                                <label for="account_number">Rekening</label>
                                <input type="text" id="account_number" class="form-control" name="account_number" value="{{ $detailUser->account_number }}" autocomplete="off">
                                </div>

                                
                           
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="submitEditData">Sunting</button>
                </div>
            </div>
        </div>
    </div>
</form>
