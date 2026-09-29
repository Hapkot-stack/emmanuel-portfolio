<?php
namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function track(Request $request)
    {
        $data = $request->validate([
            'event_type' => 'required|string|max:50',
            'page'       => 'nullable|string|max:500',
            'label'      => 'nullable|string|max:500',
        ]);
        AnalyticsEvent::track($data['event_type'], $data['page'] ?? null, $data['label'] ?? null);
        return response()->json(['ok' => true]);
    }
}
