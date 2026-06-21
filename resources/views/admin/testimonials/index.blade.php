@extends('layouts.admin')

@section('title', 'Testimoni & Review')
@section('subtitle', 'Kelola testimoni yang masuk dari pengguna.')

@section('content')
<div class="p-6">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Pengirim</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Rating</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Review</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($testimonials as $t)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-3">
                                {{ substr($t->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">{{ $t->name }}</div>
                                <div class="text-xs text-gray-400">{{ $t->position ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex text-yellow-500">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star{{ $i < $t->rating ? '' : ' text-gray-300' }} text-sm"></i>
                            @endfor
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-gray-700 line-clamp-2 max-w-xs">{{ $t->review }}</p>
                        @if($t->is_replied)
                            <span class="text-xs text-green-600 mt-1 inline-block"><i class="fas fa-check mr-1"></i>Sudah dibalas</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($t->is_active)
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase bg-green-100 text-green-700">Aktif</span>
                        @else
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold uppercase bg-gray-100 text-gray-500">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center space-x-3">
                            <a href="{{ route('admin.testimonials.edit', $t->id) }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <span class="text-gray-300">|</span>
                            <a href="#" onclick="event.preventDefault(); if(confirm('Hapus testimonial ini?')){ this.nextElementSibling.submit(); }" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </a>
                            <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada testimoni.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
