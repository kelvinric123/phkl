<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use App\Models\Specialty;
use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consultants = Consultant::with('specialty')->latest()->paginate(10);
        return view('consultants.index', compact('consultants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specialties = Specialty::orderBy('name')->get();
        return view('consultants.create', compact('specialties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:20',
            'name' => 'required|string|max:255',
            'specialty_id' => 'required|exists:specialties,id',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'hourly_rate' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        Consultant::create($validated);

        return redirect()->route('consultants.index')
            ->with('success', 'Consultant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultant $consultant)
    {
        return view('consultants.show', compact('consultant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consultant $consultant)
    {
        $specialties = Specialty::orderBy('name')->get();
        return view('consultants.edit', compact('consultant', 'specialties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consultant $consultant)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:20',
            'name' => 'required|string|max:255',
            'specialty_id' => 'required|exists:specialties,id',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'hourly_rate' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $consultant->update($validated);

        return redirect()->route('consultants.index')
            ->with('success', 'Consultant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultant $consultant)
    {
        $consultant->delete();

        return redirect()->route('consultants.index')
            ->with('success', 'Consultant deleted successfully.');
    }
}
