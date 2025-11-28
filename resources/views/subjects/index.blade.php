@extends('layouts.app') {{-- Sesuaikan dengan nama layout Anda --}}

@section('title', 'Mata Pelajaran')

@section('content')
<section class="table-components">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Mata Pelajaran</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Mata Pelajaran
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ========== title-wrapper end ========== -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="d-flex justify-content-between align-items-center mb-20">
                        <h6 class="mb-0">Daftar Mata Pelajaran</h6>
                        <a href="{{ route('subjects.create') }}" class="main-btn primary-btn btn-hover">
                            Tambah Mata Pelajaran
                        </a>
                    </div>

                    <div class="table-wrapper table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><h6>Kode</h6></th>
                                    <th><h6>Nama Mata Pelajaran</h6></th>
                                    <th><h6>Guru Pengajar</h6></th>
                                    <th><h6>Kelas</h6></th>
                                    <th><h6>Jurusan</h6></th>
                                    <th><h6>Status</h6></th>
                                    <th><h6>Aksi</h6></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($subjects as $subject)
                                <tr>
                                    <td>{{ $subject->subject_code }}</td>
                                    <td>{{ $subject->subject_name }}</td>
                                    <td>{{ $subject->teacher_name ?? '—' }}</td>
                                    <td>{{ $subject->class_level }}</td>
                                    <td>{{ $subject->major }}</td>
                                    <td>
                                        @if($subject->status === 'active')
                                            <span class="status-btn active-btn">Aktif</span>
                                        @else
                                            <span class="status-btn close-btn">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action">
                                            <a href="{{ route('subjects.show', $subject) }}" class="text-info me-2">
                                                <i class="lni lni-eye"></i>
                                            </a>
                                            <a href="{{ route('subjects.edit', $subject) }}" class="text-primary me-2">
                                                <i class="lni lni-pencil"></i>
                                            </a>
                                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="lni lni-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data mata pelajaran.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $subjects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection