@extends('layouts.guest')

@section('title','Kontak')

@section('content')

<div class="page-container py-5">

    <div class="mb-5">

        <h2 class="page-title h2 fw-bold mb-1">
            Kontak Kami
        </h2>

        <p class="page-subtitle">
            Hubungi Pengadilan Tinggi Tata Usaha Negara Jakarta apabila
            membutuhkan informasi mengenai SIAP SIDANG maupun jadwal persidangan.
        </p>

    </div>

    <div class="row g-5 align-items-stretch">

        <div class="col-lg-5">

            <div class="contact-card">

                <h3 class="section-title mb-4">

                    Pengadilan Tinggi Tata Usaha Negara Jakarta

                </h3>

                <div class="contact-item">

                    <div class="contact-icon">

                        <i class="bi bi-geo-alt-fill"></i>

                    </div>

                    <div>

                        <h6>Alamat</h6>

                        <p>
                            Jalan Cikini Raya No. 117, Kec. Menteng, Kota Jakarta Pusat, DKI Jakarta 10330
                        </p>

                    </div>

                </div>

                <div class="contact-item">

                    <div class="contact-icon">

                        <i class="bi bi-telephone-fill"></i>

                    </div>

                    <div>

                        <h6>Telepon</h6>

                        <p>(021) 3192 6162</p>

                    </div>

                </div>

                <div class="contact-item">

                    <div class="contact-icon">

                        <i class="bi bi-envelope-fill"></i>

                    </div>

                    <div>

                        <h6>Email</h6>

                        <p>pttun.jakarta@gmail.com</p>

                    </div>

                </div>

                <div class="contact-item">

                    <div class="contact-icon">

                        <i class="bi bi-globe"></i>

                    </div>

                    <div>

                        <h6>Website</h6>

                        <p>pttun-jakarta.go.id</p>

                    </div>

                </div>

                <div class="contact-item mb-0">

                    <div class="contact-icon">

                        <i class="bi bi-clock-fill"></i>

                    </div>

                    <div>

                        <h6>Jam Operasional</h6>

                        <p>
                            Senin - Jumat
                            <br>
                            08.00 - 16.30 WIB
                        </p>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-7">

            <div class="map-card">

                <iframe
                    src="https://maps.google.com/maps?q=Pengadilan%20Tinggi%20Tata%20Usaha%20Negara%20Jakarta&t=&z=15&ie=UTF8&iwloc=&output=embed"
                    loading="lazy">
                </iframe>

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

    .page-title {
        font-weight: 700;
        color: #17375E;
    }

    .page-subtitle {
        max-width: 700px;
        color: #6B7280;
        font-size: 16px;
    }

    .section-title {
        color: #17375E;
        font-weight: 700;
    }

    .contact-card {

        background: white;
        border-radius: 22px;
        padding: 35px;
        height: 100%;
        box-shadow: 0 15px 35px rgba(0, 0, 0, .06);

    }

    .contact-item {

        display: flex;
        gap: 18px;
        margin-bottom: 28px;

    }

    .contact-icon {

        width: 54px;
        height: 54px;
        border-radius: 14px;
        background: #FFF6DE;
        color: #E4B028;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;

    }

    .contact-item h6 {

        color: #17375E;
        margin-bottom: 6px;
        font-weight: 700;

    }

    .contact-item p {

        color: #6B7280;
        margin: 0;
        line-height: 1.7;

    }

    .map-card {

        height: 100%;
        min-height: 520px;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, .06);

    }

    .map-card iframe {

        width: 100%;
        height: 100%;
        border: 0;

    }
</style>

@endsection