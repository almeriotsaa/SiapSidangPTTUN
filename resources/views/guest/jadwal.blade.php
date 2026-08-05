@extends('layouts.guest')

@section('title', 'Jadwal Sidang')

@section('content')

<style>
    :root{
        --tun-navy:#0f2c4c;
        --tun-gold:#c9a227;
        --tun-green:#198754;
    }

    .page-title{
        font-weight:700;
        color:var(--tun-navy);
    }

    .schedule-card{
        border:none;
        border-radius:16px;
        overflow:hidden;
        box-shadow:0 10px 25px rgba(0,0,0,.08);
    }

    .table thead{
        background:var(--tun-navy);
        color:#fff;
    }

    .table thead th{
        padding:16px;
        font-weight:600;
        text-align:center;
        vertical-align:middle;
    }

    .table tbody td{
        padding:18px 14px;
        vertical-align:top;
    }

    .case-number{
        font-weight:700;
        color:var(--tun-navy);
        font-size:1rem;
    }

    .datetime{
        font-weight:600;
    }

    .room{
        color:#6c757d;
        font-size:.9rem;
    }

    .label{
        font-weight:700;
        color:var(--tun-navy);
    }

    .divider{
        border-bottom:1px solid #e9ecef;
        margin:6px 0;
    }

    .status{
        color:#198754;
        font-weight:700;
    }

    .search-card{
        border:none;
        border-radius:16px;
        box-shadow:0 8px 20px rgba(0,0,0,.06);
    }
</style>

<div class="container py-5">

    <h2 class="page-title mb-4">
        Jadwal Sidang
    </h2>

    <!-- Filter -->
    <div class="card search-card mb-4">
        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-4">
                    <input type="date" class="form-control">
                </div>

                <div class="col-md-5">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Cari Nomor Perkara...">
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                        Cari
                    </button>
                </div>

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
                        <div class="case-number">
                            23/G/2026/PT.TUN.JKT
                        </div>
                    </td>

                    <td>

                        <div class="datetime">
                            05 Agustus 2026
                        </div>

                        <div>
                            10:00 WIB
                        </div>

                        <div class="room">
                            Ruang Sidang 1
                        </div>

                    </td>

                    <td>

                        Pemeriksaan Persiapan
                        <br>
                        (Perbaikan Gugatan &
                        Surat Kuasa)

                    </td>

                    <td>

                        <div>
                            <span class="label">HK :</span>
                            Ulia Alba, S.H., M.H.
                        </div>

                        <div class="divider"></div>

                        <div>
                            <span class="label">HA 1 :</span>
                            Listyorani Imawati, S.H., M.H.
                        </div>

                        <div class="divider"></div>

                        <div>
                            <span class="label">HA 2 :</span>
                            Berdyan Shonata, S.H.
                        </div>

                        <div class="divider"></div>

                        <div>
                            <span class="label">PP :</span>
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

                        <div class="status">
                            Penggugat ✔ Hadir
                        </div>

                        <div class="divider"></div>

                        <div class="status">
                            Tergugat ✔ Hadir
                        </div>

                    </td>

                </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection