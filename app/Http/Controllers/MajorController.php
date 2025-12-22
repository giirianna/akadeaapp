<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if user is admin
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized access');
        }

        $majors = Major::orderBy('name')->paginate(10);
        return view('majors.index', compact('majors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Check if user is admin
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized access');
        }

        // Get arrays of names, codes, and descriptions
        $names = $request->input('names', []);
        $codes = $request->input('codes', []);
        $descriptions = $request->input('descriptions', []);

        // Validate that we have at least one major
        if (empty($names)) {
            return redirect()->route('majors.index')
                ->with('error', __('At least one major is required'));
        }

        $createdCount = 0;
        $errors = [];

        // Process each major
        foreach ($names as $index => $name) {
            $name = trim($name);
            if (empty($name)) {
                continue; // Skip empty names
            }

            try {
                $code = isset($codes[$index]) ? trim($codes[$index]) : null;
                $description = isset($descriptions[$index]) ? trim($descriptions[$index]) : null;

                // Check for duplicate name
                if (Major::where('name', $name)->exists()) {
                    $errors[] = "Major '{$name}' already exists.";
                    continue;
                }

                // Check for duplicate code
                if ($code && Major::where('code', $code)->exists()) {
                    $errors[] = "Code '{$code}' is already in use.";
                    continue;
                }

                Major::create([
                    'name' => $name,
                    'code' => $code,
                    'description' => $description,
                ]);

                $createdCount++;
            } catch (\Exception $e) {
                $errors[] = "Error creating major: " . $e->getMessage();
            }
        }

        // Prepare response message
        if ($createdCount > 0) {
            $message = $createdCount . ' major(s) added successfully';
            if (!empty($errors)) {
                $message .= '. Errors: ' . implode('; ', $errors);
            }
            return redirect()->route('majors.index')
                ->with('success', $message);
        } elseif (!empty($errors)) {
            return redirect()->route('majors.index')
                ->with('error', implode('; ', $errors));
        } else {
            return redirect()->route('majors.index')
                ->with('error', 'No valid majors were provided');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Major $major): RedirectResponse
    {
        // Check if user is admin
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:majors,name,' . $major->id,
            'code' => 'nullable|string|max:50|unique:majors,code,' . $major->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $major->update($validated);

        return redirect()->route('majors.index')
            ->with('success', __('Major updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Major $major): RedirectResponse
    {
        // Check if user is admin
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized access');
        }

        $major->delete();

        return redirect()->route('majors.index')
            ->with('success', __('Major deleted successfully'));
    }
}
