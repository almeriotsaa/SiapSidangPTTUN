@extends('layouts.admin')

@section('title','Kehadiran')

@section('content')

<style>
    .page-container {
        width: 100%;
        max-width: 1700px;
        margin: auto;
        padding-inline: 45px;
    }

    .table-card {
        background:#fff;
        border:1px solid #f1f1f1;
        border-radius:.75rem;
        box-shadow:0 1px 2px rgba(0,0,0,.04);
        overflow:hidden;
    }
    .table-card thead th {
        background:#f9fafb;
        font-size:.72rem;
        font-weight:600;
        color:#6b7280;
        text-transform:uppercase;
        letter-spacing:.03em;
        white-space:nowrap;
    }
    .table-card tbody td {
        vertical-align:middle;
        font-size:.9rem;
    }
    .table-card tbody tr:hover {
        background:#fafafa;
    }
    .table-responsive-wrap {
        overflow-x:auto;
    }

    .status-cell {
        display:flex;
        align-items:center;
        gap:8px;
        white-space:nowrap;
    }

    .badge-status {
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:3px 10px;
        border-radius:999px;
        font-size:.75rem;
        font-weight:500;
        white-space:nowrap;
    }
    .badge-status-hadir {
        background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;
    }
    .badge-status-tidak-hadir {
        background:#fef2f2; color:#dc2626; border:1px solid #fecaca;
    }
    .badge-status-belum-hadir {
        background:#f3f4f6; color:#4b5563; border:1px solid #e5e7eb;
    }

    .badge-tipe {
        display:inline-block;
        padding:2px 8px;
        border-radius:.4rem;
        font-size:.72rem;
        font-weight:600;
    }
    .badge-tipe-penggugat {
        background:#eef2ff; color:#4338ca;
    }
    .badge-tipe-tergugat {
        background:#fff7ed; color:#c2410c;
    }

    .btn-tandai-hadir {
        font-size:.75rem;
        padding:.3rem .7rem;
        border-radius:999px;
    }
</style>

<section class="py-5">
    <div class="page-container">

        {{-- Header --}}
        <div class="mb-4">
            <h1 class="h3 fw-bold text-dark mb-1">Kehadiran</h1>
            <p class="text-secondary small mb-0">
                @if (auth()->user()->role === 'admin')
                    Status kehadiran Penggugat &amp; Tergugat per jadwal sidang (tampilan saja — Admin tidak dapat mengubah status).
                @else
                    Tandai kehadiran Penggugat dan Tergugat &middot; Status otomatis menjadi <strong>Tidak Hadir</strong> jika belum ditandai hadir 15 menit setelah jadwal sidang.
                @endif
            </p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Table --}}
        <div class="table-card table-responsive-wrap">
            <table class="table table-borderless mb-0">
                <thead>
                    <tr>
                        <th class="px-3 py-3">No</th>
                        <th class="px-3 py-3">No. Perkara</th>
                        <th class="px-3 py-3">Tanggal</th>
                        <th class="px-3 py-3">Waktu</th>
                        <th class="px-3 py-3">Ruang</th>
                        <th class="px-3 py-3">Pihak</th>
                        <th class="px-3 py-3">Tipe</th>
                        <th class="px-3 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kehadiranList as $i => $k)
                        @php
                            $jadwal = $k->jadwalSidang;
                            $lewatBatas = $jadwal->sudahLewatBatas();
                            $bisaTandaiHadir = auth()->user()->role !== 'admin' && $k->status !== 'Hadir' && !$lewatBatas;
                        @endphp
                        <tr style="border-top:1px solid #f1f1f1;">
                            <td class="px-3 py-3 text-secondary">{{ $i + 1 }}</td>
                            <td class="px-3 py-3 fw-semibold text-dark">{{ $jadwal->perkara->nomor_perkara }}</td>
                            <td class="px-3 py-3">{{ $jadwal->tanggal_sidang->format('d M Y') }}</td>
                            <td class="px-3 py-3 fw-medium">{{ substr($jadwal->jam_sidang, 0, 5) }}</td>
                            <td class="px-3 py-3">{{ $jadwal->ruang_sidang }}</td>
                            <td class="px-3 py-3">{{ $k->pihak->nama }}</td>
                            <td class="px-3 py-3">
                                @if ($k->pihak->tipe === 'penggugat')
                                    <span class="badge-tipe badge-tipe-penggugat">Penggugat</span>
                                @else
                                    <span class="badge-tipe badge-tipe-tergugat">Tergugat</span>
                                @endif
                            </td>
                            <td class="px-3 py-3">
                                @if ($k->status === 'Hadir')
                                    <span class="badge-status badge-status-hadir">&#9679; Hadir</span>
                                @elseif ($lewatBatas)
                                    <span class="badge-status badge-status-tidak-hadir">&#9679; Tidak Hadir</span>
                                @elseif ($bisaTandaiHadir)
                                    <div class="status-cell">
                                        <span class="badge-status badge-status-belum-hadir">&#9679; Belum Hadir</span>
                                        <form method="POST" action="{{ route('kehadiran.tandai-hadir', $k->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-tandai-hadir">Hadir</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="badge-status badge-status-belum-hadir">&#9679; Belum Hadir</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-secondary small py-5">
                                Belum ada jadwal sidang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</section>

@endsection