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

    .pihak-pill {
        display:block;
        width:max-content;
        max-width:100%;
        background:#f3f4f6;
        color:#374151;
        border-radius:.4rem;
        padding:2px 8px;
        font-size:.8rem;
        margin-bottom:4px;
        white-space:normal;
        word-break:break-word;
    }
    .pihak-pill:last-child {
        margin-bottom:0;
    }

    .td-pihak {
        white-space:normal;
        max-width:200px;
        min-width:140px;
    }

    .td-aksi {
        white-space:nowrap;
    }
</style>

<section class="hero-section py-5">
    <div class="page-container">

    {{-- Header --}}
    <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Kelola Jadwal Sidang</h1>
            <p class="text-secondary small mb-0">
                Tambah, ubah, atau hapus jadwal sidang
            </p>
        </div>
        @if (auth()->user()->role === 'admin')
            <button onclick="openAddModal()" type="button" class="btn d-flex align-items-center gap-2" style="background-color: #000080; color: #fff;">
                <span class="fs-5 lh-1">+</span> Tambah Jadwal
            </button>
        @endif
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
                    @if (auth()->user()->role === 'admin')
                        <th class="px-3 py-3 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwalList as $i => $j)
                    <tr style="border-top:1px solid #f1f1f1;">
                        <td class="px-3 py-3 text-secondary">{{ $i + 1 }}</td>
                        <td class="px-3 py-3 fw-semibold text-dark">{{ $j->perkara->nomor_perkara }}</td>
                        <td class="px-3 py-3">{{ $j->perkara->agenda }}</td>
                        <td class="px-3 py-3">{{ $j->tanggal_sidang->format('d M Y') }}</td>
                        <td class="px-3 py-3 fw-medium">{{ substr($j->jam_sidang, 0, 5) }}</td>
                        <td class="px-3 py-3">{{ $j->ruang_sidang }}</td>
                        <td class="px-3 py-3">{{ $j->hakimKetua->nama }}</td>
                        <td class="px-3 py-3">{{ $j->hakimAnggota1->nama }}</td>
                        <td class="px-3 py-3">{{ $j->hakimAnggota2->nama }}</td>
                        <td class="px-3 py-3">{{ $j->panitera->nama }}</td>
                        <td class="px-3 py-3 td-pihak">
                            @foreach ($j->perkara->pihak->where('tipe', 'penggugat') as $pg)
                                <span class="pihak-pill">{{ $pg->nama }}</span>
                            @endforeach
                        </td>
                        <td class="px-3 py-3 td-pihak">
                            @foreach ($j->perkara->pihak->where('tipe', 'tergugat') as $tg)
                                <span class="pihak-pill">{{ $tg->nama }}</span>
                            @endforeach
                        </td>
                        @if (auth()->user()->role === 'admin')
                            <td class="px-3 py-3 text-center td-aksi">
                                <button type="button" class="btn btn-link btn-sm text-decoration-none p-0 me-3"
                                    onclick="openEditModal({{ $j->id }})">Edit</button>

                                <form id="deleteJadwalForm{{ $j->id }}" method="POST" action="{{ route('kelola-jadwal.destroy', $j->id) }}" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" class="btn btn-link btn-sm text-decoration-none text-danger p-0"
                                    onclick="askDelete('deleteJadwalForm{{ $j->id }}', 'Yakin ingin menghapus jadwal sidang {{ $j->perkara->nomor_perkara }} tanggal {{ $j->tanggal_sidang->format('d M Y') }}?')">
                                    Hapus
                                </button>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="text-center text-secondary small py-5">
                            Belum ada jadwal sidang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@if (auth()->user()->role === 'admin')

    {{-- Modal Tambah Jadwal --}}
    <div class="modal fade" id="addJadwalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold text-dark mb-0">Tambah Jadwal Sidang</h5>
                    <button type="button" class="btn-close" onclick="closeAddModal()" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('kelola-jadwal.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-dark">No. Perkara</label>
                            <select name="perkara_id" id="f_perkara_add" required class="form-select" onchange="handlePerkaraChange('add')">
                                <option value="" disabled selected>Pilih No. Perkara</option>
                                @foreach ($perkaraList as $p)
                                    <option value="{{ $p->id }}">{{ $p->nomor_perkara }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark">Penggugat</label>
                                <div id="f_penggugat_display_add" class="autofill-box is-empty">Pilih No. Perkara dulu</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark">Tergugat</label>
                                <div id="f_tergugat_display_add" class="autofill-box is-empty">Pilih No. Perkara dulu</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-dark">Agenda</label>
                            <div id="f_agenda_display_add" class="autofill-box is-empty">Pilih No. Perkara dulu</div>
                        </div>

                        <div class="pt-2 border-top mb-3">
                            <p class="text-secondary fw-bold text-uppercase mb-0 mt-3" style="font-size:.72rem; letter-spacing:.03em;">Jadwal</p>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-dark">Tanggal Sidang</label>
                                <input type="date" name="tanggal_sidang" required class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-dark">Jam Sidang</label>
                                <input type="time" name="jam_sidang" required class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-dark">Ruang Sidang</label>
                                <select name="ruang_sidang" required class="form-select">
                                    <option value="" disabled selected>Pilih Ruang</option>
                                    <option>Ruang Sidang Persiapan</option>
                                    <option>Ruang Sidang</option>
                                </select>
                            </div>
                        </div>

                        <div class="pt-2 border-top mb-3">
                            <p class="text-secondary fw-bold text-uppercase mb-0 mt-3" style="font-size:.72rem; letter-spacing:.03em;">Majelis Hakim &amp; Panitera Pengganti</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-dark">Hakim Ketua</label>
                            <select name="hakim_ketua_id" required class="form-select">
                                <option value="" disabled selected>Pilih Hakim Ketua</option>
                                @foreach ($hakimList as $h)
                                    <option value="{{ $h->id }}">{{ $h->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-dark">Hakim Anggota I</label>
                            <select name="hakim_anggota1_id" required class="form-select">
                                <option value="" disabled selected>Pilih Hakim Anggota I</option>
                                @foreach ($hakimList as $h)
                                    <option value="{{ $h->id }}">{{ $h->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-dark">Hakim Anggota II</label>
                            <select name="hakim_anggota2_id" required class="form-select">
                                <option value="" disabled selected>Pilih Hakim Anggota II</option>
                                @foreach ($hakimList as $h)
                                    <option value="{{ $h->id }}">{{ $h->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-dark">Panitera Pengganti</label>
                            <select name="panitera_pengganti_id" required class="form-select">
                                <option value="" disabled selected>Pilih Panitera Pengganti</option>
                                @foreach ($paniteraList as $pp)
                                    <option value="{{ $pp->id }}">{{ $pp->nama }}</option>
                                @endforeach
                            </select>
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

    {{-- Modal Edit Jadwal --}}
    @foreach ($jadwalList as $j)
        <div class="modal fade" id="editJadwalModal{{ $j->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="fw-bold text-dark mb-0">Edit Jadwal Sidang</h5>
                        <button type="button" class="btn-close" onclick="closeEditModal({{ $j->id }})" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="{{ route('kelola-jadwal.update', $j->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-dark">No. Perkara</label>
                                <select name="perkara_id" id="f_perkara_edit{{ $j->id }}" required class="form-select" onchange="handlePerkaraChange('edit{{ $j->id }}')">
                                    @foreach ($perkaraList as $p)
                                        <option value="{{ $p->id }}" {{ $p->id === $j->perkara_id ? 'selected' : '' }}>{{ $p->nomor_perkara }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-dark">Penggugat</label>
                                    <div id="f_penggugat_display_edit{{ $j->id }}" class="autofill-box">-</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-dark">Tergugat</label>
                                    <div id="f_tergugat_display_edit{{ $j->id }}" class="autofill-box">-</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-dark">Agenda</label>
                                <div id="f_agenda_display_edit{{ $j->id }}" class="autofill-box">-</div>
                            </div>

                            <div class="pt-2 border-top mb-3">
                                <p class="text-secondary fw-bold text-uppercase mb-0 mt-3" style="font-size:.72rem; letter-spacing:.03em;">Jadwal</p>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-dark">Tanggal Sidang</label>
                                    <input type="date" name="tanggal_sidang" required class="form-control"
                                        value="{{ $j->tanggal_sidang->format('Y-m-d') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-dark">Jam Sidang</label>
                                    <input type="time" name="jam_sidang" required class="form-control"
                                        value="{{ substr($j->jam_sidang, 0, 5) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-dark">Ruang Sidang</label>
                                    <select name="ruang_sidang" required class="form-select">
                                        @foreach (['Ruang Sidang Persiapan', 'Ruang Sidang'] as $ruang)
                                            <option {{ $j->ruang_sidang === $ruang ? 'selected' : '' }}>{{ $ruang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="pt-2 border-top mb-3">
                                <p class="text-secondary fw-bold text-uppercase mb-0 mt-3" style="font-size:.72rem; letter-spacing:.03em;">Majelis Hakim &amp; Panitera Pengganti</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-dark">Hakim Ketua</label>
                                <select name="hakim_ketua_id" required class="form-select">
                                    @foreach ($hakimList as $h)
                                        <option value="{{ $h->id }}" {{ $h->id === $j->hakim_ketua_id ? 'selected' : '' }}>{{ $h->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-dark">Hakim Anggota I</label>
                                <select name="hakim_anggota1_id" required class="form-select">
                                    @foreach ($hakimList as $h)
                                        <option value="{{ $h->id }}" {{ $h->id === $j->hakim_anggota1_id ? 'selected' : '' }}>{{ $h->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-dark">Hakim Anggota II</label>
                                <select name="hakim_anggota2_id" required class="form-select">
                                    @foreach ($hakimList as $h)
                                        <option value="{{ $h->id }}" {{ $h->id === $j->hakim_anggota2_id ? 'selected' : '' }}>{{ $h->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-dark">Panitera Pengganti</label>
                                <select name="panitera_pengganti_id" required class="form-select">
                                    @foreach ($paniteraList as $pp)
                                        <option value="{{ $pp->id }}" {{ $pp->id === $j->panitera_pengganti_id ? 'selected' : '' }}>{{ $pp->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex gap-3 pt-2 border-top">
                                <button type="button" onclick="closeEditModal({{ $j->id }})" class="btn btn-outline-secondary flex-fill mt-3">Batal</button>
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
                    <p class="fw-bold text-dark mb-1">Hapus jadwal ini?</p>
                    <p id="deleteConfirmText" class="text-secondary small mb-0">Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer border-0 justify-content-center gap-2 pb-4">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger px-4" onclick="confirmDeleteSubmit()">Hapus</button>
                </div>
            </div>
        </div>
    </div>

@endif

</section>

@if (auth()->user()->role === 'admin')
<script>
    const perkaraOptions = @json($perkaraList);
    const jadwalIds = @json($jadwalList->pluck('id'));
    const hasErrors = @json($errors->any());

    let addModalInstance = null;
    const editModalInstances = {};
    let deleteModalInstance = null;
    let formToDelete = null;

    document.addEventListener('DOMContentLoaded', function () {
        const addModalEl = document.getElementById('addJadwalModal');
        if (addModalEl) {
            addModalInstance = new bootstrap.Modal(addModalEl);
        }

        const deleteModalEl = document.getElementById('deleteConfirmModal');
        if (deleteModalEl) {
            deleteModalInstance = new bootstrap.Modal(deleteModalEl);
        }

        jadwalIds.forEach(function (id) {
            const editModalEl = document.getElementById('editJadwalModal' + id);
            if (editModalEl) {
                editModalInstances[id] = new bootstrap.Modal(editModalEl);
            }
        });

        if (hasErrors && addModalInstance) {
            addModalInstance.show();
        }

        jadwalIds.forEach(function (id) {
            handlePerkaraChange('edit' + id);
        });
    });

    function handlePerkaraChange(suffix) {
        const select = document.getElementById('f_perkara_' + suffix);
        if (!select) return;

        const selectedId = parseInt(select.value, 10);
        const data = perkaraOptions.find(p => p.id === selectedId);

        const penggugatDisplay = document.getElementById('f_penggugat_display_' + suffix);
        const tergugatDisplay = document.getElementById('f_tergugat_display_' + suffix);
        const agendaDisplay = document.getElementById('f_agenda_display_' + suffix);

        if (data) {
            const penggugatNames = data.pihak.filter(p => p.tipe === 'penggugat').map(p => p.nama).join(', ');
            const tergugatNames = data.pihak.filter(p => p.tipe === 'tergugat').map(p => p.nama).join(', ');

            if (penggugatDisplay) {
                penggugatDisplay.textContent = penggugatNames || '-';
                penggugatDisplay.classList.remove('is-empty');
            }
            if (tergugatDisplay) {
                tergugatDisplay.textContent = tergugatNames || '-';
                tergugatDisplay.classList.remove('is-empty');
            }
            if (agendaDisplay) {
                agendaDisplay.textContent = data.agenda;
                agendaDisplay.classList.remove('is-empty');
            }
        } else {
            if (penggugatDisplay) {
                penggugatDisplay.textContent = 'Pilih No. Perkara dulu';
                penggugatDisplay.classList.add('is-empty');
            }
            if (tergugatDisplay) {
                tergugatDisplay.textContent = 'Pilih No. Perkara dulu';
                tergugatDisplay.classList.add('is-empty');
            }
            if (agendaDisplay) {
                agendaDisplay.textContent = 'Pilih No. Perkara dulu';
                agendaDisplay.classList.add('is-empty');
            }
        }
    }

    function openAddModal() {
        if (addModalInstance) addModalInstance.show();
    }
    function closeAddModal() {
        if (addModalInstance) addModalInstance.hide();
    }

    function openEditModal(id) {
        if (editModalInstances[id]) editModalInstances[id].show();
    }
    function closeEditModal(id) {
        if (editModalInstances[id]) editModalInstances[id].hide();
    }

    function askDelete(formId, message) {
        formToDelete = document.getElementById(formId);
        const confirmTextEl = document.getElementById('deleteConfirmText');
        if (confirmTextEl) confirmTextEl.textContent = message;
        if (deleteModalInstance) deleteModalInstance.show();
    }
    function confirmDeleteSubmit() {
        if (formToDelete) {
            formToDelete.submit();
        }
    }
</script>
@endif

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof window.Echo !== 'undefined') {
            window.Echo.channel('jadwal-sidang-channel')
                .listen('.jadwal.updated', function (e) {
                    console.log('Ada pembaruan jadwal dari Admin, merefresh halaman...');
                    window.location.reload();
                });
        }
    });
</script>
@endpush