<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drug;
use App\Models\Supplier;
use App\Models\StockEntry;

class DrugController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('role:admin,pharmacist');
    // }

    public function index()
    {
        $drugs = Drug::with('stockEntries')->get();
        return view('drugs.index', compact('drugs'));
    }

    public function edit($id)
    {
        //edit only drug name
        $drug = Drug::findOrFail($id);
        return view('drugs.edit', compact('drug'));
    }

    public function sell($id)
    {
        // Fetch the drug from the database by its ID
        $drug = Drug::findOrFail($id);
        
        // Logic to handle selling the drug, such as updating the stock or marking the sale
        // This is a placeholder, you should add your actual logic here
        
        return redirect()->route('drugs.index')->with('success', 'Drug sold successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $drug = Drug::findOrFail($id);
        $drug->update($request->all());

        return redirect()->route('drugs.index')->with('success', 'Drug updated successfully.');
    }


// Show all drugs with total stock


    // Form to stock a drug
    public function addDrug()
    {
        
        return view('drugs.add');
    }

    // Store stock entry
    public function storeDrug(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Drug::create([
            'name' => $request->name,
        ]);

        return redirect()->route('drugs.index')->with('success', 'Drug added successfully.');
    }

    // Show form to set selling price for entries without it
    public function setSellingPriceForm()
    {
        $entries = StockEntry::whereNull('selling_price')->with('drug', 'supplier')->get();
        return view('drugs.set_price', compact('entries'));
    }

    // Update selling price
    public function updateSellingPrice(Request $request, StockEntry $entry)
    {
        $request->validate([
            'selling_price' => 'required|numeric|min:0',
        ]);

        $entry->selling_price = $request->selling_price;
        $entry->save();

        return redirect()->back()->with('success', 'Selling price updated successfully.');
    }

    public function destroy($id)
    {
        $drug = Drug::findOrFail($id);
        $drug->delete();

        return redirect()->route('drugs.index')->with('success', 'Drug deleted successfully.');
    }
    public function fetchDrugs(Request $request)
    {
        $query = $request->input('query');

        // Find drugs that contain the query (case insensitive)
        $drugs = Drug::where('name', 'LIKE', '%' . $query . '%')->get();

        return response()->json($drugs);
    }

}
