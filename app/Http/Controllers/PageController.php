<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Property;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home()
    {
        // Mengambil 3 properti terbaru dari database
        $featuredProjects = Property::latest()->take(3)->get();
        return view('pages.home', compact('featuredProjects'));
    }

    public function project()
    {
        $clusters = Category::with('properties')->get();
        return view('pages.project', compact('clusters'));
    }

    public function projectDetail($id)
    {
        $project = Property::findOrFail($id);
        $isSold = $project->status === 'sold';
        return view('pages.project-detail', compact('project', 'isSold'));
    }

    public function contact()
    {
        $contactInfo = [
            'address' => 'Marketing Gallery White House Premier, Tapos, Depok, Jawa Barat',
            'phone' => '(021) 1234-5678',
            'whatsapp' => '+62 812-3456-7890',
            'email' => 'info@whitehousepremiere.co.id',
            'hours' => 'Senin - Jumat, 09:00 - 18:00'
        ];

        $offices = [
            [
                'city' => 'Marketing Gallery',
                'address' => 'Marketing Gallery White House Premier, Tapos, Depok, Jawa Barat',
                'phone' => '(021) 1234-5678'
            ]
        ];

        return view('pages.contact', compact('contactInfo', 'offices'));
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Inquiry::create($request->only(['name', 'email', 'phone', 'subject', 'message']));

        return back()->with('success', 'Pesan Anda telah dikirim! Tim kami akan menghubungi Anda segera.');
    }
}
