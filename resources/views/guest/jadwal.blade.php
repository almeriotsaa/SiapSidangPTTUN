@extends('layouts.guest')

@section('title', 'Jadwal Sidang')

@section('content')

<style>
    :root {
        --tun-navy: #0f2c4c;
        --tun-gold: #c9a227;
        --tun-green: #198754;
    }

    .page-container {
        width: 100%;
        max-width: 1700px;
        margin-inline: auto;
        padding-inline: 32px;
    }

    @media (max-width:992px) {
        .page-container {
            padding-inline: 20px;
        }
    }

    .page-title {
        font-weight: 700;
        color: var(--tun-navy);
    }

    .schedule-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
    }

    .table thead {
        background: var(--tun-navy);
        color: #fff;
    }

    .table thead th {
        padding: 16px;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
    }

    .table tbody td {
        padding: 18px 14px;
        vertical-align: top;
    }

    .label {
        font-weight: 700;
        color: var(--tun-navy);
    }

    .divider {
        border-bottom: 1px solid #e9ecef;
        margin: 6px 0;
    }

    .case-badge {

        display: inline-block;
        background: #EEF5FF;
        color: #17375E;
        padding: 8px 15px;
        border-radius: 10px;
        font-weight: 700;
        font-size: .92rem;

    }

    .judge-item {

        margin-bottom: 10px;

    }

    .judge-role {

        display: inline-block;
        background: #17375E;
        color: white;
        padding: 3px 9px;
        border-radius: 5px;
        font-size: 12px;
        margin-right: 8px;

    }

    .page-title {

        font-size: 34px;
        font-weight: 700;
        color: #17375E;

    }

    .page-subtitle {

        color: #6B7280;
        margin-top: 6px;

    }

    .filter-card {

        border: none;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .06);

    }

    .btn-search {

        background: #17375E;
        color: white;
        border-radius: 10px;
        padding: 11px;

    }

    .btn-search:hover {

        background: #0F2C4C;
        color: white;

    }

    .schedule-card {

        border: none;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, .08);

    }

    .table tbody tr:hover {

        background: #F8FBFF;

    }

    .table thead {

        position: sticky;
        top: 0;
        z-index: 10;

    }

    .schedule-toolbar {

        margin-bottom: 28px;

        padding-bottom: 20px;

        border-bottom: 1px solid #E8EDF3;

    }

    .schedule-toolbar .form-label {

        font-weight: 600;
        color: #17375E;
        margin-bottom: 10px;

    }

    .toolbar-input {

        height: 52px;

        border-radius: 12px;

        border: 1px solid #D6DEE8;

        padding-inline: 16px;

        transition: .25s;

    }

    .toolbar-input:focus {

        border-color: #17375E;

        box-shadow: 0 0 0 .18rem rgba(23, 55, 94, .12);

    }

    .btn-generate {

        height: 52px;

        border: none;

        border-radius: 12px;

        background: #17375E;

        color: white;

        font-weight: 600;

        transition: .25s;

    }

    .btn-generate:hover {

        background: #0F2C4C;

        transform: translateY(-2px);

    }
</style>

<div class="page-container py-5">

    <div class="page-header">

        <h2 class="page-title">
            Jadwal Sidang
        </h2>

        <p class="page-subtitle">
            Informasi jadwal persidangan yang dapat diakses oleh masyarakat secara online.
        </p>

    </div>

    <!-- Filter -->
    <div class="schedule-toolbar mb-4">

        <div class="row align-items-end">

            <div class="col-lg-4">

                <label class="form-label">
                    Pilih Tanggal Sidang
                </label>

                <input
                    type="date"
                    class="form-control toolbar-input">

            </div>

            <div class="col-lg-3">

                <button class="btn btn-generate w-100">

                    <i class="bi bi-arrow-repeat me-2"></i>

                    Tampilkan

                </button>

            </div>

        </div>

    </div>

    <div class="card schedule-card">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>

                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">No Perkara</th>
                        <th width="17%">Waktu & Ruang</th>
                        <th width="20%">Agenda</th>
                        <th width="23%">Majelis Hakim / PP</th>
                        <th width="15%">Pihak</th>
                        <th width="10%">Kehadiran</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td class="text-center">
                            <strong>1</strong>
                        </td>

                        <td>
                            <span class="case-badge">

                                23/G/2026/PT.TUN.JKT

                            </span>
                        </td>

                        <td>

                            <div class="schedule-info">

                                <div>

                                    <i class="bi bi-calendar3"></i>

                                    05 Agustus 2026

                                </div>

                                <div>

                                    <i class="bi bi-clock"></i>

                                    10.00 WIB

                                </div>

                                <div>

                                    <i class="bi bi-door-open"></i>

                                    Ruang Sidang I

                                </div>

                            </div>

                        </td>

                        <td>

                            Pemeriksaan Persiapan
                            <br>
                            (Perbaikan Gugatan &
                            Surat Kuasa)

                        </td>

                        <td>

                            <div class="judge-item">

                                <span class="judge-role">

                                    HK

                                </span>

                                Ulia Alba, S.H., M.H.

                            </div>

                            <div class="judge-item">

                                <span class="judge-role">

                                    HA1

                                </span>

                                Listyorani Imawati

                            </div>

                            <div class="judge-item">

                                <span class="judge-role">

                                    HA2

                                </span>

                                Berdyan Shonata

                            </div>

                            <div class="judge-item">

                                <span class="judge-role">

                                    PP

                                </span>

                                Hambali, S.H., M.H.

                            </div>

                        </td>

                        <td>

                            <div>
                                <span class="label">
                                    Penggugat :
                                </span>
                                Ir. Rully Chairul Azwar
                            </div>

                            <div class="divider"></div>

                            <div>
                                <span class="label">
                                    Tergugat :
                                </span>

                                Kepala Kantor Pertanahan
                                Kabupaten Pandeglang

                            </div>

                        </td>

                        <td>

                            <span class="badge bg-success">

                                Penggugat Hadir

                            </span>

                            <br><br>

                            <span class="badge bg-success">

                                Tergugat Hadir

                            </span>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection