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
        try {
            $validated = $request->validate([
                'code'        => 'required|string|unique:products,code',
                'name'        => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'unit'        => 'nullable|string|in:Pcs,Box,Lusin,Pack,Loyang,Toples',
                'hpp'         => 'nullable|numeric|min:0',
                'price'       => 'required|numeric|min:0',
                'stock'       => 'required|integer|min:0',
                'min_stock'   => 'nullable|integer|min:0',
                'description' => 'nullable|string',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'has_size'    => 'nullable|boolean',
                'price_s'     => 'nullable|numeric|min:0',
                'price_m'     => 'nullable|numeric|min:0',
                'price_l'     => 'nullable|numeric|min:0',
                'price_xl'    => 'nullable|numeric|min:0',
            ], [
                'code.required'        => 'Kode barang harus diisi',
                'code.unique'          => 'Kode barang sudah digunakan',
                'name.required'        => 'Nama barang harus diisi',
                'category_id.required' => 'Kategori harus dipilih',
                'price.required'       => 'Harga harus diisi',
                'stock.required'       => 'Stok harus diisi',
                'image.image'          => 'File harus berupa gambar',
                'image.max'            => 'Ukuran gambar maksimal 2MB',
            ]);

            $hasSize = $request->boolean('has_size');
            $validated['unit']     = $request->input('unit', 'Pcs');
            $validated['has_size'] = $hasSize;
            $validated['price_s']  = $hasSize ? $request->price_s : null;
            $validated['price_m']  = $hasSize ? $request->price_m : null;
            $validated['price_l']  = $hasSize ? $request->price_l : null;
            $validated['price_xl'] = $hasSize ? $request->price_xl : null;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();

                $imagePath = $file->storeAs('products', $filename, 'public');
                $validated['image'] = $imagePath;
            }

            Product::create($validated);

            return response()->json(['success' => true, 'message' => 'Produk berhasil ditambahkan']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
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
        try {
            $product = Product::findOrFail($id);

            $validated = $request->validate([
                'code'        => 'required|string|unique:products,code,' . $id,
                'name'        => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'unit'        => 'nullable|string|in:Pcs,Box,Lusin,Pack,Loyang,Toples',
                'hpp'         => 'nullable|numeric|min:0',
                'price'       => 'required|numeric|min:0',
                'stock'       => 'required|integer|min:0',
                'min_stock'   => 'nullable|integer|min:0',
                'description' => 'nullable|string',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'has_size'    => 'nullable|boolean',
                'price_s'     => 'nullable|numeric|min:0',
                'price_m'     => 'nullable|numeric|min:0',
                'price_l'     => 'nullable|numeric|min:0',
                'price_xl'    => 'nullable|numeric|min:0',
            ], [
                'code.required'        => 'Kode barang harus diisi',
                'code.unique'          => 'Kode barang sudah digunakan',
                'name.required'        => 'Nama barang harus diisi',
                'category_id.required' => 'Kategori harus dipilih',
                'price.required'       => 'Harga harus diisi',
                'stock.required'       => 'Stok harus diisi',
                'image.image'          => 'File harus berupa gambar',
                'image.max'            => 'Ukuran gambar maksimal 2MB',
            ]);

            $hasSize = $request->boolean('has_size');
            $validated['unit']     = $request->input('unit', 'Pcs');
            $validated['has_size'] = $hasSize;
            $validated['price_s']  = $hasSize ? $request->price_s : null;
            $validated['price_m']  = $hasSize ? $request->price_m : null;
            $validated['price_l']  = $hasSize ? $request->price_l : null;
            $validated['price_xl'] = $hasSize ? $request->price_xl : null;

            if ($request->hasFile('image')) {
                // Hapus foto lama jika ada
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();

                $imagePath = $file->storeAs('products', $filename, 'public');
                $validated['image'] = $imagePath;
            }

            $product->update($validated);

            return response()->json(['success' => true, 'message' => 'Produk berhasil diupdate']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

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
