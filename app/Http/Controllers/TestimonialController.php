<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::active()->latest()->get();
        $reviews = [
            ['rating' => 4.8, 'platform' => 'Google Reviews', 'totalReviews' => 145],
            ['rating' => 4.9, 'platform' => 'Trustpilot', 'totalReviews' => 89],
            ['rating' => 4.7, 'platform' => 'Instagram', 'totalReviews' => 320],
        ];

        return view('pages.testimoni', compact('testimonials', 'reviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Testimonial::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'position' => $request->position,
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        return redirect()->route('testimoni')->with('success', 'Terima kasih! Review Anda telah kami terima.');
    }
}
