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
    public function fetchMessages(Request $request): JsonResponse
    {
        $weekShift = $request->query('weekShift', 0);
        Log::info("Week Shift: " . $weekShift);

        // Check that weekShift is being processed correctly
        try {
            $startOfWeek = Carbon::now()->startOfWeek()->addWeeks($weekShift);
            $endOfWeek = Carbon::now()->endOfWeek()->addWeeks($weekShift);

            // Continue with message query logic
            $messagesPerDay = Message::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Rest of your function
            $dates = [];
            $counts = [];
            for ($date = $startOfWeek->copy(); $date <= $endOfWeek; $date->addDay()) {
                $formattedDate = $date->format('Y-m-d');
                $dates[] = $formattedDate;
                $counts[] = $messagesPerDay->where('date', $formattedDate)->first()->count ?? 0;
            }

            return response()->json(['labels' => $dates, 'counts' => $counts]);

        } catch (\Exception $e) {
            Log::error("Error in fetchMessages: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }
}
