<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Message;
use Illuminate\Routing\Controller;

class ChartController extends Controller
{
    public function fetchMessages(Request $request): JsonResponse // Maakt een functie die berichten ophaalt
{
    $weekShift = $request->query('weekShift', 0); // Haalt de weekverschuiving op uit de URL, standaard is 0
    Log::info("Week Shift: " . $weekShift); // Logt de weekverschuiving voor debug-doeleinden

    try {
        // Bepaal het begin en het einde van de week op basis van de huidige datum en de weekverschuiving
        $startOfWeek = Carbon::now()->startOfWeek()->addWeeks($weekShift); // Start van de week
        $endOfWeek = Carbon::now()->endOfWeek()->addWeeks($weekShift); // Einde van de week

        // Haal het aantal berichten per dag op binnen de opgegeven week
        $messagesPerDay = Message::whereBetween('created_at', [$startOfWeek, $endOfWeek]) // Zoek berichten tussen de datums
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count') // Selecteer de datum en tel het aantal berichten
            ->groupBy('date') // Groepeer op datum
            ->orderBy('date') // Sorteer de resultaten op datum
            ->get(); // Voer de query uit en haal de resultaten op

        // Voorbereiden van arrays om de data op te slaan
        $dates = []; // Array om de datums op te slaan
        $counts = []; // Array om het aantal berichten op te slaan

        // Loop door elke dag van de week
        for ($date = $startOfWeek->copy(); $date <= $endOfWeek; $date->addDay()) {
            $formattedDate = $date->format('Y-m-d'); // Formatteer de datum naar Y-m-d formaat
            $dates[] = $formattedDate; // Voeg de geformatteerde datum toe aan de $dates array

            // Zoek het aantal berichten voor deze datum, als er geen zijn, voeg 0 toe
            $counts[] = $messagesPerDay->where('date', $formattedDate)->first()->count ?? 0;
        }

        // Geef de labels (datums) en counts (aantallen) terug als JSON
        return response()->json(['labels' => $dates, 'counts' => $counts]);

    } catch (\Exception $e) { // Als er een fout optreedt
        Log::error("Error in fetchMessages: " . $e->getMessage()); // Log de foutmelding
        return response()->json(['error' => 'An error occurred'], 500); // Geef een foutmelding terug
    }
}
}
