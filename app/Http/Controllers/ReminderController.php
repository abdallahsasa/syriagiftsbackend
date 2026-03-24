<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function index()
    {
        return response()->json(
            Reminder::where('user_id', Auth::id())->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'occasion_type' => 'nullable|string'
        ]);

        $reminder = Reminder::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'date' => $request->date,
            'occasion_type' => $request->occasion_type
        ]);

        return response()->json($reminder, 201);
    }

    public function destroy($id)
    {
        $reminder = Reminder::where('user_id', Auth::id())->findOrFail($id);
        $reminder->delete();

        return response()->json(['message' => 'Reminder deleted']);
    }
}
