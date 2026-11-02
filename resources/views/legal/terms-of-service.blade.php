@extends('layouts.app')

@section('title', 'Syarat dan Ketentuan | Mikroliterasi')

@section('content')
<div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 lg:px-8">

    <header class="mb-10 border-b border-border pb-8">
        <p class="mb-3 text-sm font-medium uppercase tracking-wider text-primary">
            Informasi dan Ketentuan
        </p>

        <h1 class="text-3xl font-semibold tracking-tight text-text sm:text-4xl">
            Syarat dan Ketentuan Layanan
        </h1>

        <p class="mt-4 max-w-3xl leading-relaxed text-text-muted">
            Ketentuan yang mengatur penggunaan platform Mikroliterasi,
            termasuk akses akun, materi pembelajaran, dan layanan digital
            yang tersedia.
        </p>

        <p class="mt-4 text-sm text-text-muted">
            Terakhir diperbarui: {{ now()->format('d/m/Y') }}
        </p>
    </header>

    <article class="max-w-4xl space-y-9 leading-7 text-text">

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                1. Ketentuan Umum
            </h2>

            <p>
                Selamat datang di Mikroliterasi. Mikroliterasi merupakan
                platform pembelajaran dan literasi digital yang menyediakan
                materi, sumber belajar, serta berbagai konten edukatif.
            </p>

            <p class="mt-3">
                Dengan mengakses atau menggunakan layanan Mikroliterasi,
                Anda menyatakan telah membaca dan memahami syarat serta
                ketentuan ini.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                2. Akun Pengguna
            </h2>

            <p>
                Beberapa fitur Mikroliterasi memerlukan akun pengguna.
                Pengguna bertanggung jawab untuk:
            </p>

            <ul class="mt-3 list-disc space-y-2 pl-6">
                <li>
                    Memberikan informasi yang benar dan dapat dipertanggungjawabkan.
                </li>

                <li>
                    Menjaga keamanan akses terhadap akun masing-masing.
                </li>

                <li>
                    Tidak menggunakan akun pihak lain tanpa izin.
                </li>

                <li>
                    Segera melaporkan apabila mengetahui adanya penggunaan
                    akun yang tidak sah.
                </li>
            </ul>

            <p class="mt-3">
                Pengguna bertanggung jawab atas aktivitas yang dilakukan
                melalui akun miliknya, sepanjang sesuai dengan ketentuan
                hukum yang berlaku.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                3. Autentikasi Google
            </h2>

            <p>
                Mikroliterasi menyediakan pilihan masuk menggunakan
                Google Sign-In. Penggunaan fitur ini tunduk pada proses
                autentikasi dan ketentuan layanan Google.
            </p>

            <p class="mt-3">
                Pengguna harus menggunakan akun Google yang sah dan
                memiliki akses yang valid. Mikroliterasi dapat membatasi
                penggunaan Google Sign-In berdasarkan jenis akun atau
                persyaratan akses yang berlaku pada platform.
            </p>

            <p class="mt-3">
                Penggunaan autentikasi Google tidak mengalihkan tanggung
                jawab pengguna untuk menjaga keamanan akun Google miliknya.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                4. Penggunaan Layanan
            </h2>

            <p>
                Pengguna diperbolehkan mengakses dan menggunakan layanan
                Mikroliterasi untuk tujuan pembelajaran, pendidikan,
                penelitian, dan kegiatan lain yang sah sesuai dengan
                fungsi platform.
            </p>

            <p class="mt-3">
                Dalam menggunakan layanan, pengguna dilarang:
            </p>

            <ul class="mt-3 list-disc space-y-2 pl-6">
                <li>
                    Melakukan tindakan yang melanggar hukum atau hak
                    pihak lain.
                </li>

                <li>
                    Mengakses sistem, akun, atau data tanpa kewenangan.
                </li>

                <li>
                    Mengganggu, merusak, atau mencoba menghambat
                    operasional platform.
                </li>

                <li>
                    Menyebarkan malware, kode berbahaya, atau konten
                    yang dapat membahayakan pengguna lain.
                </li>

                <li>
                    Menggunakan layanan untuk penipuan, penyalahgunaan,
                    atau kegiatan yang bertentangan dengan tujuan
                    platform.
                </li>

                <li>
                    Mengunggah atau menyebarkan materi yang melanggar
                    hak cipta, privasi, atau hak kekayaan intelektual
                    pihak lain.
                </li>
            </ul>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                5. Hak Kekayaan Intelektual
            </h2>

            <p>
                Materi, desain, identitas visual, struktur, dan konten
                yang tersedia pada Mikroliterasi dapat dilindungi oleh
                ketentuan hak cipta dan hak kekayaan intelektual lainnya.
            </p>

            <p class="mt-3">
                Pengguna tidak diperkenankan menyalin, mendistribusikan,
                memodifikasi, atau menggunakan materi yang dilindungi
                untuk kepentingan komersial tanpa izin dari pemegang
                hak yang bersangkutan.
            </p>

            <p class="mt-3">
                Materi yang berasal dari pihak ketiga tetap menjadi
                milik pemegang hak masing-masing dan penggunaannya
                mengikuti ketentuan lisensi atau atribusi yang berlaku.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                6. Konten dan Materi Pembelajaran
            </h2>

            <p>
                Materi yang disediakan pada Mikroliterasi ditujukan
                untuk mendukung kegiatan pembelajaran dan penyebaran
                pengetahuan.
            </p>

            <p class="mt-3">
                Kami berupaya menjaga kualitas dan ketepatan informasi.
                Namun, materi yang tersedia tidak selalu mencerminkan
                perkembangan informasi paling mutakhir dan tidak
                dimaksudkan sebagai pengganti penilaian profesional
                dalam bidang tertentu.
            </p>

            <p class="mt-3">
                Pengguna bertanggung jawab untuk melakukan penilaian
                dan verifikasi lebih lanjut sebelum menggunakan
                informasi untuk keperluan akademik, penelitian,
                maupun pengambilan keputusan.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                7. Ketersediaan Layanan
            </h2>

            <p>
                Mikroliterasi berupaya menyediakan layanan secara
                berkelanjutan. Namun, kami tidak menjamin bahwa
                seluruh fitur selalu tersedia tanpa gangguan.
            </p>

            <p class="mt-3">
                Layanan dapat mengalami pemeliharaan, pembaruan,
                perubahan fitur, atau penghentian sementara apabila
                diperlukan untuk kepentingan teknis, keamanan,
                maupun operasional.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                8. Pembatasan dan Penghentian Akses
            </h2>

            <p>
                Mikroliterasi dapat membatasi atau menghentikan akses
                pengguna apabila ditemukan indikasi penyalahgunaan
                layanan, pelanggaran ketentuan ini, atau tindakan
                yang dapat mengganggu keamanan dan operasional platform.
            </p>

            <p class="mt-3">
                Tindakan tersebut dilakukan dengan mempertimbangkan
                sifat pelanggaran dan ketentuan hukum yang berlaku.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                9. Privasi dan Pengelolaan Data
            </h2>

            <p>
                Pengelolaan informasi pribadi pengguna dilakukan
                berdasarkan
                <a href="{{ route('privacy-policy') }}"
                   class="text-primary underline underline-offset-4">
                    Kebijakan Privasi Mikroliterasi
                </a>.
            </p>

            <p class="mt-3">
                Dengan menggunakan layanan, pengguna memahami bahwa
                informasi tertentu diperlukan untuk menyediakan
                autentikasi, pengelolaan akun, dan fungsi platform.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                10. Perubahan Syarat dan Ketentuan
            </h2>

            <p>
                Mikroliterasi dapat memperbarui syarat dan ketentuan
                ini seiring dengan perkembangan layanan, perubahan
                fitur, maupun ketentuan hukum yang berlaku.
            </p>

            <p class="mt-3">
                Perubahan akan dipublikasikan melalui halaman ini.
                Pengguna disarankan untuk meninjau ketentuan secara
                berkala.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                11. Hukum yang Berlaku
            </h2>

            <p>
                Syarat dan ketentuan ini ditafsirkan berdasarkan
                peraturan perundang-undangan yang berlaku di
                Republik Indonesia.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                12. Kontak
            </h2>

            <p>
                Untuk pertanyaan atau informasi lebih lanjut mengenai
                penggunaan layanan Mikroliterasi, silakan menghubungi:
            </p>

            <div class="mt-4 rounded-lg border border-border bg-surface p-5">
                <p class="font-semibold text-text">Mikroliterasi</p>

                <p class="mt-2 text-text-muted">
                    Email:
                    <a href="mailto:notivra.usk@gmail.com"
                       class="text-primary underline underline-offset-4">
                        notivra.usk@gmail.com
                    </a>
                </p>

                <p class="mt-1 text-text-muted">
                    Website:
                    <a href="https://mikroliterasi.com"
                       class="text-primary underline underline-offset-4">
                        mikroliterasi.com
                    </a>
                </p>
            </div>
        </section>

    </article>

</div>
@endsection
