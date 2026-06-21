@extends('layouts.admin')

@section('title', 'Detail Transaksi')
@section('subtitle', 'Informasi lengkap transaksi properti.')

@section('content')
<div class="p-6 bg-slate-50 min-h-screen">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Detail Pembayaran & Manajemen Data</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola rincian dana masuk, tipe transaksi, dan status pemesanan unit.</p>
        </div>
        <a href="{{ route('admin.transaction.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Tabel
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-900 border-b border-slate-800 flex items-center justify-between">
                <h2 class="text-sm font-bold tracking-wider text-slate-200 uppercase">Rincian Komponen Biaya</h2>
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">
                    {{ $transaction->transaction_code }}
                </span>
            </div>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4 border-b border-slate-100">
                    <div>
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Nama Pembeli</span>
                        <span class="text-sm font-bold text-slate-800 block mt-0.5">{{ $transaction->user->name }}</span>
                        <span class="text-xs text-slate-500 block">{{ $transaction->user->email }}</span>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Unit Properti</span>
                        <span class="text-sm font-bold text-slate-800 block mt-0.5">{{ $property->name ?? 'Unit Properti' }}</span>
                    </div>
                </div>

                @if($transaction->is_installment)
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-3 mb-2">
                    <h4 class="text-xs font-bold text-purple-700 uppercase tracking-wider mb-2">Informasi Cicilan</h4>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div><span class="text-purple-500">Rencana:</span> <span class="font-bold text-purple-800">{{ strtoupper(str_replace('_', ' ', $transaction->installment_plan)) }}</span></div>
                        <div><span class="text-purple-500">Total + Jasa:</span> <span class="font-bold text-purple-800">Rp {{ number_format($transaction->installment_total, 0, ',', '.') }}</span></div>
                        <div><span class="text-purple-500">Jumlah Cicilan:</span> <span class="font-bold text-purple-800">{{ $transaction->installment_count }}x</span></div>
                        <div><span class="text-purple-500">Cicilan Dibayar:</span> <span class="font-bold text-purple-800">{{ $transaction->paid_installments }} / {{ $transaction->installment_count }}</span></div>
                        <div><span class="text-purple-500">Biaya Jasa:</span> <span class="font-bold text-amber-600">Rp {{ number_format($transaction->service_fee, 0, ',', '.') }}</span></div>
                        <div><span class="text-purple-500">Progress:</span>
                            @php $prog = $transaction->installment_count > 0 ? round(($transaction->paid_installments / $transaction->installment_count) * 100) : 0; @endphp
                            <span class="font-bold {{ $prog >= 100 ? 'text-green-600' : 'text-blue-600' }}">{{ $prog }}%</span>
                        </div>
                    </div>

                    @if($transaction->installments->count() > 0)
                    <div class="mt-3">
                        <table class="w-full text-[10px]">
                            <thead>
                                <tr class="text-purple-500 border-b border-purple-200">
                                    <th class="py-1 text-left">#</th>
                                    <th class="py-1 text-left">Jatuh Tempo</th>
                                    <th class="py-1 text-right">Jumlah</th>
                                    <th class="py-1 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->installments as $inst)
                                <tr class="border-b border-purple-100">
                                    <td class="py-1">{{ $inst->installment_number }}</td>
                                    <td class="py-1">{{ $inst->due_date->format('d/m/Y') }}</td>
                                    <td class="py-1 text-right font-medium">Rp {{ number_format($inst->amount, 0, ',', '.') }}</td>
                                    <td class="py-1 text-right">
                                        @if($inst->payment_status === 'success')
                                        <span class="text-green-600 font-bold">LUNAS</span>
                                        @elseif($inst->payment_status === 'failed')
                                        <span class="text-red-600 font-bold">GAGAL</span>
                                        @else
                                        <span class="text-yellow-600">MENUNGGU</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                @endif

                <div class="space-y-3 pt-2">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500">Harga Rumah Asli (Pricelist)</span>
                        <span class="font-semibold text-slate-700">Rp {{ number_format($transaction->property_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500">Nilai Pokok Pembayaran</span>
                        <span class="font-semibold text-slate-800">Rp {{ number_format($price_raw, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500">Biaya Lingkungan & Pengelolaan (IPL 20%)</span>
                        <span class="font-medium text-amber-600">+ Rp {{ number_format($ipl, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm pb-3 border-b border-slate-100">
                        <span class="text-slate-500">Pajak Pertambahan Nilai (PPN 2%)</span>
                        <span class="font-medium text-amber-600">+ Rp {{ number_format($tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-3 bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <span class="text-base font-bold text-slate-800">Total Dana Masuk</span>
                        <span class="text-xl font-extrabold text-emerald-600">Rp {{ number_format($transaction->total_payable, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-blue-600 border-b border-blue-700">
                    <h2 class="text-sm font-bold tracking-wider text-white uppercase">Aksi & Update Data</h2>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.transaction.update', $transaction->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Metode Transaksi</label>
                            <select name="payment_type" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                <option value="booking" {{ $transaction->payment_type == 'booking' ? 'selected' : '' }}>BOOKING (Rp 10.000.000 + Pajak)</option>
                                <option value="dp" {{ $transaction->payment_type == 'dp' ? 'selected' : '' }}>DP 20% + Pajak</option>
                                <option value="cash" {{ $transaction->payment_type == 'cash' ? 'selected' : '' }}>CASH PENUH + Pajak</option>
                            </select>
                        </div>

                        @if(in_array($transaction->payment_type, ['booking', 'dp']))
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Rencana Cicilan</label>
                            <select name="installment_plan" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                <option value="none" {{ $transaction->installment_plan == 'none' ? 'selected' : '' }}>TANPA CICILAN (Full Bayar)</option>
                                <option value="monthly" {{ $transaction->installment_plan == 'monthly' ? 'selected' : '' }}>1 BULAN (1x Cicilan)</option>
                                <option value="quarterly" {{ $transaction->installment_plan == 'quarterly' ? 'selected' : '' }}>3 BULAN (3x Cicilan + 2% Jasa)</option>
                                <option value="semi_annually" {{ $transaction->installment_plan == 'semi_annually' ? 'selected' : '' }}>6 BULAN (6x Cicilan + 3.5% Jasa)</option>
                            </select>
                        </div>
                        @endif

                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide mb-2">Status Pembayaran</label>
                            <select name="payment_status" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                <option value="pending" {{ $transaction->payment_status == 'pending' ? 'selected' : '' }}>PENDING (Belum Bayar)</option>
                                <option value="success" {{ $transaction->payment_status == 'success' ? 'selected' : '' }}>SUCCESS (Lunas)</option>
                                <option value="failed" {{ $transaction->payment_status == 'failed' ? 'selected' : '' }}>FAILED (Gagal)</option>
                                <option value="expired" {{ $transaction->payment_status == 'expired' ? 'selected' : '' }}>EXPIRED (Kadaluarsa)</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full mt-2 inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition duration-150">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-rose-100 shadow-sm p-5 flex flex-col justify-between gap-4 border-l-4 border-l-rose-500">
                <div>
                    <h3 class="text-sm font-bold text-rose-600 uppercase tracking-wider">Zona Bahaya</h3>
                    <p class="text-xs text-slate-500 mt-1">Data transaksi yang dihapus tidak bisa dikembalikan lagi dari database.</p>
                </div>
                <form action="{{ route('admin.transaction.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini secara permanen dari database?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 rounded-lg text-xs font-bold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus Transaksi Permanen
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
