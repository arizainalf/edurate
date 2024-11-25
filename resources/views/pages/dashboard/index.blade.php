@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">

    <!-- Custom CSS for Hover effect -->
    <style>
        a.card {
            text-decoration: none; /* Menghilangkan garis bawah */
        }

        a.card:hover {
            transform: scale(1.05); /* Efek memperbesar sedikit */
            transition: transform 0.3s ease;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Hallo, {{ getGreeting() }} {{ auth()->user()->name }}.</h1>
            </div>
            <div class="row">
                <!-- Card Guru -->
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('guru.index') }}" class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-chalkboard-teacher"></i> <!-- Ikon yang sama dengan sidebar -->
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Guru</h4>
                            </div>
                            <div class="card-body">
                                {{ $guru }}
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card Jabatan -->
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('jabatan.index') }}" class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-briefcase"></i> <!-- Ikon yang sama dengan sidebar -->
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jabatan</h4>
                            </div>
                            <div class="card-body">
                                {{ $jabatan }}
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card Nilai -->
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('nilai.index') }}" class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-book"></i> <!-- Ikon yang sama dengan sidebar -->
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Nilai</h4>
                            </div>
                            <div class="card-body">
                                {{ $nilai }}
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card Mapel -->
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('mapel.index') }}" class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-book-reader"></i> <!-- Ikon yang sama dengan sidebar -->
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Mapel</h4>
                            </div>
                            <div class="card-body">
                                {{ $mapel }}
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>

    <script>
        $(document).ready(function() {
            renderData();

            $("#bulan_filter, #tahun_filter").on("change", function() {
                renderData();
            });
        });

        const renderData = () => {
            const successCallback = function(response) {
                createChart(response.data.labels, response.data.berkunjung, response.data.peminjaman, response.data
                    .pengembalian);
            };

            const errorCallback = function(error) {
                console.error(error);
            };

            const url = `/admin?bulan=${$("#bulan_filter").val()}&tahun=${$("#tahun_filter").val()}`;

            ajaxCall(url, "GET", null, successCallback, errorCallback);
        };
    </script>
@endpush
