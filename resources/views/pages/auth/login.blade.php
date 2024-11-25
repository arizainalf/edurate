@extends('layouts.auth')

@section('title', 'Login')

@push('style')
<!-- Custom Styles -->
<style>
    /* Button color */
    .btn-primary {
        background-color: #104064 !important; /* Dark blue */
        color: #fff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #082c4a !important; /* Darker blue for hover */
        color: #fff;
    }

    .btn-primary:active {
        background-color: #072c3a !important; /* Even darker blue for active state */
        color: #fff;
    }

    /* Input field style */
    .form-control {
        border: 1px solid #dcdcdc;
        border-radius: 10px;
    }

    .form-control:focus {
        border-color: #104064; /* Match button color */
        box-shadow: 0 0 5px rgba(16, 64, 100, 0.5);
    }

    /* Welcome text style */
    .welcome-text {
        color: #104064; /* Dark blue */
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
        margin-top: 15px;
        margin-bottom: 10px;
    }

    /* Subtext style */
    .subtext {
        color: #6c757d; /* Dark gray */
        font-size: 0.9rem;
        text-align: center;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    /* Background image */
    .background-moving {
        background-image: url('{{ asset('img/guru3.jpg') }}');
        background-position: center center;
        background-size: contain;
        background-repeat: no-repeat;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    /* Footer styles */
    .text-muted-transparent {
        color: rgba(255, 255, 255, 0.9) !important;
    }
</style>
@endpush

@section('main')
<section class="section">
    <div class="d-flex align-items-stretch flex-wrap">
        <!-- Login Form Section -->
        <div class="col-lg-4 col-12 order-lg-1 min-vh-100 order-2 bg-white d-flex justify-content-center align-items-center">
            <div class="py-4 px-3">
                <!-- Logo -->
                <div class="text-center mb-4">
                    <img src="{{ asset('img/logo2.png') }}" alt="logo" class="img-fluid" style="max-height: 40px;">
                </div>

                <!-- Welcome Text -->
                <div class="welcome-text">Selamat Datang di EduGrade</div>
                <div class="subtext">Silakan login untuk melanjutkan</div>

                <!-- Login Form -->
                <form id="login" autocomplete="off">
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input id="email" type="email" class="form-control" name="email" placeholder="Masukan Alamat Email Anda">
                        <small class="invalid-feedback" id="erroremail"></small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="password" type="password" class="form-control" name="password" placeholder="Masukan Password Anda">
                            <div class="input-group-append">
                                <button class="btn bg-white border" onclick="togglePasswordVisibility('#password', '#toggle-password'); event.preventDefault();">
                                    <i id="toggle-password" class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <small class="text-danger" id="errorpassword"></small>
                    </div>
                    <div class="form-group">
                        <!-- Updated Button -->
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            <i class="fas fa-sign-in mr-2"></i>Masuk
                        </button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="text-small mt-5 text-center">
                    Copyright &copy; {{ date('Y') }} <span class="bullet"></span> Khiria Legacy
                </div>
            </div>
        </div>

        <!-- Background Image with Parallax Effect -->
        <div class="d-none d-lg-block col-lg-8 py-5 min-vh-100 background-moving position-relative overlay-gradient-bottom order-1">
            <div class="absolute-bottom-left index-2 p-5 pb-2">
                <div class="text-light">
                    <h5 class="font-weight-normal text-muted-transparent">SDIT ABU BAKAR ASH-SHIDIQ</h5>
                    <h5 class="font-weight-normal text-muted-transparent">Rajapolah, Tasikmalaya</h5>
                    <h5 id="current-time" class="font-weight-normal text-muted-transparent"></h5>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

<script>
    // Update time dynamically in WIB (Indonesia Time)
    function updateTime() {
        const timeElement = document.getElementById("current-time");
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false,
            timeZone: 'Asia/Jakarta'
        };
        timeElement.innerHTML = now.toLocaleString('id', options);
    }

    setInterval(updateTime, 1000); // Update time every second

    $(document).ready(function() {
        $("#login").submit(function(e) {
            e.preventDefault();
            setButtonLoadingState("#login .btn.btn-primary", true, "Logging in");

            const url = "{{ route('login') }}";
            const data = new FormData(this);

            const successCallback = function(response) {
                setButtonLoadingState("#login .btn.btn-primary", false,
                    "<i class='fas fa-sign-in mr-2'></i>Login");
                handleSuccess(response, null, null, "/");
            };

            const errorCallback = function(error) {
                setButtonLoadingState("#login .btn.btn-primary", false,
                    "<i class='fas fa-sign-in mr-2'></i>Login");
                handleValidationErrors(error, "login", ["email", "password"]);
            };

            ajaxCall(url, "POST", data, successCallback, errorCallback);
        });
    });
</script>
@endpush
