<div class="detail-content">
    <div class="detail-row mb-3 pb-3 border-bottom">
        <div class="row">
            <div class="col-4"><strong>Kode Mata Pelajaran:</strong></div>
            <div class="col-8">{{ $subject->subject_code }}</div>
        </div>
    </div>

    <div class="detail-row mb-3 pb-3 border-bottom">
        <div class="row">
            <div class="col-4"><strong>Nama Mata Pelajaran:</strong></div>
            <div class="col-8">{{ $subject->subject_name }}</div>
        </div>
    </div>

    <div class="detail-row mb-3 pb-3 border-bottom">
        <div class="row">
            <div class="col-4"><strong>Guru Pengajar:</strong></div>
            <div class="col-8">{{ $subject->teacher_name ?? '—' }}</div>
        </div>
    </div>

    <div class="detail-row mb-3 pb-3 border-bottom">
        <div class="row">
            <div class="col-4"><strong>Kelas:</strong></div>
            <div class="col-8">{{ $subject->class_level }}</div>
        </div>
    </div>

    <div class="detail-row mb-3 pb-3 border-bottom">
        <div class="row">
            <div class="col-4"><strong>Jurusan:</strong></div>
            <div class="col-8">{{ $subject->major }}</div>
        </div>
    </div>

    <div class="detail-row mb-3 pb-3 border-bottom">
        <div class="row">
            <div class="col-4"><strong>Status:</strong></div>
            <div class="col-8">
                @if($subject->status === 'active')
                    <span class="status-btn active-btn">Aktif</span>
                @else
                    <span class="status-btn close-btn">Tidak Aktif</span>
                @endif
            </div>
        </div>
    </div>

    @if($subject->description)
        <div class="detail-row mb-3">
            <div class="row">
                <div class="col-4"><strong>Deskripsi:</strong></div>
                <div class="col-8">{{ $subject->description }}</div>
            </div>
        </div>
    @endif
</div>
