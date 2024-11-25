<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.2;
            font-size: 10;
            margin: 0;
            padding: 0;
        }

        h3 {
            margin: 2px;
        }
    </style>
    @stack('style')
</head>

<body>
    <table width="100%" border="0" cellpadding="2.5" cellspacing="0">
        <tbody>
            <tr>
                <td width="20%">
                    {{-- Logo Pemerintah Kota Tasikmalaya --}}
                    {{-- <img width="120px" src="{{ generateBase64Image(public_path('images/logo-pemkot.png')) }}" alt=""> --}}
                </td>
                <td align="left">
                    <h3>RAPOT KINERJA GURU/TENAGA KEPENDIDIKAN</h3>
                    <h3>SD/SMP IT ABU BAKAR ASH-SHIDIQ</h3>
                    <h3>TAHUN PELAJARAN</h3>
                    <div>
                        <span>
                            Jl. Nasional III, Manggungsari, Kec. Rajapolah, Kabupaten Tasikmalaya, Jawa Barat 46155
                        </span>
                    </div>
                </td>
                <td width="20%" align="right">
                    {{-- Logo SDIT/SMPIT --}}
                    <img width="120px" src="{{ generateBase64Image(public_path('img/Abbash.png')) }}" alt="">
                </td>
            </tr>
        </tbody>
    </table>
    <hr style="height: 1px; background-color: black;">

    {{-- Isi utama halaman --}}
    @yield('main')

    @stack('scripts')
</body>

</html>
