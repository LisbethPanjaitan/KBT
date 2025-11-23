<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Route;
use App\Models\Bus;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedule::with(['route', 'bus'])
            ->orderBy('departure_time', 'asc')
            ->paginate(20);
        
        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $routes = Route::where('status', 'active')->get();
        $buses = Bus::where('status', 'active')->get();
        
        return view('admin.schedules.create', compact('routes', 'buses'));
    }

    /**
     * Store a newly created resource in storage.
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

        // Get route and bus
        $route = Route::findOrFail($validated['route_id']);
        $bus = Bus::findOrFail($validated['bus_id']);

        // Map arrival_time to estimated_arrival_time for database
        $validated['estimated_arrival_time'] = $validated['arrival_time'];
        unset($validated['arrival_time']);

        // Set price to route's base_price if not provided
        if (empty($validated['price'])) {
            $validated['price'] = $route->base_price;
        }

        // Set available_seats to match bus capacity
        $validated['available_seats'] = $bus->total_seats;
        
        // Create schedule
        $schedule = Schedule::create($validated);

        // Auto-create seats based on bus configuration
        $totalSeats = $bus->total_seats;
        $seatsPerRow = $bus->seats_per_row;
        
        for ($i = 1; $i <= $totalSeats; $i++) {
            $row = ceil($i / $seatsPerRow);
            $col = (($i - 1) % $seatsPerRow) + 1;
            $seatNumber = chr(64 + $row) . $col; // A1, A2, B1, B2, etc

            \App\Models\Seat::create([
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
            ->with('success', 'Jadwal berhasil ditambahkan dan siap dibooking oleh user!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schedule = Schedule::with(['route', 'bus', 'bookings'])->findOrFail($id);
        
        return view('admin.schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $routes = Route::where('status', 'active')->get();
        $buses = Bus::where('status', 'active')->get();
        
        return view('admin.schedules.edit', compact('schedule', 'routes', 'buses'));
    }

    /**
     * Update the specified resource in storage.
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

        // Map arrival_time to estimated_arrival_time for database
        $validated['estimated_arrival_time'] = $validated['arrival_time'];
        unset($validated['arrival_time']);

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }

    /**
     * Display calendar view
     */
    public function calendar()
    {
        $schedules = Schedule::with(['route', 'bus'])
            ->whereMonth('departure_date', now()->month)
            ->get();
        
        return view('admin.schedules.calendar', compact('schedules'));
    }
}
