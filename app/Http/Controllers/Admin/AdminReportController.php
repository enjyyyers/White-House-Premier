<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Exports\AdminReportExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminReportController extends Controller
{
    public function index()
    {
        $admins = User::admins()->latest()->get();

        $totalAdmin = $admins->count();
        $totalPria = $admins->where('jenis_kelamin', 'L')->count();
        $totalWanita = $admins->where('jenis_kelamin', 'P')->count();
        $belumSet = $admins->whereNull('jenis_kelamin')->count();

        return view('admin.laporan.index', compact('admins', 'totalAdmin', 'totalPria', 'totalWanita', 'belumSet'));
    }

    public function updateJenisKelamin(Request $request, $id)
    {
        $request->validate([
            'jenis_kelamin' => 'required|in:P,L',
        ]);

        $admin = User::findOrFail($id);

        if ($admin->role !== 'admin') {
            return back()->with('error', 'User ini bukan admin.');
        }

        $admin->jenis_kelamin = $request->jenis_kelamin;

        if (empty($admin->kode_admin)) {
            $admin->kode_admin = User::generateKodeAdmin($admin->name, $admin->jenis_kelamin);
        }

        $admin->save();

        return back()->with('success', 'Jenis kelamin admin berhasil diperbarui.');
    }

    public function regenerate($id)
    {
        $admin = User::findOrFail($id);

        if ($admin->role !== 'admin') {
            return back()->with('error', 'User ini bukan admin.');
        }

        $admin->kode_admin = User::generateKodeAdmin($admin->name, $admin->jenis_kelamin);
        $admin->save();

        return back()->with('success', 'Kode admin berhasil diperbarui.');
    }

    public function exportPdf()
    {
        $admins = User::admins()->latest()->get();

        $totalAdmin = $admins->count();
        $totalPria = $admins->where('jenis_kelamin', 'L')->count();
        $totalWanita = $admins->where('jenis_kelamin', 'P')->count();
        $belumSet = $admins->whereNull('jenis_kelamin')->count();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('admins', 'totalAdmin', 'totalPria', 'totalWanita', 'belumSet'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan-data-admin-whp-' . now()->format('YmdHis') . '.pdf');
    }

    public function exportExcel()
    {
        $filename = 'laporan-data-admin-' . now()->format('YmdHis') . '.xlsx';
        return Excel::download(new AdminReportExport, $filename);
    }
}
