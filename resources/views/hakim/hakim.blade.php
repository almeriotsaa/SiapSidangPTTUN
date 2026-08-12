@extends('layouts.admin')

@section('title','Kelola Majelis Hakim & Panitera Pengganti')

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

    .section-title {
        font-size:.72rem;
        font-weight:700;
        color:#6b7280;
        text-transform:uppercase;
        letter-spacing:.03em;
    }

    .table-scroll-wrap {
        max-height: 360px;
        overflow-y: auto;
    }
    .table-scroll-wrap thead th {
        position: sticky;
        top: 0;
        z-index: 1;
    }
</style>

<section class="py-5">
    <div class="page-container">

        {{-- Header --}}
        <div class="mb-4">
            <h1 class="h3 fw-bold text-dark mb-1">Kelola Majelis Hakim &amp; Panitera Pengganti</h1>
            <p class="text-secondary small mb-0">
                Data ini dipakai saat membuat jadwal sidang
            </p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ============================= --}}
        {{-- SECTION: Majelis Hakim         --}}
        {{-- ============================= --}}
        <div class="mb-5">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <p class="section-title mb-0">Majelis Hakim</p>
                <button type="button" onclick="openHakimModal()"
                    class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                    <span class="fs-6 lh-1">+</span> Tambah Hakim
                </button>
            </div>

            <div class="table-card">
                <div class="table-scroll-wrap">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr>
                                <th class="px-3 py-3">No</th>
                                <th class="px-3 py-3">Nama Hakim</th>
                                <th class="px-3 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hakimList as $i => $h)
                                <tr style="border-top:1px solid #f1f1f1;">
                                    <td class="px-3 py-3 text-secondary">{{ $i + 1 }}</td>
                                    <td class="px-3 py-3 fw-semibold text-dark">{{ $h->nama }}</td>
                                    <td class="px-3 py-3 text-center">
                                        <form id="deleteHakimForm{{ $h->id }}" method="POST" action="{{ route('hakim.destroy', $h->id) }}" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type="button" class="btn btn-link btn-sm text-decoration-none text-danger p-0"
                                            onclick="askDelete('deleteHakimForm{{ $h->id }}', 'Yakin ingin menghapus {{ $h->nama }}?')">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-secondary small py-4">
                                        Belum ada data hakim.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ============================= --}}
        {{-- SECTION: Panitera Pengganti    --}}
        {{-- ============================= --}}
        <div>
            <div class="d-flex align-items-center justify-content-between mb-3">
                <p class="section-title mb-0">Panitera Pengganti</p>
                <button type="button" onclick="openPaniteraModal()"
                    class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                    <span class="fs-6 lh-1">+</span> Tambah Panitera
                </button>
            </div>

            <div class="table-card">
                <div class="table-scroll-wrap">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr>
                                <th class="px-3 py-3">No</th>
                                <th class="px-3 py-3">Nama Panitera Pengganti</th>
                                <th class="px-3 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($paniteraList as $i => $p)
                                <tr style="border-top:1px solid #f1f1f1;">
                                    <td class="px-3 py-3 text-secondary">{{ $i + 1 }}</td>
                                    <td class="px-3 py-3 fw-semibold text-dark">{{ $p->nama }}</td>
                                    <td class="px-3 py-3 text-center">
                                        <form id="deletePaniteraForm{{ $p->id }}" method="POST" action="{{ route('panitera.destroy', $p->id) }}" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type="button" class="btn btn-link btn-sm text-decoration-none text-danger p-0"
                                            onclick="askDelete('deletePaniteraForm{{ $p->id }}', 'Yakin ingin menghapus {{ $p->nama }}?')">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-secondary small py-4">
                                        Belum ada data panitera pengganti.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- Modal Tambah Hakim --}}
<div class="modal fade" id="hakimModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h2 class="h5 fw-bold text-dark mb-0">Tambah Hakim</h2>
                <button type="button" class="btn-close" onclick="closeHakimModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('hakim.store') }}">
                    @csrf
                    <label class="form-label fw-semibold small text-dark">Nama Hakim</label>
                    <div id="hakimNameFieldsWrapper">
                        <div class="name-row">
                            <input type="text" name="names[]" class="form-control" required
                                placeholder="Dr. H. Ahmad Sutrisno, S.H., M.H.">
                        </div>
                    </div>
                    <button type="button" onclick="addNameField('hakimNameFieldsWrapper', 'Nama hakim lainnya')"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1 mb-3">
                        <span class="fs-6 lh-1">+</span> Tambah Nama Lain
                    </button>
                    <div class="d-flex gap-3 pt-2 border-top">
                        <button type="button" onclick="closeHakimModal()" class="btn btn-outline-secondary flex-fill mt-3">Batal</button>
                        <button type="submit" class="btn btn-primary flex-fill mt-3">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Panitera --}}
<div class="modal fade" id="paniteraModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h2 class="h5 fw-bold text-dark mb-0">Tambah Panitera Pengganti</h2>
                <button type="button" class="btn-close" onclick="closePaniteraModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('panitera.store') }}">
                    @csrf
                    <label class="form-label fw-semibold small text-dark">Nama Panitera Pengganti</label>
                    <div id="paniteraNameFieldsWrapper">
                        <div class="name-row">
                            <input type="text" name="names[]" class="form-control" required
                                placeholder="Siti Aminah, S.H.">
                        </div>
                    </div>
                    <button type="button" onclick="addNameField('paniteraNameFieldsWrapper', 'Nama panitera lainnya')"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1 mb-3">
                        <span class="fs-6 lh-1">+</span> Tambah Nama Lain
                    </button>
                    <div class="d-flex gap-3 pt-2 border-top">
                        <button type="button" onclick="closePaniteraModal()" class="btn btn-outline-secondary flex-fill mt-3">Batal</button>
                        <button type="submit" class="btn btn-primary flex-fill mt-3">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Hapus (dipakai bersama untuk Hakim & Panitera) --}}
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-body text-center pt-4 pb-2">
                <p class="fw-bold text-dark mb-1">Hapus data ini?</p>
                <p id="deleteConfirmText" class="text-secondary small mb-0">Apakah Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer border-0 justify-content-center gap-2 pb-4">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger px-4" onclick="confirmDeleteSubmit()">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    let hakimModalInstance = null;
    let paniteraModalInstance = null;
    let deleteModalInstance = null;
    let formToDelete = null;

    document.addEventListener('DOMContentLoaded', function () {
        hakimModalInstance = new bootstrap.Modal(document.getElementById('hakimModal'));
        paniteraModalInstance = new bootstrap.Modal(document.getElementById('paniteraModal'));
        deleteModalInstance = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    });

    // Dipakai untuk kedua form (Hakim & Panitera) — wrapper ID beda per form
    function addNameField(wrapperId, placeholderText) {
        const wrapper = document.getElementById(wrapperId);
        const row = document.createElement('div');
        row.className = 'name-row';
        row.innerHTML = `
            <input type="text" name="names[]" class="form-control" required placeholder="${placeholderText}">
            <button type="button" class="btn btn-outline-danger btn-remove-name" onclick="this.parentElement.remove()">&times;</button>
        `;
        wrapper.appendChild(row);
    }

    function openHakimModal() { hakimModalInstance.show(); }
    function closeHakimModal() { hakimModalInstance.hide(); }

    function openPaniteraModal() { paniteraModalInstance.show(); }
    function closePaniteraModal() { paniteraModalInstance.hide(); }

    // Buka modal konfirmasi, simpan form mana yang harus disubmit kalau user klik "Hapus"
    function askDelete(formId, message) {
        formToDelete = document.getElementById(formId);
        document.getElementById('deleteConfirmText').textContent = message;
        deleteModalInstance.show();
    }

    function confirmDeleteSubmit() {
        if (formToDelete) {
            formToDelete.submit();
        }
    }
</script>

@endsection