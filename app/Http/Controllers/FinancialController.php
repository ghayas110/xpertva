<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Financial;
use App\Models\Client;

class FinancialController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Only Accounts, Admin, and HR can access financials
        if (!in_array($user->role, ['accounts', 'super_admin', 'hr'])) {
            abort(403, 'Unauthorized access to Financials.');
        }

        $region = $user->region; // USA or Pakistan (null for Admin/HR)
        
        // Fetch clients for dropdowns
        $clients = Client::all();

        // Admin/HR see everything
        if (in_array($user->role, ['super_admin', 'hr'])) {
            $financials = Financial::with('client')->latest()->get();
        } 
        // Region specific view
        else {
            $financials = Financial::with('client')
                ->where('region_tag', $region)
                ->orWhere('category', 'Internal Transfer') // Both regions might need to see transfers
                ->latest()
                ->get();
        }

        return view('financials.index', compact('financials', 'region', 'clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'category' => 'required|string', // Invoicing, Internal Transfer, Payroll, Expense Log
        ]);

        $user = Auth::user();

        // Pakistan accounts are read-only for Invoices
        if ($user->region === 'Pakistan' && $request->category === 'Invoicing') {
            abort(403, 'Pakistan Accounts cannot create invoices.');
        }

        Financial::create([
            'client_id' => $request->client_id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'category' => $request->category,
            'region_tag' => $user->region ?? 'Global',
        ]);

        return back()->with('success', 'Financial record added successfully.');
    }

    public function update(Request $request, Financial $financial)
    {
        $user = Auth::user();

        // Only Accounts, Admin, and HR can access financials
        if (!in_array($user->role, ['accounts', 'super_admin', 'hr'])) {
            abort(403, 'Unauthorized access to Financials.');
        }

        $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'category' => 'required|string',
        ]);

        // Pakistan accounts are read-only for Invoices
        if ($user->region === 'Pakistan' && $request->category === 'Invoicing') {
            abort(403, 'Pakistan Accounts cannot modify invoices.');
        }

        $financial->update([
            'client_id' => $request->client_id,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'category' => $request->category,
        ]);

        return back()->with('success', 'Financial record updated successfully.');
    }

    public function destroy(Financial $financial)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['accounts', 'super_admin', 'hr'])) {
            abort(403, 'Unauthorized access to Financials.');
        }

        // Pakistan accounts are read-only for Invoices
        if ($user->region === 'Pakistan' && $financial->category === 'Invoicing') {
            abort(403, 'Pakistan Accounts cannot delete invoices.');
        }

        $financial->delete();

        return back()->with('success', 'Financial record deleted successfully.');
    }
}
