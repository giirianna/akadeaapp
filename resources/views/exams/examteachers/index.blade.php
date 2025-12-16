@extends('layouts.app')

@section('title', 'Daftar Ujian')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Ujian</h2>
        <a href="{{ route('exams.create') }}" class="btn btn-primary">+ Buat Ujian Baru</a>
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
                                        <a href="{{ route('exams.show', $exam) }}" 
                                           class="text-info" 
                                           title="Lihat">
                                            <i class="lni lni-eye"></i>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('exams.edit', $exam) }}" 
                                           class="text-warning" 
                                           title="Edit">
                                            <i class="lni lni-pencil"></i>
                                        </a>

                                        <!-- Hasil -->
                                        <a href="{{ route('exams.submissions', $exam) }}" 
                                           class="text-success" 
                                           title="Hasil">
                                            <i class="lni lni-files"></i>
                                        </a>

                                        <!-- Hapus -->
                                        <button
                                            type="button"
                                            class="text-danger"
                                            title="Hapus"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $exam->id }}"
                                        >
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
<div class="modal fade" id="deleteModal{{ $exam->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $exam->id }}" aria-hidden="true">
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
@endsection