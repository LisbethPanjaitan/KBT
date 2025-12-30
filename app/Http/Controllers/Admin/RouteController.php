<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Menampilkan daftar rute.
     * Ditambahkan logika pencarian dan pengurutan terbaru.
     */
    public function index(Request $request)
    {
        $query = Route::query();

        // Logika Pencarian (Search) sesuai dengan input 'q' di Blade
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('origin_city', 'like', "%{$search}%")
                  ->orWhere('destination_city', 'like', "%{$search}%")
                  ->orWhere('origin_terminal', 'like', "%{$search}%")
                  ->orWhere('destination_terminal', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan Status jika diperlukan
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // FIX: Gunakan latest() agar rute yang BARU ditambah muncul di paling atas (Halaman 1)
        $routes = $query->latest()->paginate(20);

        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    /**
     * Menyimpan rute baru ke database.
     */
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

        // Simpan data
        Route::create($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.routes.index')
            ->with('success', 'Rute baru berhasil ditambahkan dan siap digunakan.');
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

    /**
     * Memperbarui data rute.
     */
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
            ->with('success', 'Data rute berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $route = Route::findOrFail($id);
        
        // Cek jika rute memiliki jadwal aktif sebelum dihapus (opsional untuk keamanan data)
        if ($route->schedules()->exists()) {
            return redirect()->back()->with('error', 'Rute tidak bisa dihapus karena memiliki jadwal perjalanan.');
        }

        $route->delete();

        return redirect()->route('admin.routes.index')
            ->with('success', 'Rute berhasil dihapus dari sistem.');
    }
}