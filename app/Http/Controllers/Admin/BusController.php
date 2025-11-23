<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::orderBy('plate_number', 'asc')->paginate(20);
        return view('admin.vehicles.index', compact('buses'));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:20|unique:buses',
            'bus_type' => 'required|string|max:100',
            'total_seats' => 'required|integer|min:1|max:100',
            'rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,inactive',
            'facilities' => 'nullable|string',
            'manufacture_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        Bus::create($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Bus berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $bus = Bus::with(['schedules' => function($query) {
            $query->upcoming()->take(10);
        }])->findOrFail($id);
        
        return view('admin.vehicles.show', compact('bus'));
    }

    public function edit(string $id)
    {
        $bus = Bus::findOrFail($id);
        return view('admin.vehicles.edit', compact('bus'));
    }

    public function update(Request $request, string $id)
    {
        $bus = Bus::findOrFail($id);
        
        $validated = $request->validate([
            'plate_number' => 'required|string|max:20|unique:buses,plate_number,' . $id,
            'bus_type' => 'required|string|max:100',
            'total_seats' => 'required|integer|min:1|max:100',
            'rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,inactive',
            'facilities' => 'nullable|string',
            'manufacture_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        $bus->update($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Bus berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $bus = Bus::findOrFail($id);
        $bus->delete();

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Bus berhasil dihapus');
    }
}
