@extends('layouts.admin')

@section('title','Kelola Perkara')

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

    .name-row {
        display:flex;
        gap:.5rem;
        align-items:center;
        margin-bottom:.5rem;
    }
    .name-row .form-control {
        flex:1;
    }
    .btn-remove-name {
        flex-shrink:0;
        width:38px;
        height:38px;
        display:flex;
        align-items:center;
        justify-content:center;
        border-radius:.5rem;
    }

    .pihak-pill {
        display:inline-block;
        background:#f3f4f6;
        color:#374151;
        border-radius:.4rem;
        padding:2px 8px;
        font-size:.8rem;
        margin:2px 4px 2px 0;
    }
</style>

<section class="py-5">
    <div class="page-container">

        {{-- Header --}}
        <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">Kelola Perkara</h1>
                <p class="text-secondary small mb-0">
                    Tambah, ubah, atau hapus data perkara &middot; Data ini masih dummy (belum tersambung database)
                </p>
            </div>
            <button type="button" onclick="openModal()"
                class="btn btn-primary d-flex align-items-center gap-2">
                <span class="fs-5 lh-1">+</span> Buat Perkara
            </button>
        </div>

        {{-- Table --}}
        <div class="table-card">
            <table class="table table-borderless mb-0">
                <thead>
                    <tr>
                        <th class="px-3 py-3">No</th>
                        <th class="px-3 py-3">No. Perkara</th>
                        <th class="px-3 py-3">Agenda</th>
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
            Belum ada data perkara. Klik "Buat Perkara" untuk menambahkan.
        </p>

    </div>
</section>

{{-- Modal Form Perkara --}}
<div class="modal fade" id="perkaraModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h2 id="modalTitle" class="h5 fw-bold text-dark mb-0">Buat Perkara</h2>
                <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="perkaraForm" onsubmit="savePerkara(event)">
                    <input type="hidden" id="editIndex" value="">

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">No. Perkara</label>
                        <input id="f_perkara" type="text" required placeholder="123/Pdt.G/2026/PN.Jkt.Ps"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">Agenda</label>
                        <input id="f_agenda" type="text" required placeholder="Pembuktian Penggugat"
                            class="form-control">
                    </div>

                    {{-- Penggugat: bisa lebih dari 1 --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">Penggugat</label>
                        <div id="penggugatFieldsWrapper">
                            <div class="name-row">
                                <input type="text" class="form-control penggugat-input" required
                                    placeholder="Tajudin">
                            </div>
                        </div>
                        <button type="button" onclick="addNameField('penggugatFieldsWrapper', 'penggugat-input', 'Nama penggugat lainnya')"
                            class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                            <span class="fs-6 lh-1">+</span> Tambah Penggugat
                        </button>
                    </div>

                    {{-- Tergugat: bisa lebih dari 1 --}}
                    <div class="mb-3 pt-2 border-top">
                        <label class="form-label fw-semibold small text-dark mt-3">Tergugat</label>
                        <div id="tergugatFieldsWrapper">
                            <div class="name-row">
                                <input type="text" class="form-control tergugat-input" required
                                    placeholder="Kepala Kantor Pertanahan Kabupaten Pandeglang">
                            </div>
                        </div>
                        <button type="button" onclick="addNameField('tergugatFieldsWrapper', 'tergugat-input', 'Nama tergugat lainnya')"
                            class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                            <span class="fs-6 lh-1">+</span> Tambah Tergugat
                        </button>
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

<script>
    // ============================================
    // DUMMY DATA — belum tersambung database.
    // penggugat & tergugat sekarang berupa array (bisa lebih dari 1 nama).
    // Struktur ini murni untuk preview UI, belum ada validasi server-side,
    // belum ada CSRF protection, dan tidak persist setelah refresh.
    // ============================================
    let perkaraData = [
        {
            perkara: '123/Pdt.G/2026/PN.Jkt.Ps',
            agenda: 'Pembuktian Penggugat',
            penggugat: ['Tajudin', 'Dkk'],
            tergugat: ['Kepala Kantor Pertanahan Kabupaten Pandeglang'],
        },
    ];

    let perkaraModalInstance = null;
    document.addEventListener('DOMContentLoaded', function () {
        perkaraModalInstance = new bootstrap.Modal(document.getElementById('perkaraModal'));
    });

    // Tambah satu baris input nama baru ke wrapper tertentu (dipakai untuk Penggugat & Tergugat)
    function addNameField(wrapperId, inputClass, placeholderText) {
        const wrapper = document.getElementById(wrapperId);

        const row = document.createElement('div');
        row.className = 'name-row';
        row.innerHTML = `
            <input type="text" class="form-control ${inputClass}" required
                placeholder="${placeholderText}">
            <button type="button" class="btn btn-outline-danger btn-remove-name" onclick="this.parentElement.remove()">
                &times;
            </button>
        `;
        wrapper.appendChild(row);
    }

    // Reset wrapper jadi 1 input kosong lagi
    function resetNameFields(wrapperId, inputClass, placeholderText) {
        document.getElementById(wrapperId).innerHTML = `
            <div class="name-row">
                <input type="text" class="form-control ${inputClass}" required
                    placeholder="${placeholderText}">
            </div>
        `;
    }

    // Isi ulang wrapper sesuai jumlah data yang ada (dipakai saat Edit)
    function fillNameFields(wrapperId, inputClass, placeholderText, values) {
        const wrapper = document.getElementById(wrapperId);
        wrapper.innerHTML = '';

        values.forEach((val, i) => {
            const row = document.createElement('div');
            row.className = 'name-row';
            const removeBtn = i === 0
                ? ''
                : `<button type="button" class="btn btn-outline-danger btn-remove-name" onclick="this.parentElement.remove()">&times;</button>`;
            row.innerHTML = `
                <input type="text" class="form-control ${inputClass}" required
                    placeholder="${placeholderText}" value="${val}">
                ${removeBtn}
            `;
            wrapper.appendChild(row);
        });
    }

    function renderTable() {
        const tbody = document.getElementById('tableBody');
        const emptyState = document.getElementById('emptyState');
        tbody.innerHTML = '';

        if (perkaraData.length === 0) {
            emptyState.classList.remove('d-none');
            return;
        }
        emptyState.classList.add('d-none');

        perkaraData.forEach((p, i) => {
            const row = document.createElement('tr');
            row.style.borderTop = '1px solid #f1f1f1';

            const penggugatPills = p.penggugat.map(nama => `<span class="pihak-pill">${nama}</span>`).join('');
            const tergugatPills = p.tergugat.map(nama => `<span class="pihak-pill">${nama}</span>`).join('');

            row.innerHTML = `
                <td class="px-3 py-3 text-secondary">${i + 1}</td>
                <td class="px-3 py-3 fw-semibold text-dark">${p.perkara}</td>
                <td class="px-3 py-3">${p.agenda}</td>
                <td class="px-3 py-3">${penggugatPills}</td>
                <td class="px-3 py-3">${tergugatPills}</td>
                <td class="px-3 py-3 text-center">
                    <button onclick="editPerkara(${i})" class="btn btn-link btn-sm text-decoration-none p-0 me-3">Edit</button>
                    <button onclick="deletePerkara(${i})" class="btn btn-link btn-sm text-decoration-none text-danger p-0">Hapus</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function openModal() {
        document.getElementById('modalTitle').textContent = 'Buat Perkara';
        document.getElementById('perkaraForm').reset();
        document.getElementById('editIndex').value = '';
        resetNameFields('penggugatFieldsWrapper', 'penggugat-input', 'Nama penggugat lainnya');
        resetNameFields('tergugatFieldsWrapper', 'tergugat-input', 'Nama tergugat lainnya');
        perkaraModalInstance.show();
    }

    function editPerkara(index) {
        const p = perkaraData[index];
        document.getElementById('modalTitle').textContent = 'Edit Perkara';
        document.getElementById('editIndex').value = index;
        document.getElementById('f_perkara').value = p.perkara;
        document.getElementById('f_agenda').value = p.agenda;

        fillNameFields('penggugatFieldsWrapper', 'penggugat-input', 'Nama penggugat lainnya', p.penggugat);
        fillNameFields('tergugatFieldsWrapper', 'tergugat-input', 'Nama tergugat lainnya', p.tergugat);

        perkaraModalInstance.show();
    }

    function deletePerkara(index) {
        if (confirm('Yakin ingin menghapus data perkara ini?')) {
            perkaraData.splice(index, 1);
            renderTable();
        }
    }

    function closeModal() {
        perkaraModalInstance.hide();
    }

    function savePerkara(event) {
        event.preventDefault();

        const penggugatValues = Array.from(document.querySelectorAll('.penggugat-input'))
            .map(el => el.value.trim())
            .filter(v => v !== '');

        const tergugatValues = Array.from(document.querySelectorAll('.tergugat-input'))
            .map(el => el.value.trim())
            .filter(v => v !== '');

        const data = {
            perkara: document.getElementById('f_perkara').value,
            agenda: document.getElementById('f_agenda').value,
            penggugat: penggugatValues,
            tergugat: tergugatValues,
        };

        const editIndex = document.getElementById('editIndex').value;
        if (editIndex === '') {
            perkaraData.push(data);
        } else {
            perkaraData[editIndex] = data;
        }

        renderTable();
        closeModal();
    }

    renderTable();
</script>

@endsection