<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Tampilkan halaman laporan
        return view('reports.index');
    }

    public function filter(Request $request)
    {
        // Ambil input filter dari request
        $valasName = $request->input('valas_name');
        $month = $request->input('month');

        // Ambil data transaksi yang sesuai dengan filter
        $transactions = Transaction::where('valas_name', $valasName)
            ->whereMonth('created_at', $month)
            ->get();

        // Kirim data transaksi ke view untuk ditampilkan dalam grafik
        return view('reports.filter', compact('transactions'));
    }
}
