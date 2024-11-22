@extends('layouts.auth')

@section('title', 'Login')

@push('style')
<!-- Custom Styles -->
<style>
    /* Button color that matches the background */
    .btn-primary {
        background-color: #FF9E80; /* Pastel orange */
        color: #fff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #FF7043; /* Dark orange */
        color: #fff;
    }

    .btn-success {
        background-color: #FF80AB; /* Pastel pink */
        color: #fff;
        border: none;
    }

    .btn-success:hover {
        background-color: #FF4081; /* Dark pink */
        color: #fff;
    }

    /* Input field style */
    .form-control {
        border: 1px solid #dcdcdc;
        border-radius: 10px;
    }

    .form-control:focus {
        border-color: #FF9E80; /* Pastel orange */
        box-shadow: 0 0 5px rgba(255, 158, 128, 0.5);
    }

    /* Link color */
    .text-small a {
        color: #FF9E80; /* Pastel orange */
    }

    .text-small a:hover {
        color: #FF7043; /* Dark orange */
        text-decoration: underline;
    }

    /* Background text color */
    .text-muted-transparent {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    /* Border and padding for login section */
    .min-vh-100 {
        border-right: 1px solid #f0f0f0;
    }

    /* Adjust padding for aesthetics */
    .py-4.px-3 {
        padding: 2rem;
        max-width: 400px;
    }

    /* Animation for moving background */
    @keyframes backgroundMove {
        0% {
            background-position: 0 0;
        }
        100% {
            background-position: 100% 100%;
        }
    }

    .background-moving {
        animation: backgroundMove 20s linear infinite;
        background-size: cover;
        background-attachment: fixed;
    }

    /* Font size for the date and time */
    #current-time {
        font-size: 0.8rem; /* Small font size */
        font-weight: normal; /* Normal font weight */
        margin-top: 5px; /* Slight space above the time */
    }
</style>
@endpush

@section('main')
    <section class="section">
        <div class="d-flex align-items-stretch flex-wrap">
            <!-- Login Form Section -->
            <div
                class="col-lg-4 col-12 order-lg-1 min-vh-100 order-2 bg-white d-flex justify-content-center align-items-center">
                <div class="py-4 px-3">
                    <!-- Logo -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('img/logo.png') }}" alt="logo" class="img-fluid" style="max-height: 30px;">
                    </div>
                    <!-- Login Form -->
                    <form id="login" autocomplete="off">
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input id="email" type="email" class="form-control" name="email"
                                placeholder="Enter your email">
                            <small class="invalid-feedback" id="erroremail"></small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control" name="password"
                                    placeholder="Enter your password">
                                <div class="input-group-append">
                                    <button class="btn bg-white border"
                                        onclick="togglePasswordVisibility('#password', '#toggle-password'); event.preventDefault();">
                                        <i id="toggle-password" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="text-danger" id="errorpassword"></small>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                <i class="fas fa-sign-in mr-2"></i>Login
                            </button>
                        </div>
                    </form>

                    <!-- Forgot Password Link -->
                    <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}" class="text-small font-weight-bold">Forgot Password?</a>
                    </div>

                    <!-- Footer -->
                    <div class="text-small mt-5 text-center">
                        Copyright &copy; {{ date('Y') }} <span class="bullet"></span> Khiria Legacy
                    </div>
                </div>
            </div>

            <!-- Background Image with Moving Effect -->
            <div class="d-none d-lg-block col-lg-8 py-5 min-vh-100 background-moving position-relative overlay-gradient-bottom order-1"
                style="background-image: url('{{ asset('img/anime.jpg') }}');">
                <div class="absolute-bottom-left index-2 p-5 pb-2">
                    <div class="text-light">
                        <h5 class="font-weight-normal text-muted-transparent">SDIT ABU BAKAR ASH-SHIDIQ</h5>
                        <h5 class="font-weight-normal text-muted-transparent">Rajapolah, Tasikmalaya</h5>
                        <h5 id="current-time" class="font-weight-normal text-muted-transparent"></h5> <!-- Dynamic time -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

    <script>
        // Update time dynamically in WIB (Indonesia Time) without AM/PM
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
                hour12: false, // Remove AM/PM
                timeZone: 'Asia/Jakarta' // Use WIB time zone
            };
            timeElement.innerHTML = now.toLocaleString('en-US', options);
        }

        setInterval(updateTime, 1000); // Update time every second

        $(document).ready(function() {
            $("#login").submit(function(e) {
                e.preventDefault();

                // Set loading state on button
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
