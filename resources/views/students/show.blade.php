@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<div class="card">
    <div class="card-header bg-info text-white">
        <h5>Detail Siswa</h5>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nama</dt>
            <dd class="col-sm-9">{{ $student->name }}</dd>

            <dt class="col-sm-3">Kelas</dt>
            <dd class="col-sm-9">{{ $student->class }}</dd>

            <dt class="col-sm-3">Jurusan</dt>
            <dd class="col-sm-9">{{ $student->major ?? '-' }}</dd>

            <dt class="col-sm-3">NIS</dt>
            <dd class="col-sm-9">{{ $student->nis }}</dd>

            <dt class="col-sm-3">Tanggal Lahir</dt>
            <dd class="col-sm-9">{{ optional($student->birth_date)->format('d-m-Y') ?? '-' }}</dd>

            <dt class="col-sm-3">Alamat</dt>
            <dd class="col-sm-9">{{ $student->address ?? '-' }}</dd>
        </dl>

        <div class="d-flex gap-2">
            <a href="{{ route('students.edit', $student) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection