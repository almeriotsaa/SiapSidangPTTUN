@extends('layouts.admin')

@section('title','Dashboard')

@section('content')

<style>
    .badge-soft {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 500;
    }
    .badge-soft-green  { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
    .badge-soft-red     { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
    .badge-soft-gray    { background:#f3f4f6; color:#4b5563; border:1px solid #e5e7eb; }

    .status-dot { width:6px; height:6px; border-radius:50%; display:inline-block; }
    .dot-green  { background:#22c55e; }
    .dot-red     { background:#ef4444; }
    .dot-gray    { background:#9ca3af; }

    .summary-card {
        background:#fff;
        border:1px solid #f1f1f1;
        border-radius:.75rem;
        box-shadow:0 1px 2px rgba(0,0,0,.04);
        padding:1rem;
    }
    .summary-card .label {
        font-size:.75rem;
        font-weight:500;
        color:#6b7280;
        text-transform:uppercase;
        letter-spacing:.03em;
    }
    .summary-card .value {
        font-size:1.5rem;
        font-weight:700;
        margin-top:.25rem;
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
        border-bottom:1px solid #f1f1f1;
    }
    .table-card tbody td {
        vertical-align:middle;
        font-size:.9rem;
    }
    .table-card tbody tr:hover {
        background:#fafafa;
    }

    .pihak-pill {
        display:inline-block;
        background:#f3f4f6;
        color:#374151;
        border-radius:.4rem;
        padding:2px 8px;
        font-size:.75rem;
        margin:1px 3px 1px 0;
    }
</style>

<div class="container-fluid px-4" style="max-width:1500px;">

    {{-- Role badge --}}
    <div class="mb-3">
        <span class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill"
            style="background:#f9fafb; border:1px solid #e5e7eb; font-size:.8rem; color:#374151;">
            <span class="rounded-circle" style="width:7px; height:7px; background:{{ auth()->user()->role === 'admin' ? '#17375E' : '#E4B028' }};"></span>
            Masuk sebagai <strong>{{ auth()->user()->nama }}</strong>
            &middot; {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Front Office' }}
        </span>
    </div>

    {{-- Header --}}
    <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Jadwal Sidang Hari Ini</h1>
            <p class="text-secondary small mb-0">
                {{ \Carbon\Carbon::today()->format('d M Y') }} &middot; Toleransi kehadiran 15 menit dari jadwal
            </p>
        </div>
    </div>

    {{-- Summary cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="summary-card">
                <p class="label mb-0">Total Perkara</p>
                <p class="value text-dark mb-0">{{ $totalPerkara }}</p>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="summary-card">
                <p class="label mb-0">Semua Hadir</p>
                <p class="value text-success mb-0">{{ $totalSemuaHadir }}</p>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="summary-card">
                <p class="label mb-0">Ada Kendala Kehadiran</p>
                <p class="value text-danger mb-0">{{ $totalKendala }}</p>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="summary-card">
                <p class="label mb-0">Belum Lengkap</p>
                <p class="value text-secondary mb-0">{{ $totalBelumLengkap }}</p>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">No. Perkara</th>
                    <th class="px-4 py-3">Waktu</th>
                    <th class="px-4 py-3">Ruang</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwalHariIni as $i => $j)
                    @php $status = $j->statusRingkasan(); @endphp
                    <tr style="border-top:1px solid #f1f1f1;">
                        <td class="px-4 py-4 text-secondary">{{ $i + 1 }}</td>
                        <td class="px-4 py-4 fw-semibold text-dark">{{ $j->perkara->nomor_perkara }}</td>
                        <td class="px-4 py-4 fw-medium">{{ substr($j->jam_sidang, 0, 5) }}</td>
                        <td class="px-4 py-4">{{ $j->ruang_sidang }}</td>
                        <td class="px-4 py-4">
                            <span class="badge-soft {{ $status['badge'] }}">
                                <span class="status-dot {{ $status['dot'] }}"></span>
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <button type="button" class="btn btn-link btn-sm text-decoration-none p-0"
                                onclick="openDetailModal({{ $j->id }})">
                                Lihat Detail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-secondary small py-5">
                            Tidak ada jadwal sidang hari ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- Modal Detail Sidang — satu per baris, pre-filled dari server --}}
@foreach ($jadwalHariIni as $j)
    <div class="modal fade" id="detailModal{{ $j->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">

                <div class="modal-header border-0 pb-0">
                    <div>
                        <h2 class="h5 fw-bold text-dark mb-0">{{ $j->perkara->nomor_perkara }}</h2>
                        <p class="text-secondary small mb-0">{{ $j->perkara->agenda }}</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" style="max-height:70vh; overflow-y:auto;">

                    <div>
                        <h3 class="fw-bold text-dark text-uppercase mb-3" style="font-size:.75rem; letter-spacing:.03em;">Informasi Sidang</h3>
                        <div class="mb-2">
                            <p class="text-secondary small mb-0">Tanggal</p>
                            <p class="fw-semibold text-dark">{{ $j->tanggal_sidang->format('d M Y') }}</p>
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary small mb-0">Waktu</p>
                            <p class="fw-semibold text-dark">{{ substr($j->jam_sidang, 0, 5) }}</p>
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary small mb-0">Ruang Sidang</p>
                            <p class="fw-semibold text-dark">{{ $j->ruang_sidang }}</p>
                        </div>
                    </div>

                    <div class="pt-3 mt-3 border-top">
                        <h3 class="fw-bold text-dark text-uppercase mb-3" style="font-size:.75rem; letter-spacing:.03em;">Majelis Hakim</h3>
                        <div class="mb-2">
                            <p class="text-secondary small mb-0">Hakim Ketua</p>
                            <p class="fw-semibold text-dark">{{ $j->hakimKetua->nama }}</p>
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary small mb-0">Hakim Anggota I</p>
                            <p class="fw-semibold text-dark">{{ $j->hakimAnggota1->nama }}</p>
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary small mb-0">Hakim Anggota II</p>
                            <p class="fw-semibold text-dark">{{ $j->hakimAnggota2->nama }}</p>
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary small mb-0">Panitera Pengganti</p>
                            <p class="fw-semibold text-dark">{{ $j->panitera->nama }}</p>
                        </div>
                    </div>

                    <div class="pt-3 mt-3 border-top">
                        <h3 class="fw-bold text-dark text-uppercase mb-3" style="font-size:.75rem; letter-spacing:.03em;">Para Pihak</h3>
                        <div class="mb-2">
                            <p class="text-secondary small mb-1">Penggugat</p>
                            @foreach ($j->perkara->pihak->where('tipe', 'penggugat') as $pg)
                                <span class="pihak-pill">{{ $pg->nama }}</span>
                            @endforeach
                        </div>
                        <div class="mb-2">
                            <p class="text-secondary small mb-1">Tergugat</p>
                            @foreach ($j->perkara->pihak->where('tipe', 'tergugat') as $tg)
                                <span class="pihak-pill">{{ $tg->nama }}</span>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="px-6 py-4 border-top d-flex justify-content-end">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    const detailModalInstances = {};

    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($jadwalHariIni as $j)
            detailModalInstances[{{ $j->id }}] = new bootstrap.Modal(document.getElementById('detailModal{{ $j->id }}'));
        @endforeach
    });

    function openDetailModal(id) {
        detailModalInstances[id].show();
    }
</script>

@endsection