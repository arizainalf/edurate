<div class="modal fade" role="dialog" id="createModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span id="label-modal"></span> Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="saveData" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" id="id">
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama">
                        <small class="invalid-feedback" id="errornama"></small>
                    </div>
                    <div class="form-group">
                        <label for="jabatan_id" class="form-label">Jabatan<span class="text-danger">*</span></label>
                        <select name="jabatan_id" id="jabatan_id" class="form-control">
                        </select>
                        <small class="invalid-feedback" id="errorjabatan_id"></small>
                    </div>
                    <div class="form-group">
                        <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran<span class="text-danger">*</span></label>
                        <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="form-control">
                        </select>
                        <small class="invalid-feedback" id="errormata_pelajaran_id"></small>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
