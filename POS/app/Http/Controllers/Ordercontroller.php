<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Category;

class OrderController extends Controller
{
    public function index(){
        $data['categories'] = Category::get();
        $data['customers'] = Customer::get();
        return view('order.index')->with($data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_payload' => 'required|string',
        ]);

        $payload = json_decode($validated['order_payload'], true);
        if(!$payload || empty($payload['items'])){
            return redirect()->back()->with('error', 'No items in order');
        }
    

        DB::beginTransaction();
        try{
            $order = new Order();
            $order->invoice = 'INV'.time();
            $order->total = $payload['total'] ?? array_sum(array_column($payload['items'], 'price'));
            $order->user_id = Auth::id() ?? 1;
            $order->customer_id = $validated['customer_id'];
            $order->save();

            foreach ($payload['items'] as $item) {

                $product = Product::find($item['id']);
                if (!$product) {
                    throw new \Exception("Produk ID {$item['id']} tidak ditemukan.");
                }
                if ($product->stock < $item['qty']) {
                    throw new \Exception("Stok produk '{$product->name}' tidak mencukupi (tersisa {$product->stock}).");
                }
                $product->decrement('stock', $item['qty']);

                $detail = new OrderDetail();
                $detail->order_id = $order->id;
                $detail->product_id = $item['id'];
                $detail->qty = $item['qty'];
                $detail->price = $item['price'];
                $detail->save();
            }

            DB::commit();
            return redirect()->route('order.print', $order->id)->with('success', 'Order saved');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to save order: '.$e->getMessage());
        }
    }

    public function print(Order $order)
    {
        $order->load('customer');
        $details = OrderDetail::where('order_id', $order->id)->get();
        $productIds = $details->pluck('product_id')->unique()->toArray();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        return view('order.print', [
            'order' => $order,
            'details' => $details,
            'products'=> $products,
        ]);
    }
}