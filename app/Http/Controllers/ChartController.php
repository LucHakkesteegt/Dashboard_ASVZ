<?php
// app/Http/Controllers/ChartController.php

namespace App\Http\Controllers;

use App\Models\Message; // Zorg ervoor dat je de Message model importeert
use Carbon\Carbon; // Zorg ervoor dat je Carbon importeert voor datum handling
use Illuminate\Http\JsonResponse;

class ChartController extends Controller
{
    public function fetchMessages(): JsonResponse
    {
        // Haal de start- en einddatum van de huidige week
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Haal berichten op, gegroepeerd per datum
        $messagesPerDay = Message::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Voorbereiden van labels en counts
        $dates = [];
        $counts = [];

        for ($date = $startOfWeek->copy(); $date <= $endOfWeek; $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $dates[] = $formattedDate;
            $counts[] = $messagesPerDay->where('date', $formattedDate)->first()->count ?? 0; // Default to 0
        }

        return response()->json(['labels' => $dates, 'counts' => $counts]);
    }
}
