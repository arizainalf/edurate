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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Penilaian</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <form id="saveData" action="{{ route('nilai.penilaian.store') }}" method="POST">
                                        @csrf
                                        <table class="table-striped table">
                                            <tr>
                                                <td>Nama</td>
                                                <td colspan="3">
                                                    <div class="form-group">
                                                        <select name="guru_id" id="guru_id" class="form-control" required>
                                                            <option value="">-- Pilih Guru --</option>
                                                            @foreach ($gurus as $guru)
                                                                <option value="{{ $guru->id }}">{{ $guru->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            @foreach ($kriterias as $kriteria)
                                                <tr>
                                                    <th colspan="4">
                                                        <h4>{{ $kriteria->nama }}</h4>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>No</td>
                                                    <td>Aspek Yang di Nilai</td>
                                                    <td>Nilai</td>
                                                    <td>Keterangan</td>
                                                </tr>
                                                @if ($kriteria->kegiatans->isEmpty())
                                                    <tr>
                                                        <td colspan="4">Tidak ada kegiatan untuk kriteria ini.</td>
                                                    </tr>
                                                @else
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach ($kriteria->kegiatans as $kegiatan)
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $kegiatan->nama }}</td>
                                                            <td>
                                                                <input type="hidden" name="kegiatan_id[]"
                                                                    value="{{ $kegiatan->id }}">
                                                                <input type="number" name="nilai[]" class="form-control"
                                                                    required>
                                                            </td>
                                                            <td><input type="text" name="keterangan[]"
                                                                    class="form-control"></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </table>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <div class="ml-auto float-right">
                                    <button type="submit" class="btn btn-success btn-lg">Simpan</button>
                                    <button type="reset" class="btn btn-danger btn-lg">Reset</button>
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
    <script src="{{ asset('library/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('library/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#saveData").submit(function(e) {
                e.preventDefault(); // Mencegah form dikirim secara default
                setButtonLoadingState("#saveData .btn.btn-success", true);

                // Ambil URL dan data form
                let url = "{{ route('nilai.penilaian.store') }}";
                const data = new FormData(this);

                // Ajax call
                $.ajax({
                    url: url,
                    type: "POST",
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        setButtonLoadingState("#saveData .btn.btn-success", false);

                        // Tampilkan pesan sukses dengan redirect
                        swal({
                            title: "Berhasil!",
                            text: response.message || "Data berhasil disimpan.",
                            icon: "success",
                        }).then(() => {
                            // Redirect ke halaman index
                            window.location.href = "{{ route('nilai.index') }}";
                        });
                    },
                    error: function(xhr) {
                        setButtonLoadingState("#saveData .btn.btn-success", false);

                        // Menampilkan error validasi
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            handleValidationErrors(errors, "saveData", ["guru_id",
                                "kegiatan_id", "nilai"
                            ]);
                        } else {
                            swal({
                                title: "Gagal!",
                                text: "Terjadi kesalahan pada server.",
                                icon: "error",
                            });
                        }
                    },
                });
            });
        });
    </script>
@endpush
