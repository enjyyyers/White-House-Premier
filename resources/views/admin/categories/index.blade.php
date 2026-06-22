@extends('layouts.admin')

@section('title', 'Tipe & Cluster')
@section('subtitle', 'Kelola cluster induk dan spesifikasi tipe bangunan.')

@section('content')
<div class="p-6">

    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-100 text-emerald-700 rounded-xl border border-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-700 uppercase text-xs tracking-wider">
                        <i class="fas fa-tags mr-2 text-blue-500"></i> Master Cluster
                    </h3>
                </div>

                <form action="{{ route('admin.categories.store') }}" method="POST" class="p-4 border-b border-slate-50 bg-slate-50/30">
                    @csrf
                    <div class="flex gap-2">
                        <input type="text" name="name" placeholder="Nama Cluster..." required
                            class="flex-1 px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none transition">
                        <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-700">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </form>

                <table class="w-full text-left text-sm">
                    <tbody class="divide-y divide-slate-100">
                        @forelse($categories as $category)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4 font-medium text-slate-700">{{ $category->name }}</td>
                            <td class="p-4 text-right">
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-slate-300 hover:text-red-500 transition" onclick="return confirm('Hapus cluster?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td class="p-4 text-center text-slate-400 italic">Belum ada cluster</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-700 uppercase text-xs tracking-wider">
                        <i class="fas fa-home mr-2 text-emerald-500"></i> Daftar Spesifikasi Tipe
                    </h3>
                </div>

                <form action="{{ route('admin.types.store') }}" method="POST" class="p-4 border-b border-slate-50 bg-slate-50/30 flex flex-wrap gap-3">
                    @csrf
                    <input type="text" name="name" placeholder="Nama Tipe (Contoh: Tipe 36)" required
                        class="flex-1 min-w-[200px] px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <input type="text" name="description" placeholder="Keterangan (Optional)"
                        class="flex-1 min-w-[200px] px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-emerald-700 transition">
                        + Tambah Tipe
                    </button>
                </form>

                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Nama Tipe</th>
                            <th class="px-6 py-4">Slug URL</th>
                            <th class="px-6 py-4">Keterangan</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($types as $type)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-bold text-slate-700">{{ $type->name }}</td>
                            <td class="px-6 py-4 text-slate-500 font-mono text-[11px]">{{ $type->slug }}</td>
                            <td class="px-6 py-4 text-slate-400 text-xs">{{ $type->description ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.types.destroy', $type->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-50 text-red-500 p-2 rounded-lg hover:bg-red-500 hover:text-white transition" onclick="return confirm('Hapus tipe ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="p-8 text-center text-slate-400 italic">Belum ada tipe unit</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 p-4 bg-blue-50 rounded-xl border border-blue-100 flex items-center text-blue-700 text-xs">
                <i class="fas fa-info-circle mr-3 text-lg"></i>
                <p>Data <b>Tipe</b> dan <b>Cluster</b> akan muncul sebagai pilihan saat Anda menambah atau mengedit unit di Manajemen Properti.</p>
            </div>
        </div>

    </div>
</div>
@endsection
