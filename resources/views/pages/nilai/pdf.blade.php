@extends('layouts.pdf')

@section('title', 'Category')

@push('style')
@endpush

@section('main')
    <div>
        <center>
            <u>
                <h3>Data Penilaian</h3>
            </u>
        </center>
        <br>
        <table width="100%" border="1" cellpadding="2.5" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Aspek Yang di Nilai</th>
                    <th>Nilai</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody valign="top">
                @forelse ($nilais as $nilai)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td>{{ $nilai->guru_id }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" align="center">Data @yield('title') kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
@endpush
