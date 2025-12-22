<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\UploadedFile;

class QuestionImportService
{
    /**
     * Parse questions from Excel/Word file
     *
     * Expected columns:
     * A: Question Type (multiple_choice or essay)
     * B: Question Text
     * C: Option A
     * D: Option B
     * E: Option C
     * F: Option D
     * G: Option E
     * H: Correct Answer (A, B, C, D, E for MC; leave blank for essay)
     */
    public function parseFile(UploadedFile $file): array
    {
        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $questions = [];
            $errors = [];

            // Skip header row (row 0)
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];

                // Skip empty rows
                if (empty($row[1])) { // Check if question text is empty
                    continue;
                }

                $question = $this->parseRow($row, $i + 1);

                if (isset($question['error'])) {
                    $errors[] = $question['error'];
                } else {
                    $questions[] = $question;
                }
            }

            return [
                'success' => true,
                'questions' => $questions,
                'errors' => $errors,
                'count' => count($questions)
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error parsing file: ' . $e->getMessage(),
                'errors' => []
            ];
        }
    }

    /**
     * Parse a single row from the spreadsheet
     */
    private function parseRow(array $row, int $rowNumber): array
    {
        $type = strtolower(trim($row[0] ?? ''));
        $questionText = trim($row[1] ?? '');

        // Validate question type
        if (!in_array($type, ['multiple_choice', 'essay'])) {
            return [
                'error' => "Row {$rowNumber}: Invalid question type '{$type}'. Must be 'multiple_choice' or 'essay'."
            ];
        }

        // Validate question text
        if (empty($questionText)) {
            return [
                'error' => "Row {$rowNumber}: Question text is required."
            ];
        }

        if ($type === 'essay') {
            return [
                'type' => 'essay',
                'question_text' => $questionText,
                'options' => null,
                'correct_answer' => null
            ];
        }

        // Multiple choice validation
        $optionA = trim($row[2] ?? '');
        $optionB = trim($row[3] ?? '');
        $optionC = trim($row[4] ?? '');
        $optionD = trim($row[5] ?? '');
        $optionE = trim($row[6] ?? '');

        $options = array_filter([
            $optionA,
            $optionB,
            $optionC,
            $optionD,
            $optionE
        ]);

        if (count($options) < 2) {
            return [
                'error' => "Row {$rowNumber}: Multiple choice questions must have at least 2 options."
            ];
        }

        $correctAnswer = strtoupper(trim($row[7] ?? ''));
        $answerIndex = $this->getAnswerIndex($correctAnswer);

        if ($answerIndex === null || $answerIndex >= count($options)) {
            return [
                'error' => "Row {$rowNumber}: Invalid correct answer '{$correctAnswer}'. Must be one of: " . implode(', ', array_slice(['A', 'B', 'C', 'D', 'E'], 0, count($options)))
            ];
        }

        return [
            'type' => 'multiple_choice',
            'question_text' => $questionText,
            'options' => array_values($options),
            'correct_answer' => [$answerIndex] // Store as array for consistency
        ];
    }

    /**
     * Convert letter (A, B, C, D, E) to array index (0, 1, 2, 3, 4)
     */
    private function getAnswerIndex(string $letter): ?int
    {
        $letter = strtoupper($letter);
        $map = ['A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4];

        return $map[$letter] ?? null;
    }
}
