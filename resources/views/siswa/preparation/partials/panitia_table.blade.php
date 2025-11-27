<div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
        <h6 class="fw-bold text-primary mb-0">
            <i class="bi bi-people-fill me-2 fs-5"></i> Struktur Kepanitiaan
        </h6>
        <!-- ADD BUTTON -->
        <button class="btn btn-primary btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addMemberModal">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Anggota
        </button>
    </div>

    <div class="card-body p-0">
        <!-- MASS UPDATE FORM (For Roles) -->
        <form action="{{ route('siswa.panitia-update-struktur', $activity->activity_code) }}" method="POST">
            @csrf
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary small text-uppercase">
                        <tr>
                            <th class="px-4 py-3">Anggota</th>
                            <th class="py-3">Divisi (Sub-Role)</th>
                            <th class="py-3" style="width: 25%">Jabatan (Role)</th>
                            <th class="py-3 text-center" style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($panitiaList as $p)
                            <tr>
                                <!-- 1. NAME -->
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 40px; height: 40px;">
                                            {{ substr($p->student->full_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $p->student->full_name }}</div>
                                            <div class="small text-muted">{{ $p->student->student_number }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- 2. DIVISI (With Edit Trigger) -->
                                <td>
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                        {{ $p->subRole->sub_role_name ?? 'Belum ada divisi' }}
                                    </span>
                                </td>

                                <!-- 3. JABATAN (Inline Edit) -->
                                <td>
                                    <select class="form-select form-select-sm bg-light border-0" 
                                            name="updates[{{ $p->activity_structure_id }}]"
                                            style="font-weight: 500;">
                                        @foreach($roles as $r)
                                            <option value="{{ $r->student_role_id }}" 
                                                {{ $p->student_role_id == $r->student_role_id ? 'selected' : '' }}>
                                                {{ $r->role_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <!-- 4. ACTIONS (Edit SubRole & Delete) -->
                                <td class="text-center">
                                    <div class="btn-group">
                                        {{-- Edit Button (Triggers Modal) --}}
                                        <button type="button" class="btn btn-sm btn-light text-primary" 
                                                title="Edit Divisi"
                                                onclick="openEditModal('{{ $p->activity_structure_id }}', '{{ $p->sub_role_id }}', '{{ $p->student->full_name }}')">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        
                                        {{-- Delete Button --}}
                                        <button type="button" class="btn btn-sm btn-light text-danger" 
                                                title="Kick Member"
                                                onclick="confirmDelete('{{ $p->activity_structure_id }}', '{{ $p->student->full_name }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-person-x fs-1 d-block mb-2 opacity-25"></i>
                                    Belum ada anggota panitia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Save Roles Button -->
            <div class="p-3 border-top bg-light d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-4 fw-bold">
                    <i class="bi bi-save me-2"></i> Simpan Perubahan Jabatan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODALS ================= -->

<!-- 1. ADD MEMBER MODAL -->
<div class="modal fade" id="addMemberModal" tabindex="-1">
    <div class="modal-dialog modal-lg"> <!-- Changed to modal-lg for better table view -->
        <div class="modal-content">
            <form action="{{ route('siswa.panitia-tambah-member', $activity->activity_code) }}" method="POST" onsubmit="return validateStudentSelection()">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Anggota Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    
                    {{-- SEARCHABLE TABLE SECTION --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Pilih Mahasiswa</label>
                        
                        <!-- Search Input -->
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                            <input type="text" id="studentSearchInput" class="form-control" placeholder="Ketik NRP atau Nama untuk mencari...">
                        </div>

                        <!-- Hidden Input stores the selected ID -->
                        <input type="hidden" name="student_id" id="selectedStudentId">

                        <!-- Scrollable Table -->
                        <div class="border rounded overflow-auto bg-white" style="max-height: 250px;">
                            <table class="table table-sm table-hover mb-0" id="studentTable">
                                <thead class="table-light sticky-top shadow-sm">
                                    <tr>
                                        <th class="text-center" style="width: 50px;"><i class="bi bi-check2-circle"></i></th>
                                        <th>NRP</th>
                                        <th>Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allStudents as $s)
                                        <tr class="student-row" style="cursor: pointer;" onclick="selectStudent('{{ $s->student_id }}', '{{ $s->full_name }}', this)">
                                            <td class="text-center">
                                                <input type="radio" name="display_radio" class="form-check-input pointer-events-none">
                                            </td>
                                            <td class="nrp-cell fw-bold text-dark">{{ $s->student_number }}</td>
                                            <td class="name-cell">{{ $s->full_name }}</td>
                                        </tr>
                                    @empty
                                    <tr>
                                        <td>Belum ada anggota</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Selection Feedback -->
                        <div class="mt-2 p-2 bg-success bg-opacity-10 text-success rounded border border-success border-opacity-25" id="selectionFeedback" style="display: none;">
                            <i class="bi bi-person-check-fill me-2"></i> Mahasiswa Terpilih: <strong id="selectedStudentNameDisplay"></strong>
                        </div>
                        <div class="form-text text-danger" id="selectionError" style="display: none;">
                            <i class="bi bi-exclamation-circle"></i> Silakan pilih mahasiswa dari tabel di atas.
                        </div>
                    </div>

                    <div class="row g-3 border-top pt-3">
                        {{-- Division Selection --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Divisi</label>
                            <select name="sub_role_id" class="form-select" required>
                                @foreach($listDivisi as $d)
                                    <option value="{{ $d->id ?? $d->sub_role_id }}">{{ $d->sub_role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Role Selection --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jabatan</label>
                            <select name="student_role_id" class="form-select" required>
                                @foreach($roles as $r)
                                    <option value="{{ $r->student_role_id }}">{{ $r->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Tambah Anggota</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 2. EDIT DIVISION MODAL -->
<div class="modal fade" id="editMemberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editMemberForm" method="POST">
                @csrf
                
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Detail Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border mb-3">
                        Mengedit data untuk: <strong id="editMemberName">...</strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pindah Divisi (Sub-Role)</label>
                        <select name="sub_role_id" id="editSubRoleId" class="form-select">
                            @foreach($listDivisi as $d)
                                <option value="{{ $d->id ?? $d->sub_role_id }}">{{ $d->sub_role_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    {{-- Optional: Edit Custom Structure Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Jabatan Khusus (Opsional)</label>
                        <input type="text" name="structure_name" class="form-control" placeholder="Contoh: Koordinator Lapangan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 3. DELETE FORM (Hidden) -->
<form id="deleteMemberForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>


<!-- JAVASCRIPT LOGIC -->
<script>
    // Base URL needed for dynamic routes in JS
    const baseEditUrl = "{{ url('/panitia/update-member') }}";
    const baseDeleteUrl = "{{ url('/panitia/delete-member') }}";

    // --- 1. SEARCH & SELECT LOGIC ---
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('studentSearchInput');
        
        if(searchInput) {
            searchInput.addEventListener('keyup', function() {
                const value = this.value.toLowerCase();
                const rows = document.querySelectorAll('#studentTable tbody tr');
                
                rows.forEach(row => {
                    const nrp = row.querySelector('.nrp-cell').textContent.toLowerCase();
                    const name = row.querySelector('.name-cell').textContent.toLowerCase();
                    
                    if (nrp.indexOf(value) > -1 || name.indexOf(value) > -1) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        }
    });

    function selectStudent(id, name, rowElement) {
        // Update Hidden Input
        document.getElementById('selectedStudentId').value = id;
        
        // Update Feedback UI
        document.getElementById('selectedStudentNameDisplay').innerText = name;
        document.getElementById('selectionFeedback').style.display = 'block';
        document.getElementById('selectionError').style.display = 'none';

        // Check the radio button visually
        const radio = rowElement.querySelector('input[type="radio"]');
        if(radio) radio.checked = true;

        // Highlight Row
        document.querySelectorAll('.student-row').forEach(r => r.classList.remove('table-active', 'bg-primary', 'bg-opacity-10'));
        rowElement.classList.add('table-active', 'bg-primary', 'bg-opacity-10');
    }

    function validateStudentSelection() {
        const selectedId = document.getElementById('selectedStudentId').value;
        if (!selectedId) {
            document.getElementById('selectionError').style.display = 'block';
            return false; // Prevent submission
        }
        return true;
    }

    // --- 2. EDIT & DELETE LOGIC ---
    function openEditModal(structureId, currentSubRoleId, memberName) {
        document.getElementById('editMemberName').innerText = memberName;
        document.getElementById('editSubRoleId').value = currentSubRoleId;
        
        const form = document.getElementById('editMemberForm');
        form.action = `${baseEditUrl}/${structureId}`;
        
        new bootstrap.Modal(document.getElementById('editMemberModal')).show();
    }

    function confirmDelete(structureId, memberName) {
        if(confirm(`Apakah Anda yakin ingin mengeluarkan ${memberName} dari kepanitiaan?`)) {
            const form = document.getElementById('deleteMemberForm');
            form.action = `${baseDeleteUrl}/${structureId}`;
            form.submit();
        }
    }
</script>