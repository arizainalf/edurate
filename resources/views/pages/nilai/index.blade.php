@extends('layouts.app')

@section('title', 'Nilai')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title font-weight-bolder">
                            Data @yield('title')
                        </div>
                        <div class="ml-auto">
                            <a href="{{ route('nilai.penilaian') }}" >
                            <button class="btn btn-lg btn-success" ><i
                                    class="fas fa-plus mr-2"></i>Penilaian</button> </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('nilai.show', 'pdf') }}" class="btn btn-sm px-3 btn-danger mr-1"
                                target="_blank"><i class="fas fa-file-pdf mr-2"></i>Pdf</a>
                            <a href="{{ route('nilai.show', 'excel') }}" class="btn btn-sm px-3 btn-info" target="_blank"><i
                                    class="fas fa-file-excel mr-2"></i>Excel</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="nilai-table" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" width="5%">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Tahun Ajaran</th>
                                        <th scope="col" width="20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('pages.nilai.modal')
@endsection

@push('scripts')
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            datatableCall('nilai-table', '{{ route('nilai.index') }}', [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'guru',
                    name: 'guru'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'tahun_pelajaran',
                    name: 'tahun_pelajaran'
                },
                {
                    data: 'nilai',
                    name: 'nilai'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]);

            select2ToJson("#jabatan_id", "{{ route('jabatan.index') }}", "#createModal");
            select2ToJson("#mata_pelajaran_id", "{{ route('mapel.index') }}", "#createModal");

            $("#saveData").submit(function(e) {
                setButtonLoadingState("#saveData .btn.btn-success", true);
                e.preventDefault();
                const kode = $("#saveData #id").val();
                let url = "{{ route('nilai.store') }}";
                const data = new FormData(this);

                if (kode !== "") {
                    data.append("_method", "PUT");
                    url = `/admin/nilai/${kode}`;
                }

                const successCallback = function(response) {
                    setButtonLoadingState("#saveData .btn.btn-success", false);
                    handleSuccess(response, "nilai-table", "createModal");
                };

                const errorCallback = function(error) {
                    setButtonLoadingState("#saveData .btn.btn-success", false);
                    handleValidationErrors(error, "saveData", ["nama", "nilai_id", "mapel_id"]);
                };

                ajaxCall(url, "POST", data, successCallback, errorCallback);
            });
        });
    </script>
@endpush
