@extends('layouts.admin')

@section('title', 'Manajemen Users')
@section('subtitle', 'Daftar pengguna yang terdaftar di sistem WhiteHouse.')

@section('content')
<div class="p-6">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Informasi User</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Role</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Terdaftar Pada</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-3">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">{{ $user->name }}</div>
                                <div class="text-xs text-gray-400">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                            {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.manajemenuser.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
