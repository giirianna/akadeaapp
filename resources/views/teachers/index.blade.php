@extends('layouts.app')

@section('title', 'Daftar Guru')

@section('content')
<section class="table-components">
    <div class="container-fluid">
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

        <div class="tables-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="d-flex justify-content-between align-items-center mb-30">
                            <div>
                                <h6>Data Guru</h6>
                                <p class="text-sm">Daftar lengkap guru yang terdaftar dalam sistem</p>
                            </div>
                            <button
                                type="button"
                                class="main-btn primary-btn btn-hover btn-modal"
                                data-url="{{ route('teachers.create') }}"
                                data-title="Tambah Guru"
                            >
                                <i class="lni lni-plus"></i> Tambah Guru
                            </button>
                        </div>

                        @if ($teachers->isEmpty())
                            <div class="alert alert-info" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="lni lni-info-circle me-2"></i>
                                    <span>
                                        Belum ada data guru.
                                        <button
                                            type="button"
                                            class="btn btn-link p-0 text-primary btn-modal"
                                            data-url="{{ route('teachers.create') }}"
                                            data-title="Tambah Guru"
                                        >
                                            Silakan tambahkan data baru
                                        </button>
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="table-wrapper table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><h6>Photo</h6></th>
                                            <th class="text-start"><h6>Full Name</h6></th>
                                            <th class="text-center"><h6>Teacher ID / NIP</h6></th>
                                            <th class="text-center"><h6>Subjects</h6></th>
                                            <th class="text-center"><h6>Status</h6></th>
                                            <th class="text-center"><h6>Actions</h6></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($teachers as $teacher)
                                            <tr>
                                                <td class="text-center px-3">
                                                    <div class="d-flex justify-content-center align-items-center" style="height: 60px;">
                                                        @if ($teacher->photo)
                                                            <img
                                                                src="{{ asset('storage/' . $teacher->photo) }}"
                                                                alt="{{ $teacher->full_name }}"
                                                                class="rounded-circle"
                                                                style="width: 40px; height: 40px; object-fit: cover;"
                                                            >
                                                        @else
                                                            <img
                                                                src="{{ asset('assets/images/profile/profile-image.png') }}"
                                                                alt="default"
                                                                class="rounded-circle"
                                                                style="width: 40px; height: 40px;"
                                                            >
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="min-width px-2">
                                                    <p>{{ $teacher->full_name }}</p>
                                                </td>
                                                <td class="text-center px-3">
                                                    <p><strong>{{ $teacher->teacher_number }}</strong></p>
                                                </td>
                                                <td class="text-center px-3">
                                                    @if ($teacher->teacher_role)
                                                        @php
                                                            $subjects = array_filter(explode(',', $teacher->teacher_role));
                                                        @endphp
                                                        <p class="mb-0">{{ implode(', ', $subjects) }}</p>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td class="text-center px-3">
                                                    <p>{{ $teacher->employment_status ?? '—' }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <div class="action d-flex gap-2 justify-content-center">
                                                        <button
                                                            type="button"
                                                            class="text-info btn-modal"
                                                            title="Detail"
                                                            data-url="{{ route('teachers.show', $teacher) }}"
                                                            data-title="Detail Guru"
                                                        >
                                                            <i class="lni lni-eye"></i>
                                                        </button>
                                                        <button
                                                            type="button"
                                                            class="text-warning btn-modal"
                                                            title="Edit"
                                                            data-url="{{ route('teachers.edit', $teacher) }}"
                                                            data-title="Edit Guru"
                                                        >
                                                            <i class="lni lni-pencil"></i>
                                                        </button>
                                                        <button
                                                            type="button"
                                                            class="text-danger"
                                                            title="Hapus"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteConfirmModal"
                                                            data-form-id="delete-form-{{ $teacher->id }}"
                                                        >
                                                            <i class="lni lni-trash-can"></i>
                                                        </button>
                                                        <form
                                                            id="delete-form-{{ $teacher->id }}"
                                                            action="{{ route('teachers.destroy', $teacher) }}"
                                                            method="POST"
                                                            style="display: none;"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-20">
                                <p class="text-sm">Total: {{ $teachers->total() }} data</p>
                                <div class="pagination-wrapper">
                                    {{ $teachers->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== MODAL: POPUP UTAMA ========== -->
<div class="modal fade" id="popupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupModalLabel">Loading...</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- NOTIFIKASI SWEETALERT -->
                <div
                    id="modalSuccessAlert"
                    class="d-none text-center py-4 px-3"
                    style="opacity: 0; transform: translateY(10px); transition: opacity 0.3s ease, transform 0.3s ease;"
                >
                    <div class="mb-2">
                        <div
                            class="d-inline-flex align-items-center justify-content-center"
                            style="width: 36px; height: 36px; border-radius: 50%; background: #e8f4ff; color: #1e40af;"
                        >
                            <i class="lni lni-checkmark fs-5"></i>
                        </div>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Berhasil!</h6>
                    <p id="modalSuccessMessage" class="text-muted mb-2 small">Guru berhasil ditambahkan.</p>
                    <button
                        type="button"
                        class="btn btn-sm btn-primary px-3 py-1"
                        id="modalSuccessOkBtn"
                        style="font-size: 0.8125rem;"
                    >
                        OK
                    </button>
                </div>

                <div id="popupModalContent" style="min-height: 200px;">
                    Loading...
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary d-none" id="popupModalSubmit">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- ========== MODAL: KONFIRMASI HAPUS ========== -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-3 shadow-sm border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title text-dark">
                    <i class="lni lni-warning me-2 text-warning"></i> Hapus Data Guru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-3">Apakah Anda yakin ingin menghapus data guru ini?</p>
                <p class="text-muted small mb-0">
                    <i class="lni lni-info-circle me-1"></i> Tindakan ini tidak dapat dikembalikan.
                </p>
            </div>
            <div class="modal-footer p-3 border-top">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    <i class="lni lni-cross-circle me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-outline-danger px-4" id="confirmDeleteBtn">
                    <i class="lni lni-trash-can me-1"></i> Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========== INLINE JAVASCRIPT ========== -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof bootstrap === 'undefined') {
            console.error('Bootstrap JS not loaded. Please ensure bootstrap.bundle.js is included.');
            return;
        }

        const modalEl = document.getElementById('popupModal');
        const modal = new bootstrap.Modal(modalEl);
        const modalTitle = document.getElementById('popupModalLabel');
        const modalContent = document.getElementById('popupModalContent');
        const submitBtn = document.getElementById('popupModalSubmit');

        document.querySelectorAll('.btn-modal').forEach(button => {
            button.addEventListener('click', function () {
                const url = this.getAttribute('data-url');
                const title = this.getAttribute('data-title');

                modalTitle.textContent = title;
                modalContent.innerHTML = '<div class="text-center">Memuat data...</div>';
                submitBtn.classList.add('d-none');

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    let content = doc.querySelector('.container-fluid > div')?.outerHTML ||
                                  doc.querySelector('section')?.outerHTML ||
                                  html;

                    modalContent.innerHTML = content;

                    const form = modalContent.querySelector('form');
                    if (form) {
                        form.addEventListener('submit', function (e) {
                            e.preventDefault();

                            const formData = new FormData(form);
                            const url = form.action;
                            const isEdit = url.includes('/edit');

                            fetch(url, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    return response.json().catch(() => ({ success: true }));
                                } else {
                                    return response.text().then(htmlError => {
                                        modalContent.innerHTML = htmlError;
                                        const newForm = modalContent.querySelector('form');
                                        if (newForm) {
                                            newForm.addEventListener('submit', arguments.callee);
                                        }
                                        throw new Error('Validation failed');
                                    });
                                }
                            })
                            .then(data => {
                                if (data.success !== false) {
                                    const successAlert = document.getElementById('modalSuccessAlert');
                                    const successMsg = document.getElementById('modalSuccessMessage');
                                    const okBtn = document.getElementById('modalSuccessOkBtn');

                                    successMsg.textContent = data.message ||
                                        (isEdit ? 'Guru berhasil diperbarui.' : 'Guru berhasil ditambahkan.');

                                    modalContent.style.display = 'none';
                                    successAlert.classList.remove('d-none');

                                    // Trigger smooth entrance animation
                                    successAlert.offsetHeight; // force reflow
                                    successAlert.style.opacity = '1';
                                    successAlert.style.transform = 'translateY(0)';

                                    okBtn.onclick = function () {
                                        modal.hide();
                                        setTimeout(() => location.reload(), 300);
                                    };

                                    // Auto close after 3 seconds
                                    setTimeout(() => {
                                        modal.hide();
                                        setTimeout(() => location.reload(), 300);
                                    }, 3000);
                                }
                            })
                            .catch(err => {
                                if (err.message !== 'Validation failed') {
                                    alert('Terjadi kesalahan. Silakan coba lagi.');
                                }
                            });
                        });

                        if (form.action.includes('/edit')) {
                            submitBtn.classList.remove('d-none');
                            submitBtn.onclick = function () {
                                form.dispatchEvent(new Event('submit'));
                            };
                        }
                    }

                    modal.show();
                })
                .catch(() => {
                    modalContent.innerHTML = '<p class="text-danger">Gagal memuat data.</p>';
                    modal.show();
                });
            });
        });

        // === Konfirmasi Hapus ===
        let currentFormId = null;
        document.querySelectorAll('[data-form-id]').forEach(button => {
            button.addEventListener('click', function () {
                currentFormId = this.getAttribute('data-form-id');
            });
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
            if (currentFormId) {
                const form = document.getElementById(currentFormId);
                if (form) {
                    form.submit();
                }
            }
        });
    });
</script>
@endsection