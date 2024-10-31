<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;

class OrderService
{
    public function createOrder(array $data)
    {
        // Agrupar las cantidades de los productos seleccionados
        $productQuantities = [];
        foreach ($data['products'] as $product) {
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

        // Crear la orden
        $order = Order::create([
            'client_id' => $data['client_id'],
            'order_date' => now(),
            'total' => $total,
        ]);

        // Asociar los productos a la orden
        $products = [];
        foreach ($productQuantities as $productId => $quantity) {
            $products[$productId] = [
                'quantity' => $quantity,
                'price' => Product::find($productId)->price,
            ];
        }
        $order->products()->attach($products);

        return $order;
    }
}
