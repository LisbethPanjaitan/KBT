<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::orderBy('origin_city', 'asc')->paginate(20);
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin_city' => 'required|string|max:100',
            'origin_terminal' => 'required|string|max:200',
            'destination_city' => 'required|string|max:100',
            'destination_terminal' => 'required|string|max:200',
            'distance_km' => 'required|numeric|min:1',
            'estimated_duration_minutes' => 'required|integer|min:1',
            'base_price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        Route::create($validated);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Rute berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $route = Route::with(['schedules' => function($query) {
            $query->upcoming()->take(10);
        }])->findOrFail($id);
        
        return view('admin.routes.show', compact('route'));
    }

    public function edit(string $id)
    {
        $route = Route::findOrFail($id);
        return view('admin.routes.edit', compact('route'));
    }

    public function update(Request $request, string $id)
    {
        $route = Route::findOrFail($id);
        
        $validated = $request->validate([
            'origin_city' => 'required|string|max:100',
            'origin_terminal' => 'required|string|max:200',
            'destination_city' => 'required|string|max:100',
            'destination_terminal' => 'required|string|max:200',
            'distance_km' => 'required|numeric|min:1',
            'estimated_duration_minutes' => 'required|integer|min:1',
            'base_price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $route->update($validated);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Rute berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $route = Route::findOrFail($id);
        $route->delete();

        return redirect()->route('admin.routes.index')
            ->with('success', 'Rute berhasil dihapus');
    }
}
