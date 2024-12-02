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
            font-size: 10px; /* Tambahkan satuan "px" pada font-size */
            margin: 0;
            padding: 0;
        }

        h3 {
            margin: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse; /* Menjaga tata letak agar tetap rapi */
            border: 0; /* Pastikan border pada tabel dihilangkan */
        }

        td {
            border: none; /* Hilangkan border pada elemen td */
            margin: 0;
            padding: 0;
        }

        img {
            border: none; /* Hilangkan border pada elemen img */
            margin: 0;
            padding: 0;
            display: block; /* Hilangkan spasi tambahan di bawah gambar */
        }

        hr {
            height: 1px;
            background-color: black;
            border: none; /* Menghapus border pada hr */
            margin: 0; /* Menghapus margin default */
        }
    </style>
    @stack('style')
</head>

<body>
    <table cellpadding="2.5" cellspacing="0" border="0">
        <tbody>
            <tr>
                <td width="20%" align="left">
                    <!-- Logo SDIT/SMPIT -->
                    <img width="120px" src="{{ generateBase64Image(public_path('img/Abbash.png')) }}" alt="Logo SDIT/SMPIT" border="0">
                </td>
                <td align="center">
                    <h3>RAPOT KINERJA GURU/TENAGA KEPENDIDIKAN</h3>
                    <h3>SD/SMP IT ABU BAKAR ASH-SHIDIQ</h3>
                    <h3>
                        TAHUN PELAJARAN {{ date('Y') }}/{{ date('Y') + 1 }}
                    </h3>
                    <div>
                        <span>
                            Jl. Nasional III, Manggungsari, Kec. Rajapolah, Kabupaten Tasikmalaya, Jawa Barat 46155
                        </span>
                    </div>
                </td>
                <td width="20%" align="right">
                    <!-- Logo SMP -->
                    <img width="120px" src="{{ generateBase64Image(public_path('img/smp.png')) }}" alt="Logo SMP" border="0">
                </td>
            </tr>
        </tbody>
    </table>
    <hr>

    <!-- Isi utama halaman -->
    @yield('main')

    @stack('scripts')
</body>

</html>
