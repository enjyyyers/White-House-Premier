@extends('layouts.admin')

@section('title', 'Laporan Admin')
@section('subtitle', 'Rekapitulasi data admin White House Premiere.')

@section('content')
<div class="p-6">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Laporan Data Admin</h2>
            <p class="text-sm text-gray-500">Rekapitulasi data admin White House Premiere.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-2">
            <button onclick="window.print()" class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fas fa-print mr-2"></i> Cetak
            </button>
            <a href="{{ route('admin.laporan-admin.pdf') }}" class="flex items-center px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                <i class="fas fa-file-pdf mr-2"></i> Export PDF
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Admin</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalAdmin }}</p>
                </div>
                <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                    <i class="fas fa-user-shield text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Laki-laki</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPria }}</p>
                </div>
                <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                    <i class="fas fa-male text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Perempuan</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalWanita }}</p>
                </div>
                <div class="h-12 w-12 bg-pink-100 rounded-xl flex items-center justify-center text-pink-600">
                    <i class="fas fa-female text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Belum Diatur</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $belumSet }}</p>
                </div>
                <div class="h-12 w-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-500">
                    <i class="fas fa-question text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">
                <i class="fas fa-list mr-2"></i> Daftar Admin
            </h3>
            <div class="mt-2 sm:mt-0">
                <input type="text" id="searchInput" placeholder="Cari admin..." class="text-sm border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 w-full sm:w-64" onkeyup="filterTable()">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="adminTable">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Kode Admin</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Nama Admin</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Jenis Kelamin</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Tahun</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Email</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($admins as $index => $admin)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-sm font-bold text-blue-700 bg-blue-50 px-3 py-1.5 rounded-lg">
                                {{ $admin->kode_admin ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-sm mr-3">
                                    {{ substr($admin->name, 0, 1) }}
                                </div>
                                <div class="font-semibold text-gray-800">{{ $admin->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($admin->jenis_kelamin)
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                    {{ $admin->jenis_kelamin == 'P' ? 'bg-pink-100 text-pink-700' : 'bg-blue-100 text-blue-700' }}">
                                    <i class="fas {{ $admin->jenis_kelamin == 'P' ? 'fa-venus' : 'fa-mars' }} mr-1"></i>
                                    {{ $admin->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-laki' }}
                                </span>
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $admin->created_at ? $admin->created_at->format('Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $admin->email }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-1">
                                <form action="{{ route('admin.laporan-admin.update-jenis-kelamin', $admin->id) }}" method="POST" class="inline-flex items-center space-x-1">
                                    @csrf
                                    <select name="jenis_kelamin" class="text-xs border border-gray-300 rounded-lg px-2 py-1.5 focus:ring-2 focus:ring-blue-500">
                                        <option value="">JK</option>
                                        <option value="P" {{ $admin->jenis_kelamin == 'P' ? 'selected' : '' }}>P</option>
                                        <option value="L" {{ $admin->jenis_kelamin == 'L' ? 'selected' : '' }}>L</option>
                                    </select>
                                    <button type="submit" class="text-xs bg-blue-500 text-white px-2 py-1.5 rounded-lg hover:bg-blue-600 transition-colors">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @if($admin->kode_admin)
                                <form action="{{ route('admin.laporan-admin.regenerate', $admin->id) }}" method="POST" onsubmit="return confirm('Regenerate kode admin?')">
                                    @csrf
                                    <button type="submit" class="text-xs bg-gray-500 text-white px-2 py-1.5 rounded-lg hover:bg-gray-600 transition-colors" title="Regenerate">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                            <i class="fas fa-users text-4xl mb-3 block text-gray-300"></i>
                            Belum ada admin terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-5">
        <div class="flex items-start space-x-3">
            <div class="h-8 w-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 shrink-0">
                <i class="fas fa-info text-sm"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-blue-800">Format Kode Admin</h3>
                <p class="text-sm text-blue-700 mt-1">
                    <code class="bg-blue-100 px-2 py-0.5 rounded text-xs font-mono font-bold">WHP-ADM-{INISIAL}-{JK}{TAHUN}-{URUTAN}</code>
                </p>
                <ul class="mt-2 text-xs text-blue-600 space-y-1">
                    <li><strong>WHP</strong> : White House Premiere</li>
                    <li><strong>ADM</strong> : Admin</li>
                    <li><strong>INISIAL</strong> : 2 huruf awal dari nama (Contoh: GW untuk Giescha Wiwenar)</li>
                    <li><strong>JK</strong> : Jenis Kelamin (P = Perempuan, L = Laki-laki)</li>
                    <li><strong>TAHUN</strong> : 2 digit tahun (Contoh: 26 untuk 2026)</li>
                    <li><strong>URUTAN</strong> : Nomor urut 3 digit (001, 002, ...)</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('#adminTable tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
}
</script>

<style media="print">
    body { background: white; }
    .no-print { display: none !important; }
    .sidebar, aside, nav, header { display: none !important; }
    main { margin-left: 0 !important; }
    .p-6 { padding: 0 !important; }
    table { font-size: 12px; }
    th { background: #f3f4f6 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .bg-blue-50, .bg-green-100, .bg-red-100 { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .rounded-xl { border-radius: 0 !important; }
    .shadow-sm { box-shadow: none !important; }
</style>
@endsection
