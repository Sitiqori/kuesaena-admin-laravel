<?php

namespace App\Http\Controllers\Kasir;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class KasirController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category')
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('kasir.index', compact('categories', 'products'));
    }

    public function process(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validate request
            $validated = $request->validate([
                'customer_name' => 'required|string',
                'customer_address' => 'nullable|string',
                'payment_method' => 'required|in:cash,qris,debit',
                'ppn_enabled' => 'boolean',
                'items' => 'required|array',
                'items.*.id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
            ]);

            // Check or create customer (skip if "Umum")
            $customerId = null;
            if (strtolower(trim($validated['customer_name'])) !== 'umum') {
                $customer = Customer::firstOrCreate(
                    ['name' => $validated['customer_name']],
                    [
                        'phone' => $validated['customer_phone'] ?? '-',
                        'address' => $validated['customer_address'] ?? '-'
                    ]
                );
                $customerId = $customer->id;
            }

            // Calculate totals
            $subtotal = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['id']);

                // Check stock
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi");
                }

                $itemSubtotal = $product->price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $itemSubtotal,
                ];

                // Reduce stock
                $product->decrement('stock', $item['quantity']);
            }

            $tax = $validated['ppn_enabled'] ? $subtotal * 0.11 : 0;
            $total = $subtotal + $tax;

            $user = Auth::user();

            $order = Order::create([
                'customer_id' => $customerId,
                'user_id'     => $user->id,
                'order_number' => Order::generateOrderNumber(),
                'subtotal'    => $subtotal,
                'tax'          => $tax,
                'discount'    => 0,
                'total'       => $total,
                'payment_method' => $validated['payment_method'],
                'status'      => 'pending',
            ]);


            // Create order items
            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }

            DB::commit();

            // Prepare response with order details
            $orderData = [
                'order_number' => $order->order_number,
                'customer_name' => $customer->name,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_amount' => $request->input('payment_amount', $total),
                'change' => max(0, $request->input('payment_amount', $total) - $total),
                'items' => collect($orderItems)->map(function($item) {
                    $product = Product::find($item['product_id']);
                    return [
                        'name' => $product->name,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                    ];
                })->toArray(),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil',
                'order' => $orderData,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
