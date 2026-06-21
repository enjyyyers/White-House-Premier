<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
        ]);

        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update($request->only(['name', 'position', 'review', 'rating', 'is_active']));

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil diperbarui.');
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['reply' => 'required|string']);

        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update([
            'reply' => $request->reply,
            'replied_at' => now(),
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Balasan berhasil dikirim.');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil dihapus.');
    }
}
