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
        vertical-align:top;
        font-size:.9rem;
    }
    .table-card tbody tr:hover {
        background:#fafafa;
    }
    .table-responsive-wrap {
        overflow-x:auto;
    }

    .pihak-row {
        display:flex;
        align-items:flex-start;
        gap:8px;
        margin-bottom:6px;
    }
    .pihak-row:last-child {
        margin-bottom:0;
    }
    .pihak-nama {
        width:110px;
        flex:0 0 110px;
        white-space:normal;
        word-break:break-word;
        padding-top:2px;
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

    .btn-tandai-hadir {
        font-size: .85rem;
        font-weight: 700;
        padding: .4rem .9rem;
        border-radius: .7rem;
        box-shadow: 0 2px 4px rgba(0,0,0,.1);
        letter-spacing: .02em;
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
                        <th class="px-3 py-3">Penggugat</th>
                        <th class="px-3 py-3">Tergugat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwalList as $i => $j)
                        @php
                            $lewatBatas = $j->sudahLewatBatas();
                            $penggugatList = $j->kehadiran->filter(fn ($k) => $k->pihak && $k->pihak->tipe === 'penggugat');
                            $tergugatList  = $j->kehadiran->filter(fn ($k) => $k->pihak && $k->pihak->tipe === 'tergugat');
                        @endphp
                        <tr style="border-top:1px solid #f1f1f1;">
                            <td class="px-3 py-3 text-secondary">{{ $i + 1 }}</td>
                            <td class="px-3 py-3 fw-semibold text-dark">{{ $j->perkara->nomor_perkara }}</td>
                            <td class="px-3 py-3">{{ $j->tanggal_sidang->format('d M Y') }}</td>
                            <td class="px-3 py-3 fw-medium">{{ substr($j->jam_sidang, 0, 5) }}</td>
                            <td class="px-3 py-3">{{ $j->ruang_sidang }}</td>

                            {{-- Kolom Penggugat: semua pihak ditumpuk di sini, bukan kolom baru --}}
                            <td class="px-3 py-3">
                                @forelse ($penggugatList as $k)
                                    @php
                                        $bisaTandaiHadir = auth()->user()->role !== 'admin' && $k->status !== 'Hadir' && !$lewatBatas;
                                    @endphp
                                    <div class="pihak-row">
                                        <span class="pihak-nama">{{ $k->pihak->nama }}</span>
                                        @if ($k->status === 'Hadir')
                                            <span class="badge-status badge-status-hadir">&#9679; Hadir</span>
                                        @elseif ($lewatBatas)
                                            <span class="badge-status badge-status-tidak-hadir">&#9679; Tidak Hadir</span>
                                        @elseif ($bisaTandaiHadir)
                                            <span class="badge-status badge-status-belum-hadir">&#9679; Belum Hadir</span>
                                            <form method="POST" action="{{ route('kehadiran.tandai-hadir', $k->id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-tandai-hadir">Hadir</button>
                                            </form>
                                        @else
                                            <span class="badge-status badge-status-belum-hadir">&#9679; Belum Hadir</span>
                                        @endif
                                    </div>
                                @empty
                                    <span class="text-secondary">-</span>
                                @endforelse
                            </td>

                            {{-- Kolom Tergugat: sama, ditumpuk di dalam satu kolom --}}
                            <td class="px-3 py-3">
                                @forelse ($tergugatList as $k)
                                    @php
                                        $bisaTandaiHadir = auth()->user()->role !== 'admin' && $k->status !== 'Hadir' && !$lewatBatas;
                                    @endphp
                                    <div class="pihak-row">
                                        <span class="pihak-nama">{{ $k->pihak->nama }}</span>
                                        @if ($k->status === 'Hadir')
                                            <span class="badge-status badge-status-hadir">&#9679; Hadir</span>
                                        @elseif ($lewatBatas)
                                            <span class="badge-status badge-status-tidak-hadir">&#9679; Tidak Hadir</span>
                                        @elseif ($bisaTandaiHadir)
                                            <span class="badge-status badge-status-belum-hadir">&#9679; Belum Hadir</span>
                                            <form method="POST" action="{{ route('kehadiran.tandai-hadir', $k->id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-tandai-hadir">Hadir</button>
                                            </form>
                                        @else
                                            <span class="badge-status badge-status-belum-hadir">&#9679; Belum Hadir</span>
                                        @endif
                                    </div>
                                @empty
                                    <span class="text-secondary">-</span>
                                @endforelse
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-secondary small py-5">
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