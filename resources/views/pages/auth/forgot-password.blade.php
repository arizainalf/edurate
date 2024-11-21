@extends('layouts.auth')

@section('title', 'Forgot Password')

@push('style')
<!-- Custom Styles -->
<style>
    /* Button styles */
    .btn-primary {
        background-color: #FF9E80; /* Pastel orange */
        color: #fff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #FF7043; /* Dark orange */
        color: #fff;
    }

    /* Input field styles */
    .form-control {
        border: 1px solid #dcdcdc;
        border-radius: 10px;
    }

    .form-control:focus {
        border-color: #FF9E80; /* Pastel orange */
        box-shadow: 0 0 5px rgba(255, 158, 128, 0.5);
    }

    /* Link styles */
    .text-small a {
        color: #FF9E80; /* Pastel orange */
    }

    .text-small a:hover {
        color: #FF7043; /* Dark orange */
        text-decoration: underline;
    }

    /* Background text styles */
    .text-muted-transparent {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    /* Login section border and padding */
    .min-vh-100 {
        border-right: 1px solid #f0f0f0;
    }

    /* Adjust padding for aesthetics */
    .py-4.px-3 {
        padding: 2rem;
        max-width: 400px;
    }

    /* Background animation */
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

    /* Small font size for dynamic time */
    #current-time {
        font-size: 0.8rem; /* Small font size */
        font-weight: normal; /* Normal font weight */
        margin-top: 5px; /* Space above the time */
    }
</style>
@endpush

@section('main')
<section class="section">
    <div class="d-flex align-items-stretch flex-wrap">
        <!-- Forgot Password Form Section -->
        <div class="col-lg-4 col-12 order-lg-1 min-vh-100 order-2 bg-white d-flex justify-content-center align-items-center">
            <div class="py-4 px-3">
                <!-- Logo -->
                <div class="text-center mb-4">
                    <img src="{{ asset('img/logo.png') }}" alt="logo" class="img-fluid" style="max-height: 40px;">
                </div>
                <!-- Forgot Password Form -->
                <form id="forgot-password" autocomplete="off">
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input id="email" type="email" class="form-control" name="email" placeholder="Enter Your Email">
                        <small class="invalid-feedback" id="erroremail"></small>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            <i class="fas fa-key mr-2"></i>Forgot Password
                        </button>
                    </div>
                </form>

                <!-- Link to Login -->
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-small font-weight-bold">Back to Login</a>
                </div>

                <!-- Footer -->
                <div class="text-small mt-5 text-center">
                    Copyright &copy; {{ date('Y') }} <span class="bullet"></span> Khiria Legacy
                </div>
            </div>
        </div>

        <!-- Image with moving background -->
        <div class="d-none d-lg-block col-lg-8 py-5 min-vh-100 background-moving position-relative overlay-gradient-bottom order-1"
            style="background-image: url('{{ asset('img/background.jpg') }}');">
            <div class="absolute-bottom-left index-2 p-5 pb-2">
                <div class="text-light">
                    <h5 class="font-weight-normal text-muted-transparent">SDIT ABU BAKAR ASH-SHIDIQ</h5>
                    <h5 class="font-weight-normal text-muted-transparent">Rajapolah, Tasikmalaya</h5>
                    <h5 id="current-time" class="font-weight-normal text-muted-transparent"></h5> <!-- Dynamic Time -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

<script>
    // Update time dynamically in English format
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
            hour12: false, // 24-hour format
            timeZone: 'Asia/Jakarta' // WIB timezone
        };
        timeElement.innerHTML = now.toLocaleString('en-US', options);
    }

    setInterval(updateTime, 1000);

    // Handle the form submission
    $(document).ready(function() {
        $("#forgot-password").submit(function(e) {
            setButtonLoadingState("#forgot-password .btn.btn-primary", true, "Forgot Password");
            e.preventDefault();
            const url = "{{ route('password.email') }}";
            const data = new FormData(this);

            const successCallback = function(response) {
                setButtonLoadingState("#forgot-password .btn.btn-primary", false, "Forgot Password");
                handleSuccess(response, null, null, "/login");
            };

            const errorCallback = function(error) {
                setButtonLoadingState("#forgot-password .btn.btn-primary", false, "Forgot Password");
                handleValidationErrors(error, "forgot-password", ["email"]);
            };

            ajaxCall(url, "POST", data, successCallback, errorCallback);
        });
    });
</script>
@endpush
