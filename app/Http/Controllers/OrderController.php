<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

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

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(StoreOrderRequest $request)
    {
        // Extraer client_id y productos del request
        $clientId = $request->input('client_id');
        $productsData = $request->input('products');
        // Llamar al servicio con los datos extraídos
        $this->orderService->createOrder($clientId, $productsData);

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
