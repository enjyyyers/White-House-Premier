<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VisitScheduleController extends Controller
{
    public function index()
{
    $schedules = \App\Models\VisitSchedule::with(['user', 'property'])->latest()->get();
    return view('admin.visits.index', compact('schedules'));
}

public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,confirmed,completed,cancelled',
    ]);
    $visit = \App\Models\VisitSchedule::findOrFail($id);
    $visit->update(['status' => $request->status]);
    return back()->with('success', 'Status kunjungan berhasil diupdate!');
}
}
