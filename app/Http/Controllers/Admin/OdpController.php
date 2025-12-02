<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OdpController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Odp::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('location_name', 'like', "%{$search}%");
            });
        }

        $odps = $query->latest()->paginate(20);

        return view('admin.network.odps.index', compact('odps'));
    }

    public function create()
    {
        return view('admin.network.odps.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:odps,code',
            'location_name' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,full',
        ]);

        $validated['available_ports'] = $validated['capacity'];

        \App\Models\Odp::create($validated);

        return redirect()->route('admin.network.odps.index')
            ->with('success', 'ODP created successfully!');
    }

    public function show(\App\Models\Odp $odp)
    {
        return view('admin.network.odps.show', compact('odp'));
    }

    public function edit(\App\Models\Odp $odp)
    {
        return view('admin.network.odps.edit', compact('odp'));
    }

    public function update(Request $request, \App\Models\Odp $odp)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:odps,code,' . $odp->id,
            'location_name' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,full',
        ]);

        // Adjust available ports if capacity changes
        if ($validated['capacity'] != $odp->capacity) {
            $diff = $validated['capacity'] - $odp->capacity;
            $validated['available_ports'] = $odp->available_ports + $diff;
        }

        $odp->update($validated);

        return redirect()->route('admin.network.odps.index')
            ->with('success', 'ODP updated successfully!');
    }

    public function destroy(\App\Models\Odp $odp)
    {
        $odp->delete();

        return redirect()->route('admin.network.odps.index')
            ->with('success', 'ODP deleted successfully!');
    }

    public function map()
    {
        $odps = \App\Models\Odp::all();
        return view('admin.network.map', compact('odps'));
    }
}
