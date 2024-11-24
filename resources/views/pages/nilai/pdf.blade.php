@extends('layouts.pdf')

@section('title', 'Penilaian')

@section('main')
    <div>
        <center>
            <u>
                <h3>Data Penilaian</h3>
            </u>
        </center>
        <br>
        <table width="100%" border="1" cellpadding="2.5" cellspacing="0">
            @foreach ($kriterias as $kriteria)
                <thead>
                    <tr>
                        <th colspan="4" align="left">{{ $kriteria->nama }}</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Aspek Yang Dinilai</th>
                        <th>Nilai</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody valign="top">
                    @forelse ($kriteria->filteredKegiatans as $kegiatan)
                        @foreach ($kegiatan->detailNilais as $detailNilai)
                            <tr>
                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                <td>{{ $kegiatan->nama }}</td>
                                <td>{{ $detailNilai->nilai->nilai }}</td>
                                <td>{{ $detailNilai->ket }}</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="4" align="center">Tidak ada kegiatan yang sesuai</td>
                        </tr>
                    @endforelse
                </tbody>
            @endforeach
        </table>
    </div>
@endsection
@extends('layouts.pdf')

@section('title', 'Penilaian')

@section('main')
    <div>
        <center>
            <u>
                <h3>Data Penilaian</h3>
            </u>
        </center>
        <br>
        <table width="100%" border="1" cellpadding="2.5" cellspacing="0">
            @foreach ($kriterias as $kriteria)
                @if ($kriteria->filteredKegiatans->isNotEmpty())
                    <thead>
                        <tr>
                            <th colspan="4">{{ $kriteria->nama }}</th>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Kegiatan</th>
                            <th>Nilai</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                            $displayedActivities = [];
                        @endphp
                        @foreach ($kriteria->filteredKegiatans as $kegiatan)
                            @foreach ($kegiatan->detailNilais as $detailNilai)
                                @if (!in_array($kegiatan->id, $displayedActivities))
                                    @php
                                        $displayedActivities[] = $kegiatan->id;
                                    @endphp
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $kegiatan->nama }}</td>
                                        <td>{{ $detailNilai->nilai->nilai ?? '-' }}</td>
                                        <td>{{ $detailNilai->ket ?? '-' }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                @endif
            @endforeach
            </tbody>

        </table>
    </div>
@endsection
