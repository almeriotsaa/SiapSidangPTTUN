@extends('layouts.guest')

@section('title', 'Jadwal Sidang')

@section('content')

<style>
    .page-container {
        width: 100%;
        max-width: 1700px;
        margin: auto;
        padding-inline: 24px;
    }

    .title-main {
        font-weight: 700;
        color: #17375E;
    }

    /* ===== Toolbar filter ===== */
    .filter-card {
        background: #fff;
        border: 1px solid #f1f1f1;
        border-radius: .75rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .04);
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .filter-card .form-label {
        font-size: .78rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: .03em;
        margin-bottom: .4rem;
    }

    .btn-tampilkan {
        background-color: #17375E;
    }

    .btn-tampilkan:hover {
        background-color: #17375E;
    }

    /* ===== Table, konsisten dengan halaman admin ===== */
    .table-card {
        background: #fff;
        border: 1px solid #f1f1f1;
        border-radius: .75rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .04);
        overflow: hidden;
    }

    .table-card thead th {
        background: #f9fafb;
        font-size: .72rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: .03em;
        white-space: nowrap;
    }

    .table-card tbody td {
        vertical-align: top;
        font-size: .9rem;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .table-card tbody tr {
        border-top: 1px solid #f1f1f1;
    }

    .table-card tbody tr:hover {
        background: #fafafa;
    }

    .table-responsive-wrap {
        overflow-x: auto;
    }

    /* ===== Detail kecil di dalam sel ===== */
    .case-code {
        font-weight: 600;
        color: #111827;
    }

    .meta-line {
        font-size: .85rem;
        color: #374151;
        display: flex;
        align-items: center;
        gap: .4rem;
        margin-bottom: .25rem;
    }

    .meta-line:last-child {
        margin-bottom: 0;
    }

    .meta-line i {
        color: #9ca3af;
        font-size: .8rem;
    }

    .judge-row {
        font-size: .85rem;
        color: #374151;
        margin-bottom: .35rem;
        display: flex;
        gap: .5rem;
        align-items: baseline;
    }

    .judge-row:last-child {
        margin-bottom: 0;
    }

    .judge-tag {
        flex: 0 0 auto;
        display: inline-block;
        background: #f3f4f6;
        color: #4b5563;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .02em;
        padding: .15rem .4rem;
        border-radius: .35rem;
        min-width: 32px;
        text-align: center;
    }

    .party-row {
        font-size: .85rem;
        color: #374151;
        margin-bottom: .5rem;
    }

    .party-row:last-child {
        margin-bottom: 0;
    }

    .party-role {
        display: block;
        font-size: .68rem;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: .03em;
        margin-bottom: .1rem;
    }

    .att-name {
        font-size: .82rem;
        color: #374151;
        display: flex;
        align-items: center;
        gap: .4rem;
        margin-bottom: .4rem;
    }

    .att-name:last-child {
        margin-bottom: 0;
    }

    .att-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        flex: 0 0 auto;
    }

    .att-dot.hadir {
        background: #16a34a;
    }

    .att-dot.tidak {
        background: #9ca3af;
    }

    .empty-state {
        text-align: center;
        color: #9ca3af;
        padding: 3rem 1rem;
        font-size: .9rem;
    }

    .filter-card {
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 16px;
        padding: 24px 28px;
    }

    .attendance-legend {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
    }

    .legend-title {
        font-size: 14px;
        font-weight: 600;
        color: #6B7280;
        margin-right: 8px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #374151;
    }

    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
    }

    .legend-dot.hadir {
        background: #16a34a;
    }

    .legend-dot.belum {
        background: #9CA3AF;
    }
</style>

<section class="hero-section py-5">
    <div class="page-container">

        {{-- Header --}}
        <div class="mb-4">
            <h1 class="title-main h2 fw-bold mb-1">Jadwal Sidang</h1>
            <p class="text-secondary mb-0">
                Informasi jadwal persidangan yang dapat diakses oleh masyarakat secara online
            </p>
        </div>

        {{-- Filter --}}
        <div class="filter-card">

            <div class="d-flex justify-content-between align-items-end flex-wrap gap-4">

                <!-- Filter -->
                <form method="GET" class="d-flex align-items-end gap-3">

                    <div>
                        <label class="form-label">Pilih Tanggal Sidang</label>

                        <input
                            type="date"
                            name="tanggal"
                            value="{{ request('tanggal', now()->format('Y-m-d')) }}"
                            class="form-control">
                    </div>

                    <div>
                        <button type="submit"
                            class="btn btn-tampilkan d-flex align-items-center gap-2 text-white">
                            <i class="bi bi-arrow-repeat"></i>
                            Tampilkan
                        </button>
                    </div>

                </form>

                <!-- Keterangan -->
                <div class="attendance-legend">

                    <span class="legend-title">Keterangan</span>

                    <div class="legend-item">
                        <span class="legend-dot hadir"></span>
                        <span>Hadir</span>
                    </div>

                    <div class="legend-item">
                        <span class="legend-dot belum"></span>
                        <span>Belum Hadir</span>
                    </div>

                </div>

            </div>

        </div>

        {{-- Table --}}
        <div class="table-card table-responsive-wrap">
            <table class="table table-borderless mb-0">
                <thead>
                    <tr>
                        <th class="px-3 py-3">No</th>
                        <th class="px-3 py-3">No. Perkara</th>
                        <th class="px-3 py-3">Waktu &amp; Ruang</th>
                        <th class="px-3 py-3">Agenda</th>
                        <th class="px-3 py-3">Majelis Hakim &amp; Panitera Pengganti</th>
                        <th class="px-3 py-3">Penggugat</th>
                        <th class="px-3 py-3">Tergugat</th>
                        <th class="px-3 py-3">Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwal as $item)
                    <tr>
                        <td class="px-3 text-secondary">{{ $loop->iteration }}</td>

                        <td class="px-3">
                            <span class="case-code">{{ $item->perkara->nomor_perkara }}</span>
                        </td>

                        <td class="px-3">
                            <div class="meta-line">
                                <i class="bi bi-calendar3"></i>
                                {{ \Carbon\Carbon::parse($item->tanggal_sidang)->translatedFormat('d F Y') }}
                            </div>
                            <div class="meta-line">
                                <i class="bi bi-clock"></i>
                                {{ substr($item->jam_sidang, 0, 5) }} WIB
                            </div>
                            <div class="meta-line">
                                <i class="bi bi-door-open"></i>
                                {{ $item->ruang_sidang }}
                            </div>
                        </td>

                        <td class="px-3">
                            {{ $item->perkara->agenda }}
                        </td>

                        {{-- Digabung: Hakim Ketua, Hakim Anggota I, Hakim Anggota II, Panitera Pengganti --}}
                        <td class="px-3">
                            <div class="judge-row">
                                <span class="judge-tag">HK</span>
                                <span>{{ $item->hakimKetua->nama }}</span>
                            </div>
                            <div class="judge-row">
                                <span class="judge-tag">HA1</span>
                                <span>{{ $item->hakimAnggota1->nama }}</span>
                            </div>
                            <div class="judge-row">
                                <span class="judge-tag">HA2</span>
                                <span>{{ $item->hakimAnggota2->nama }}</span>
                            </div>
                            <div class="judge-row">
                                <span class="judge-tag">PP</span>
                                <span>{{ $item->panitera->nama }}</span>
                            </div>
                        </td>

                        {{-- Penggugat --}}
                        <td class="px-3">
                            @forelse ($item->perkara->pihakPerkara->where('tipe', 'penggugat') as $pihak)
                            <div class="party-row">{{ $pihak->nama }}</div>
                            @empty
                            <span class="text-secondary">-</span>
                            @endforelse
                        </td>

                        {{-- Tergugat --}}
                        <td class="px-3">
                            @forelse ($item->perkara->pihakPerkara->where('tipe', 'tergugat') as $pihak)
                            <div class="party-row">{{ $pihak->nama }}</div>
                            @empty
                            <span class="text-secondary">-</span>
                            @endforelse
                        </td>

                        <td class="px-3">
                            @foreach ($item->kehadiran as $hadir)
                            <div class="att-name">
                                <span class="att-dot {{ $hadir->status == 'Hadir' ? 'hadir' : 'tidak' }}"></span>
                                {{ $hadir->pihak->nama }}
                            </div>
                            @endforeach
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-0">
                            <p class="empty-state mb-0">
                                Belum ada jadwal sidang untuk tanggal yang dipilih.
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</section>

@endsection