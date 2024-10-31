<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class OrderService
{
    /**
     * Create a new order.
     *
     * @param int $clientId
     * @param array $productsData
     * @return Order
     * @throws InvalidArgumentException
     */
    public function createOrder(int $clientId, array $productsData): Order
    {
        if ($clientId <= 0) {
            throw new InvalidArgumentException('Client ID must be a positive integer.');
        }

        if (empty($productsData)) {
            throw new InvalidArgumentException('Product data cannot be empty.');
        }

        $productQuantities = $this->groupProductQuantities($productsData);
        $products = $this->getProductsByIds($productQuantities->keys());

        if ($products->isEmpty()) {
            throw new InvalidArgumentException('No valid products found for the given IDs.');
        }

        $total = $this->calculateTotal($products, $productQuantities);

        return $this->createNewOrder($clientId, $total, $productQuantities, $products);
    }

    /**
     * Group product quantities.
     *
     * @param array $productsData
     * @return Collection
     */
    protected function groupProductQuantities(array $productsData): Collection
    {
        return collect($productsData)
            ->groupBy('id')
            ->map(fn($items) => $items->sum('quantity'))
            ->filter(fn($quantity) => $quantity > 0); // Asegurarse de que la cantidad sea positiva
    }

    /**
     * Get products by IDs.
     *
     * @param Collection $productIds
     * @return Collection
     */
    protected function getProductsByIds(Collection $productIds): Collection
    {
        return Product::whereIn('id', $productIds)->get();
    }

    /**
     * Calculate the total price of the order.
     *
     * @param Collection $products
     * @param Collection $productQuantities
     * @return float
     */
    protected function calculateTotal(Collection $products, Collection $productQuantities): float
    {
        return $products->reduce(
            fn($carry, $product) =>
            $carry + $product->price * $productQuantities[$product->id],
            0
        );
    }

    /**
     * Create a new order and associate products.
     *
     * @param int $clientId
     * @param float $total
     * @param Collection $productQuantities
     * @param Collection $products
     * @return Order
     */
    protected function createNewOrder(int $clientId, float $total, Collection $productQuantities, Collection $products): Order
    {
        $order = Order::create([
            'client_id' => $clientId,
            'order_date' => now(),
            'total' => $total,
        ]);

        $orderProducts = $products->mapWithKeys(fn($product) => [
            $product->id => [
                'quantity' => $productQuantities[$product->id],
                'price' => $product->price,
            ],
        ]);

        $order->products()->attach($orderProducts);

        return $order;
    }
}
