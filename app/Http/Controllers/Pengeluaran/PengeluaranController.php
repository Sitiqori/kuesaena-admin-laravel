<?php

namespace App\Http\Controllers\Pengeluaran;

use App\Models\Expense;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('user')
            ->orderBy('date', 'desc')
            ->get();

        $totalPengeluaran = $expenses->sum('amount');

        return view('pengeluaran.index', compact('expenses', 'totalPengeluaran'));
    }

    public function create()
    {
        return view('pengeluaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|in:Listrik,Gaji,Perlengkapan,Sewa,Lainnya',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'date' => 'required|date',
        ], [
            'category.required' => 'Kategori harus dipilih',
            'amount.required' => 'Nominal harus diisi',
            'amount.numeric' => 'Nominal harus berupa angka',
            'description.required' => 'Deskripsi harus diisi',
            'date.required' => 'Tanggal harus diisi',
        ]);

        $validated['user_id'] = Auth::id();

        Expense::create($validated);

        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil ditambahkan');
    }

    public function show(Expense $pengeluaran)
    {
        return response()->json($pengeluaran->load('user'));
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        return response()->json($expense);
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);

        $validated = $request->validate([
            'category' => 'required|in:Listrik,Gaji,Perlengkapan,Sewa,Lainnya',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $expense->update($validated);

        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil diupdate');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil dihapus');
    }

    public function exportPdf(Request $request)
    {
        $query = Expense::with('user')->orderBy('date', 'desc');

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by date
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('date', $request->date);
        }

        $expenses = $query->get();
        $totalPengeluaran = $expenses->sum('amount');

        // Group by category
        $byCategory = $expenses->groupBy('category')->map(function($items) {
            return [
                'count' => $items->count(),
                'total' => $items->sum('amount'),
            ];
        });

        $pdf = Pdf::loadView('pengeluaran.pdf', compact(
            'expenses',
            'totalPengeluaran',
            'byCategory'
        ));

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('laporan-pengeluaran-' . date('Y-m-d') . '.pdf');
    }
}
