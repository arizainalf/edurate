@extends('layouts.pdf')

@section('title', 'Penilaian')

@push('style')
    <style>
        .no-border {
            border: none !important;
        }
    </style>
@endpush

@section('main')
    <div>
        <h3>Nama Guru : {{ $guru->nama }}</h3>
        <h3>Jabatan : {{ $guru->jabatan->nama }}</h3>
        <h3>Mata Pelajaran : {{ $guru->mataPelajaran->nama }}</h3>
        <center>
            <h3>Instrumen Penilaian</h3>
        </center>
        @php
            $totalSemua = 0;
            $totalNilai = 0;
        @endphp
        @foreach ($kriterias as $kriteria)
            <table width="100%" border="1" cellpadding="2.5" cellspacing="0">
                <thead>
                    <tr>
                        <th colspan="4" align="left">{{ $kriteria->nama }}</th>
                    </tr>
                    <tr>
                        <th width="5%">No</th>
                        <th>Kegiatan</th>
                        <th align="center" width="10%">Nilai</th>
                        <th width="20%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 0;
                        $total = 0;

                    @endphp
                    @foreach ($kriteria->kegiatans as $kegiatan)
                        @foreach ($kegiatan->detailNilais as $nilai)
                            @php
                                $no++;
                                $totalNilai += $no;
                                $total += $nilai->penilaian;
                                $totalSemua += $total;
                            @endphp
                            <tr>
                                <td align="center">{{ $no }}</td>
                                <td>{{ $kegiatan->nama }}</td>
                                <td align="center">{{ $nilai->penilaian }}</td>
                                <td>{{ $nilai->ket ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    <tr>
                        <td align="center" colspan="2">Total</td>
                        <td align="center">{{ $total / $no }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        @endforeach
        <table width="100%">
            <tr>
                <td width="60%">
                    <table width="100%" border="1" cellpadding="2.5" cellspacing="0">
                        <tr align="center">
                            <th>Nilai</th>
                            <th>Predikat</th>
                        </tr>
                        <tr align="center">
                            <td>{{ $hasilTotal = $totalSemua / $totalNilai }}</td>
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
                </td>
                <td width="40%" align="center">
                    <p>Rajapolah, {{$tanggal}} </p>
                    <br><br>
                    <p>Ari Syamsul Bahri. M.Pd</p>
                </td>
            </tr>
        </table>

        <br>
        <p>Tembusan</p>
        <p>1. Ketua Yayasan Abu Bakar Ash-Shiddiq Al-Khairiyyah</p>
        <p>2. SDM Yayasan Abu Bakar Ash-Shiddiq Al-Khairiyyah</p>
        <p>3. File</p>
        <p>Kriteria penilaian :</p>
        <table>
            <tr>
                <td>Kategori</td>
                <td>Nilai</td>
                <td>Artinya</td>
            </tr>
            <tr>
                <td>Kurang</td>
                <td>0-50</td>
                <td>Membutuhkan pengawasan terus menerus.</td>
            </tr>
            <tr>
                <td>Sedang</td>
                <td>51-68</td>
                <td>Kadang - Kadang memerlukan tindak lanjut.</td>
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
                <td>Sepernuhnya bisa dipercaya dan dapat menjadi contoh pegawai lain.</td>
            </tr>
        </table>

    </div>
@endsection
