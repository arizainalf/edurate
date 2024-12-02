@extends('layouts.pdf')

@section('title', 'Penilaian')

@push('style')
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            margin: 10px;
        }

        header {
            text-align: center;
            margin-bottom: 10px;
        }

        h3, h4, p {
            margin: 4px 0;
            font-size: 10pt;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid black;
            padding: 3px;
            text-align: center;
            font-size: 8pt;
        }

        th {
            background-color: #f2f2f2;
        }

        .no-border {
            border: none !important;
        }

        .signature {
            text-align: right;
            margin-top: 20px;
            font-size: 10pt;
        }

        .table-footer {
            text-align: left;
            font-size: 8pt;
            border: none;
        }

        ol li {
            font-size: 8pt;
        }

        .kriteria-penilaian table th, .kriteria-penilaian table td {
            font-size: 7.5pt;
        }
    </style>
@endpush

@section('main')
    <!-- Header -->
    <div>
        <h3>Nama Guru: {{ $guru->nama }}</h3>
        <h3>Jabatan: {{ $guru->jabatan->nama }}</h3>
        <h3>Mata Pelajaran: {{ $guru->mataPelajaran->nama }}</h3>
        <center>
            <h3>Instrumen Penilaian</h3>
        </center>
    </div>

    @php
        $totalSemua = 0;
        $totalNilai = 0;
        $no = 1;
        setlocale(LC_TIME, 'id_ID.UTF-8', 'ind');
        $formattedDate = strftime('%d %B %Y', strtotime($tanggal));
    @endphp

    <!-- Tabel Penilaian -->
    @foreach ($kriterias as $kriteria)
        <h4>{{ $kriteria->nama }}</h4>
        @php
            $totalKriteria = 0;
            $jumlahKegiatan = 0;
        @endphp
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Kegiatan</th>
                    <th width="10%">Nilai</th>
                    <th width="20%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kriteria->kegiatans as $kegiatan)
                    @php
                        $total = 0;
                        $subNo = 0;
                    @endphp
                    @foreach ($kegiatan->detailNilais as $nilai)
                        @if ($nilai->nilai_id == $id)
                            @php
                                $totalNilai++;
                                $subNo++;
                                $total += $nilai->penilaian;
                                $totalSemua += $nilai->penilaian;
                                $totalKriteria += $nilai->penilaian;
                                $jumlahKegiatan++;
                            @endphp
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td align="left">{{ $kegiatan->nama }}</td>
                                <td>{{ number_format($nilai->penilaian, 2) }}</td>
                                <td>{{ $nilai->ket ?? '-' }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach

                <tr>
                    <td colspan="2"><strong>Rata-rata</strong></td>
                    <td>{{ $jumlahKegiatan > 0 ? number_format($totalKriteria / $jumlahKegiatan, 2) : 0 }}</td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
    @endforeach

    <!-- Penilaian Akhir -->
    <h4>Penilaian Akhir</h4>
    <table>
        <tr>
            <th>Nilai Total</th>
            <th>Predikat</th>
        </tr>
        <tr>
            <td>{{ number_format($hasilTotal = $totalSemua / $totalNilai, 3) }}</td>
            <td>
                @if ($hasilTotal <= 50)
                    Kurang
                @elseif ($hasilTotal <= 68)
                    Sedang
                @elseif ($hasilTotal <= 78)
                    Cukup
                @elseif ($hasilTotal <= 88)
                    Baik
                @elseif ($hasilTotal <= 100)
                    Sangat Baik
                @endif
            </td>
        </tr>
    </table>

    <!-- Tanda Tangan -->
    <div class="signature">
        <p>Rajapolah, {{ $formattedDate }}</p>
        <br><br><br><br><br><br><br>
        <p><strong>Kepala Sekolah SD/SMPIT</strong></p>
    </div>

    <!-- Tembusan -->
    <p><strong>Tembusan:</strong></p>
    <ol>
        <li>Ketua Yayasan Abu Bakar Ash-Shiddiq Al-Khairiyyah</li>
        <li>SDM Yayasan Abu Bakar Ash-Shiddiq Al-Khairiyyah</li>
        <li>File</li>
    </ol>

    <!-- Kriteria Penilaian -->
    <div class="kriteria-penilaian">
        <p><strong>Kriteria Penilaian:</strong></p>
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Nilai</th>
                    <th>Artinya</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Kurang</td>
                    <td>0-50</td>
                    <td>Membutuhkan pengawasan terus menerus.</td>
                </tr>
                <tr>
                    <td>Sedang</td>
                    <td>51-68</td>
                    <td>Kadang-kadang memerlukan tindak lanjut.</td>
                </tr>
                <tr>
                    <td>Cukup</td>
                    <td>69-78</td>
                    <td>Biasanya dapat diandalkan.</td>
                </tr>
                <tr>
                    <td>Baik</td>
                    <td>79-88</td>
                    <td>Hanya sedikit memerlukan pengawasan.</td>
                </tr>
                <tr>
                    <td>Sangat Baik</td>
                    <td>89-100</td>
                    <td>Sepenuhnya bisa dipercaya dan dapat menjadi contoh pegawai lain.</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
