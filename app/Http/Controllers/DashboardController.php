<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $date = $request->date;
       $totalRevenue = Ticket::when($date, function ($q) use ($date) {
            $q->whereDate('created_at', $date);
        })->sum('price');

        $totalTickets = Ticket::when($date, function ($q) use ($date) {
            $q->whereDate('created_at', $date);
        })->count();
       $baseDate = $date
    ? Carbon::parse($date)
    : now();

$monthlyRevenue = Ticket::whereMonth('created_at', $baseDate->month)
    ->whereYear('created_at', $baseDate->year)
    ->sum('price');

        $start = $baseDate->copy()->subDays(6)->startOfDay();
        $end = $baseDate->copy()->endOfDay();

        $revenueByDay = Ticket::whereBetween('created_at', [$start, $end])
        ->selectRaw('DATE(created_at) as date, SUM(price) as total')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        $topMovies = Ticket::whereBetween('created_at', [$start, $end])
        ->selectRaw('movie as name, SUM(price) as revenue')
        ->groupBy('movie')
        ->orderByDesc('revenue')
        ->limit(5)
        ->get();

       $peakHours = Ticket::whereBetween('created_at', [$start, $end])
    ->selectRaw("
        SUBSTRING_INDEX(
            SUBSTRING_INDEX(showtime, ' ', -1),
            '-',
            1
        ) as hour,
        COUNT(*) as total
    ")
    ->groupBy('hour')
    ->orderBy('hour')
    ->get();

       $queryRoom = Ticket::whereDate('created_at', $baseDate->toDateString());

$roomStats = $queryRoom->get()->groupBy(function($ticket){
    return $ticket->movie . '-' . $ticket->room;
})->map(function($tickets){

    $first = $tickets->first();

    $soldSeats = 0;

    foreach($tickets as $ticket){
        $soldSeats += count(explode(' ', trim($ticket->seat)));
    }

    return [
        'movie' => $first->movie,
        'room' => $first->room,
        'soldSeats' => $soldSeats,
        'totalSeats' => 89,
        'fillRate' => round(($soldSeats / 50) * 100)
    ];

})->values();

$monthlyChart = Ticket::selectRaw('MONTH(created_at) as month, SUM(price) as total')
    ->groupBy('month')
    ->orderBy('month')
    ->get();

return response()->json([
    'totalRevenue' => $totalRevenue,
    'totalTickets' => $totalTickets,
    'monthlyRevenue' => $monthlyRevenue,
    'revenueByDay' => $revenueByDay,
    'topMovies' => $topMovies,
    'peakHours' => $peakHours,
    'roomStats' => $roomStats,
    'monthlyChart' => $monthlyChart
]);
    }
}
