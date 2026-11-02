@extends('layouts.app')

@section('title', 'Kebijakan Privasi | Mikroliterasi')

@section('content')
<div class="mx-auto w-full max-w-300 px-4 py-10 sm:px-6 lg:px-8">

    <header class="mb-10 border-b border-border pb-8">
        <p class="mb-3 text-sm font-medium uppercase tracking-wider text-primary">
            Informasi dan Kebijakan
        </p>

        <h1 class="text-3xl font-semibold tracking-tight text-text sm:text-4xl">
            Kebijakan Privasi
        </h1>

        <p class="mt-4 max-w-3xl leading-relaxed text-text-muted">
            Kebijakan ini menjelaskan bagaimana Mikroliterasi mengumpulkan,
            menggunakan, menyimpan, dan melindungi informasi pribadi pengguna
            ketika mengakses layanan kami.
        </p>

        <p class="mt-4 text-sm text-text-muted">
            Terakhir diperbarui: {{ now()->format('d/m/Y') }}
        </p>
    </header>

    <article class="max-w-4xl space-y-9 leading-7 text-text">

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                1. Pendahuluan
            </h2>

            <p>
                Mikroliterasi merupakan platform pembelajaran dan literasi
                digital yang menyediakan berbagai materi, sumber belajar,
                serta konten edukatif bagi penggunanya.
            </p>

            <p class="mt-3">
                Kami menghargai privasi pengguna dan berkomitmen untuk
                mengelola informasi pribadi secara bertanggung jawab.
                Dengan menggunakan Mikroliterasi, Anda memahami praktik
                pengelolaan informasi sebagaimana dijelaskan dalam kebijakan ini.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                2. Informasi yang Kami Kumpulkan
            </h2>

            <p>
                Kami dapat mengumpulkan informasi berikut ketika Anda
                menggunakan layanan Mikroliterasi:
            </p>

            <ul class="mt-3 list-disc space-y-2 pl-6">
                <li>
                    <strong>Informasi identitas:</strong>
                    nama dan alamat email yang digunakan untuk membuat
                    atau mengakses akun.
                </li>

                <li>
                    <strong>Informasi autentikasi:</strong>
                    identitas akun Google yang digunakan untuk menghubungkan
                    akun pengguna dengan layanan Google Sign-In.
                </li>

                <li>
                    <strong>Informasi aktivitas:</strong>
                    informasi yang berkaitan dengan penggunaan fitur,
                    materi pembelajaran, dan layanan platform.
                </li>

                <li>
                    <strong>Informasi teknis:</strong>
                    informasi yang diperlukan untuk menjaga fungsi,
                    keamanan, dan kestabilan layanan, seperti informasi
                    sesi dan data teknis permintaan.
                </li>
            </ul>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                3. Penggunaan Google Sign-In
            </h2>

            <p>
                Mikroliterasi menyediakan autentikasi menggunakan akun Google
                untuk mempermudah pengguna dalam mengakses platform.
                Ketika menggunakan fitur tersebut, kami dapat menerima
                informasi dasar dari Google, meliputi:
            </p>

            <ul class="mt-3 list-disc space-y-2 pl-6">
                <li>Nama profil Google.</li>
                <li>Alamat email Google.</li>
                <li>Identitas unik akun Google.</li>
                <li>Status verifikasi alamat email.</li>
            </ul>

            <p class="mt-3">
                Informasi tersebut digunakan untuk membuat akun mahasiswa,
                menghubungkan akun Google dengan akun Mikroliterasi yang
                telah tersedia, dan memproses autentikasi pengguna.
            </p>

            <p class="mt-3">
                Mikroliterasi tidak meminta atau mengumpulkan kata sandi
                akun Google pengguna. Kami juga tidak menggunakan Google
                Sign-In untuk mengakses kontak, dokumen, foto, atau data
                pribadi lainnya di layanan Google.
            </p>

            <p class="mt-3">
                Identitas Google digunakan untuk menghubungkan akun.
                Mikroliterasi tidak menyimpan token akses Google sebagai
                data akun pengguna.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                4. Tujuan Penggunaan Informasi
            </h2>

            <p>Informasi yang dikumpulkan digunakan untuk:</p>

            <ul class="mt-3 list-disc space-y-2 pl-6">
                <li>Membuat dan mengelola akun pengguna.</li>
                <li>Memverifikasi identitas dan memproses autentikasi.</li>
                <li>Menyediakan akses terhadap materi dan fitur pembelajaran.</li>
                <li>Menjaga keamanan serta mencegah penyalahgunaan layanan.</li>
                <li>Memelihara dan meningkatkan kualitas platform.</li>
                <li>Menanggapi pertanyaan dan permintaan bantuan pengguna.</li>
            </ul>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                5. Penyimpanan dan Perlindungan Data
            </h2>

            <p>
                Informasi pengguna disimpan dalam sistem yang digunakan
                untuk mengoperasikan Mikroliterasi. Kami menerapkan
                langkah-langkah teknis dan organisasi yang wajar untuk
                melindungi informasi dari akses, perubahan, pengungkapan,
                atau penggunaan yang tidak sah.
            </p>

            <p class="mt-3">
                Meskipun demikian, tidak ada sistem penyimpanan maupun
                transmisi data elektronik yang dapat dijamin sepenuhnya
                bebas dari risiko keamanan.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                6. Pengungkapan Informasi kepada Pihak Ketiga
            </h2>

            <p>
                Mikroliterasi tidak menjual informasi pribadi pengguna.
                Informasi dapat diproses atau diungkapkan secara terbatas
                dalam keadaan berikut:
            </p>

            <ul class="mt-3 list-disc space-y-2 pl-6">
                <li>
                    Kepada penyedia layanan teknologi yang diperlukan
                    untuk menjalankan dan memelihara platform.
                </li>

                <li>
                    Apabila diwajibkan oleh hukum atau permintaan
                    dari otoritas yang berwenang.
                </li>

                <li>
                    Untuk melindungi keamanan, hak, dan kepentingan
                    sah Mikroliterasi maupun penggunanya.
                </li>
            </ul>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                7. Masa Penyimpanan Data
            </h2>

            <p>
                Informasi pribadi disimpan selama diperlukan untuk
                menyediakan layanan, memenuhi tujuan pengumpulan,
                menjaga keamanan sistem, dan memenuhi kewajiban hukum
                yang berlaku.
            </p>

            <p class="mt-3">
                Apabila informasi tidak lagi diperlukan, penghapusan
                atau penanganannya akan dilakukan sesuai kebutuhan
                operasional dan ketentuan yang berlaku.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                8. Hak Pengguna
            </h2>

            <p>
                Pengguna dapat mengajukan permintaan untuk memperoleh
                informasi mengenai data pribadinya, memperbaiki
                informasi yang tidak akurat, atau meminta penghapusan
                data sesuai ketentuan hukum yang berlaku.
            </p>

            <p class="mt-3">
                Permintaan tersebut dapat disampaikan melalui alamat
                kontak yang tercantum pada bagian akhir kebijakan ini.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                9. Perubahan Kebijakan Privasi
            </h2>

            <p>
                Mikroliterasi dapat memperbarui kebijakan ini apabila
                terdapat perubahan pada layanan, teknologi, atau
                ketentuan hukum yang berlaku.
            </p>

            <p class="mt-3">
                Versi terbaru akan dipublikasikan pada halaman ini.
                Pengguna disarankan untuk meninjau kebijakan secara berkala.
            </p>
        </section>

        <section>
            <h2 class="mb-3 text-xl font-semibold">
                10. Kontak
            </h2>

            <p>
                Apabila memiliki pertanyaan, permintaan, atau keluhan
                mengenai privasi dan pengelolaan informasi pribadi,
                silakan menghubungi kami melalui:
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
