@extends('layouts.app')

@section('title', 'Daftar Guru')

@section('content')
    <!-- ========== table components start ========== -->
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
                    <!-- end col -->
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
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== title-wrapper end ========== -->

            <!-- ========== tables-wrapper start ========== -->
            <div class="tables-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <div class="d-flex justify-content-between align-items-center mb-30">
                                <div>
                                    <h6>Data Guru</h6>
                                    <p class="text-sm">Daftar lengkap guru yang terdaftar dalam sistem</p>
                                </div>
                                <a href="{{ route('teachers.create') }}" class="btn btn-primary">
                                    <span class="icon"><i class="lni lni-plus"></i></span> Tambah Guru
                                </a>
                            </div>

                            @if($teachers->isEmpty())
                                <div class="alert alert-info" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="lni lni-info-circle me-2"></i>
                                        <span>Belum ada data guru. <a href="{{ route('teachers.create') }}">Silakan tambahkan
                                                data baru</a></span>
                                    </div>
                                </div>
                            @else
                                <div class="table-wrapper table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50px;">
                                                    <h6>#</h6>
                                                </th>
                                                <th class="text-start">
                                                    <h6>Nama Lengkap</h6>
                                                </th>
                                                <th class="text-center">
                                                    <h6>NIP / Nomor Guru</h6>
                                                </th>
                                                <th class="text-center">
                                                    <h6>Mapel / Peran</h6>
                                                </th>
                                                <th class="text-center">
                                                    <h6>Status</h6>
                                                </th>
                                                <th class="text-center">
                                                    <h6>Aksi</h6>
                                                </th>
                                            </tr>
                                            <!-- end table row-->
                                        </thead>
                                        <tbody>
                                            @foreach($teachers as $teacher)
                                                <tr>
                                                    <td class="text-center">
                                                        <p>{{ ($teachers->currentPage() - 1) * $teachers->perPage() + $loop->iteration }}</p>
                                                    </td>
                                                    <td class="text-start min-width">
                                                        <p>{{ $teacher->full_name }}</p>
                                                    </td>
                                                    <td class="text-center min-width">
                                                        <p><strong>{{ $teacher->teacher_number }}</strong></p>
                                                    </td>
                                                    <td class="text-center min-width">
                                                        <p>{{ $teacher->teacher_role }}</p>
                                                    </td>
                                                    <td class="text-center min-width">
                                                        <p>{{ $teacher->employment_status ?? '-' }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="action d-flex gap-2 justify-content-center">
                                                            <a href="{{ route('teachers.show', $teacher) }}" class="text-info" title="Detail">
                                                                <i class="lni lni-eye"></i>
                                                            </a>
                                                            <a href="{{ route('teachers.edit', $teacher) }}" class="text-warning" title="Edit">
                                                                <i class="lni lni-pencil"></i>
                                                            </a>
                                                            <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" style="display:inline;"
                                                                onsubmit="return confirm('Yakin ingin menghapus data guru ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-danger" title="Hapus"
                                                                    style="background:none; border:none; cursor:pointer; padding:0;">
                                                                    <i class="lni lni-trash-can"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- end table row -->
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-wrapper -->

                                <!-- Pagination -->
                                <div class="d-flex justify-content-between align-items-center mt-20">
                                    <p class="text-sm">Total: {{ $teachers->total() }} data</p>
                                    <div class="pagination-wrapper">
                                        {{ $teachers->links() }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== tables-wrapper end ========== -->
        </div>
        <!-- end container-fluid -->
    </section>
    <!-- ========== table components end ========== -->
@endsection
