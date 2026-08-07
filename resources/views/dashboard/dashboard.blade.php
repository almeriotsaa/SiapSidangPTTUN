@extends('layouts.admin')

@section('title','Dashboard')

@section('content')

@php
    $sidangList = [
        ['no' => 1, 'perkara' => '123/Pdt.G/2026/PN.Jkt.Ps', 'jenis' => 'Perdata', 'waktu' => '08.30', 'ruang' => 'Ruang Sidang I', 'penggugat_status' => 'Hadir', 'tergugat_status' => 'Hadir'],
        ['no' => 2, 'perkara' => '45/Pid.B/2026/PN.Jkt.Ps', 'jenis' => 'Pidana', 'waktu' => '09.00', 'ruang' => 'Ruang Sidang II', 'penggugat_status' => 'Belum Hadir', 'tergugat_status' => 'Belum Hadir'],
        ['no' => 3, 'perkara' => '78/Pdt.G/2026/PN.Jkt.Ps', 'jenis' => 'Perdata', 'waktu' => '09.15', 'ruang' => 'Ruang Sidang III', 'penggugat_status' => 'Hadir', 'tergugat_status' => 'Belum Hadir'],
        ['no' => 4, 'perkara' => '12/Pdt.G/2026/PN.Jkt.Ps', 'jenis' => 'Perdata', 'waktu' => '07.30', 'ruang' => 'Ruang Sidang I', 'penggugat_status' => 'Tidak Hadir', 'tergugat_status' => 'Hadir'],
        ['no' => 5, 'perkara' => '99/Pid.Sus/2026/PN.Jkt.Ps', 'jenis' => 'Pidana', 'waktu' => '07.00', 'ruang' => 'Ruang Sidang II', 'penggugat_status' => 'Hadir', 'tergugat_status' => 'Tidak Hadir'],
        ['no' => 6, 'perkara' => '56/Pdt.G/2026/PN.Jkt.Ps', 'jenis' => 'Perdata', 'waktu' => '11.00', 'ruang' => 'Ruang Sidang III', 'penggugat_status' => 'Belum Hadir', 'tergugat_status' => 'Belum Hadir'],
    ];

    function ringkasStatus($p, $t) {
        if ($p === 'Tidak Hadir' || $t === 'Tidak Hadir') {
            return ['label' => 'Ada Kendala Kehadiran', 'badge' => 'badge-soft-red', 'dot' => 'dot-red'];
        }
        if ($p === 'Hadir' && $t === 'Hadir') {
            return ['label' => 'Kedua Pihak Hadir', 'badge' => 'badge-soft-green', 'dot' => 'dot-green'];
        }
        if ($p === 'Hadir' && $t === 'Belum Hadir') {
            return ['label' => 'Penggugat Hadir', 'badge' => 'badge-soft-yellow', 'dot' => 'dot-yellow'];
        }
        if ($t === 'Hadir' && $p === 'Belum Hadir') {
            return ['label' => 'Tergugat Hadir', 'badge' => 'badge-soft-yellow', 'dot' => 'dot-yellow'];
        }
        return ['label' => 'Belum Check-in', 'badge' => 'badge-soft-gray', 'dot' => 'dot-gray'];
    }

    $sidangList = collect($sidangList)->map(function ($s) {
        $s['status'] = ringkasStatus($s['penggugat_status'], $s['tergugat_status']);
        return $s;
    });

    $totalPerkara = $sidangList->count();
    $totalHadirPenuh = $sidangList->filter(fn ($s) => $s['status']['label'] === 'Kedua Pihak Hadir')->count();
    $totalKendala = $sidangList->filter(fn ($s) => $s['status']['label'] === 'Ada Kendala Kehadiran')->count();
    $totalBelumCheckin = $sidangList->filter(fn ($s) => $s['status']['label'] === 'Belum Check-in')->count();
@endphp

<style>
    /* Badge soft-color, meniru tampilan Tailwind bg-*-50 text-*-700 ring-1 */

    .page-container {
        width: 100%;
        max-width: 1700px;
        margin: auto;
        padding-inline: 45px;
    }
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
    .badge-soft-yellow { background:#fefce8; color:#a16207; border:1px solid #fef08a; }
    .badge-soft-gray    { background:#f3f4f6; color:#4b5563; border:1px solid #e5e7eb; }

    .status-dot { width:6px; height:6px; border-radius:50%; display:inline-block; }
    .dot-green  { background:#22c55e; }
    .dot-red     { background:#ef4444; }
    .dot-yellow { background:#facc15; }
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
</style>
<section class="hero-section py-5">
    <div class="page-container">

    {{-- Header --}}
    <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Jadwal Sidang Hari Ini</h1>
            <p class="text-secondary small mb-0">
                4 Agustus 2026 &middot; Toleransi kehadiran 15 menit dari jadwal &middot; Status diperbarui otomatis
            </p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm">+15 menit</button>
            <button class="btn btn-outline-secondary btn-sm">+60 menit</button>
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
                <p class="label mb-0">Kedua Pihak Hadir</p>
                <p class="value text-success mb-0">{{ $totalHadirPenuh }}</p>
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
                <p class="label mb-0">Belum Check-in</p>
                <p class="value text-secondary mb-0">{{ $totalBelumCheckin }}</p>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <th class="px-3 py-3">No</th>
                    <th class="px-3 py-3">No. Perkara</th>
                    <th class="px-3 py-3">Waktu</th>
                    <th class="px-3 py-3">Ruang</th>
                    <th class="px-3 py-3">Status</th>
                    <th class="px-3 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sidangList as $s)
                    <tr style="border-top:1px solid #f1f1f1;">
                        <td class="px-3 py-3 text-secondary">{{ $s['no'] }}</td>
                        <td class="px-3 py-3 fw-semibold text-dark">{{ $s['perkara'] }}</td>
                        <td class="px-3 py-3 fw-medium">{{ $s['waktu'] }}</td>
                        <td class="px-3 py-3">{{ $s['ruang'] }}</td>
                        <td class="px-3 py-3">
                            <span class="badge-soft {{ $s['status']['badge'] }}">
                                <span class="status-dot {{ $s['status']['dot'] }}"></span>
                                {{ $s['status']['label'] }}
                            </span>
                        </td>
                        <td class="px-3 py-3 text-center">
                            <button type="button"
                                    class="btn btn-link btn-sm text-decoration-none p-0"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal"
                                    onclick="openDetailModal({{ $s['no'] }})">
                                Lihat Detail
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- Modal Detail Sidang (Bootstrap native modal) --}}
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0 pb-0">
                <div>
                    <h2 id="d_perkara" class="h5 fw-bold text-dark mb-0">-</h2>
                    <p id="d_agenda" class="text-secondary small mb-0">-</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="max-height:70vh; overflow-y:auto;">

                {{-- Informasi Sidang --}}
                <div>
                    <h3 class="text-xs fw-bold text-dark text-uppercase mb-3" style="font-size:.75rem; letter-spacing:.03em;">Informasi Sidang</h3>
                    <div class="mb-2">
                        <p class="text-secondary small mb-0">No. Perkara</p>
                        <p id="d_no_perkara" class="fw-semibold text-dark">-</p>
                    </div>
                    <div class="mb-2">
                        <p class="text-secondary small mb-0">Agenda Sidang</p>
                        <p id="d_agenda_inline" class="fw-semibold text-dark">-</p>
                    </div>
                    <div class="mb-2">
                        <p class="text-secondary small mb-0">Tanggal</p>
                        <p id="d_tanggal" class="fw-semibold text-dark">-</p>
                    </div>
                    <div class="mb-2">
                        <p class="text-secondary small mb-0">Waktu</p>
                        <p id="d_waktu" class="fw-semibold text-dark">-</p>
                    </div>
                    <div class="mb-2">
                        <p class="text-secondary small mb-0">Ruang Sidang</p>
                        <p id="d_ruang" class="fw-semibold text-dark">-</p>
                    </div>
                    <div class="mb-2">
                        <p class="text-secondary small mb-0">Status Sidang</p>
                        <p id="d_status" class="fw-semibold text-dark">-</p>
                    </div>
                </div>

                {{-- Majelis Hakim --}}
                <div class="pt-3 mt-3 border-top">
                    <h3 class="fw-bold text-dark text-uppercase mb-3" style="font-size:.75rem; letter-spacing:.03em;">Majelis Hakim</h3>
                    <div class="mb-2">
                        <p class="text-secondary small mb-0">Hakim Ketua</p>
                        <p id="d_hakim_ketua" class="fw-semibold text-dark">-</p>
                    </div>
                    <div class="mb-2">
                        <p class="text-secondary small mb-0">Hakim Anggota I</p>
                        <p id="d_hakim_1" class="fw-semibold text-dark">-</p>
                    </div>
                    <div class="mb-2">
                        <p class="text-secondary small mb-0">Hakim Anggota II</p>
                        <p id="d_hakim_2" class="fw-semibold text-dark">-</p>
                    </div>
                    <div class="mb-2">
                        <p class="text-secondary small mb-0">Panitera Pengganti</p>
                        <p id="d_panitera" class="fw-semibold text-dark">-</p>
                    </div>
                </div>

                {{-- Para Pihak --}}
                <div class="pt-3 mt-3 border-top">
                    <h3 class="fw-bold text-dark text-uppercase mb-3" style="font-size:.75rem; letter-spacing:.03em;">Para Pihak</h3>
                    <div class="mb-2">
                        <p class="text-secondary small mb-0">Penggugat</p>
                        <p id="d_penggugat" class="fw-semibold text-dark">-</p>
                    </div>
                    <div class="mb-2">
                        <p class="text-secondary small mb-0">Tergugat</p>
                        <p id="d_tergugat" class="fw-semibold text-dark">-</p>
                        <p id="d_intervensi" class="text-secondary small mt-1 d-none"></p>
                    </div>
                </div>

            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
</section>


<script>
    // ============================================
    // DUMMY DATA — belum tersambung database.
    // Hanya kasus No. 1 yang punya data lengkap (contoh dari user).
    // Kasus lain diisi "-" sampai datanya dilengkapi.
    // ============================================
    const detailData = {
        1: {
            perkara: '123/Pdt.G/2026/PN.Jkt.Ps',
            jenis: 'Perdata',
            agenda: 'Pembuktian Penggugat',
            tanggal: '4 Agustus 2026',
            waktu: '08.30',
            ruang: 'Ruang Sidang I',
            status: 'Kedua Pihak Hadir',
            hakim_ketua: 'Dr. H. Ahmad Sutrisno, S.H., M.H.',
            hakim_1: 'Hj. Rina Marlina, S.H., M.H.',
            hakim_2: 'Bambang Setiawan, S.H., M.H.',
            panitera: 'Siti Aminah, S.H.',
            penggugat: 'Tajudin, DKK',
            tergugat: 'Kepala Kantor Pertanahan Kabupaten Pandeglang',
            intervensi: 'Kementerian Pertahanan RI',
        },
    };

    const defaultDetail = {
        perkara: '-', jenis: '-', agenda: '-', tanggal: '-', waktu: '-', ruang: '-', status: '-',
        hakim_ketua: '-', hakim_1: '-', hakim_2: '-', panitera: '-',
        penggugat: '-', tergugat: '-', intervensi: null,
    };

    function openDetailModal(id) {
        const d = detailData[id] || defaultDetail;

        document.getElementById('d_perkara').textContent = d.perkara;
        document.getElementById('d_agenda').textContent = d.agenda;
        document.getElementById('d_no_perkara').textContent = d.perkara;
        document.getElementById('d_agenda_inline').textContent = d.agenda;
        document.getElementById('d_tanggal').textContent = d.tanggal;
        document.getElementById('d_waktu').textContent = d.waktu;
        document.getElementById('d_ruang').textContent = d.ruang;
        document.getElementById('d_status').textContent = d.status;
        document.getElementById('d_hakim_ketua').textContent = d.hakim_ketua;
        document.getElementById('d_hakim_1').textContent = d.hakim_1;
        document.getElementById('d_hakim_2').textContent = d.hakim_2;
        document.getElementById('d_panitera').textContent = d.panitera;
        document.getElementById('d_penggugat').textContent = d.penggugat;
        document.getElementById('d_tergugat').textContent = d.tergugat;

        const intervensiEl = document.getElementById('d_intervensi');
        if (d.intervensi) {
            intervensiEl.textContent = 'Tergugat Intervensi: ' + d.intervensi;
            intervensiEl.classList.remove('d-none');
        } else {
            intervensiEl.classList.add('d-none');
        }
    }
</script>

@endsection