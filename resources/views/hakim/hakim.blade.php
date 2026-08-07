@extends('layouts.admin')

@section('title','Kelola Majelis Hakim')

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
</style>

<section class="py-5">
    <div class="page-container">

        {{-- Header --}}
        <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">Kelola Majelis Hakim</h1>
                <p class="text-secondary small mb-0">
                    Tambah atau hapus nama hakim &middot; Data ini masih dummy (belum tersambung database)
                </p>
            </div>
            <button type="button" onclick="openModal()"
                class="btn btn-primary d-flex align-items-center gap-2">
                <span class="fs-5 lh-1">+</span> Tambah Hakim
            </button>
        </div>

        {{-- Table --}}
        <div class="table-card">
            <table class="table table-borderless mb-0">
                <thead>
                    <tr>
                        <th class="px-3 py-3">No</th>
                        <th class="px-3 py-3">Nama Hakim</th>
                        <th class="px-3 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    {{-- Diisi otomatis oleh JavaScript --}}
                </tbody>
            </table>
        </div>

        <p id="emptyState" class="d-none text-center text-secondary small py-5">
            Belum ada data hakim. Klik "Tambah Hakim" untuk menambahkan.
        </p>

    </div>
</section>

{{-- Modal Form Hakim --}}
<div class="modal fade" id="hakimModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h2 class="h5 fw-bold text-dark mb-0">Tambah Hakim</h2>
                <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="hakimForm" onsubmit="saveHakim(event)">

                    <label class="form-label fw-semibold small text-dark">Nama Hakim</label>
                    <div id="nameFieldsWrapper">
                        {{-- Baris nama pertama, tidak bisa dihapus --}}
                        <div class="name-row">
                            <input type="text" class="form-control hakim-name-input" required
                                placeholder="Dr. H. Ahmad Sutrisno, S.H., M.H.">
                        </div>
                    </div>

                    <button type="button" onclick="addNameField()"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1 mb-3">
                        <span class="fs-6 lh-1">+</span> Tambah Nama Lain
                    </button>

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
    // Struktur ini murni untuk preview UI, belum ada validasi server-side,
    // belum ada CSRF protection, dan tidak persist setelah refresh.
    // ============================================
    let hakimData = [
        'Dr. H. Ahmad Sutrisno, S.H., M.H.',
        'Hj. Rina Marlina, S.H., M.H.',
        'Bambang Setiawan, S.H., M.H.',
    ];

    let hakimModalInstance = null;
    document.addEventListener('DOMContentLoaded', function () {
        hakimModalInstance = new bootstrap.Modal(document.getElementById('hakimModal'));
    });

    function renderTable() {
        const tbody = document.getElementById('tableBody');
        const emptyState = document.getElementById('emptyState');
        tbody.innerHTML = '';

        if (hakimData.length === 0) {
            emptyState.classList.remove('d-none');
            return;
        }
        emptyState.classList.add('d-none');

        hakimData.forEach((nama, i) => {
            const row = document.createElement('tr');
            row.style.borderTop = '1px solid #f1f1f1';
            row.innerHTML = `
                <td class="px-3 py-3 text-secondary">${i + 1}</td>
                <td class="px-3 py-3 fw-semibold text-dark">${nama}</td>
                <td class="px-3 py-3 text-center">
                    <button onclick="deleteHakim(${i})" class="btn btn-link btn-sm text-decoration-none text-danger p-0">Hapus</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    // Tambah satu baris input nama baru, dengan tombol hapus baris (kecuali baris pertama)
    function addNameField() {
        const wrapper = document.getElementById('nameFieldsWrapper');

        const row = document.createElement('div');
        row.className = 'name-row';
        row.innerHTML = `
            <input type="text" class="form-control hakim-name-input" required
                placeholder="Nama hakim lainnya">
            <button type="button" class="btn btn-outline-danger btn-remove-name" onclick="this.parentElement.remove()">
                &times;
            </button>
        `;
        wrapper.appendChild(row);
    }

    function openModal() {
        document.getElementById('hakimForm').reset();
        // Reset ke satu input kosong saja setiap kali modal dibuka
        document.getElementById('nameFieldsWrapper').innerHTML = `
            <div class="name-row">
                <input type="text" class="form-control hakim-name-input" required
                    placeholder="Dr. H. Ahmad Sutrisno, S.H., M.H.">
            </div>
        `;
        hakimModalInstance.show();
    }

    function deleteHakim(index) {
        if (confirm('Yakin ingin menghapus nama hakim ini?')) {
            hakimData.splice(index, 1);
            renderTable();
        }
    }

    function closeModal() {
        hakimModalInstance.hide();
    }

    function saveHakim(event) {
        event.preventDefault();

        const inputs = document.querySelectorAll('.hakim-name-input');
        inputs.forEach(input => {
            const nama = input.value.trim();
            if (nama !== '') {
                hakimData.push(nama);
            }
        });

        renderTable();
        closeModal();
    }

    renderTable();
</script>

@endsection