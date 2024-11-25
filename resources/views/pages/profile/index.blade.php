@extends('layouts.app')

@section('title', 'Profil')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-dark">Data @yield('title')</h4>
                            </div>
                            <div class="card-body">
                                <form id="updateData">
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name" class="form-label">Nama <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ Auth::user()->name }}">
                                        <small class="invalid-feedback" id="errorname"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ Auth::user()->email }}">
                                        <small class="invalid-feedback" id="erroremail"></small>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-dark">Ubah Password</h4>
                            </div>
                            <div class="card-body">
                                <form id="updatePassword">
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="password_lama" class="form-label">Password Lama <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password_lama"
                                                name="password_lama">
                                            <div class="input-group-append">
                                                <a class="btn bg-white d-flex justify-content-center align-items-center border"
                                                    onclick="togglePasswordVisibility('#password_lama', '#toggle-password-lama'); event.preventDefault();">
                                                    <i id="toggle-password-lama" class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <small class="text-danger" id="errorpassword_lama"></small>
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
                                        <small class="text-danger" id="errorpassword_confirmation"></small>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success d-none d-lg-block">Simpan</button>
                                        <button type="submit"
                                            class="btn btn-success d-block w-100 d-lg-none">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#updateData").submit(function(e) {
                e.preventDefault();
                const formData = new FormData();
                const url = `{{ route('profil') }}`;

                // Tambahkan semua field dari form
                $(this).serializeArray().forEach(field => {
                    formData.append(field.name, field.value);
                });

                sendProfileUpdate(formData, url);
            });

            function sendProfileUpdate(formData, url) {
                const successCallback = function(response) {
                    setButtonLoadingState("#updateData .btn.btn-success", false);
                    handleSuccess(response, null, null, "no");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#updateData .btn.btn-success", false);
                    handleValidationErrors(error, "updateData", ["nama", "email"]);
                };

                ajaxCall(url, "POST", formData, successCallback, errorCallback);
            }
        });
    </script>
@endpush
