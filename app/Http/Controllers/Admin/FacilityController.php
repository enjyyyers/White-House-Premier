<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::all();
        return view('admin.facilities.index', compact('facilities'));
    }

    public function show($id)
    {
        return redirect()->route('admin.facilities.edit', $id);
    }

    public function create()
    {
        return view('admin.facilities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:facilities,name',
            'icon' => 'nullable|string|max:100',
        ]);

        Facility::create($request->only(['name', 'icon']));

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $facility = Facility::findOrFail($id);
        return view('admin.facilities.edit', compact('facility'));
    }

    public function update(Request $request, $id)
    {
        $facility = Facility::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:facilities,name,' . $id,
            'icon' => 'nullable|string|max:100',
        ]);

        $facility->update($request->only(['name', 'icon']));

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);
        $facility->delete();

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil dihapus!');
    }
}
