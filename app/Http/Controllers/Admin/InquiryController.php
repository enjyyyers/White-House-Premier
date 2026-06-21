<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Events\InquiryRepliedEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::latest()->get();
        $unreadCount = Inquiry::whereNull('reply')->count();
        return view('admin.inquiries.index', compact('inquiries', 'unreadCount'));
    }

    public function show($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $inquiry = Inquiry::findOrFail($id);
        $inquiry->update([
            'reply' => $request->reply,
            'replied_at' => now(),
        ]);

        try {
            broadcast(new InquiryRepliedEvent($inquiry));
        } catch (\Exception $e) {
            Log::warning('Broadcast gagal: ' . $e->getMessage());
        }

        return redirect()->route('admin.inquiries.index')->with('success', 'Balasan berhasil dikirim.');
    }

    public function destroy($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
