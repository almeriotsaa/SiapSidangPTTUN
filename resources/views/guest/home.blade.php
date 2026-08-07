@extends('layouts.guest')

@section('title','Beranda')

@section('content')

<!-- HERO -->
<section class="hero-section py-5 text-white">

    <div class="page-container">

        <div class="row align-items-center">

            <div class="col-lg-6">

                <h1 class="title-hero">

                    SIAP SIDANG -

                </h1>

                <h4 class="sub-title mb-3">

                    Pengadilan Tingi Tata Usaha Negara Jakarta

                </h4>

                <p class="deskripsi">

                    Website resmi SIAP SIDANG Pengadilan Tinggi Tata Usaha Negara Jakarta.

                    Masyarakat dapat melihat jadwal sidang secara online, sedangkan petugas internal dapat melakukan validasi kehadiran pihak yang berperkara.

                </p>

            </div>

            <div class="col-lg-6 text-center">

                <div id="heroCarousel"
                    class="carousel slide hero-carousel"
                    data-bs-ride="carousel"
                    data-bs-interval="4000"
                    data-bs-pause="false">

                    <div class="carousel-inner">

                        <div class="carousel-item active">
                            <img src="{{ asset('assets/images/pttun 1.jfif') }}"
                                class="d-block w-100 image-hero"
                                alt="">
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('assets/images/pttun 2.jfif') }}"
                                class="d-block w-100 image-hero"
                                alt="">
                        </div>

                        <div class="carousel-item">
                            <img src="{{ asset('assets/images/pttun 3.jfif') }}"
                                class="d-block w-100 image-hero"
                                alt="">
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- FITUR -->

<section class="fitur-section py-5">

    <div class="page-container">

        <div class="section-title text-center mb-5">

            <h2 class="fw-bold mt-3">
                SIAP SIDANG
            </h2>

            <p class="text-muted mx-auto">
                Sistem Informasi Presensi Sidang yang membantu proses administrasi
                persidangan menjadi lebih cepat, transparan, dan terintegrasi.
            </p>

        </div>

        <div class="row g-4">

            <!-- CARD 1 -->
            <div class="col-lg-4">

                <div class="feature-card">

                    <span class="feature-number">
                        01
                    </span>

                    <div class="feature-icon bg-primary">

                        <i class="bi bi-calendar-week"></i>

                    </div>

                    <h4>
                        Jadwal Sidang
                    </h4>

                    <p>
                        Menampilkan jadwal sidang lengkap beserta agenda, waktu, ruang sidang, dan majelis hakim yang dapat diakses secara online.
                    </p>

                </div>

            </div>

            <!-- CARD 2 -->
            <div class="col-lg-4">

                <div class="feature-card">

                    <span class="feature-number">
                        02
                    </span>

                    <div class="feature-icon bg-success">

                        <i class="bi bi-person-check"></i>

                    </div>

                    <h4>
                        Validasi Kehadiran
                    </h4>

                    <p>
                        Memungkinkan Front Office melakukan validasi kehadiran para pihak secara real-time sebelum proses persidangan dimulai.
                    </p>

                </div>

            </div>

            <!-- CARD 3 -->
            <div class="col-lg-4">

                <div class="feature-card">

                    <span class="feature-number">
                        03
                    </span>

                    <div class="feature-icon bg-danger">

                        <i class="bi bi-shield-lock"></i>

                    </div>

                    <h4>
                        Hak Akses Pengguna
                    </h4>

                    <p>
                        Setiap pengguna sistem Siap Sidang memperoleh hak akses sesuai perannya, mulai dari Admin & Front Office (Administrasi).
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<style>
    .page-container {
        width: 100%;
        max-width: 1700px;
        margin: auto;
        padding-inline: 32px;
    }

    @media (max-width:992px) {
        .page-container {
            padding-inline: 20px;
        }
    }

    .hero-section {
        background-color: #0B1849;
    }

    .title-hero {
        font-size: 36px;
        font-weight: 600;
        color: #E4B028;
        /* font-family: 'Source Serif 4', serif; */
    }

    .sub-title {
        font-size: 16px;
        font-weight: 500;
        color: #E4B028;
    }

    .deskripsi {
        font-size: 15px;
        text-align: justify;
        line-height: 1.9;
        max-width: 550px;
    }

    .hero-carousel {
        border-radius: 22px;
        overflow: hidden;
        border: 4px solid #fff;
    }

    .image-hero {
        width: 100%;
        height: 360px;
        object-fit: cover;
    }

    /* Hilangkan tombol */
    .carousel-control-prev,
    .carousel-control-next {
        display: none;
    }

    /* Hilangkan indikator */
    .carousel-indicators {
        display: none;
    }

    /* Animasi zoom halus */
    .carousel-item img {
        transition: transform 5s ease;
    }

    .carousel-item.active img {
        transform: scale(1.05);
    }

    .fitur-section {

        background: #FFFBEF;
        position: relative;
        overflow: hidden;
        padding: 90px 0;

    }

    /* background ornament */

    .fitur-section::before {

        content: "";
        position: absolute;
        width: 420px;
        height: 420px;
        border-radius: 50%;
        background: rgba(23, 55, 94, .05);
        top: -180px;
        left: -150px;

    }

    .fitur-section::after {

        content: "";
        position: absolute;
        width: 350px;
        height: 350px;
        border-radius: 50%;
        background: rgba(176, 141, 87, .08);
        right: -120px;
        bottom: -150px;

    }

    .section-title {

        position: relative;
        z-index: 2;

    }

    .section-title h2 {

        font-size: 48px;
        font-weight: 700;
        color: #17375E;
        /* font-family: 'Source Serif 4', serif; */

    }

    .section-title p {

        max-width: 650px;
        font-size: 15px;

    }

    .feature-card {

        position: relative;
        background: white;
        border-radius: 18px;
        padding: 45px 30px;
        text-align: center;
        transition: .35s;
        overflow: hidden;
        border: 1px solid #E5E7EB;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .05);

    }

    .feature-card::before {

        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background-color: #17375E;

    }

    .feature-card:hover {

        transform: translateY(-10px);
        box-shadow: 0 18px 35px rgba(0, 0, 0, .12);

    }

    .feature-icon {

        width: 90px;
        height: 90px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto;
        color: white;
        font-size: 36px;
        margin-bottom: 25px;

    }

    .feature-card h4 {

        font-weight: 700;
        color: #17375E;
        margin-bottom: 15px;

    }

    .feature-card p {

        color: #6B7280;
        line-height: 1.8;
        font-size: 15px;

    }

    .feature-number {

        position: absolute;
        top: 20px;
        right: 25px;
        font-size: 50px;
        font-weight: 700;
        color: #EEF2F7;

    }
</style>

@endsection