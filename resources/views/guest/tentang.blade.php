@extends('layouts.guest')

@section('title','Tentang')

@section('content')

<div class="page-container py-5">

    <!-- Tentang Sistem -->

    <div class="row align-items-center g-5 mb-5">

        <div class="col-lg-5">

            <img src="{{ asset('assets/images/pttun 2.jfif') }}"
                class="img-fluid">

        </div>

        <div class="col-lg-7">

            <h3 class="section-title">

                Apa itu SIAP SIDANG?

            </h3>

            <p class="teks-deskripsi">

                SIAP SIDANG merupakan Sistem Informasi Presensi Sidang yang
                dikembangkan untuk membantu proses administrasi persidangan
                di Pengadilan Tinggi Tata Usaha Negara Jakarta.

            </p>

            <p class="teks-deskripsi2">

                Melalui sistem ini, masyarakat dapat melihat jadwal sidang
                secara online, sementara petugas internal dapat melakukan
                validasi kehadiran pihak berperkara secara real-time sehingga
                informasi yang diterima Panitera Pengganti menjadi lebih cepat
                dan akurat.

            </p>

        </div>

    </div>

    <!-- Tujuan -->

    <div class="row g-4 mb-5">

        <div class="col-md-3">

            <div class="feature-card">

                <i class="bi bi-calendar-week"></i>

                <h5>Jadwal Sidang</h5>

                <p>
                    Menyediakan informasi jadwal sidang secara online.
                </p>

            </div>

        </div>

        <div class="col-md-3">

            <div class="feature-card">

                <i class="bi bi-person-check"></i>

                <h5>Validasi</h5>

                <p>
                    Mempermudah validasi kehadiran para pihak.
                </p>

            </div>

        </div>

        <div class="col-md-3">

            <div class="feature-card">

                <i class="bi bi-lightning-charge"></i>

                <h5>Real-time</h5>

                <p>
                    Informasi langsung diterima oleh Panitera Pengganti.
                </p>

            </div>

        </div>

        <div class="col-md-3">

            <div class="feature-card">

                <i class="bi bi-shield-check"></i>

                <h5>Efisien</h5>

                <p>
                    Mengurangi proses administrasi manual.
                </p>

            </div>

        </div>

    </div>

    <!-- Developer -->

    <div class="developer-section">

        <h2 class="section-title mb-4">

            Dikembangkan Oleh

        </h2>

        <p class="mb-4">

            Website SIAP SIDANG dikembangkan sebagai bagian dari program
            magang mahasiswa <strong>CCIT Fakultas Teknik Universitas Indonesia</strong>
            di Pengadilan Tinggi Tata Usaha Negara Jakarta.

        </p>

        <div class="row g-4">

            <div class="col-md-3">

                <div class="developer-card">

                    <div class="developer-avatar">
                        AT
                    </div>

                    <h5>Almerio Tsany Fauzan Setiawan</h5>

                    <span>Full Stack Developer</span>

                </div>

            </div>

            <div class="col-md-3">

                <div class="developer-card">

                    <div class="developer-avatar">
                        MS
                    </div>

                    <h5>Michael Timothy Sipahutar</h5>

                    <span>Full Stack Developer</span>

                </div>

            </div>

            <div class="col-md-3">

                <div class="developer-card">

                    <div class="developer-avatar">
                        FR
                    </div>

                    <h5>Fajar Rizky Handani Hasibuan</h5>

                    <span>Full Stack Developer</span>

                </div>

            </div>

            <div class="col-md-3">

                <div class="developer-card">

                    <div class="developer-avatar">
                        MF
                    </div>

                    <h5>Muhammad Faiq Al Harits</h5>

                    <span>Full Stack Developer</span>

                </div>

            </div>

        </div>

    </div>

</div>

<style>
    .page-container {
        width: 100%;
        max-width: 1700px;
        margin: 0 auto;
        padding: 0 32px;
    }

    @media (max-width:992px) {
        .page-container {
            padding: 0 20px;
        }
    }

    .section-title {
        color: #17375E;
        font-weight: 700;
    }

    .teks-deskripsi {
        text-align: justify;
        line-height: 1.9;
    }

    .teks-deskripsi2 {
        text-align: justify;
        line-height: 1.9;
    }

    .feature-card {
        text-align: center;
        padding: 35px 25px;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
        height: 100%;
        transition: .3s;
    }

    .feature-card:hover {
        transform: translateY(-5px);
    }

    .feature-card i {
        font-size: 42px;
        color: #E4B028;
        margin-bottom: 18px;
    }

    .developer-section {
        margin-top: 80px;
    }

    .developer-card {
        text-align: center;
        background: white;
        border-radius: 18px;
        padding: 35px 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
    }

    .developer-avatar {
        width: 90px;
        height: 90px;
        margin: auto;
        margin-bottom: 20px;
        border-radius: 50%;
        background: #17375E;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        font-weight: bold;
    }
</style>

@endsection