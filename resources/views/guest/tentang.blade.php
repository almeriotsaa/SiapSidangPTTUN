@extends('layouts.guest')

@section('title','Tentang')

@section('content')

<div class="page-container py-5">

    <!-- Tentang Sistem -->

    <div class="content-panel panel-tint-blue mb-5">

        <div class="row align-items-center g-5">

            <div class="col-lg-5">

                <img src="{{ asset('assets/images/pttun 2.jfif') }}"
                    class="img-fluid about-image">

            </div>

            <div class="col-lg-7">

                <h3 class="section-title mb-3">

                    Apa itu SIAP SIDANG?

                </h3>

                <p class="teks-deskripsi">

                    SIAP SIDANG merupakan Sistem Informasi Presensi Sidang yang
                    dikembangkan untuk membantu proses administrasi persidangan
                    di Pengadilan Tinggi Tata Usaha Negara Jakarta.

                </p>

                <p class="teks-deskripsi">

                    Melalui sistem ini, masyarakat dapat melihat jadwal sidang
                    secara online, sementara petugas internal dapat melakukan
                    validasi kehadiran pihak berperkara secara real-time sehingga
                    informasi yang diterima Panitera Pengganti menjadi lebih cepat
                    dan akurat.

                </p>

            </div>

        </div>

    </div>

    <!-- Tujuan -->

    <div class="content-panel panel-tint-gold mb-5">

        <div class="row g-4">

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
                        Informasi langsung diterima oleh Pengguna.
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

    </div>

    <!-- Developer -->

    <div class="content-panel panel-tint-blue developer-section">

        <h2 class="section-title mb-3">

            Dikembangkan Oleh

        </h2>

        <p class="teks-deskripsi mb-4">

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

                    <span class="developer-role">Full Stack Developer</span>

                </div>

            </div>

            <div class="col-md-3">

                <div class="developer-card">

                    <div class="developer-avatar">
                        MS
                    </div>

                    <h5>Michael Timothy Sipahutar</h5>

                    <span class="developer-role">Full Stack Developer</span>

                </div>

            </div>

            <div class="col-md-3">

                <div class="developer-card">

                    <div class="developer-avatar">
                        FR
                    </div>

                    <h5>Fajar Rizky Handani Hasibuan</h5>

                    <span class="developer-role">Full Stack Developer</span>

                </div>

            </div>

            <div class="col-md-3">

                <div class="developer-card">

                    <div class="developer-avatar">
                        MF
                    </div>

                    <h5>Muhammad Faiq Al Harits</h5>

                    <span class="developer-role">Full Stack Developer</span>

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

    .content-panel {
        border-radius: 24px;
        padding: 45px;
    }

    @media (max-width:768px) {
        .content-panel {
            padding: 28px 20px;
        }
    }

    .panel-tint-blue {
        background: #EFF5FB;
    }

    .panel-tint-gold {
        background: #FBF6E9;
    }

    .content-panel .feature-card,
    .content-panel .developer-card {
        background: #fff;
    }

    .about-image {
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
    }

    .teks-deskripsi {
        text-align: justify;
        line-height: 1.9;
        color: #4b5563;
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
        box-shadow: 0 15px 35px rgba(0, 0, 0, .1);
    }

    .feature-card i {
        font-size: 42px;
        color: #E4B028;
        margin-bottom: 18px;
    }

    .feature-card h5 {
        color: #17375E;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .feature-card p {
        color: #6b7280;
        font-size: .92rem;
        margin-bottom: 0;
    }

    /* ===== Section developer ===== */
    .developer-card {
        text-align: center;
        background: white;
        border-radius: 18px;
        padding: 35px 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
        height: 100%;
        transition: .3s;
    }

    .developer-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, .1);
    }

    .developer-card h5 {
        color: #17375E;
        font-weight: 700;
        font-size: .95rem;
        margin-bottom: 6px;
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

    .developer-role {
        display: inline-block;
        font-size: .8rem;
        color: #9ca3af;
        font-weight: 500;
    }
</style>

@endsection