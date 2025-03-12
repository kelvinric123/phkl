<?php

namespace App\Http\Controllers;

use App\Models\SurgicalProcedure;
use Illuminate\Http\Request;

class SurgicalProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $procedures = SurgicalProcedure::orderBy('name')->paginate(10);
        return view('surgical-procedures.index', compact('procedures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('surgical-procedures.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'type' => 'required|string|in:Surgical,Minor',
            'description' => 'nullable|string',
            'charge' => 'required|numeric|min:0',
            'anaesthetist_percentage' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean'
        ]);

        // Set default anaesthetist percentage for Surgical procedures if not provided
        if ($validatedData['type'] === 'Surgical' && !isset($validatedData['anaesthetist_percentage'])) {
            $validatedData['anaesthetist_percentage'] = 40.00;
        }

        SurgicalProcedure::create($validatedData);

        return redirect()->route('surgical-procedures.index')
            ->with('success', 'Procedure created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SurgicalProcedure $surgicalProcedure)
    {
        return view('surgical-procedures.show', compact('surgicalProcedure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SurgicalProcedure $surgicalProcedure)
    {
        return view('surgical-procedures.edit', compact('surgicalProcedure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SurgicalProcedure $surgicalProcedure)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'type' => 'required|string|in:Surgical,Minor',
            'description' => 'nullable|string',
            'charge' => 'required|numeric|min:0',
            'anaesthetist_percentage' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean'
        ]);

        // Set default anaesthetist percentage for Surgical procedures if not provided
        if ($validatedData['type'] === 'Surgical' && !isset($validatedData['anaesthetist_percentage'])) {
            $validatedData['anaesthetist_percentage'] = 40.00;
        }

        $surgicalProcedure->update($validatedData);

        return redirect()->route('surgical-procedures.index')
            ->with('success', 'Procedure updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SurgicalProcedure $surgicalProcedure)
    {
        $surgicalProcedure->delete();

        return redirect()->route('surgical-procedures.index')
            ->with('success', 'Procedure deleted successfully.');
    }

    /**
     * Search for procedures by text query.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type'); // Optional type filter
        
        if (empty($query)) {
            return response()->json([]);
        }
        
        // Start with base query
        $proceduresQuery = SurgicalProcedure::where('is_active', true);
        
        // Apply type filter if provided
        if ($type) {
            $proceduresQuery->where('type', $type);
        }
        
        // Apply text search conditions
        $proceduresQuery->where(function($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%")
              ->orWhere('code', 'LIKE', "%{$query}%");
        });
        
        // Get the results
        $procedures = $proceduresQuery->limit(10)
            ->get(['id', 'name', 'code', 'description', 'type', 'charge', 'anaesthetist_percentage']);
        
        // Make sure charge is properly formatted as a numeric value
        $procedures = $procedures->map(function($procedure) {
            // Convert charge to a float to ensure it's numeric
            $procedure->charge = (float)$procedure->charge;
            $procedure->anaesthetist_percentage = (float)$procedure->anaesthetist_percentage;
            return $procedure;
        });
        
        // Add some debugging information
        \Log::info('Procedure Search', [
            'query' => $query,
            'type' => $type,
            'sql' => $proceduresQuery->toSql(),
            'bindings' => $proceduresQuery->getBindings(),
            'results_count' => $procedures->count()
        ]);
            
        return response()->json($procedures);
    }
}
