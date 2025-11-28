@extends('layouts.app')

@section('title', 'Daftar Guru')

@section('content')
<section class="table-components">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Daftar Guru</h2>
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
                                    Guru
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
                        <h6 class="mb-0">Data Guru</h6>
                        <a href="{{ route('teachers.create') }}" class="main-btn primary-btn btn-hover">
                            Tambah Guru
                        </a>
                    </div>

                    <div class="table-wrapper table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><h6>Foto</h6></th>
                                    <th><h6>NIP/Nomor Guru</h6></th>
                                    <th><h6>Nama Lengkap</h6></th>
                                    <th><h6>Jabatan</h6></th>
                                    <th><h6>Status Kepegawaian</h6></th>
                                    <th><h6>Mata Pelajaran</h6></th>
                                    <th><h6>Aksi</h6></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teachers as $teacher)
                                <tr>
                                    <td class="min-width">
                                        <div class="employee-image">
                                            @if($teacher->photo)
                                                <img src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->full_name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('assets/images/profile/profile-image.png') }}" alt="default" class="rounded-circle" style="width: 40px; height: 40px;">
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $teacher->teacher_number }}</td>
                                    <td>{{ $teacher->full_name }}</td>
                                    <td>{{ $teacher->teacher_role ?? '—' }}</td>
                                    <td>{{ $teacher->employment_status ?? '—' }}</td>
                                    <td>
                                        @if($teacher->subjects->count() > 0)
                                            {{ $teacher->subjects->count() }} mata pelajaran
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action">
                                            <a href="{{ route('teachers.show', $teacher) }}" class="text-info me-2">
                                                <i class="lni lni-eye"></i>
                                            </a>
                                            <a href="{{ route('teachers.edit', $teacher) }}" class="text-primary me-2">
                                                <i class="lni lni-pencil"></i>
                                            </a>
                                            <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger" onclick="return confirm('Yakin ingin menghapus data guru ini?')">
                                                    <i class="lni lni-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data guru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $teachers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection