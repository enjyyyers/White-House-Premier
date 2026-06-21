<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori
     */
    public function index()
    {
        // Mengambil semua data kategori dari database
        $categories = Category::all();
        $types = Type::all();

        // Mengarahkan ke file view yang sudah kita buat tadi
        return view('admin.categories.index', compact('categories', 'types'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|unique:categories,name'
    ]);

    Category::create([
        'name' => $request->name,
        'slug' => Str::slug($request->name)
    ]);

    return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function storeType(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:types,name'
        ]);

        Type::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return back()->with('success', 'Tipe berhasil ditambahkan!');
    }

    public function destroyType($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();

        return back()->with('success', 'Tipe berhasil dihapus!');
    }

    public function create()
    {
        return redirect()->route('admin.categories.index');
    }

    public function show($id)
    {
        return redirect()->route('admin.categories.index');
    }

    public function edit($id)
    {
        return redirect()->route('admin.categories.index');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.categories.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}
