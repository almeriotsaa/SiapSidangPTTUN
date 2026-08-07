@extends('layouts.admin')

@section('title','Riwayat')

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
    }
    .table-card tbody td {
        vertical-align:top;
        font-size:.9rem;
    }
    .table-card tbody tr:hover {
        background:#fafafa;
    }

    .badge-status {
        display:inline-block;
        margin-top:.25rem;
        padding:2px 8px;
        border-radius:999px;
        font-size:.72rem;
        font-weight:500;
    }
    .badge-status-hadir      { background:#dcfce7; color:#15803d; }
    .badge-status-tidak      { background:#fee2e2; color:#dc2626; }
    .badge-status-terlambat  { background:#fef9c3; color:#a16207; }
</style>

<section class="hero-section py-5">
    <div class="page-container">
    {{-- Header --}}
    <div class="mb-4">
        <h1 class="h3 fw-bold text-dark mb-1">Riwayat &amp; Log Sidang</h1>
        <p class="text-secondary small mb-0">Rekam jejak kehadiran untuk audit dan laporan bulanan.</p>
    </div>

    {{-- Search --}}
    <div class="mb-3">
        <input
            id="searchInput"
            type="text"
            placeholder="Cari nomor perkara..."
            oninput="filterTable()"
            class="form-control"
            style="max-width:24rem;"
        >
    </div>

    {{-- Table --}}
    <div class="table-card">
        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <th class="px-3 py-3">Tanggal</th>
                    <th class="px-3 py-3">No. Perkara</th>
                    <th class="px-3 py-3">Jenis</th>
                    <th class="px-3 py-3">Waktu</th>
                    <th class="px-3 py-3">Ruang</th>
                    <th class="px-3 py-3">Penggugat</th>
                    <th class="px-3 py-3">Tergugat</th>
                    <th class="px-3 py-3">Catatan</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                {{-- Diisi otomatis oleh JavaScript --}}
            </tbody>
        </table>
    </div>

    <p id="emptyState" class="d-none text-center text-secondary small py-5">
        Tidak ada riwayat sidang yang cocok dengan pencarian.
    </p>

</div>
</section>


<script>
    // ============================================
    // DUMMY DATA — belum tersambung database.
    // ============================================
    const riwayatData = [
        {
            tanggal: '3 Agu 2026', perkara: '10/Pdt.G/2026/PN.Jkt.Ps', jenis: 'Perdata', waktu: '09.00', ruang: 'Ruang Sidang',
            penggugat: 'Sartono', penggugat_status: 'Hadir',
            tergugat: 'PT Anugerah', tergugat_status: 'Hadir',
            catatan: '-',
        },
        {
            tanggal: '3 Agu 2026', perkara: '22/Pid.B/2026/PN.Jkt.Ps', jenis: 'Pidana', waktu: '10.00', ruang: 'Ruang Sidang',
            penggugat: 'JPU', penggugat_status: 'Hadir',
            tergugat: 'Slamet Riyadi (Terdakwa)', tergugat_status: 'Tidak Hadir',
            catatan: 'Sidang ditunda',
        },
        {
            tanggal: '3 Agu 2026', perkara: '31/Pdt.G/2026/PN.Jkt.Ps', jenis: 'Perdata', waktu: '11.00', ruang: 'Ruang Sidang Persiapan',
            penggugat: 'Wati Suryani', penggugat_status: 'Terlambat',
            tergugat: 'PT Multi Sejahtera', tergugat_status: 'Hadir',
            catatan: 'Penggugat hadir 20 menit setelah jadwal',
        },
        {
            tanggal: '3 Agu 2026', perkara: '05/Pid.Sus/2026/PN.Jkt.Ps', jenis: 'Pidana', waktu: '13.00', ruang: 'Ruang Sidang',
            penggugat: 'JPU', penggugat_status: 'Hadir',
            tergugat: 'Dedi Kurniawan (Terdakwa)', tergugat_status: 'Hadir',
            catatan: '-',
        },
    ];

    const statusBadge = {
        'Hadir': 'badge-status-hadir',
        'Tidak Hadir': 'badge-status-tidak',
        'Terlambat': 'badge-status-terlambat',
    };

    function renderTable(data) {
        const tbody = document.getElementById('tableBody');
        const emptyState = document.getElementById('emptyState');
        tbody.innerHTML = '';

        if (data.length === 0) {
            emptyState.classList.remove('d-none');
            return;
        }
        emptyState.classList.add('d-none');

        data.forEach((r) => {
            const row = document.createElement('tr');
            row.style.borderTop = '1px solid #f1f1f1';
            row.innerHTML = `
                <td class="px-3 py-3 text-secondary text-nowrap">${r.tanggal}</td>
                <td class="px-3 py-3 fw-semibold text-dark text-nowrap">${r.perkara}</td>
                <td class="px-3 py-3">${r.jenis}</td>
                <td class="px-3 py-3">${r.waktu}</td>
                <td class="px-3 py-3">${r.ruang}</td>
                <td class="px-3 py-3">
                    <div>${r.penggugat} &mdash;</div>
                    <span class="badge-status ${statusBadge[r.penggugat_status]}">${r.penggugat_status}</span>
                </td>
                <td class="px-3 py-3">
                    <div>${r.tergugat} &mdash;</div>
                    <span class="badge-status ${statusBadge[r.tergugat_status]}">${r.tergugat_status}</span>
                </td>
                <td class="px-3 py-3 text-secondary">${r.catatan}</td>
            `;
            tbody.appendChild(row);
        });
    }

    function filterTable() {
        const keyword = document.getElementById('searchInput').value.trim().toLowerCase();
        const filtered = riwayatData.filter(r => r.perkara.toLowerCase().includes(keyword));
        renderTable(filtered);
    }

    renderTable(riwayatData);
</script>

@endsection