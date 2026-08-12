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
                    Tambah, ubah, atau hapus data perkara
                </p>
            </div>
            <button type="button" onclick="openAddModal()"
                class="btn btn-primary d-flex align-items-center gap-2">
                <span class="fs-5 lh-1">+</span> Buat Perkara
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
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
                <tbody>
                    @forelse ($perkaraList as $i => $p)
                        <tr style="border-top:1px solid #f1f1f1;">
                            <td class="px-3 py-3 text-secondary">{{ $i + 1 }}</td>
                            <td class="px-3 py-3 fw-semibold text-dark">{{ $p->nomor_perkara }}</td>
                            <td class="px-3 py-3">{{ $p->agenda }}</td>
                            <td class="px-3 py-3">
                                @foreach ($p->pihak->where('tipe', 'penggugat') as $pg)
                                    <span class="pihak-pill">{{ $pg->nama }}</span>
                                @endforeach
                            </td>
                            <td class="px-3 py-3">
                                @foreach ($p->pihak->where('tipe', 'tergugat') as $tg)
                                    <span class="pihak-pill">{{ $tg->nama }}</span>
                                @endforeach
                            </td>
                            <td class="px-3 py-3 text-center">
                                <button type="button" class="btn btn-link btn-sm text-decoration-none p-0 me-3"
                                    onclick="openEditModal({{ $p->id }})">Edit</button>
                                <form id="deletePerkaraForm{{ $p->id }}" method="POST" action="{{ route('perkara.destroy', $p->id) }}" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" class="btn btn-link btn-sm text-decoration-none text-danger p-0"
                                    onclick="askDelete('deletePerkaraForm{{ $p->id }}', 'Yakin ingin menghapus perkara {{ $p->nomor_perkara }}? Semua jadwal sidang dan riwayat kehadiran terkait juga akan terhapus.')">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-secondary small py-5">
                                Belum ada data perkara. Klik "Buat Perkara" untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</section>

{{-- Modal Tambah Perkara --}}
<div class="modal fade" id="addPerkaraModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h2 class="h5 fw-bold text-dark mb-0">Buat Perkara</h2>
                <button type="button" class="btn-close" onclick="closeAddModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('perkara.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">No. Perkara</label>
                        <input type="text" name="nomor_perkara" class="form-control" required
                            placeholder="123/Pdt.G/2026/PN.Jkt.Ps">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">Agenda</label>
                        <input type="text" name="agenda" class="form-control" required
                            placeholder="Pembuktian Penggugat">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">Penggugat</label>
                        <div id="addPenggugatWrapper">
                            <div class="name-row">
                                <input type="text" name="penggugat[]" class="form-control" required placeholder="Tajudin">
                            </div>
                        </div>
                        <button type="button" onclick="addNameField('addPenggugatWrapper', 'penggugat[]', 'Nama penggugat lainnya')"
                            class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                            <span class="fs-6 lh-1">+</span> Tambah Penggugat
                        </button>
                    </div>

                    <div class="mb-3 pt-2 border-top">
                        <label class="form-label fw-semibold small text-dark mt-3">Tergugat</label>
                        <div id="addTergugatWrapper">
                            <div class="name-row">
                                <input type="text" name="tergugat[]" class="form-control" required
                                    placeholder="Kepala Kantor Pertanahan Kabupaten Pandeglang">
                            </div>
                        </div>
                        <button type="button" onclick="addNameField('addTergugatWrapper', 'tergugat[]', 'Nama tergugat lainnya')"
                            class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                            <span class="fs-6 lh-1">+</span> Tambah Tergugat
                        </button>
                    </div>

                    <div class="d-flex gap-3 pt-2 border-top">
                        <button type="button" onclick="closeAddModal()" class="btn btn-outline-secondary flex-fill mt-3">Batal</button>
                        <button type="submit" class="btn btn-primary flex-fill mt-3">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Perkara — satu per baris data, sudah pre-filled dari server --}}
@foreach ($perkaraList as $p)
    <div class="modal fade" id="editPerkaraModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h2 class="h5 fw-bold text-dark mb-0">Edit Perkara</h2>
                    <button type="button" class="btn-close" onclick="closeEditModal({{ $p->id }})" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('perkara.update', $p->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-dark">No. Perkara</label>
                            <input type="text" name="nomor_perkara" class="form-control" required value="{{ $p->nomor_perkara }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-dark">Agenda</label>
                            <input type="text" name="agenda" class="form-control" required value="{{ $p->agenda }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-dark">Penggugat</label>
                            <div id="editPenggugatWrapper{{ $p->id }}">
                                @foreach ($p->pihak->where('tipe', 'penggugat') as $idx => $pg)
                                    <div class="name-row">
                                        <input type="text" name="penggugat[]" class="form-control" required value="{{ $pg->nama }}">
                                        @if ($idx > 0)
                                            <button type="button" class="btn btn-outline-danger btn-remove-name" onclick="this.parentElement.remove()">&times;</button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addNameField('editPenggugatWrapper{{ $p->id }}', 'penggugat[]', 'Nama penggugat lainnya')"
                                class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                                <span class="fs-6 lh-1">+</span> Tambah Penggugat
                            </button>
                        </div>

                        <div class="mb-3 pt-2 border-top">
                            <label class="form-label fw-semibold small text-dark mt-3">Tergugat</label>
                            <div id="editTergugatWrapper{{ $p->id }}">
                                @foreach ($p->pihak->where('tipe', 'tergugat') as $idx => $tg)
                                    <div class="name-row">
                                        <input type="text" name="tergugat[]" class="form-control" required value="{{ $tg->nama }}">
                                        @if ($idx > 0)
                                            <button type="button" class="btn btn-outline-danger btn-remove-name" onclick="this.parentElement.remove()">&times;</button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addNameField('editTergugatWrapper{{ $p->id }}', 'tergugat[]', 'Nama tergugat lainnya')"
                                class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                                <span class="fs-6 lh-1">+</span> Tambah Tergugat
                            </button>
                        </div>

                        <div class="d-flex gap-3 pt-2 border-top">
                            <button type="button" onclick="closeEditModal({{ $p->id }})" class="btn btn-outline-secondary flex-fill mt-3">Batal</button>
                            <button type="submit" class="btn btn-primary flex-fill mt-3">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- Modal Konfirmasi Hapus --}}
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
    let addModalInstance = null;
    const editModalInstances = {};
    let deleteModalInstance = null;
    let formToDelete = null;

    document.addEventListener('DOMContentLoaded', function () {
        addModalInstance = new bootstrap.Modal(document.getElementById('addPerkaraModal'));
        deleteModalInstance = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

        @foreach ($perkaraList as $p)
            editModalInstances[{{ $p->id }}] = new bootstrap.Modal(document.getElementById('editPerkaraModal{{ $p->id }}'));
        @endforeach

        @if ($errors->any())
            addModalInstance.show();
        @endif
    });

    // Dipakai di modal Tambah maupun Edit — wrapperId & inputName beda-beda per konteks
    function addNameField(wrapperId, inputName, placeholderText) {
        const wrapper = document.getElementById(wrapperId);
        const row = document.createElement('div');
        row.className = 'name-row';
        row.innerHTML = `
            <input type="text" name="${inputName}" class="form-control" required placeholder="${placeholderText}">
            <button type="button" class="btn btn-outline-danger btn-remove-name" onclick="this.parentElement.remove()">&times;</button>
        `;
        wrapper.appendChild(row);
    }

    function openAddModal() { addModalInstance.show(); }
    function closeAddModal() { addModalInstance.hide(); }

    function openEditModal(id) { editModalInstances[id].show(); }
    function closeEditModal(id) { editModalInstances[id].hide(); }

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