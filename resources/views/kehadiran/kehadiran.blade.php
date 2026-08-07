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
    }

    .badge-status {
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:3px 10px;
        border-radius:999px;
        font-size:.75rem;
        font-weight:500;
    }
    .badge-status-hadir {
        background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;
    }
    .badge-status-tidak-hadir {
        background:#fef2f2; color:#dc2626; border:1px solid #fecaca;
    }

    .btn-tandai-hadir {
        font-size:.75rem;
        padding:.3rem .7rem;
        border-radius:999px;
    }

    .toast-saved {
        position:fixed;
        bottom:24px;
        right:24px;
        background:#111827;
        color:#fff;
        padding:.6rem 1.1rem;
        border-radius:.6rem;
        font-size:.85rem;
        opacity:0;
        transform:translateY(8px);
        transition:opacity .25s, transform .25s;
        z-index:1080;
        pointer-events:none;
    }
    .toast-saved.show {
        opacity:1;
        transform:translateY(0);
    }
</style>

<section class="py-5">
    <div class="page-container">

        {{-- Header --}}
        <div class="mb-4">
            <h1 class="h3 fw-bold text-dark mb-1">Kehadiran</h1>
            <p class="text-secondary small mb-0">
                Tandai kehadiran Penggugat dan Tergugat &middot; Status otomatis menjadi <strong>Tidak Hadir</strong>
                jika belum ditandai hadir 15 menit setelah jadwal sidang &middot; Data ini masih dummy (belum tersambung database)
            </p>
        </div>

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
                        <th class="px-3 py-3">Status Penggugat</th>
                        <th class="px-3 py-3">Tergugat</th>
                        <th class="px-3 py-3">Status Tergugat</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    {{-- Diisi otomatis oleh JavaScript --}}
                </tbody>
            </table>
        </div>

        <p id="emptyState" class="d-none text-center text-secondary small py-5">
            Belum ada jadwal sidang.
        </p>

    </div>
</section>

<div id="toastSaved" class="toast-saved">Status kehadiran diperbarui</div>

<script>
    // ============================================
    // DUMMY DATA — belum tersambung database.
    // status_penggugat / status_tergugat: '' berarti belum ditandai hadir
    // (ditampilkan sebagai "Tidak Hadir" secara default). 'Hadir' berarti
    // sudah ditandai hadir manual lewat tombol.
    //
    // CATATAN PENTING: karena belum ada database, status yang sudah
    // ditandai "Hadir" akan HILANG jika halaman di-refresh (kembali ke
    // default "Tidak Hadir"). Ini keterbatasan sementara sampai fitur ini
    // tersambung ke backend sungguhan.
    // ============================================
    const TOLERANSI_MENIT = 15;

    let kehadiranData = [
        {
            perkara: '123/Pdt.G/2026/PN.Jkt.Ps', tanggal: '2026-08-07', waktu: '18.30', ruang: 'Ruang Sidang I',
            penggugat: 'Tajudin, DKK', status_penggugat: '',
            tergugat: 'Kepala Kantor Pertanahan Kabupaten Pandeglang', status_tergugat: '',
        },
        {
            perkara: '45/Pid.B/2026/PN.Jkt.Ps', tanggal: '2026-08-07', waktu: '09.00', ruang: 'Ruang Sidang II',
            penggugat: 'JPU Kejari Jakarta Pusat', status_penggugat: '',
            tergugat: 'Ahmad Fauzi (Terdakwa)', status_tergugat: '',
        },
        {
            perkara: '78/Pdt.G/2026/PN.Jkt.Ps', tanggal: '2026-08-07', waktu: '09.15', ruang: 'Ruang Sidang III',
            penggugat: 'Ny. Ratna Wijaya', status_penggugat: '',
            tergugat: 'CV Karya Abadi', status_tergugat: '',
        },
    ];

    // Hitung batas waktu (jadwal + toleransi) sebagai objek Date
    function getDeadline(row) {
        const waktu24 = row.waktu.replace('.', ':'); // "08.30" -> "08:30"
        const jadwal = new Date(`${row.tanggal}T${waktu24}:00`);
        return new Date(jadwal.getTime() + TOLERANSI_MENIT * 60000);
    }

    // Apakah jendela waktu untuk tandai hadir sudah lewat?
    function isPastDeadline(row) {
        return new Date() > getDeadline(row);
    }

    function renderTable() {
        const tbody = document.getElementById('tableBody');
        const emptyState = document.getElementById('emptyState');
        tbody.innerHTML = '';

        if (kehadiranData.length === 0) {
            emptyState.classList.remove('d-none');
            return;
        }
        emptyState.classList.add('d-none');

        kehadiranData.forEach((s, i) => {
            const lewatBatas = isPastDeadline(s);

            const row = document.createElement('tr');
            row.style.borderTop = '1px solid #f1f1f1';
            row.innerHTML = `
                <td class="px-3 py-3 text-secondary">${i + 1}</td>
                <td class="px-3 py-3 fw-semibold text-dark">${s.perkara}</td>
                <td class="px-3 py-3">${formatTanggal(s.tanggal)}</td>
                <td class="px-3 py-3 fw-medium">${s.waktu}</td>
                <td class="px-3 py-3">${s.ruang}</td>
                <td class="px-3 py-3">${s.penggugat}</td>
                <td class="px-3 py-3">${renderStatusCell(i, 'penggugat', s.status_penggugat, lewatBatas)}</td>
                <td class="px-3 py-3">${s.tergugat}</td>
                <td class="px-3 py-3">${renderStatusCell(i, 'tergugat', s.status_tergugat, lewatBatas)}</td>
            `;
            tbody.appendChild(row);
        });
    }

    // Render badge status + tombol "Hadir" (kalau masih dalam jendela waktu dan belum ditandai hadir)
    function renderStatusCell(index, pihak, status, lewatBatas) {
        if (status === 'Hadir') {
            return `<span class="badge-status badge-status-hadir">&#9679; Hadir</span>`;
        }

        if (lewatBatas) {
            // Waktu + toleransi sudah lewat, tanpa ditandai hadir -> terkunci Tidak Hadir
            return `<span class="badge-status badge-status-tidak-hadir">&#9679; Tidak Hadir</span>`;
        }

        // Masih dalam jendela waktu: tampilkan status default + tombol untuk menandai hadir
        return `
            <div class="status-cell">
                <span class="badge-status badge-status-tidak-hadir">&#9679; Tidak Hadir</span>
                <button type="button" class="btn btn-success btn-tandai-hadir" onclick="tandaiHadir(${index}, '${pihak}')">
                    Hadir
                </button>
            </div>
        `;
    }

    function tandaiHadir(index, pihak) {
        if (pihak === 'penggugat') {
            kehadiranData[index].status_penggugat = 'Hadir';
        } else {
            kehadiranData[index].status_tergugat = 'Hadir';
        }
        renderTable();
        showToast();
    }

    function formatTanggal(isoDate) {
        const bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        const [y, m, d] = isoDate.split('-').map(Number);
        return `${d} ${bulan[m - 1]} ${y}`;
    }

    function showToast() {
        const toast = document.getElementById('toastSaved');
        toast.classList.add('show');
        clearTimeout(window._toastTimeout);
        window._toastTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 1500);
    }

    renderTable();

    // Cek ulang tiap 30 detik supaya baris yang melewati batas waktu otomatis
    // terkunci jadi "Tidak Hadir" tanpa perlu refresh halaman manual.
    setInterval(renderTable, 30000);
</script>

@endsection