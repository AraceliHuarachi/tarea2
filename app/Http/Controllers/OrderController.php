<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {

        $orders = Order::with(['client', 'products'])->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $clients = Client::all();
        $products = Product::all();
        $validationRules = (new StoreOrderRequest())->rules();

        return view('orders.create', compact('clients', 'products', 'validationRules'));
    }

    public function store(StoreOrderRequest $request)
    {
        // Agrupar las cantidades de los productos seleccionados
        $productQuantities = [];
        foreach ($request->input('products') as $product) {
            if (!isset($productQuantities[$product['id']])) {
                $productQuantities[$product['id']] = 0;
            }
            $productQuantities[$product['id']] += $product['quantity'];
        }

        // Calcular el total
        $total = 0;
        foreach ($productQuantities as $productId => $quantity) {
            $productPrice = Product::find($productId)->price;
            $total += $productPrice * $quantity;
        }

        // Crear el nuevo pedido
        $order = Order::create([
            'client_id' => $request->input('client_id'),
            'order_date' => now(),
            'total' => $request->input('total'),
        ]);
        // print_r($request->all());
        // die("hola");

        // Asociar los productos al pedido   
        $products = [];
        foreach ($productQuantities as $productId => $quantity) {
            $products[$productId] = [
                'quantity' => $quantity,
                'price' => Product::find($productId)->price,
            ];
        }
        $order->products()->attach($products);
        return redirect()->route('orders.index')->with('success', 'Order added successfully.');
    }

    public function show($order)
    {
        $order = Order::find($order);
        return view('orders.show', compact('order'));
    }
    public function edit(Order $order)
    {
        $clients = Client::all();
        $products = Product::all();
        return view('orders.edit', compact('order', 'clients', 'products'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'name' => 'required|string|max:255',

        ]);

        $order->update($request->all());
        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
