@extends('layouts.app')

@section('title', 'Buat Ujian')
@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary fw-bold">Buat Ujian Baru</h2>
        </div>

        <!-- Tambahkan enctype untuk upload file -->
        <form action="{{ route('exams.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Info Ujian -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-muted">Judul Ujian</label>
                            <input type="text" name="title" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-medium text-muted">Durasi (menit)</label>
                            <input type="number" name="duration_minutes" class="form-control" min="1" value="60" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-medium text-muted">Status</label>
                            <div class="badge bg-primary-subtle text-primary fw-medium">Draft</div>
                        </div>
                    </div>

                    <!-- Kelas & Mapel -->
                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-muted">Kelas</label>
                            <select name="class" class="form-control form-select-lg" required>
                                <option value="">Pilih Kelas</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-muted">Mata Pelajaran</label>
                            <select name="subject" class="form-control form-select-lg" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->subject_name }}">{{ $subject->subject_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-muted">Waktu Mulai</label>
                            <input type="datetime-local" name="start_time" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-muted">Waktu Berakhir</label>
                            <input type="datetime-local" name="end_time" class="form-control" required>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label fw-medium text-muted">Deskripsi (Opsional)</label>
                        <textarea name="description" class="form-control" rows="2"
                            placeholder="Tambahkan instruksi atau catatan untuk siswa..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Soal -->
            <div id="questions-container" class="mb-5"></div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <button type="button"
                    class="btn btn-outline-primary d-flex align-items-center justify-content-center gap-2 px-4 py-2 rounded-pill shadow-sm"
                    style="min-width: 180px; font-weight: 500;" onclick="addQuestion()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"
                        stroke="none">
                        <path d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Soal
                </button>
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill"
                    style="min-width: 160px; font-weight: 500;">
                    Simpan Ujian
                </button>
            </div>
        </form>
    </div>

    <style>
        :root {
            --primary: #1a73e8;
            --primary-light: #e8f0fe;
            --border: #e0e0e0;
            --text: #202124;
            --text-light: #5f6368;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: #fafafa;
        }

        .card {
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-size: 0.9rem;
        }

        .question-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            transition: box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .question-card:hover {
            border-color: #c6dafc;
            box-shadow: 0 2px 8px rgba(26, 115, 232, 0.1);
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .question-number {
            font-weight: 600;
            color: var(--text);
            font-size: 1.1rem;
        }

        .question-type-select {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.95rem;
            background: white;
            color: var(--text);
            min-width: 160px;
        }

        .question-type-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
        }

        .question-text-input {
            font-size: 1.1rem;
            border: none;
            padding: 0;
            margin-bottom: 16px;
            font-weight: 500;
            color: var(--text);
            width: 100%;
        }

        .question-text-input:focus {
            outline: none;
        }

        .image-upload-container {
            margin-top: 12px;
        }

        .image-upload-container label {
            display: block;
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 6px;
        }

        .image-upload-container .form-control {
            font-size: 0.9rem;
        }

        .image-preview {
            margin-top: 8px;
            max-width: 200px;
            max-height: 150px;
            display: none;
        }

        .image-preview img {
            width: 100%;
            border-radius: 6px;
            border: 1px solid var(--border);
        }

        .option-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 6px 0;
        }

        .option-row input[type="text"] {
            flex: 1;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 0.95rem;
            margin: 0 8px;
        }

        .option-row input[type="radio"],
        .option-row input[type="checkbox"] {
            margin-right: 8px;
            transform: scale(1.2);
        }

        .remove-option {
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 1.2rem;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
        }

        .remove-option:hover {
            background: #f1f3f4;
            color: #d93025;
        }

        .add-option-link,
        .add-other-link {
            display: inline-block;
            color: var(--primary);
            font-weight: 500;
            font-size: 0.95rem;
            cursor: pointer;
            margin-top: 6px;
            transition: opacity 0.2s;
        }

        .add-option-link:hover,
        .add-other-link:hover {
            opacity: 0.8;
        }

        .correct-answer-section {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }

        .correct-answer-label {
            font-size: 0.95rem;
            color: var(--text-light);
            margin-bottom: 8px;
            display: block;
        }

        .correct-answer-options {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .correct-answer-options .form-check {
            margin-bottom: 0;
        }

        .correct-answer-options label {
            font-size: 0.95rem;
            color: var(--text);
        }

        .required-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }

        .required-toggle label {
            font-size: 0.95rem;
            color: var(--text-light);
            margin: 0;
            cursor: pointer;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 42px;
            height: 22px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.3s;
            border-radius: 11px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: 0.3s;
            border-radius: 50%;
        }

        .switch input:checked+.slider {
            background-color: var(--primary);
        }

        .switch input:checked+.slider:before {
            transform: translateX(20px);
        }

        @media (max-width: 768px) {
            .question-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .question-type-select {
                width: 100%;
            }

            .d-flex {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 12px !important;
            }

            .btn {
                min-width: auto !important;
                width: 100%;
            }
        }
    </style>

    <script>
        let questionIndex = 0;

        function addQuestion() {
            const container = document.getElementById('questions-container');
            const qId = questionIndex++;

            const html = `
            <div class="question-card" data-id="${qId}">
                <div class="question-header">
                    <div class="question-number">Soal ${qId + 1}</div>
                    <select class="question-type-select" onchange="changeType(this, ${qId})">
                        <option value="multiple_choice">Pilihan Ganda</option>
                        <option value="checkbox">Kotak Centang</option>
                        <option value="dropdown">Dropdown</option>
                        <option value="essay">Esai</option>
                    </select>
                </div>

                <input type="text" name="questions[${qId}][question_text]" class="question-text-input" placeholder="Ketik pertanyaan di sini..." required>

                <!-- Upload Gambar Soal -->
                <div class="image-upload-container">
                    <label for="image_${qId}">Gambar Soal (Opsional)</label>
                    <input type="file" id="image_${qId}" name="questions[${qId}][image]" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this, ${qId})">
                    <div class="image-preview" id="preview_${qId}">
                        <img src="" alt="Preview">
                    </div>
                </div>

                <div class="type-specific-container" id="type-${qId}"></div>

                <input type="hidden" name="questions[${qId}][type]" class="question-type-hidden" value="multiple_choice">

                <div class="required-toggle">
                    <label class="switch">
                        <input type="checkbox" name="questions[${qId}][required]" value="1" checked>
                        <span class="slider"></span>
                    </label>
                    <label>Wajib diisi</label>
                </div>
            </div>`;

            container.insertAdjacentHTML('beforeend', html);
            changeType(document.querySelector(`.question-type-select`), qId);
        }

        function previewImage(input, idx) {
            const preview = document.getElementById(`preview_${idx}`);
            const img = preview.querySelector('img');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    img.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }

        function changeType(select, idx) {
            const type = select.value;
            const container = document.getElementById(`type-${idx}`);
            container.innerHTML = '';

            document.querySelector(`.question-card[data-id="${idx}"] .question-type-hidden`).value = type;

            if (type === 'essay') {
                container.innerHTML = `
                <textarea name="questions[${idx}][essay_placeholder]" class="form-control" rows="2" placeholder="Petunjuk jawaban (opsional)"></textarea>`;
            } else if (['multiple_choice', 'checkbox'].includes(type)) {
                const isCheckbox = type === 'checkbox';
                let optionsHtml = '';
                for (let i = 0; i < 2; i++) {
                    optionsHtml += `
                    <div class="option-row">
                        <input type="${isCheckbox ? 'checkbox' : 'radio'}" disabled>
                        <input type="text" name="questions[${idx}][options][]" class="form-control" placeholder="Opsi ${i + 1}" required>
                        <button type="button" class="remove-option" onclick="removeOption(this, ${idx})">×</button>
                    </div>`;
                }

                container.innerHTML = `
                <div class="options-list" id="options-${idx}">
                    ${optionsHtml}
                </div>
                <div class="add-option-link" onclick="addOption(${idx})">+ Tambah opsi</div>
                <span class="text-muted mx-2">•</span>
                <div class="add-other-link" onclick="addOtherOption(${idx})">Tambah "Lainnya"</div>

                <div class="correct-answer-section">
                    <label class="correct-answer-label">Jawaban yang Benar:</label>
                    <div class="correct-answer-options" id="correct-answer-${idx}"></div>
                </div>`;

                renderCorrectAnswer(idx, type);
            } else if (type === 'dropdown') {
                let optionsHtml = '';
                for (let i = 0; i < 2; i++) {
                    optionsHtml += `
                    <div class="option-row">
                        <input type="text" name="questions[${idx}][options][]" class="form-control" placeholder="Opsi ${i + 1}" required>
                        <button type="button" class="remove-option" onclick="removeOption(this, ${idx})">×</button>
                    </div>`;
                }

                container.innerHTML = `
                <div class="options-list" id="options-${idx}">
                    ${optionsHtml}
                </div>
                <div class="add-option-link" onclick="addOption(${idx})">+ Tambah opsi</div>

                <div class="correct-answer-section">
                    <label class="correct-answer-label">Jawaban yang Benar:</label>
                    <select name="questions[${idx}][correct_answer][]" class="form-control" id="correct-select-${idx}">
                    </select>
                </div>`;
                renderCorrectAnswer(idx, type);
            }
        }

        function renderCorrectAnswer(idx, type) {
            const optionsList = document.getElementById(`options-${idx}`);
            if (!optionsList) return;

            const options = Array.from(optionsList.querySelectorAll('input[type="text"]'));
            const correctContainer = document.getElementById(`correct-answer-${idx}`) || document.getElementById(`correct-select-${idx}`);

            if (!correctContainer) return;

            if (type === 'multiple_choice' || type === 'dropdown') {
                let selectHtml = '<select name="questions[' + idx + '][correct_answer][]" class="form-control">';
                options.forEach((opt, i) => {
                    const value = opt.value.trim() || `Opsi ${i + 1}`;
                    selectHtml += `<option value="${i}">${value}</option>`;
                });
                selectHtml += '</select>';

                if (correctContainer.tagName === 'SELECT') {
                    correctContainer.outerHTML = selectHtml;
                } else {
                    correctContainer.innerHTML = selectHtml;
                }
            } else if (type === 'checkbox') {
                let checkboxes = '';
                options.forEach((opt, i) => {
                    const value = opt.value.trim() || `Opsi ${i + 1}`;
                    checkboxes += `
                    <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" name="questions[${idx}][correct_answer][]" value="${i}" id="correct_${idx}_${i}">
                        <label class="form-check-label" for="correct_${idx}_${i}">${value}</label>
                    </div>`;
                });
                correctContainer.innerHTML = checkboxes;
            }
        }

        function addOption(idx) {
            const container = document.getElementById(`options-${idx}`);
            const count = container.children.length + 1;
            const questionType = document.querySelector(`.question-card[data-id="${idx}"] .question-type-select`).value;
            const isChoice = ['multiple_choice', 'checkbox'].includes(questionType);

            const el = document.createElement('div');
            el.className = 'option-row';
            el.innerHTML = `
            ${isChoice ? `<input type="${questionType === 'checkbox' ? 'checkbox' : 'radio'}" disabled>` : ''}
            <input type="text" name="questions[${idx}][options][]" class="form-control" placeholder="Opsi ${count}" required>
            <button type="button" class="remove-option" onclick="removeOption(this, ${idx})">×</button>`;
            container.appendChild(el);

            renderCorrectAnswer(idx, questionType);
        }

        function addOtherOption(idx) {
            const container = document.getElementById(`options-${idx}`);
            const questionType = document.querySelector(`.question-card[data-id="${idx}"] .question-type-select`).value;
            const isChoice = ['multiple_choice', 'checkbox'].includes(questionType);

            const el = document.createElement('div');
            el.className = 'option-row';
            el.innerHTML = `
            ${isChoice ? `<input type="${questionType === 'checkbox' ? 'checkbox' : 'radio'}" disabled>` : ''}
            <input type="text" name="questions[${idx}][options][]" class="form-control" value="Lainnya" readonly>
            <button type="button" class="remove-option" onclick="removeOption(this, ${idx})">×</button>`;
            container.appendChild(el);

            renderCorrectAnswer(idx, questionType);
        }

        function removeOption(btn, idx) {
            const optionRows = btn.closest('.options-list').querySelectorAll('.option-row');
            if (optionRows.length > 1) {
                btn.closest('.option-row').remove();
                const type = document.querySelector(`.question-card[data-id="${idx}"] .question-type-select`).value;
                renderCorrectAnswer(idx, type);
            } else {
                alert('Minimal harus ada 1 opsi.');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            addQuestion();
        });
    </script>
@endsection