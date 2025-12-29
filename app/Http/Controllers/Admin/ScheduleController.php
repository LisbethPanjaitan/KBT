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
     * Menggunakan withCount untuk menghitung kursi yang sudah dipesan secara real-time.
     */
    public function index(Request $request)
    {
        $query = Schedule::with(['route', 'bus'])
            // FIX: Hitung kursi yang statusnya 'booked' secara real-time agar indikator kapasitas akurat
            ->withCount(['seats as booked_seats_count' => function ($q) {
                $q->where('status', 'booked');
            }]);

        // Filter jika ada pencarian berdasarkan rute
        if ($request->filled('route_id')) {
            $query->where('route_id', $request->route_id);
        }

        $schedules = $query->orderBy('departure_date', 'desc')
            ->orderBy('departure_time', 'asc')
            ->paginate(20);
        
        // Statistik untuk dashboard atas
        $stats = [
            'today' => Schedule::whereDate('departure_date', Carbon::today())->count(),
            'active' => Schedule::where('status', 'scheduled')->count(),
            'departed' => Schedule::where('status', 'departed')->count(),
            'cancelled' => Schedule::where('status', 'cancelled')->count(),
        ];

        return view('admin.schedules.index', compact('schedules', 'stats'));
    }

    /**
     * Menampilkan form untuk membuat jadwal baru.
     */
    public function create()
    {
        $routes = Route::where('status', 'active')->get();
        $buses = Bus::where('status', 'active')->get();
        
        return view('admin.schedules.create', compact('routes', 'buses'));
    }

    /**
     * Menyimpan jadwal baru ke database dan men-generate kursi bus secara otomatis.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'bus_id' => 'required|exists:buses,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'price' => 'nullable|numeric|min:0',
            'status' => 'required|in:scheduled,departed,arrived,cancelled',
        ]);

        $route = Route::findOrFail($validated['route_id']);
        $bus = Bus::findOrFail($validated['bus_id']);
        
        // Sinkronisasi input form dengan nama kolom di database (estimated_arrival_time)
        $validated['estimated_arrival_time'] = $validated['arrival_time'];
        unset($validated['arrival_time']);

        // Jika harga tidak diisi, gunakan harga dasar dari rute
        if (empty($validated['price'])) {
            $validated['price'] = $route->base_price;
        }

        $validated['available_seats'] = $bus->total_seats;
        $schedule = Schedule::create($validated);

        // Auto-create seats berdasarkan konfigurasi bus (Layout Grid)
        $totalSeats = $bus->total_seats;
        $seatsPerRow = $bus->seats_per_row;
        
        for ($i = 1; $i <= $totalSeats; $i++) {
            $row = ceil($i / $seatsPerRow);
            $col = (($i - 1) % $seatsPerRow) + 1;
            $seatNumber = chr(64 + $row) . $col; // Contoh: A1, A2, B1, dst.

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
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Menampilkan rincian jadwal tertentu.
     */
    public function show(string $id)
    {
        $schedule = Schedule::with(['route', 'bus', 'bookings.passengers'])->findOrFail($id);
        return view('admin.schedules.show', compact('schedule'));
    }

    /**
     * Menampilkan form edit jadwal.
     */
    public function edit(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $routes = Route::where('status', 'active')->get();
        $buses = Bus::where('status', 'active')->get();
        
        return view('admin.schedules.edit', compact('schedule', 'routes', 'buses'));
    }

    /**
     * Memperbarui data jadwal di database.
     */
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

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diperbarui');
    }

    /**
     * Menghapus jadwal dari database.
     */
    public function destroy(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }

    /**
     * Menampilkan tampilan kalender jadwal.
     */
    public function calendar()
    {
        $schedules = Schedule::with(['route', 'bus'])
            ->whereMonth('departure_date', now()->month)
            ->get();
            
        return view('admin.schedules.calendar', compact('schedules'));
    }
}