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
                        <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name">
                        <small class="invalid-feedback" id="errornama"></small>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email">
                        <small class="invalid-feedback" id="erroremail"></small>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password Baru <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="password" type="password" class="form-control" name="password">
                            <div class="input-group-append">
                                <a class="btn bg-white d-flex justify-content-center align-items-center border"
                                    onclick="togglePasswordVisibility('#password', '#toggle-password'); event.preventDefault();">
                                    <i id="toggle-password" class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <small class="text-danger" id="errorpassword"></small>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                            <div class="input-group-append">
                                <a class="btn bg-white d-flex justify-content-center align-items-center border"
                                    onclick="togglePasswordVisibility('#password_confirmation', '#toggle-password-confirmation'); event.preventDefault();">
                                    <i id="toggle-password-confirmation" class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <small class="invalid-feedback" id="errorpassword_confirmation"></small>
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
