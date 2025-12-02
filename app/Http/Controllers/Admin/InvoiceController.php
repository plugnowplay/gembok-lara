<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Invoice::with(['customer', 'package']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $invoices = $query->latest()->paginate(20);
        $customers = \App\Models\Customer::orderBy('name')->get();

        $stats = [
            'total' => \App\Models\Invoice::count(),
            'paid' => \App\Models\Invoice::where('status', 'paid')->count(),
            'unpaid' => \App\Models\Invoice::where('status', 'unpaid')->count(),
            'total_revenue' => \App\Models\Invoice::where('status', 'paid')->sum('amount'),
            'pending_revenue' => \App\Models\Invoice::where('status', 'unpaid')->sum('amount'),
        ];

        return view('admin.invoices.index', compact('invoices', 'customers', 'stats'));
    }

    public function create()
    {
        $customers = \App\Models\Customer::where('status', 'active')->orderBy('name')->get();
        $packages = \App\Models\Package::where('is_active', true)->get();
        return view('admin.invoices.create', compact('customers', 'packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'package_id' => 'nullable|exists:packages,id',
            'amount' => 'required|integer|min:0',
            'tax_amount' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'invoice_type' => 'required|in:monthly,installation,voucher,other',
        ]);

        // Generate invoice number
        $lastInvoice = \App\Models\Invoice::latest()->first();
        $number = $lastInvoice ? (int)substr($lastInvoice->invoice_number, 4) + 1 : 1;
        $validated['invoice_number'] = 'INV-' . str_pad($number, 6, '0', STR_PAD_LEFT);
        $validated['status'] = 'unpaid';
        $validated['tax_amount'] = $validated['tax_amount'] ?? 0;

        \App\Models\Invoice::create($validated);

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice created successfully!');
    }

    public function show(\App\Models\Invoice $invoice)
    {
        $invoice->load(['customer', 'package']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(\App\Models\Invoice $invoice)
    {
        $customers = \App\Models\Customer::orderBy('name')->get();
        $packages = \App\Models\Package::where('is_active', true)->get();
        return view('admin.invoices.edit', compact('invoice', 'customers', 'packages'));
    }

    public function update(Request $request, \App\Models\Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'package_id' => 'nullable|exists:packages,id',
            'amount' => 'required|integer|min:0',
            'tax_amount' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'invoice_type' => 'required|in:monthly,installation,voucher,other',
        ]);

        $invoice->update($validated);

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice updated successfully!');
    }

    public function destroy(\App\Models\Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return redirect()->route('admin.invoices.index')
                ->with('error', 'Cannot delete paid invoice!');
        }

        $invoice->delete();

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice deleted successfully!');
    }

    public function pay(\App\Models\Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return redirect()->back()
                ->with('error', 'Invoice already paid!');
        }

        $invoice->update([
            'status' => 'paid',
            'paid_date' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Invoice marked as paid!');
    }

    public function print(\App\Models\Invoice $invoice)
    {
        $invoice->load(['customer', 'package']);
        $company = [
            'name' => \App\Models\AppSetting::where('key', 'company_name')->value('value') ?? 'GEMBOK LARA',
            'phone' => \App\Models\AppSetting::where('key', 'company_phone')->value('value') ?? '-',
            'email' => \App\Models\AppSetting::where('key', 'company_email')->value('value') ?? '-',
            'address' => \App\Models\AppSetting::where('key', 'company_address')->value('value') ?? '-',
        ];
        
        return view('admin.invoices.print', compact('invoice', 'company'));
    }
}
