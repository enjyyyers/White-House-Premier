<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Type;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::all();
        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        $categories = Category::all();
        $types = Type::all();
        return view('admin.properties.create', compact('categories', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'google_maps_url' => 'nullable|url', // Ditambahkan validasi URL maps
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'image_living_room' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_bathroom' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_exterior' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Masukkan 'google_maps_url' ke dalam penangkapan data teks
        $data = $request->only([
            'name', 'location', 'price', 'category_id', 'type_id', 'bedrooms',
            'bathrooms', 'building_area', 'land_area', 'description', 'status',
            'google_maps_url'
        ]);

        // Auto-generate slug dari nama
        $data['slug'] = \Illuminate\Support\Str::slug($request->name);

        // Proses upload masing-masing foto dengan nama aman (hash)
        $photoFields = ['image', 'image_living_room', 'image_bathroom', 'image_exterior'];
        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . $field . '_' . \Illuminate\Support\Str::random(16) . '.' . $extension;
                $file->move(public_path('uploads/properties'), $filename);
                $data[$field] = $filename;
            }
        }

        Property::create($data);

        return redirect()->route('admin.properties.index')->with('success', 'Unit Berhasil Ditambahkan!');
    }

    public function show($id)
    {
        $property = Property::findOrFail($id);
        return redirect()->route('admin.properties.edit', $id);
    }

    public function edit($id)
    {
        $property = Property::findOrFail($id);
        $categories = Category::all();
        $types = Type::all();
        return view('admin.properties.edit', compact('property', 'categories', 'types'));
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'google_maps_url' => 'nullable|url', // Ditambahkan validasi URL maps
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_living_room' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_bathroom' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image_exterior' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Masukkan 'google_maps_url' ke dalam penangkapan data teks
        $data = $request->only([
            'name', 'location', 'price', 'category_id', 'type_id', 'bedrooms',
            'bathrooms', 'building_area', 'land_area', 'description', 'status',
            'google_maps_url'
        ]);

        // Auto-generate slug dari nama
        $data['slug'] = \Illuminate\Support\Str::slug($request->name);

        // Proses upload masing-masing foto dengan nama aman (hash)
        $photoFields = ['image', 'image_living_room', 'image_bathroom', 'image_exterior'];
        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . $field . '_' . \Illuminate\Support\Str::random(16) . '.' . $extension;
                $file->move(public_path('uploads/properties'), $filename);
                $data[$field] = $filename;
            }
        }

        $property->update($data);

        return redirect()->route('admin.properties.index')->with('success', 'Unit Berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return redirect()->route('admin.properties.index')->with('success', 'Unit Berhasil Dihapus!');
    }
}
