<?php

namespace Database\Seeders;

use App\Models\Guru;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Kegiatan;
use App\Models\Kriteria;
use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = [[
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('11221122'),
        ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }

        $jabatan = [
            [
                'nama' => 'Kepala Sekolah',
            ],
            [
                'nama' => 'Wakasek Kesiswaan',
            ],
            [
                'nama' => 'Wakasek Kurikulum',
            ],
            [
                'nama' => 'Guru',
            ],
        ];

        foreach ($jabatan as $key => $value) {
            Jabatan::create($value);
        }

        $mapel = [
            [
                'nama' => 'Bahasa Indonesia',
            ],
            [
                'nama' => 'Matematika',
            ],
            [
                'nama' => 'Bahasa Inggris',
            ],
            [
                'nama' => 'Pendidikan Agama Islam',
            ],
            [
                'nama' => 'Pendidikan Jasmani',
            ],
            [
                'nama' => 'Pendidikan Pancasila dan Kewarganegaraan',
            ],
            [
                'nama' => 'Seni Budaya',
            ],
            [
                'nama' => 'Ilmu Pengetahuan Alam',
            ],
            [
                'nama' => 'Ilmu Pengetahuan Sosial',
            ]
            ];

        foreach ($mapel as $key => $value) {
            MataPelajaran::create($value);
        }

        $guru = [
            [
                'jabatan_id' => 1,
                'mata_pelajaran_id' => 1,
                'nama' => 'Muhammad Arizain Alfiansyah',
            ]
        ];

        foreach ($guru as $key => $value) {
            Guru::create($value);
        }

        $kriteria = [
            [
                'nama' => 'LOYALITAS/KESETIAAN',
            ],
            [
                'nama' => 'PRESTASI KERJA',
            ],
            [
                'nama' => 'Ketelitian dan Kerajinan Hasil Kerja',
            ],
            [
                'nama' => 'Sikap dan Disiplin Kerja',
            ],
        ];

        foreach ($kriteria as $key => $value) {
            Kriteria::create($value);
        }

        $kegiatan = [
            [
                'nama' => 'Kedatangan ke sekolah tepat waktu',
                'kriteria_id' => 1,
            ],
            [
                'nama' => 'Kepulangan dari sekolah tepat waktu',
                'kriteria_id' => 1,
            ],
            [
                'nama' => 'Banyak sedikitnya jam meninggalkan pekerjaan untuk kepentingan pribadi',
                'kriteria_id' => 1,
            ],
            [
                'nama' => 'Kehadiran dalam kelas sesuai jadwal pelajaran',
                'kriteria_id' => 1,
            ],
            [
                'nama' => 'Keikutsertaan dalam upacara bendera di sekolah',
                'kriteria_id' => 1,
            ],
            [
                'nama' => 'Keikutsertaan dalam apel embun pagi di sekolah',
                'kriteria_id' => 1,
            ],
            [
                'nama' => 'Keikutsertaan dalam pengajian rutin di hari kamis dan ahad di sekolah',
                'kriteria_id' => 1,
            ],
            [
                'nama' => 'keikutsertaaan dalam kegiatan yang dilaksanakan di Yayasan Abbash',
                'kriteria_id' => 1,
            ],
            [
                'nama' => 'Keikutsertaan dalam kegiatan rapat-rapat di sekolah',
                'kriteria_id' => 1,
            ],
            [
                'nama' => 'Pembuatan perangkat mengajar : Program tahunan dan program semeseter',
                'kriteria_id' => 2,
            ],
            [
                'nama' => 'Pembuatan perangkat mengajar : Rencana pelaksanaan pembelajaran (RPP) / modul ajar',
                'kriteria_id' => 2,
            ],
            [
                'nama' => 'Pembuatan perangkat mengajar : Penentuan KKM',
                'kriteria_id' => 2,
            ],
            [
                'nama' => 'Penyerahan daftar nilai',
                'kriteria_id' => 2,
            ],
            [
                'nama' => 'Pelaksanaan ulangan harian',
                'kriteria_id' => 2,
            ],
            [
                'nama' => 'Penyerahan soal ujian / ulangan',
                'kriteria_id' => 2,
            ],
            [
                'nama' => 'Pembuatan analisis hasil ujian / ulangan',
                'kriteria_id' => 2,
            ],
            [
                'nama' => 'Pembuatan dan pelaksanaan remedial / pengayaan',
                'kriteria_id' => 2,
            ],
            [
                'nama' => 'Pelaporan dalam suatu kepanitiaan yang diberikan',
                'kriteria_id' => 2,
            ],
            [
                'nama' => 'Bagi guru mata pelajaran : Pengisian jurnal kelas',
                'kriteria_id' => 3,
            ],
            [
                'nama' => 'Bagi guru mata pelajaran : Pengisian presensi kehadiran siswa saat KBM',
                'kriteria_id' => 3,
            ],
            [
                'nama' => 'Bagi guru mata pelajaran : Pengisian daftar nilai',
                'kriteria_id' => 3,
            ],
            [
                'nama' => 'Bagi guru yang bertugas sebagai wali kelas : Catatan penaganan siswa',
                'kriteria_id' => 3,
            ],
            [
                'nama' => 'Bagi guru yang bertugas sebagai wali kelas : Kelengkapan administrasi selaku wali kelas',
                'kriteria_id' => 3,
            ],
            [
                'nama' => 'Bagi guru yang bertugas sebagai wali kelas : Rutinitas pelaksanaan pengajian kelas',
                'kriteria_id' => 3,
            ],
            [
                'nama' => 'Bagi guru yang bertugas sebagai wali kelas : Kepedulian dalam membantu kegiatan yang diselenggarakan di sekolah',
                'kriteria_id' => 3,
            ],
            [
                'nama' => 'Bagi guru yang bertugas sebagai pembina kegiatan ekstrakurikuler : Pembuatan program kerja',
                'kriteria_id' => 3,
            ],
            [
                'nama' => 'Bagi guru yang bertugas sebagai pembina kegiatan ekstrakurikuler : Rutinitas pelaksanaan kegiatan',
                'kriteria_id' => 3,
            ],
            [
                'nama' => 'Bagi guru yang bertugas sebagai pembina kegiatan ekstrakurikuler : Pelaporan hasil kegiatan',
                'kriteria_id' => 3,
            ],
            [
                'nama' => 'Bagi guru yang bertugas sebagai pembina kegiatan ekstrakurikuler : Pengarsipan hasil kegiatan',
                'kriteria_id' => 3,
            ],
            [
                'nama' => 'Bagi guru yang bertugas sebagai wakasek : Pembuatan dan penjabaran program kerja',
                'kriteria_id' => 3,
            ],
            [
                'nama' => 'Bagi guru yang bertugas sebagai wakasek : Pelaksanaan program kerja kesehariannya',
                'kriteria_id' => 3,
            ],
            [
                'nama' => 'Bagi guru yang bertugas sebagai wakasek : Pelaporan hasil program kerja',
                'kriteria_id' => 3,
            ],
            [
                'nama' => 'Bagi guru yang bertugas sebagai wakasek : Pengarsipan hasil program kerja',
                'kriteria_id' => 3,
            ],
            [
                'nama' => 'Tanggung jawab',
                'kriteria_id' => 4,
            ],
            [
                'nama' => 'Ketaatan',
                'kriteria_id' => 4,
            ],
            [
                'nama' => 'Kejujuran',
                'kriteria_id' => 4,
            ],
            [
                'nama' => 'Kerja sama',
                'kriteria_id' => 4,
            ],
            [
                'nama' => 'Prakarsa',
                'kriteria_id' => 4,
            ],
            [
                'nama' => 'Kesalehan',
                'kriteria_id' => 4,
            ],
        ];

        foreach ($kegiatan as $kegiatan) {
            Kegiatan::create($kegiatan);
        }
    }
}
