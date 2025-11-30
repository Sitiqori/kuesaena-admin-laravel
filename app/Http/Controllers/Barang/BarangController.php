<?php

namespace App\Http\Controllers\Barang;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->orderBy('code')->get();
        $categories = Category::all();

        return view('barang.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('barang.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:products,code',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'code.required' => 'Kode barang harus diisi',
            'code.unique' => 'Kode barang sudah digunakan',
            'name.required' => 'Nama barang harus diisi',
            'category_id.required' => 'Kategori harus dipilih',
            'price.required' => 'Harga harus diisi',
            'stock.required' => 'Stok harus diisi',
            'image.image' => 'File harus berupa gambar',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        Product::create($validated);

        return redirect()->route('barang.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function show(Product $barang)
    {
        return response()->json($barang->load('category'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|unique:products,code,' . $id,
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $product->update($validated);

        return redirect()->route('barang.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('barang.index')->with('success', 'Produk berhasil dihapus');
    }

    public function exportPdf()
    {
        $products = Product::with('category')->orderBy('code')->get();

        $pdf = Pdf::loadView('barang.pdf', compact('products'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('daftar-produk-' . date('Y-m-d') . '.pdf');
    }
}
