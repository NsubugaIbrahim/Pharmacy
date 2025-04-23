<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;

class PharmacistController extends Controller
{
    // Show the medicine list on the dashboard
    public function index()
    {
        $drug = Drug::all(); // Fetch all medicines
        return view('pharmacist.dashboard', compact('drug'));
    }

    // Show edit form for a specific drug
    public function edit($id)
    {
        $drug = Drug::findOrFail($id);
        return view('pharmacist.edit', compact('drug')); // FIXED: 'pharmacist' → 'drug'
    }

    // Delete a specific drug
    public function destroy($id)
    {
        $drug = Drug::findOrFail($id);
        $drug->delete();

        return redirect()->route('pharmacist.index')->with('success', 'Drug deleted successfully.');
    }

    //Add stock 
    public function create()
{
    return view('pharmacist.add');
}

public function store(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'expiry_date' => 'required|date|after:today',
    ]);
    
    // Create the drug record
    // Assuming you have a Drug model
    Drug::create($validated);
    
    return redirect()->route('pharmacist.dashboard')->with('success', 'Drug added successfully');
}
}
