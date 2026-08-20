@extends(auth()->check() ? 'layouts.admin' : 'layouts.guest')

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
        align-items:center;
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
        font-size: .75rem;
        padding: 4px 10px;
        border-radius: 999px;
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
        letter-spacing: .02em;
        transition: all 0.2s ease-in-out;
    }
</style>

<section class="py-5">
    <div class="page-container">

        {{-- Header --}}
        <div class="mb-4">
            <h1 class="h3 fw-bold text-dark mb-1">Kehadiran</h1>
            <p class="text-secondary small mb-0">
                {{-- 2. Aman Pengecekan Admin bagi Guest --}}
                @if (auth()->check() && auth()->user()->role === 'admin')
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
                            
                            // Cek apakah user adalah Admin
                            $isAdmin = auth()->check() && auth()->user()->role === 'admin';
                        @endphp
                        <tr style="border-top:1px solid #f1f1f1;">
                            <td class="px-3 py-3 text-secondary">{{ $i + 1 }}</td>
                            <td class="px-3 py-3 fw-semibold text-dark">{{ $j->perkara->nomor_perkara }}</td>
                            <td class="px-3 py-3">{{ $j->tanggal_sidang->format('d M Y') }}</td>
                            <td class="px-3 py-3 fw-medium">{{ substr($j->jam_sidang, 0, 5) }}</td>
                            <td class="px-3 py-3">{{ $j->ruang_sidang }}</td>

                            {{-- Kolom Penggugat --}}
                            <td class="px-3 py-3">
                                @forelse ($penggugatList as $k)
                                    @php
                                        // Guest & FO (bukan Admin) BISA tandai hadir
                                        $bisaTandaiHadir = !$isAdmin && $k->status !== 'Hadir' && !$lewatBatas;
                                    @endphp
                                    <div class="pihak-row">
                                        <span class="pihak-nama">{{ $k->pihak->nama }}</span>
                                        <span id="status-container-{{ $k->id }}">
                                            @if ($k->status === 'Hadir')
                                                <span class="badge-status badge-status-hadir">&#9679; Hadir</span>
                                            @elseif ($lewatBatas)
                                                <span class="badge-status badge-status-tidak-hadir">&#9679; Tidak Hadir</span>
                                            @elseif ($bisaTandaiHadir)
                                                <form action="{{ route('kehadiran.tandai-hadir', $k->id) }}" method="POST" class="d-inline form-tandai-hadir">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-tandai-hadir">Hadir</button>
                                                </form>
                                            @else
                                                <span class="badge-status badge-status-belum-hadir">&#9679; Belum Hadir</span>
                                            @endif
                                        </span>
                                    </div>
                                @empty
                                    <span class="text-secondary">-</span>
                                @endforelse
                            </td>

                            {{-- Kolom Tergugat --}}
                            <td class="px-3 py-3">
                                @forelse ($tergugatList as $k)
                                    @php
                                        // Guest & FO (bukan Admin) BISA tandai hadir
                                        $bisaTandaiHadir = !$isAdmin && $k->status !== 'Hadir' && !$lewatBatas;
                                    @endphp
                                    <div class="pihak-row">
                                        <span class="pihak-nama">{{ $k->pihak->nama }}</span>
                                        <span id="status-container-{{ $k->id }}">
                                            @if ($k->status === 'Hadir')
                                                <span class="badge-status badge-status-hadir">&#9679; Hadir</span>
                                            @elseif ($lewatBatas)
                                                <span class="badge-status badge-status-tidak-hadir">&#9679; Tidak Hadir</span>
                                            @elseif ($bisaTandaiHadir)
                                                <form action="{{ route('kehadiran.tandai-hadir', $k->id) }}" method="POST" class="d-inline form-tandai-hadir">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-tandai-hadir">Hadir</button>
                                                </form>
                                            @else
                                                <span class="badge-status badge-status-belum-hadir">&#9679; Belum Hadir</span>
                                            @endif
                                        </span>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.form-tandai-hadir').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const container = this.closest('span[id^="status-container-"]');
                const button = this.querySelector('button');

                button.disabled = true;
                button.innerText = '...';

                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        if (container) {
                            container.innerHTML = '<span class="badge-status badge-status-hadir">&#9679; Hadir</span>';
                        }
                    } else {
                        button.disabled = false;
                        button.innerText = 'Hadir';
                        alert('Gagal menandai kehadiran. Silakan coba lagi.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    button.disabled = false;
                    button.innerText = 'Hadir';
                });
            });
        });

        if (typeof window.Echo !== 'undefined') {
            window.Echo.channel('jadwal-sidang-channel')
                .listen('.jadwal.updated', function (e) {
                    window.location.reload();
                });

            window.Echo.channel('kehadiran-channel')
                .listen('.kehadiran.updated', function (e) {
                    const container = document.getElementById('status-container-' + e.kehadiran.id);
                    if (container) {
                        container.innerHTML = '<span class="badge-status badge-status-hadir">&#9679; Hadir</span>';
                    }
                });
        }
    });
</script>
@endpush

@endsection