<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Schedule;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Get popular routes
        $popularRoutes = Route::where('status', 'active')
            ->take(6)
            ->get();
        
        return view('home', compact('popularRoutes'));
    }
    
    public function search(Request $request)
    {
        $query = Schedule::with(['bus', 'route'])
            ->upcoming()
            ->available();
        
        // Filter by route
        if ($request->filled('origin') && $request->filled('destination')) {
            $query->whereHas('route', function($q) use ($request) {
                $q->where('origin_city', $request->origin)
                  ->where('destination_city', $request->destination);
            });
        }
        
        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('departure_date', $request->date);
        }
        
        // Sort
        if ($request->filled('sort')) {
            switch($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'time':
                    $query->orderBy('departure_time', 'asc');
                    break;
                default:
                    $query->orderBy('departure_date', 'asc')
                          ->orderBy('departure_time', 'asc');
            }
        } else {
            $query->orderBy('departure_date', 'asc')
                  ->orderBy('departure_time', 'asc');
        }
        
        $schedules = $query->paginate(10);
        
        // Get available cities for filters
        $cities = Route::where('status', 'active')
            ->selectRaw('DISTINCT origin_city as city')
            ->pluck('city')
            ->merge(
                Route::where('status', 'active')
                    ->selectRaw('DISTINCT destination_city as city')
                    ->pluck('city')
            )
            ->unique()
            ->sort()
            ->values();
        
        return view('search', compact('schedules', 'cities'));
    }
}
