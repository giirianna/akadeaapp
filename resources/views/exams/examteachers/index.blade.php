@extends('layouts.app')

@section('title', 'Daftar Ujian')
@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Daftar Ujian</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('exams.template.download') }}" class="btn btn-outline-secondary btn-sm"
                    title="Download template soal">
                    <i class="lni lni-download"></i> Download Template
                </a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createExamModal">+
                    Buat
                    Ujian Baru</button>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if($exams->isEmpty())
                    <p class="text-muted text-center py-3">Belum ada ujian.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th class="text-center px-3">Judul Ujian</th>
                                    <th class="text-center px-3">Durasi Pengerjaan</th>
                                    <th class="text-center px-3">Waktu Pengerjaan</th>
                                    <th class="text-center px-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exams as $exam)
                                    <tr>
                                        <td class="text-center px-3">{{ $exam->title }}</td>
                                        <td class="text-center px-3">{{ $exam->duration_minutes }} menit</td>
                                        <td class="text-center px-3">
                                            {{ $exam->start_time->format('d M Y H:i') }} –<br>
                                            {{ $exam->end_time->format('d M Y H:i') }}
                                        </td>
                                        <td class="text-center px-3">
                                            <div class="action d-flex gap-2 justify-content-center">
                                                <!-- Lihat -->
                                                <a href="{{ route('exams.show', $exam) }}" class="text-info" title="Lihat">
                                                    <i class="lni lni-eye"></i>
                                                </a>

                                                <!-- Edit -->
                                                <a href="{{ route('exams.edit', $exam) }}" class="text-warning" title="Edit">
                                                    <i class="lni lni-pencil"></i>
                                                </a>

                                                <!-- Hasil -->
                                                <a href="{{ route('exams.submissions', $exam) }}" class="text-success"
                                                    title="Hasil">
                                                    <i class="lni lni-files"></i>
                                                </a>

                                                <!-- Hapus -->
                                                <button type="button" class="text-danger" title="Hapus" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $exam->id }}">
                                                    <i class="lni lni-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Hapus - DIPINDAHKAN KE LUAR TABLE (REKOMENDASI BOOTSTRAP) --}}
    @foreach($exams as $exam)
        <div class="modal fade" id="deleteModal{{ $exam->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $exam->id }}"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $exam->id }}">Hapus Ujian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus ujian <strong>"{{ $exam->title }}"</strong>?</p>
                        <p class="text-danger"><strong>Tindakan ini tidak bisa dikembalikan.</strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('exams.destroy', $exam) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="lni lni-trash-can me-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal: Buat Ujian Baru -->
    <div class="modal fade" id="createExamModal" tabindex="-1" aria-labelledby="createExamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createExamModalLabel">Buat Ujian Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('exams.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- Judul & Durasi -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="form-label fw-medium">Judul Ujian <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Durasi (menit) <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="duration_minutes" class="form-control" min="1" value="60"
                                    required>
                            </div>
                        </div>

                        <!-- Kelas & Mata Pelajaran -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Kelas <span class="text-danger">*</span></label>
                                <select name="class" class="form-control" required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="X">X</option>
                                    <option value="XI">XI</option>
                                    <option value="XII">XII</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Mata Pelajaran <span
                                        class="text-danger">*</span></label>
                                <select name="subject" class="form-control" required>
                                    <option value="">Pilih Mata Pelajaran</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->subject_name }}">{{ $subject->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Waktu Mulai & Berakhir -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Waktu Mulai <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="start_time" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Waktu Berakhir <span
                                        class="text-danger">*</span></label>
                                <input type="datetime-local" name="end_time" class="form-control" required>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">Deskripsi (Opsional)</label>
                            <textarea name="description" class="form-control" rows="3"
                                placeholder="Tambahkan instruksi atau catatan untuk siswa..."></textarea>
                        </div>

                        <!-- File Upload Soal (Opsional) -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">Upload File Soal (Opsional)</label>
                            <small class="d-block text-muted mb-2">Format: Excel (.xlsx, .xls) atau Word (.docx, .doc), max
                                10MB</small>
                            <input type="file" name="questions_file" class="form-control"
                                accept=".xlsx,.xls,.docx,.doc,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                            <small class="d-block text-muted mt-2">
                                <strong>Format Excel/Word:</strong><br>
                                Kolom: Tipe | Pertanyaan | Opsi A | Opsi B | Opsi C | Opsi D | Opsi E | Jawaban<br>
                                Tipe: Pilihan Ganda atau Essay<br>
                                <a href="{{ route('exams.template.download') }}" target="_blank" class="text-info fw-bold">
                                    <i class="lni lni-download"></i> Download Template
                                </a>
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Buat Ujian</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
