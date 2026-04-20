<?php

namespace App\Http\Controllers\Pelanggan;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all customers except "Umum" and with order count
        $customers = Customer::where('name', '!=', 'Umum')
            ->withCount('orders')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPelanggan = $customers->count();
        $totalPembelian = $customers->sum('orders_count');

        return view('pelanggan.index', compact('customers', 'totalPelanggan', 'totalPembelian'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::with(['orders' => function($query) {
            $query->orderBy('created_at', 'desc');
        }, 'orders.orderItems.product'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'customer' => $customer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
        ], [
            'name.required' => 'Nama harus diisi',
            'phone.required' => 'No. telepon harus diisi',
        ]);

        $customer->update($validated);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);

        // Don't delete "Umum" customer
        if ($customer->name === 'Umum') {
            return redirect()->route('pelanggan.index')->with('error', 'Pelanggan "Umum" tidak dapat dihapus');
        }

        // Note: Orders will be kept even after customer deletion (set to null in orders table)
        $customer->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus');
   
    }
}
