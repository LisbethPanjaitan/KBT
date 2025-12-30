<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Route;
use App\Models\Bus;
use App\Models\Seat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Menampilkan daftar jadwal keberangkatan.
     * Ditambahkan filter tanggal yang akurat dan urutan terbaru.
     */
    public function index(Request $request)
    {
        $query = Schedule::with(['route', 'bus'])
            ->withCount(['seats as booked_seats_count' => function ($q) {
                $q->where('status', 'booked');
            }]);

        // 1. Filter Berdasarkan Rute
        if ($request->filled('route_id')) {
            $query->where('route_id', $request->route_id);
        }

        // 2. Filter Berdasarkan Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Filter Berdasarkan Tanggal (Fix filter tidak akurat)
        if ($request->filled('date')) {
            $query->whereDate('departure_date', $request->date);
        }

        // Urutan: Yang terbaru diinput muncul paling atas (Halaman 1)
        $schedules = $query->latest()->paginate(20)->withQueryString();
        
        $stats = [
            'today' => Schedule::whereDate('departure_date', Carbon::today())->count(),
            'active' => Schedule::where('status', 'scheduled')->count(),
            'departed' => Schedule::where('status', 'departed')->count(),
            'cancelled' => Schedule::where('status', 'cancelled')->count(),
        ];

        // Ambil daftar rute untuk filter abjad
        $routes = Route::where('status', 'active')->orderBy('origin_city')->get();

        return view('admin.schedules.index', compact('schedules', 'stats', 'routes'));
    }

    /**
     * FIX: Fungsi Kalender (WAJIB ADA agar tidak error Internal Server Error)
     */
    public function calendar()
    {
        $schedules = Schedule::with(['route', 'bus'])->get();
        return view('admin.schedules.calendar', compact('schedules'));
    }

    /**
     * FIX: Fungsi Update Status Instan (Untuk Dropdown di Tabel)
     */
    public function updateStatus(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:scheduled,departed,arrived,cancelled'
        ]);

        $schedule->update(['status' => $request->status]);

        return back()->with('success', 'Status operasional jadwal berhasil diperbarui.');
    }

    /**
     * Menampilkan form untuk membuat jadwal baru.
     */
    public function create()
    {
        $routes = Route::where('status', 'active')->orderBy('origin_city', 'asc')->get();
        $buses = Bus::where('status', 'active')->orderBy('name', 'asc')->get();
        
        return view('admin.schedules.create', compact('routes', 'buses'));
    }

    /**
     * Menyimpan jadwal baru dan men-generate kursi otomatis.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'bus_id' => 'required|exists:buses,id',
            'departure_date' => 'required|date|after_or_equal:today',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'price' => 'nullable|numeric|min:0',
            'status' => 'required|in:scheduled,departed,arrived,cancelled',
        ]);

        $route = Route::findOrFail($validated['route_id']);
        $bus = Bus::findOrFail($validated['bus_id']);
        
        $validated['estimated_arrival_time'] = $validated['arrival_time'];
        unset($validated['arrival_time']);

        if (empty($validated['price'])) {
            $validated['price'] = $route->base_price;
        }

        $validated['available_seats'] = $bus->total_seats;
        $schedule = Schedule::create($validated);

        // Auto-create kursi berdasarkan kapasitas bus
        $seatsPerRow = $bus->seats_per_row ?? 4;
        for ($i = 1; $i <= $bus->total_seats; $i++) {
            $row = ceil($i / $seatsPerRow);
            $col = (($i - 1) % $seatsPerRow) + 1;
            $seatNumber = chr(64 + $row) . $col; 

            Seat::create([
                'schedule_id' => $schedule->id,
                'seat_number' => $seatNumber,
                'row_number' => $row,
                'column_number' => $col,
                'status' => 'available',
                'seat_type' => 'standard',
                'extra_price' => 0,
            ]);
        }

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dibuat dan kursi telah digenerate!');
    }

    public function show(string $id)
    {
        $schedule = Schedule::with(['route', 'bus', 'bookings.passengers'])->findOrFail($id);
        return view('admin.schedules.show', compact('schedule'));
    }

    public function edit(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $routes = Route::where('status', 'active')->orderBy('origin_city')->get();
        $buses = Bus::where('status', 'active')->orderBy('name')->get();
        
        return view('admin.schedules.edit', compact('schedule', 'routes', 'buses'));
    }

    public function update(Request $request, string $id)
    {
        $schedule = Schedule::findOrFail($id);
        
        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'bus_id' => 'required|exists:buses,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:scheduled,departed,arrived,cancelled',
        ]);

        $validated['estimated_arrival_time'] = $validated['arrival_time'];
        unset($validated['arrival_time']);

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->seats()->delete();
        $schedule->delete();
        
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil dihapus');
    }
}