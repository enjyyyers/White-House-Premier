@extends('layouts.admin')

@section('title', 'Dashboard Overview')
@section('subtitle', 'Ringkasan cepat data properti.')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
        <p class="text-slate-500 text-sm">Total Properti</p>
        <h3 class="text-2xl font-bold text-slate-800">24 Unit</h3>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
        <p class="text-slate-500 text-sm">Penjualan Bulan Ini</p>
        <h3 class="text-2xl font-bold text-slate-800">Rp 1.2 Miliar</h3>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
        <p class="text-slate-500 text-sm">Pesan Masuk</p>
        <h3 class="text-2xl font-bold text-slate-800">8 Inquiry</h3>
    </div>
</div>
@endsection
