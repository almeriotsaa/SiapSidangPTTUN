@extends('layouts.admin')

@section('title','Kelola Jadwal Sidang')

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
        white-space:nowrap;
    }
    .table-card tbody tr:hover {
        background:#fafafa;
    }
    .table-responsive-wrap {
        overflow-x:auto;
    }

    .autofill-box {
        background:#f9fafb;
        border:1px solid #e5e7eb;
        border-radius:.5rem;
        padding:.5rem .75rem;
        font-size:.85rem;
        color:#374151;
        min-height:38px;
        display:flex;
        align-items:center;
    }
    .autofill-box.is-empty {
        color:#9ca3af;
        font-style:italic;
    }
</style>

<section class="hero-section py-5">
    <div class="page-container">

    {{-- Header --}}
    <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Kelola Jadwal Sidang</h1>
            <p class="text-secondary small mb-0">
                Tambah, ubah, atau hapus jadwal sidang &middot; Data ini masih dummy (belum tersambung database)
            </p>
        </div>
        <button onclick="openModal()" type="button"
            class="btn btn-primary d-flex align-items-center gap-2">
            <span class="fs-5 lh-1">+</span> Tambah Jadwal
        </button>
    </div>

    {{-- Table --}}
    <div class="table-card table-responsive-wrap">
        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <th class="px-3 py-3">No</th>
                    <th class="px-3 py-3">No. Perkara</th>
                    <th class="px-3 py-3">Agenda</th>
                    <th class="px-3 py-3">Tanggal</th>
                    <th class="px-3 py-3">Jam</th>
                    <th class="px-3 py-3">Ruang</th>
                    <th class="px-3 py-3">Hakim Ketua</th>
                    <th class="px-3 py-3">Hakim Anggota I</th>
                    <th class="px-3 py-3">Hakim Anggota II</th>
                    <th class="px-3 py-3">Panitera Pengganti</th>
                    <th class="px-3 py-3">Penggugat</th>
                    <th class="px-3 py-3">Tergugat</th>
                    <th class="px-3 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                {{-- Diisi otomatis oleh JavaScript --}}
            </tbody>
        </table>
    </div>

    <p id="emptyState" class="d-none text-center text-secondary small py-5">
        Belum ada jadwal sidang. Klik "Tambah Jadwal" untuk menambahkan.
    </p>

</div>

{{-- Modal --}}
<div class="modal fade" id="modalOverlay" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h2 id="modalTitle" class="h5 fw-bold text-dark mb-0">Tambah Jadwal Sidang</h2>
                <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="jadwalForm" onsubmit="saveJadwal(event)">
                    <input type="hidden" id="editIndex" value="">

                    {{-- No. Perkara: dropdown, memicu autofill --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">No. Perkara</label>
                        <select id="f_perkara" required class="form-select" onchange="handlePerkaraChange()">
                            <option value="" disabled selected>Pilih No. Perkara</option>
                            @foreach ($perkaraList as $p)
                                <option value="{{ $p['perkara'] }}">{{ $p['perkara'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Auto-terisi dari data Perkara, tidak bisa diedit manual --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Penggugat</label>
                            <div id="f_penggugat_display" class="autofill-box is-empty">Pilih No. Perkara dulu</div>
                            <input type="hidden" id="f_penggugat">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Tergugat</label>
                            <div id="f_tergugat_display" class="autofill-box is-empty">Pilih No. Perkara dulu</div>
                            <input type="hidden" id="f_tergugat">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">Agenda</label>
                        <div id="f_agenda_display" class="autofill-box is-empty">Pilih No. Perkara dulu</div>
                        <input type="hidden" id="f_agenda">
                    </div>

                    <div class="pt-2 border-top mb-3">
                        <p class="text-secondary fw-bold text-uppercase mb-0 mt-3" style="font-size:.72rem; letter-spacing:.03em;">
                            Jadwal
                        </p>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-dark">Tanggal Sidang</label>
                            <input id="f_tanggal" type="date" required class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-dark">Jam Sidang</label>
                            <input id="f_waktu" type="time" required class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-dark">Ruang Sidang</label>
                            <select id="f_ruang" required class="form-select">
                                <option value="" disabled selected>Pilih Ruang</option>
                                <option>Ruang Sidang Persiapan</option>
                                <option>Ruang Sidang I</option>
                                <option>Ruang Sidang II</option>
                                <option>Ruang Sidang III</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-2 border-top mb-3">
                        <p class="text-secondary fw-bold text-uppercase mb-0 mt-3" style="font-size:.72rem; letter-spacing:.03em;">
                            Majelis Hakim &amp; Panitera Pengganti
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">Hakim Ketua</label>
                        <select id="f_hakim_ketua" required class="form-select">
                            <option value="" disabled selected>Pilih Hakim Ketua</option>
                            @foreach ($hakimList as $h)
                                <option value="{{ $h }}">{{ $h }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">Hakim Anggota I</label>
                        <select id="f_hakim_1" required class="form-select">
                            <option value="" disabled selected>Pilih Hakim Anggota I</option>
                            @foreach ($hakimList as $h)
                                <option value="{{ $h }}">{{ $h }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">Hakim Anggota II</label>
                        <select id="f_hakim_2" required class="form-select">
                            <option value="" disabled selected>Pilih Hakim Anggota II</option>
                            @foreach ($hakimList as $h)
                                <option value="{{ $h }}">{{ $h }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">Panitera Pengganti</label>
                        <select id="f_panitera" required class="form-select">
                            <option value="" disabled selected>Pilih Panitera Pengganti</option>
                            @foreach ($paniteraList as $pp)
                                <option value="{{ $pp }}">{{ $pp }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex gap-3 pt-2 border-top">
                        <button type="button" onclick="closeModal()" class="btn btn-outline-secondary flex-fill mt-3">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary flex-fill mt-3">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>


<script>
    // ============================================
    // DUMMY DATA — belum tersambung database.
    // perkaraOptions ditulis ulang dari data Blade ($perkaraList) supaya bisa
    // dipakai untuk logic autofill JavaScript.
    // Status kehadiran Penggugat/Tergugat TIDAK ditangani di halaman ini —
    // itu tanggung jawab fitur Kehadiran/Check-in yang terpisah.
    // ============================================
    const perkaraOptions = @json($perkaraList);

    let jadwalData = [
        {
            perkara: '123/Pdt.G/2026/PN.Jkt.Ps', agenda: 'Pembuktian Penggugat',
            tanggal: '2026-08-04', waktu: '08.30', ruang: 'Ruang Sidang I',
            hakim_ketua: 'Dr. H. Ahmad Sutrisno, S.H., M.H.', hakim_1: 'Hj. Rina Marlina, S.H., M.H.', hakim_2: 'Bambang Setiawan, S.H., M.H.',
            panitera: 'Siti Aminah, S.H.',
            penggugat: 'Budi Santoso',
            tergugat: 'PT Sumber Makmur',
        },
    ];

    let jadwalModalInstance = null;
    document.addEventListener('DOMContentLoaded', function () {
        jadwalModalInstance = new bootstrap.Modal(document.getElementById('modalOverlay'));
    });

    // Saat No. Perkara dipilih, isi otomatis Penggugat / Tergugat / Agenda
    function handlePerkaraChange() {
        const selected = document.getElementById('f_perkara').value;
        const data = perkaraOptions.find(p => p.perkara === selected);

        const penggugatDisplay = document.getElementById('f_penggugat_display');
        const tergugatDisplay = document.getElementById('f_tergugat_display');
        const agendaDisplay = document.getElementById('f_agenda_display');

        if (data) {
            penggugatDisplay.textContent = data.penggugat;
            penggugatDisplay.classList.remove('is-empty');
            document.getElementById('f_penggugat').value = data.penggugat;

            tergugatDisplay.textContent = data.tergugat;
            tergugatDisplay.classList.remove('is-empty');
            document.getElementById('f_tergugat').value = data.tergugat;

            agendaDisplay.textContent = data.agenda;
            agendaDisplay.classList.remove('is-empty');
            document.getElementById('f_agenda').value = data.agenda;
        } else {
            penggugatDisplay.textContent = 'Pilih No. Perkara dulu';
            penggugatDisplay.classList.add('is-empty');
            document.getElementById('f_penggugat').value = '';

            tergugatDisplay.textContent = 'Pilih No. Perkara dulu';
            tergugatDisplay.classList.add('is-empty');
            document.getElementById('f_tergugat').value = '';

            agendaDisplay.textContent = 'Pilih No. Perkara dulu';
            agendaDisplay.classList.add('is-empty');
            document.getElementById('f_agenda').value = '';
        }
    }

    function renderTable() {
        const tbody = document.getElementById('tableBody');
        const emptyState = document.getElementById('emptyState');
        tbody.innerHTML = '';

        if (jadwalData.length === 0) {
            emptyState.classList.remove('d-none');
            return;
        }
        emptyState.classList.add('d-none');

        jadwalData.forEach((s, i) => {
            const row = document.createElement('tr');
            row.style.borderTop = '1px solid #f1f1f1';
            row.innerHTML = `
                <td class="px-3 py-3 text-secondary">${i + 1}</td>
                <td class="px-3 py-3 fw-semibold text-dark">${s.perkara}</td>
                <td class="px-3 py-3">${s.agenda}</td>
                <td class="px-3 py-3">${s.tanggal}</td>
                <td class="px-3 py-3 fw-medium">${s.waktu}</td>
                <td class="px-3 py-3">${s.ruang}</td>
                <td class="px-3 py-3">${s.hakim_ketua}</td>
                <td class="px-3 py-3">${s.hakim_1}</td>
                <td class="px-3 py-3">${s.hakim_2}</td>
                <td class="px-3 py-3">${s.panitera}</td>
                <td class="px-3 py-3">${s.penggugat}</td>
                <td class="px-3 py-3">${s.tergugat}</td>
                <td class="px-3 py-3 text-center">
                    <button onclick="editJadwal(${i})" class="btn btn-link btn-sm text-decoration-none p-0 me-3">Edit</button>
                    <button onclick="deleteJadwal(${i})" class="btn btn-link btn-sm text-decoration-none text-danger p-0">Hapus</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function openModal() {
        document.getElementById('modalTitle').textContent = 'Tambah Jadwal Sidang';
        document.getElementById('jadwalForm').reset();
        document.getElementById('editIndex').value = '';
        handlePerkaraChange(); // reset tampilan autofill
        jadwalModalInstance.show();
    }

    function editJadwal(index) {
        const s = jadwalData[index];
        document.getElementById('modalTitle').textContent = 'Edit Jadwal Sidang';
        document.getElementById('editIndex').value = index;

        document.getElementById('f_perkara').value = s.perkara;
        handlePerkaraChange();

        document.getElementById('f_tanggal').value = s.tanggal;
        document.getElementById('f_waktu').value = convertToTimeInput(s.waktu);
        document.getElementById('f_ruang').value = s.ruang;
        document.getElementById('f_hakim_ketua').value = s.hakim_ketua;
        document.getElementById('f_hakim_1').value = s.hakim_1;
        document.getElementById('f_hakim_2').value = s.hakim_2;
        document.getElementById('f_panitera').value = s.panitera;

        jadwalModalInstance.show();
    }

    function deleteJadwal(index) {
        if (confirm('Yakin ingin menghapus jadwal ini?')) {
            jadwalData.splice(index, 1);
            renderTable();
        }
    }

    function closeModal() {
        jadwalModalInstance.hide();
    }

    function saveJadwal(event) {
        event.preventDefault();

        const data = {
            perkara: document.getElementById('f_perkara').value,
            agenda: document.getElementById('f_agenda').value,
            tanggal: document.getElementById('f_tanggal').value,
            waktu: convertToDisplayTime(document.getElementById('f_waktu').value),
            ruang: document.getElementById('f_ruang').value,
            hakim_ketua: document.getElementById('f_hakim_ketua').value,
            hakim_1: document.getElementById('f_hakim_1').value,
            hakim_2: document.getElementById('f_hakim_2').value,
            panitera: document.getElementById('f_panitera').value,
            penggugat: document.getElementById('f_penggugat').value,
            tergugat: document.getElementById('f_tergugat').value,
        };

        const editIndex = document.getElementById('editIndex').value;
        if (editIndex === '') {
            jadwalData.push(data);
        } else {
            jadwalData[editIndex] = data;
        }

        renderTable();
        closeModal();
    }

    // Helper: format "08.30" <-> "08:30" (input type="time" pakai titik dua)
    function convertToTimeInput(displayTime) {
        return displayTime.replace('.', ':');
    }
    function convertToDisplayTime(timeInputValue) {
        return timeInputValue.replace(':', '.');
    }

    renderTable();
</script>

@endsection