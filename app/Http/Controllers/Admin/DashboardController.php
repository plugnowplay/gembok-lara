<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_customers' => \App\Models\Customer::count(),
            'active_customers' => \App\Models\Customer::where('status', 'active')->count(),
            'total_packages' => \App\Models\Package::count(),
            'total_invoices' => \App\Models\Invoice::count(),
            'unpaid_invoices' => \App\Models\Invoice::where('status', 'unpaid')->count(),
            'total_revenue' => \App\Models\Invoice::where('status', 'paid')->sum('amount'),
            'pending_revenue' => \App\Models\Invoice::where('status', 'unpaid')->sum('amount'),
            'total_technicians' => \App\Models\Technician::count(),
            'total_collectors' => \App\Models\Collector::count(),
            'total_agents' => \App\Models\Agent::count(),
        ];

        $recent_invoices = \App\Models\Invoice::with(['customer', 'package'])
            ->latest()
            ->limit(10)
            ->get();

        $recent_customers = \App\Models\Customer::with('package')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_invoices', 'recent_customers'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
}
