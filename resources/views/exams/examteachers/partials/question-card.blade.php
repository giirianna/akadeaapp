<div class="question-card" data-id="{{ $loopIndex }}">
    <div class="question-header">
        <div class="question-number">Soal {{ $loopIndex + 1 }}</div>
        <select class="question-type-select" name="questions[{{ $loopIndex }}][type]" onchange="changeType(this, {{ $loopIndex }})">
            <option value="multiple_choice" {{ $q->type === 'multiple_choice' ? 'selected' : '' }}>Pilihan Ganda</option>
            <option value="checkbox" {{ $q->type === 'checkbox' ? 'selected' : '' }}>Kotak Centang</option>
            <option value="dropdown" {{ $q->type === 'dropdown' ? 'selected' : '' }}>Dropdown</option>
            <option value="essay" {{ $q->type === 'essay' ? 'selected' : '' }}>Esai</option>
        </select>
    </div>

    <input type="text" name="questions[{{ $loopIndex }}][question_text]" class="question-text-input"
           value="{{ old("questions.$loopIndex.question_text", $q->question_text) }}" required>

    {{-- Gambar Soal --}}
    <div class="image-upload-container">
        <label for="image_{{ $loopIndex }}">Gambar Soal (Opsional)</label>
        @if($q->image)
            <div class="mb-2">
                <img src="{{ Storage::url($q->image) }}" alt="Gambar Soal" style="max-height: 120px; width: auto; border-radius: 6px; border: 1px solid #e0e0e0;">
            </div>
        @endif
        <input type="file" id="image_{{ $loopIndex }}" name="questions[{{ $loopIndex }}][image]" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this, {{ $loopIndex }})">
        <div class="image-preview" id="preview_{{ $loopIndex }}" style="display: none;">
            <img src="" alt="Preview">
        </div>
    </div>

    {{-- Hidden input untuk tipe (diperlukan jika JS dimatikan) --}}
    <input type="hidden" class="question-type-hidden" value="{{ $q->type }}">

    {{-- Konten spesifik tipe soal --}}
    <div class="type-specific-container" id="type-{{ $loopIndex }}">
        @if($q->type === 'essay')
            <textarea name="questions[{{ $loopIndex }}][essay_placeholder]" class="form-control" rows="2" placeholder="Petunjuk jawaban (opsional)">{{ old("questions.$loopIndex.essay_placeholder", $q->essay_placeholder) }}</textarea>

        @elseif(in_array($q->type, ['multiple_choice', 'checkbox']))
            <div class="options-list" id="options-{{ $loopIndex }}">
                @foreach($q->options as $optIndex => $option)
                    <div class="option-row">
                        <input type="{{ $q->type === 'checkbox' ? 'checkbox' : 'radio' }}" disabled>
                        <input type="text" name="questions[{{ $loopIndex }}][options][]" class="form-control" value="{{ old("questions.$loopIndex.options.$optIndex", $option) }}" required>
                        <button type="button" class="remove-option" onclick="removeOption(this, {{ $loopIndex }})">×</button>
                    </div>
                @endforeach
            </div>
            <div class="add-option-link" onclick="addOption({{ $loopIndex }})">+ Tambah opsi</div>
            @if($q->type === 'multiple_choice')
                <span class="text-muted mx-2">•</span>
                <div class="add-other-link" onclick="addOtherOption({{ $loopIndex }})">Tambah "Lainnya"</div>
            @endif

            {{-- Jawaban Benar --}}
            <div class="correct-answer-section">
                <label class="correct-answer-label">Jawaban yang Benar:</label>
                <div class="correct-answer-options" id="correct-answer-{{ $loopIndex }}">
                    @if($q->type === 'multiple_choice')
                        <select name="questions[{{ $loopIndex }}][correct_answer][]" class="form-control">
                            @foreach($q->options as $optIndex => $option)
                                <option value="{{ $optIndex }}" {{ (old("questions.$loopIndex.correct_answer") ?? $q->correct_answer) == $optIndex ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    @else {{-- checkbox --}}
                        @foreach($q->options as $optIndex => $option)
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" name="questions[{{ $loopIndex }}][correct_answer][]" value="{{ $optIndex }}"
                                    {{ (is_array(old("questions.$loopIndex.correct_answer")) && in_array($optIndex, old("questions.$loopIndex.correct_answer"))) ||
                                       (is_array($q->correct_answer) && in_array($optIndex, $q->correct_answer)) ? 'checked' : '' }}
                                    id="correct_{{ $loopIndex }}_{{ $optIndex }}">
                                <label class="form-check-label" for="correct_{{ $loopIndex }}_{{ $optIndex }}">{{ $option }}</label>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        @elseif($q->type === 'dropdown')
            <div class="options-list" id="options-{{ $loopIndex }}">
                @foreach($q->options as $optIndex => $option)
                    <div class="option-row">
                        <input type="text" name="questions[{{ $loopIndex }}][options][]" class="form-control" value="{{ old("questions.$loopIndex.options.$optIndex", $option) }}" required>
                        <button type="button" class="remove-option" onclick="removeOption(this, {{ $loopIndex }})">×</button>
                    </div>
                @endforeach
            </div>
            <div class="add-option-link" onclick="addOption({{ $loopIndex }})">+ Tambah opsi</div>

            {{-- Jawaban Benar --}}
            <div class="correct-answer-section">
                <label class="correct-answer-label">Jawaban yang Benar:</label>
                <select name="questions[{{ $loopIndex }}][correct_answer][]" class="form-control">
                    @foreach($q->options as $optIndex => $option)
                        <option value="{{ $optIndex }}" {{ (old("questions.$loopIndex.correct_answer") ?? $q->correct_answer) == $optIndex ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>

    {{-- Wajib diisi --}}
    <div class="required-toggle">
        <label class="switch">
            <input type="checkbox" name="questions[{{ $loopIndex }}][required]" value="1"
                {{ old("questions.$loopIndex.required", $q->required) ? 'checked' : '' }}>
            <span class="slider"></span>
        </label>
        <label>Wajib diisi</label>
    </div>
</div>